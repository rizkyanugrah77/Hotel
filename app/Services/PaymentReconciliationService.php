<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomUnit;

class PaymentReconciliationService
{
    public function __construct(private PromoReservationService $promos)
    {
    }

    public function reconcile(
        Payment $payment,
        Booking $booking,
        ?string $incomingStatus,
        array $attributes = []
    ): void {
        if ($incomingStatus === null) {
            return;
        }

        $current = $payment->transaction_status;

        if ($current === PaymentStatus::REFUND->value) {
            return;
        }

        $incoming = PaymentStatus::tryFrom($incomingStatus);

        if ($incoming === null) {
            return;
        }

        if (
            $current === PaymentStatus::SUCCESS->value
            && ! in_array($incoming, [PaymentStatus::SUCCESS, PaymentStatus::REFUND], true)
        ) {
            return;
        }

        $payment->fill($attributes);

        if ($incoming === PaymentStatus::SUCCESS) {
            $isDuplicate = $current === PaymentStatus::SUCCESS->value;

            $payment->transaction_status = PaymentStatus::SUCCESS->value;
            $payment->refund_required = false;
            $payment->refund_reason = null;
            $payment->save();

            if (! $isDuplicate) {
                $this->handleSuccessfulPayment($booking, $payment);
            }

            return;
        }

        if ($incoming === PaymentStatus::REFUND) {
            $payment->transaction_status = PaymentStatus::REFUND->value;
            $payment->refund_required = false;
            $payment->refund_reason = null;
            $payment->refunded_at = now();
            $payment->save();

            $this->handleRefund($booking);

            return;
        }

        $payment->transaction_status = $incoming->value;
        $payment->save();

        if (in_array($incoming->value, PaymentStatus::failed(), true)) {
            $this->handleFailedPayment($booking, $payment);
        }
    }

    private function handleSuccessfulPayment(Booking $booking, Payment $payment): void
    {
        if ($booking->status === BookingStatus::PENDING->value) {
            if ($this->canHonour($booking)) {
                $booking->update(['status' => BookingStatus::PAID->value]);

                return;
            }

            $this->flagRefund(
                $booking,
                $payment,
                'Pembayaran diterima setelah hold berakhir atau unit tidak lagi tersedia.'
            );

            return;
        }

        if (in_array($booking->status, [BookingStatus::CANCELLED->value, BookingStatus::REFUND_REQUIRED->value], true)) {
            $this->flagRefund(
                $booking,
                $payment,
                'Booking sudah dibatalkan saat pembayaran diterima.'
            );

            return;
        }

        if (in_array($booking->status, [BookingStatus::PAID->value, BookingStatus::CHECKED_IN->value, BookingStatus::CHECKED_OUT->value], true)) {
            $this->flagRefund(
                $booking,
                $payment,
                'Pembayaran sukses ganda untuk booking yang sudah dikonfirmasi.'
            );

            return;
        }

        if ($booking->status === BookingStatus::REFUNDED->value) {
            $this->flagRefund(
                $booking,
                $payment,
                'Pembayaran diterima untuk booking yang sudah direfund.'
            );
        }
    }

    private function handleRefund(Booking $booking): void
    {
        if (in_array($booking->status, [
            BookingStatus::PAID->value,
            BookingStatus::CHECKED_IN->value,
            BookingStatus::CHECKED_OUT->value,
            BookingStatus::REFUND_REQUIRED->value,
        ], true)) {
            $booking->update(['status' => BookingStatus::REFUNDED->value]);
        }
    }

    private function handleFailedPayment(Booking $booking, Payment $payment): void
    {
        if ($booking->status !== BookingStatus::PENDING->value) {
            return;
        }

        $hasOtherActivePayment = Payment::query()
            ->where('booking_id', $booking->id)
            ->whereKeyNot($payment->id)
            ->whereIn('transaction_status', [...PaymentStatus::pending(), ...PaymentStatus::successful()])
            ->exists();

        if ($hasOtherActivePayment) {
            return;
        }

        $booking->update(['status' => BookingStatus::CANCELLED->value]);
        $this->promos->release($booking);
    }

    private function flagRefund(Booking $booking, Payment $payment, string $reason): void
    {
        $payment->forceFill([
            'refund_required' => true,
            'refund_reason' => $reason,
        ])->save();

        if (in_array($booking->status, [
            BookingStatus::PENDING->value,
            BookingStatus::CANCELLED->value,
            BookingStatus::REFUND_REQUIRED->value,
        ], true)) {
            $booking->update(['status' => BookingStatus::REFUND_REQUIRED->value]);
        }

        $this->promos->release($booking);
    }

    private function canHonour(Booking $booking): bool
    {
        if (! $booking->expires_at || $booking->expires_at->isPast()) {
            return false;
        }

        $unit = RoomUnit::query()->whereKey($booking->room_unit_id)->first();

        if (! $unit || $unit->status !== 'available') {
            return false;
        }

        return ! Booking::query()
            ->where('room_unit_id', $booking->room_unit_id)
            ->whereKeyNot($booking->id)
            ->overlapping($booking->check_in, $booking->check_out)
            ->blocking()
            ->exists();
    }
}
