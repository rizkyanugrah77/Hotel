<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentReconciliationService;
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

            $booking = Booking::withTrashed()->whereKey($payment->booking_id)->lockForUpdate()->firstOrFail();

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

            app(PaymentReconciliationService::class)->reconcile(
                $payment,
                $booking,
                $paymentStatus,
                [
                    'payment_type' => $type,
                    'transaction_id' => $notification->transaction_id,
                ]
            );

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
