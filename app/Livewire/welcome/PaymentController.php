<?php

namespace App\Livewire\welcome;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
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

    public $promo;

    public ?int $promo_id = null;

    public int $sub_total_amount = 0;

    public int $discount_amount = 0;

    public int $tax_amount = 0;

    public string $transaction_status = 'pending';

    public $bookingCode;

    public $bookings;

    public function mount($bookingCode)
    {
        $this->bookingCode = $bookingCode;

        $this->bookings = Booking::with('room', 'roomUnit', 'user')->where('booking_code', $bookingCode)->where('user_id' === auth()->id)->first();

        if (! $this->bookings) {
            return redirect()->route('index');
        }

        $paymentData = session("booking_payment_data.{$bookingCode}", []);

        if (($paymentData['gross_amount'] ?? null) === (int) $this->bookings->total_price) {
            $this->promo_id = $paymentData['promo_id'] ?? null;
            $this->promo = $this->promo_id ? Promo::find($this->promo_id) : null;
            $this->sub_total_amount = $paymentData['subtotal_amount'];
            $this->discount_amount = $paymentData['discount_amount'];
            $this->tax_amount = $paymentData['tax_amount'];
        } else {
            $this->sub_total_amount = (int) round($this->bookings->total_price / 1.11);
            $this->tax_amount = (int) $this->bookings->total_price - $this->sub_total_amount;
        }
    }

    public function pay()
    {
        $booking = Booking::with(['roomUnit', 'user'])
            ->whereKey($this->bookings->id)
            ->first();

        if (! $booking || $booking->status !== 'pending') {
            session()->flash('error', 'Booking ini tidak dapat dibayar.');

            return;
        }

        $unitIsUnavailable = ! $booking->roomUnit
            || $booking->roomUnit->status !== 'available'
            || $booking->roomUnit->bookings()
            ->whereKeyNot($booking->id)
            ->whereIn('status', ['paid', 'checked_in'])
            ->where('check_in', '<', $booking->check_out)
            ->where('check_out', '>', $booking->check_in)
            ->exists();

        if ($unitIsUnavailable) {
            session()->flash('error', 'Unit kamar untuk tanggal booking ini sudah penuh dan tidak dapat dibayar.');

            return;
        }

        $this->bookings = $booking;

        // 1. Setup Midtrans Configuration
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // 2. Prepare transaction details
        $orderId = 'INV-' . Str::uuid()->toString();
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
                'finish' => route('payment-check') . '?order_id=' . $orderId,
            ],
        ];

        try {
            // 3. Make the Snap API request to get token and redirect URL
            $snap = Snap::createTransaction($midtrans_parameter);

            // 4. Save Payment record to database
            Payment::create([
                'booking_id' => $this->bookings->id,
                'user_id' => $this->bookings->user->id,
                'order_id' => $orderId,
                'promo_id' => $this->promo_id,
                'sub_total_amount' => $this->sub_total_amount,
                'tax_amount' => $this->tax_amount,
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
            session()->flash('error', 'Payment initialization failed: ' . $e->getMessage());
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
