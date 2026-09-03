<?php

namespace App\Livewire\Welcome;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class RoomDetail extends Component
{
    public $room;

    public ?int $booking_id = null;

    public string $booking_code = '';

    public ?int $room_id = null;
    public ?int $room_unit_id = null;
    public $user_id;

    public string $check_in = '';

    public string $check_out = '';

    public int $total_guests = 0;

    public int $total_price = 0;

    public int $subtotal_amount = 0;

    public int $discount_amount = 0;

    public int $tax_amount = 0;

    public string $status = 'pending';

    public int $nights = 1;

    public $promo;

    public string $promo_code = '';

    public array $claimed_promo_ids = [];



    public function mount($slug)
    {
        $this->room = Room::where('slug', $slug)->with('galleries', 'units')->firstOrFail();
        $this->check_in = now('Asia/Jakarta')->toDateString();
        $this->check_out = now('Asia/Jakarta')->addDay()->toDateString();
        $this->total_guests = 1;
        $this->promo_code = (string) request('promo', '');
        $this->booking_id = request('booking');
        $this->calculatePrice();

        if ($this->promo_code !== '') {
            $this->validatePromo();
        }
    }


    public function updated($property)
    {
        if (in_array($property, ['check_in', 'check_out', 'total_guests'])) {
            $this->calculatePrice();
        }
    }

    public function updatedPromoCode(): void
    {
        $this->promo_code = strtoupper(trim($this->promo_code));

        if (! $this->promo || $this->promo->code === $this->promo_code || ! in_array($this->promo->id, $this->claimed_promo_ids, true)) {
            return;
        }

        Promo::whereKey($this->promo->id)
            ->where('used_count', '>', 0)
            ->decrement('used_count');

        $this->claimed_promo_ids = array_values(array_diff($this->claimed_promo_ids, [$this->promo->id]));
        $this->promo = null;
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        if ($this->check_in && $this->check_out) {
            try {
                $checkIn = Carbon::parse($this->check_in);
                $checkOut = Carbon::parse($this->check_out);

                if ($checkOut->greaterThan($checkIn)) {
                    $this->nights = $checkIn->diffInDays($checkOut);
                } else {
                    $this->nights = 1;
                }
            } catch (\Exception $e) {
                $this->nights = 1;
            }
        } else {
            $this->nights = 1;
        }

        $basePrice = $this->room->price * $this->nights;
        $extraGuestPrice = 0;

        if ($this->total_guests > 2) {
            $extraGuestPrice = ($this->total_guests - 2) * 300000 * $this->nights;
        }


        $subtotal = $basePrice + $extraGuestPrice;
        $this->discount_amount = $this->promo && $subtotal >= $this->promo->minimum_transaction
            ? $this->discountFor($subtotal)
            : 0;
        $this->subtotal_amount = $subtotal - $this->discount_amount;
        $this->tax_amount = (int) round($this->subtotal_amount * 0.11);
        $this->total_price = $this->subtotal_amount + $this->tax_amount;
    }

    public function applyPromo()
    {
        if (! $this->validatePromo()) {
            return;
        }

        if (in_array($this->promo->id, $this->claimed_promo_ids, true)) {
            return;
        }

        $claimed = Promo::query()
            ->whereKey($this->promo->id)
            ->where('is_active', true)
            ->where('start_date', '<=', now('Asia/Jakarta'))
            ->where('end_date', '>=', now('Asia/Jakarta'))
            ->where(function ($query) {
                $query->whereNull('quota')->orWhereColumn('used_count', '<', 'quota');
            })
            ->increment('used_count');

        if (! $claimed) {
            $this->promo = null;
            $this->calculatePrice();
            $this->addError('promo_code', 'Kuota promo sudah habis.');

            return;
        }

        $this->claimed_promo_ids[] = $this->promo->id;
    }

    private function validatePromo(): bool
    {
        $this->resetErrorBag('promo_code');
        $this->promo_code = strtoupper(trim($this->promo_code));

        if ($this->promo_code === '') {
            $this->promo = null;
            $this->calculatePrice();

            return true;
        }

        if ($this->promo && $this->promo->code === $this->promo_code && in_array($this->promo->id, $this->claimed_promo_ids, true)) {
            $this->calculatePrice();

            return true;
        }

        $promo = Promo::query()
            ->where('code', $this->promo_code)
            ->where('is_active', true)
            ->where('start_date', '<=', now('Asia/Jakarta'))
            ->where('end_date', '>=', now('Asia/Jakarta'))
            ->where(function ($query) {
                $query->whereNull('quota')->orWhereColumn('used_count', '<', 'quota');
            })
            ->first();

        if (! $promo) {
            $this->promo = null;
            $this->calculatePrice();
            $this->addError('promo_code', 'Kode promo tidak valid atau sudah tidak berlaku.');

            return false;
        }

        $this->promo = $promo;
        $this->calculatePrice();

        if ($this->discount_amount === 0) {
            $this->promo = null;
            $this->calculatePrice();
            $this->addError('promo_code', 'Promo belum memenuhi minimum transaksi.');

            return false;
        }

        return true;
    }

    private function discountFor(int $subtotal): int
    {
        $discount = $this->promo->discount_type === 'percentage'
            ? $subtotal * ($this->promo->discount_value / 100)
            : $this->promo->discount_value;

        return min($subtotal, (int) round($discount));
    }

    /*
    public function save()
    {
        $user = Auth::user();
        if (! $user) {
            $this->redirect(route('login', absolute: true), navigate: true);

            return;
        }

        if (! $this->validatePromo()) {
            return;
        }

        $unit = $this->room->units()
            ->lockForUpdate()
            ->whereDoesntHave('bookings', function ($query) {
                $query->whereIn('status', ['pending', 'paid',])
                    ->where('check_in', '<', $this->check_out)
                    ->where('check_out', '>', $this->check_in);
            })
            ->first();

        if (! $unit) {
            $this->dispatch('room-detail-error', message: 'Tidak ada unit kamar tersedia.', type: 'error');
            return;
        }

        $this->user_id = $user->id;
        $this->room_id = $this->room->id;
        $this->room_unit_id = $unit->id;

        $this->booking_code = $this->generateBookingCode();
        $this->calculatePrice();

        $validation = $this->validate();


        $attributes = collect($validation)->except('status')->all();
        $attributes['check_in'] = Carbon::parse($this->check_in)->setTimezone('Asia/Jakarta')->setTimeFrom(Carbon::now('Asia/Jakarta'))->format('Y-m-d H:i:s');
        $attributes['check_out'] = Carbon::parse($this->check_out)->setTimezone('Asia/Jakarta')->setTime(12, 0, 0)->format('Y-m-d H:i:s');
        $attributes['status'] = $this->status;

        $booking = Booking::updateOrCreate(['booking_code' => $this->booking_code], $attributes);
        if ($booking) {
            $this->dispatch('room-detail-saved', message: 'Booking berhasil ditambahkan.', type: 'success');

            $unit->update([
                'status' => 'occupied',
            ]);
            $bookingCode = $booking->booking_code;
            session()->put("booking_payment_data.{$bookingCode}", [
                'promo_id' => $this->promo?->id,
                'promo_code' => $this->promo?->code,
                'subtotal_amount' => $this->subtotal_amount,
                'discount_amount' => $this->discount_amount,
                'tax_amount' => $this->tax_amount,
                'gross_amount' => $this->total_price,
            ]);
            $this->resetForm();

            // return redirect()->route('payment', $bookingCode);
            $this->redirect(route('payment', $bookingCode), navigate: true);
        } else {
            $this->dispatch('room-detail-error', message: 'Booking gagal ditambahkan.', type: 'error');
        }
    }
    */

    public function save()
    {
        $user = Auth::user();

        if (! $user) {
            $this->redirect(route('login', absolute: true), navigate: true);

            return;
        }

        if (! $this->validatePromo()) {
            return;
        }

        $this->calculatePrice();

        try {
            $booking = DB::transaction(function () use ($user) {
                $unit = $this->room->units()
                    ->where('status', 'available')
                    ->lockForUpdate()
                    ->whereDoesntHave('bookings', function ($query) {
                        $query->where(function ($query) {
                            $query->whereIn('status', ['paid', 'checked_in'])
                                ->orWhere(function ($query) {
                                    $query->where('status', 'pending')
                                        ->where('expires_at', '>', now());
                                });
                        })
                            ->where('check_in', '<', $this->check_out)
                            ->where('check_out', '>', $this->check_in);
                    })
                    ->first();

                if (! $unit) {
                    return null;
                }

                $this->user_id = $user->id;
                $this->room_id = $this->room->id;
                $this->room_unit_id = $unit->id;
                $this->booking_code = $this->generateBookingCode();

                $validation = $this->validate();

                $attributes = collect($validation)->except('status')->all();
                $attributes['check_in'] = Carbon::parse($this->check_in)
                    ->setTimezone('Asia/Jakarta')
                    ->setTimeFrom(Carbon::now('Asia/Jakarta'))
                    ->format('Y-m-d H:i:s');
                $attributes['check_out'] = Carbon::parse($this->check_out)
                    ->setTimezone('Asia/Jakarta')
                    ->setTime(12, 0, 0)
                    ->format('Y-m-d H:i:s');
                $attributes['status'] = 'pending';
                $attributes['expires_at'] = now()->addMinutes(max((int) config('booking.hold_minutes'), 1));

                return Booking::create($attributes);
            }, 3);

            if (! $booking) {
                $this->dispatch(
                    'room-detail-error',
                    message: 'Tidak ada unit kamar tersedia.',
                    type: 'error'
                );

                return;
            }

            session()->put("booking_payment_data.{$booking->booking_code}", [
                'promo_id' => $this->promo?->id,
                'promo_code' => $this->promo?->code,
                'subtotal_amount' => $this->subtotal_amount,
                'discount_amount' => $this->discount_amount,
                'tax_amount' => $this->tax_amount,
                'gross_amount' => $this->total_price,
            ]);

            $this->dispatch('room-detail-saved', message: 'Booking berhasil ditambahkan.', type: 'success');
            $this->resetForm();
            $this->redirect(route('payment', $booking->booking_code), navigate: true);
        } catch (\Throwable $e) {
            report($e);

            $this->dispatch(
                'room-detail-error',
                message: 'Booking gagal diproses. Silakan coba lagi.',
                type: 'error'
            );
        }
    }



    public function generateBookingCode(): string
    {
        $prefix = 'TRX-';
        $random = Str::random(8);

        while (Booking::where('booking_code', $prefix . $random)->exists()) {
            $random = Str::random(8);
        }

        return $prefix . $random;
    }

    public function resetForm()
    {
        $this->reset([
            'booking_code',
            'room_id',
            'room_unit_id',
            'user_id',
            'check_in',
            'check_out',
            'total_guests',
            'total_price',
            'subtotal_amount',
            'discount_amount',
            'tax_amount',
            'status',
            'promo_code',
            'claimed_promo_ids',

        ]);
        $this->promo = null;
        $this->resetValidation();
    }

    public function render()
    {
        return view(
            'livewire.welcome.room-detail',
            [
                'room' => $this->room,


            ]
        )->layout('layouts.guest');
    }

    public function rules()
    {
        return [
            'booking_code' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
            'room_unit_id' => 'required|exists:room_units,id',
            'user_id' => 'required|exists:users,id',
            'check_in' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],
            'total_guests' => 'required|integer',
            'total_price' => 'required|integer',
            'status' => 'required|in:pending,cancelled,paid,completed',

        ];
    }
}
