<?php

namespace App\Livewire\welcome;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Container\Attributes\Auth;
use Livewire\Component;

class PaymentStatus extends Component
{
    public $orderId;

    public $payment;

    public function mount($orderId)
    {
        $payment = Payment::with('booking', 'booking.room', 'user')->where('order_id', $orderId)->where('user_id' === auth()->id)->first();

        if ($payment == null) {
            return redirect()->route('index');
        }

        // The signed webhook is the sole authority for payment state transitions.
        $this->payment = $payment;
    }

    public function downloadReceipt()
    {
        $payment = Payment::with([
            'booking.room',
            'booking.user',
        ])->where('order_id', $this->orderId)->where('user_id' === auth()->id)->firstOrFail();

        $pdf = Pdf::loadView('livewire.welcome.payments.receipt', [
            'payment' => $payment,
        ]);

        // 226 pt = 80 mm lebar, 600 pt = tinggi kertas (bisa disesuaikan)
        $pdf->setPaper([0, 0, 230, 500], 'portrait');

        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        return response()->streamDownload(
            fn() => print($pdf->output()),
            'receipt-' . $payment->order_id . '.pdf'
        );
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
