<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
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

            // Ambil data notification dari Midtrans
            $notification = new Notification;

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
            $acquirer = $notification->acquirer;

            $paymentFound = DB::transaction(function () use ($orderId, $transaction, $type, $fraud, $acquirer, $notification) {
                $payment = Payment::where('order_id', $orderId)->lockForUpdate()->first();

                if (! $payment) {
                    return false;
                }

                $booking = Booking::whereKey($payment->booking_id)->lockForUpdate()->firstOrFail();
                $finalPaymentStatuses = ['SUCCESS', 'FAILED', 'EXPIRED', 'CANCEL', 'REFUND'];

                if (in_array($payment->transaction_status, $finalPaymentStatuses, true)) {
                    return true;
                }

                $paymentStatus = match ($transaction) {
                    'capture' => $type === 'credit_card' && $fraud === 'challenge'
                        ? 'CHALLENGE'
                        : 'SUCCESS',
                    'settlement' => 'SUCCESS',
                    'pending' => 'PENDING',
                    'deny' => 'FAILED',
                    'expire' => 'EXPIRED',
                    'cancel' => 'CANCEL',
                    'refund' => 'REFUND',
                    default => null,
                };

                if (! $paymentStatus) {
                    return true;
                }

                $payment->update([
                    'transaction_status' => $paymentStatus,
                    'payment_type' => $type,
                    'transaction_id' => $notification->transaction_id,
                    'payment_method' => $acquirer,
                ]);

                if ($paymentStatus === 'SUCCESS' && $booking->status === 'pending') {
                    $booking->update(['status' => 'paid']);
                }

                if (in_array($paymentStatus, ['FAILED', 'EXPIRED', 'CANCEL', 'REFUND'], true)
                    && $booking->status === 'pending') {
                    $hasOtherActivePayment = Payment::where('booking_id', $booking->id)
                        ->where('id', '!=', $payment->id)
                        ->whereIn('transaction_status', ['pending', 'PENDING', 'CHALLENGE', 'SUCCESS'])
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
        } catch (\Exception $e) {

            Log::error('Midtrans Callback Error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
