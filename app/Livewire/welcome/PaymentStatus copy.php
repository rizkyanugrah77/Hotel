<?php

namespace App\Livewire\welcome;

use App\Models\Payment;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentStatus extends Component
{
    public $orderId;

    public $payment;

    public function mount($orderId)
    {
        $this->payment = Payment::with('booking.room', 'user')
            ->where('order_id', $orderId)
            ->firstOrFail();
    }

    public function notificationHandler()
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Midtrans Notification
        try {
            $notif = new Notification;
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $status = $notif->transaction_status;
        $type = $notif->transaction_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // MIDTRANS STATUS NOTIFICATION
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                $this->payment->transaction_status = ($fraud == 'challenge') ? 'CHALLENGE' : 'SUCCESS';
            }
        } elseif ($status == 'settlement') {
            $this->payment->transaction_status = 'SUCCESS';
        } elseif ($status == 'pending') {
            $this->payment->transaction_status = 'PENDING';
        } elseif ($status == 'deny') {
            $this->payment->transaction_status = 'FAILED';
        } elseif ($status == 'expire') {
            $this->payment->transaction_status = 'EXPIRED';
        } elseif ($status == 'cancel') {
            $this->payment->transaction_status = 'CANCEL';
        }

        $this->payment->payment_type = $type;
        $this->payment->save();

    }

    public function finishRedirect()
    {
        $this->payment->update([

        ]);
        $this->payment->save();

    }

    public function unfinishRedirect()
    {
        $this->payment->update([

        ]);
        $this->payment->save();

    }

    public function errorRedirect()
    {
        $this->payment->update([

        ]);
        $this->payment->save();
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
