<?php

namespace App\Livewire\welcome;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Str;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Component
{
    public $payment;

    public $user_id;

    public $booking_id;

    public $order_id;

    public $gross_amount;

    public $payment_type;

    public $transaction_id;

    public $snap_token;

    public $payment_method;

    public string $transaction_status = 'pending';

    public $bookingCode;

    public $bookings;

    public function mount($bookingCode)
    {
        $this->bookingCode = $bookingCode;
        $this->bookings = Booking::with('room', 'user')->where('booking_code', $bookingCode)->first();

        if (! $this->bookings) {
            return redirect()->route('index');
        }
    }

    public function pay()
    {
        // 1. Setup Midtrans Configuration
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // 2. Prepare transaction details
        $orderId = 'INV-'.Str::uuid()->toString();
        $grossAmount = (int) $this->bookings->total_price;

        $midtrans_parameter = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $this->bookings->user->name,
                'email' => $this->bookings->user->email,
            ],
            'callbacks' => [
                'finish' => route('payment-check').'?order_id='.$orderId,
            ],
        ];

        try {
            // 3. Make the Snap API request to get token and redirect URL
            $snap = Snap::createTransaction($midtrans_parameter);

            // 4. Save Payment record to database
            Payment::create([
                'booking_id' => $this->bookings->id,
                'user_id' => auth()->id(),
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
                'payment_type' => $this->payment_type,
                'transaction_id' => Str::random(10), // Placeholder until webhook updates it
                'snap_token' => $snap->token,
                'payment_method' => $this->payment_method,
                'transaction_status' => 'pending',
            ]);

            // 5. Redirect user to Midtrans payment page
            return redirect()->away($snap->redirect_url);

        } catch (\Exception $e) {
            session()->flash('error', 'Payment initialization failed: '.$e->getMessage());
        }

        // return redirect()->back();

    }

    public function render()
    {
        return view('livewire.welcome.payments.payment', [
            'booking' => $this->bookings,
        ])->layout('layouts.guest');
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
            'order_id' => 'required|unique:payments,order_id',
            'gross_amount' => 'required|decimal',
            'payment_type' => 'nullable|string|max:255',
            'transaction_id' => 'required|string|unique:payments,transaction_id',
            'snap_token' => 'required|string|unique:payments,snap_token',
            'payment_method' => 'nullable|string|max:255',
            'transaction_status' => 'required|in:pending,settlement,deny,expire,capture,unpaid,cancel',
        ];
    }
}
