<?php

namespace App\Livewire\Welcome;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class RoomDetail extends Component
{
    public $room;

    public ?int $booking_id = null;

    public string $booking_code = '';

    public ?int $room_id = null;

    public $user_id;

    public string $check_in = '';

    public string $check_out = '';

    public int $total_guests = 0;

    public int $total_price = 0;

    public string $status = 'pending';

    public int $nights = 1;

    public function mount($slug)
    {
        $this->room = Room::where('slug', $slug)->with('galleries')->firstOrFail();
        $this->check_in = now('Asia/Jakarta')->toDateString();
        $this->check_out = now('Asia/Jakarta')->addDay()->toDateString();
        $this->total_guests = 1;
        $this->booking_id = request('booking');
        $this->calculatePrice();
    }

    public function updated($property)
    {
        if (in_array($property, ['check_in', 'check_out', 'total_guests'])) {
            $this->calculatePrice();
        }
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
        $taxes = $subtotal * 0.11;

        $this->total_price = (int) ($subtotal + $taxes);
    }

    public function save()
    {
        $user = Auth::user();
        if (! $user) {
            $this->redirect(route('login', absolute: true), navigate: true);
        }

        $this->user_id = $user->id;
        $this->room_id = $this->room->id;
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
            $bookingCode = $booking->booking_code;
            $this->resetForm();

            // return redirect()->route('payment', $bookingCode);
            $this->redirect(route('payment', $bookingCode), navigate: true);
        } else {
            $this->dispatch('room-detail-error', message: 'Booking gagal ditambahkan.', type: 'error');
        }

    }

    public function generateBookingCode(): string
    {
        $prefix = 'TRX-';
        $random = Str::random(8);

        while (Booking::where('booking_code', $prefix.$random)->exists()) {
            $random = Str::random(8);
        }

        return $prefix.$random;
    }

    public function resetForm()
    {
        $this->reset([
            'booking_code',
            'room_id',
            'user_id',
            'check_in',
            'check_out',
            'total_guests',
            'total_price',
            'status',

        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.welcome.room-detail',
            ['room' => $this->room,

            ]
        )->layout('layouts.guest');
    }

    public function rules()
    {
        return [
            'booking_code' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
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
