<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
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
                $orderId.
                $statusCode.
                $grossAmount.
                config('midtrans.serverKey')
            );

            if ($signatureKey !== $mySignature) {
                return response()->json([
                    'message' => 'Invalid Signature',
                ], 403);
            }

            $payment = Payment::with('booking')->where('order_id', $orderId)->first();

            if (! $payment) {
                return response()->json([
                    'message' => 'Payment not found',
                ], 404);
            }

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status ?? null;
            $acquirer = $notification->acquirer;

            switch ($transaction) {

                case 'capture':
                    if ($type == 'credit_card') {
                        $payment->transaction_status =
                            ($fraud == 'challenge')
                                ? 'CHALLENGE'
                                : 'SUCCESS';
                    }
                    break;

                case 'settlement':
                    $payment->transaction_status = 'SUCCESS';
                    $payment->booking()->update([
                        'status' => 'paid',    
                    ]);
                    break;

                case 'pending':
                    $payment->transaction_status = 'PENDING';
                    $payment->booking()->update([
                        'status' => 'pending',
                    ]);
                    break;

                case 'deny':
                    $payment->transaction_status = 'FAILED';
                    $payment->booking()->update([
                        'status' => 'cancelled',
                        'payment_method'=> $acquirer,
                    ]);
                    break;

                case 'expire':
                    $payment->transaction_status = 'EXPIRED';
                    $payment->booking()->update([
                        'status' => 'cancelled',
                    ]);
                    break;

                case 'cancel':
                    $payment->transaction_status = 'CANCEL';
                    $payment->booking()->update([
                        'status' => 'cancelled',
                    ]);
                    break;
            }

            $payment->payment_type = $type;
            $payment->transaction_id = $notification->transaction_id;
            $payment->payment_method = $acquirer;
            $payment->save();

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
