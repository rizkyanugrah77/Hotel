<?php

namespace App\Livewire\welcome;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\RoomUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $this->bookings = Booking::with('room', 'roomUnit', 'user')
            ->where('booking_code', $bookingCode)
            ->where('user_id', Auth::user()->id)
            ->first();

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
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $orderId = 'INV-' . Str::uuid()->toString();

        try {
            $payment = DB::transaction(function () use ($orderId) {
                $booking = Booking::with('user')->lockForUpdate()->find($this->bookings->id);

                if (! $booking || $booking->status !== 'pending' || ! $booking->expires_at?->isFuture()) {
                    return null;
                }

                $unit = RoomUnit::whereKey($booking->room_unit_id)->lockForUpdate()->first();
                $unitIsUnavailable = ! $unit
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

                if ($unitIsUnavailable) {
                    return null;
                }

                $hasActivePayment = Payment::where('booking_id', $booking->id)
                    ->whereIn('transaction_status', ['pending', 'PENDING', 'CHALLENGE'])
                    ->lockForUpdate()
                    ->exists();

                if ($hasActivePayment) {
                    return null;
                }

                return Payment::create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'order_id' => $orderId,
                    'promo_id' => $this->promo_id,
                    'sub_total_amount' => $this->sub_total_amount,
                    'tax_amount' => $this->tax_amount,
                    'gross_amount' => (int) $booking->total_price,
                    'transaction_status' => 'PENDING',
                ]);
            }, 3);

            if (! $payment) {
                session()->flash('error', 'Booking ini tidak dapat dibayar atau pembayaran sedang diproses.');

                return;
            }

            $booking = $payment->booking()->with('user')->firstOrFail();
            $grossAmount = (int) $booking->total_price;
            $midtrans_parameter = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $booking->user->name,
                    'email' => $booking->user->email,
                ],
                'callbacks' => [
                    'finish' => route('payment-check') . '?order_id=' . $orderId,
                ],
            ];

            $snap = Snap::createTransaction($midtrans_parameter);

            $payment->update(['snap_token' => $snap->token]);

            return redirect()->away($snap->redirect_url);
        } catch (\Exception $e) {
            if (isset($payment)) {
                $payment->update(['transaction_status' => 'FAILED']);
            }

            report($e);
            session()->flash('error', 'Payment initialization failed.');
        }
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
