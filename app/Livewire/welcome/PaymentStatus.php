<?php

namespace App\Livewire\welcome;

use App\Models\Payment;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Transaction;

class PaymentStatus extends Component
{
    public $orderId;

    public $payment;

    public function mount($orderId)
    {
        $payment = Payment::with('booking', 'booking.room', 'user')->where('order_id', $orderId)->first();

        if ($payment == null) {
            return redirect()->route('index');
        }

        // Fetch latest status from Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        try {
            $statusResponse = Transaction::status($orderId);
            $status = $statusResponse->transaction_status ?? null;
            $type = $statusResponse->payment_type ?? null;
            $fraud = $statusResponse->fraud_status ?? null;

            if ($status == 'capture') {
                if ($type == 'credit_card') {
                    $payment->transaction_status = ($fraud == 'challenge') ? 'CHALLENGE' : 'SUCCESS';
                }
            } elseif ($status == 'settlement') {
                $payment->transaction_status = 'SUCCESS';
            } elseif ($status == 'pending') {
                $payment->transaction_status = 'PENDING';
            } elseif ($status == 'deny') {
                $payment->transaction_status = 'FAILED';
            } elseif ($status == 'expire') {
                $payment->transaction_status = 'EXPIRED';
            } elseif ($status == 'cancel') {
                $payment->transaction_status = 'CANCEL';
            }

            if ($type) {
                $payment->payment_type = $type;
            }
            $payment->save();
        } catch (\Exception $e) {
            session()->flash('error', 'Payment status check failed: '.$e->getMessage());
        }

        $this->payment = $payment;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render()
    {
        return view('livewire.welcome.payments.payment-success', [
            'payment' => $this->payment,
        ])->layout('layouts.guest');

    }
}
