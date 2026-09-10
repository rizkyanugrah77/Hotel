<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        try {
            return $this->handleNotification(new Notification);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function handleNotification(object $notification)
    {
        // Ambil data notification dari Midtrans

        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $signatureKey = $notification->signature_key;

        // Validasi Signature
        $mySignature = hash(
            'sha512',
            $orderId .
                $statusCode .
                $grossAmount .
                config('midtrans.serverKey')
        );

        if ($signatureKey !== $mySignature) {
            return response()->json([
                'message' => 'Invalid Signature',
            ], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status ?? null;
        // $acquirer = $notification->acquirer;

        $paymentFound = DB::transaction(function () use ($orderId, $transaction, $type, $fraud, $notification) {
            $payment = Payment::where('order_id', $orderId)->lockForUpdate()->first();

            if (! $payment) {
                return false;
            }

            $booking = Booking::whereKey($payment->booking_id)->lockForUpdate()->firstOrFail();
            $unit = RoomUnit::whereKey($booking->room_unit_id)->lockForUpdate()->first();
            $paymentStatus = match ($transaction) {
                'capture' => $type === 'credit_card' && $fraud === 'challenge'
                    ? PaymentStatus::CHALLENGE->value
                    : PaymentStatus::SUCCESS->value,
                'settlement' => PaymentStatus::SUCCESS->value,
                'pending' => PaymentStatus::PENDING->value,
                'deny' => PaymentStatus::FAILED->value,
                'expire' => PaymentStatus::EXPIRED->value,
                'cancel' => PaymentStatus::CANCEL->value,
                'refund' => PaymentStatus::REFUND->value,
                default => null,
            };

            if (! $paymentStatus) {
                return true;
            }

            $finalPaymentStatuses = PaymentStatus::failed();

            if (in_array($payment->transaction_status, $finalPaymentStatuses, true)) {
                return true;
            }

            if ($payment->transaction_status === PaymentStatus::SUCCESS->value && $paymentStatus !== PaymentStatus::REFUND->value) {
                return true;
            }

            $payment->update([
                'transaction_status' => $paymentStatus,
                'payment_type' => $type,
                'transaction_id' => $notification->transaction_id,
                // 'payment_method' => $payment_type,
            ]);

            if ($paymentStatus === PaymentStatus::SUCCESS->value && $booking->status === 'pending') {
                $holdIsActive = $booking->expires_at?->isFuture() ?? false;

                $unitHasConflict = ! $unit
                    || $unit->status !== 'available'
                    || Booking::query()
                    ->where('room_unit_id', $booking->room_unit_id)
                    ->whereKeyNot($booking->id)
                    ->where('check_in', '<', $booking->check_out)
                    ->where('check_out', '>', $booking->check_in)
                    ->where(function ($query) {
                        $query->whereIn('status', ['paid', 'checked_in'])
                            ->orWhere(function ($query) {
                                $query->where('status', 'pending')->where('expires_at', '>', now());
                            });
                    })
                    ->exists();


                // A successful charge after an expired or displaced hold must not confirm the unit.
                $booking->update(['status' => $holdIsActive && ! $unitHasConflict ? 'paid' : 'cancelled']);
            }

            if ($paymentStatus === PaymentStatus::REFUND->value && $booking->status === 'paid') {
                $booking->update(['status' => 'refunded']);
            }

            if (
                in_array($paymentStatus, PaymentStatus::failed(), true)
                && $booking->status === 'pending'
            ) {
                $hasOtherActivePayment = Payment::where('booking_id', $booking->id)
                    ->where('id', '!=', $payment->id)
                    ->whereIn('transaction_status', [...PaymentStatus::pending(), PaymentStatus::SUCCESS->value])
                    ->exists();

                if (! $hasOtherActivePayment) {
                    $booking->update(['status' => 'cancelled']);
                }
            }

            return true;
        }, 3);

        if (! $paymentFound) {
            return response()->json([
                'message' => 'Payment not found',
            ], 404);
        }

        Log::info('Midtrans Callback', [
            'order_id' => $orderId,
            'status' => $transaction,
        ]);

        return response()->json([
            'message' => 'OK',
        ]);
    }
}
