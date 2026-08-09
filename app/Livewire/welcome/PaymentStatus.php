<?php

namespace App\Livewire\welcome;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
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
            $acquirer = $statusResponse->acquirer ?? null;

            if ($status == 'capture') {
                if ($type == 'credit_card') {
                    $payment->transaction_status = ($fraud == 'challenge') ? 'CHALLENGE' : 'SUCCESS';
                } elseif ($status == 'settlement') {
                    $payment->transaction_status = 'SUCCESS';
                    $payment->booking->update([
                        'status' => 'paid',
                    ]);
                } elseif ($status == 'pending') {
                    $payment->transaction_status = 'PENDING';
                    $payment->booking->update([
                        'status' => 'pending',
                    ]);
                } elseif ($status == 'deny') {
                    $payment->transaction_status = 'FAILED';
                    $payment->booking->update([
                        'status' => 'pending',
                    ]);
                } elseif ($status == 'expire') {
                    $payment->transaction_status = 'EXPIRED';
                    $payment->booking->update([
                        'status' => 'pending',
                    ]);
                } elseif ($status == 'cancel') {
                    $payment->transaction_status = 'CANCEL';
                    $payment->booking->update([
                        'status' => 'cancelled',
                    ]);
                }
                    
                if ($type) {
                    $payment->payment_type = $type;
                }
                $payment->payment_method = $acquirer;
                $payment->save();

            }
        } catch (\Exception $e) {
            session()->flash('error', 'Payment status check failed: '.$e->getMessage());
        }

        $this->payment = $payment;
    }

       public function downloadReceipt()
    {
        $payment = Payment::with([
            'booking.room',
            'booking.user',
        ])->where('order_id', $this->orderId)->firstOrFail();

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

        // $dom_pdf = $pdf->getDomPDF();
        // $canvas = $dom_pdf->getCanvas();
        // $canvas->page_text(50, 80, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, [0, 0, 0]); 
        // $qrCode = QrCode::size(150)->generate($payment->order_id);
        

        return response()->streamDownload(
            fn () => print($pdf->output()),
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
