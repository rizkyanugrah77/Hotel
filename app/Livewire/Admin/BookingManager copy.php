<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingManager extends Component
{
    public $bookings;

    public string $booking_code = '';

    public ?int $room_id = null;

    public $user_id;

    public string $check_in = '';

    public string $check_out = '';

    public int $total_guests = 0;

    public int $total_price = 0;

    public string $status = 'pending';

    public ?int $bookingId = null;

    public $bookingEditId = null;

    public $users;

    public $rooms;

    public $bookingDeleteId;

    public function mount()
    {
        $this->users = User::where('role', '!=', 'admin')->get();
        $this->rooms = Room::all();
    }

    public function save()
    {
        // $user = Auth::user();
        $validation = $this->validate();
        $room = Room::findOrFail($this->room_id);

        $attributes = collect($validation)->except('status')->all();

        $attributes['booking_code'] = $this->generateBookingCode();
        $attributes['room_id'] = $room->id;
        $attributes['user_id'] = $this->user_id;
        $attributes['check_in'] = Carbon::parse($this->check_in)
            ->setTimezone('Asia/Jakarta')
            ->setTimeFrom(Carbon::now('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');

        $attributes['check_out'] = Carbon::parse($this->check_out)
            ->setTimezone('Asia/Jakarta')
            ->setTime(12, 0, 0)
            ->format('Y-m-d H:i:s');
        $attributes['total_guests'] = $room->capacity;
        $nights = Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out));
        $attributes['total_price'] = $room->price * max($nights, 1);
        $attributes['status'] = $this->status;

        $booking = $this->bookingEditId ? Booking::findOrFail($this->bookingEditId) : null;
        try {
            if ($booking) {

                $booking->update($attributes);

            } else {
                $booking = Booking::create($attributes);
            }

            $this->resetForm();
            $this->dispatch('booking-saved', message: $booking ? 'Booking berhasil diupdate.' : 'Booking berhasil ditambahkan.', type: 'success');

        } catch (\Throwable $th) {
            $this->dispatch('booking-error', message: $th->getMessage(), type: 'error');
        }
    }

    public function edit(int $bookingId)
    {
        $this->bookingEditId = $bookingId;
        $booking = Booking::with('room', 'user')->findOrFail($bookingId);
        $this->booking_code = $booking->booking_code;
        $this->room_id = $booking->room->id;
        $this->user_id = $booking->user->id;
        $this->check_in = $booking->check_in->format('Y-m-d');
        $this->check_out = $booking->check_out->format('Y-m-d');
        $this->total_guests = $booking->total_guests;
        $this->total_price = $booking->total_price;
        $this->status = $booking->status;

        $this->resetValidation();
        $this->dispatch('booking-editing');
    }

    public function confirmDelete(int $bookingId)
    {
        $this->bookingDeleteId = $bookingId;
        $this->dispatch('booking-delete-confirmation');
    }

    public function delete()
    {
        $booking = Booking::findOrFail($this->bookingDeleteId);
        $booking->delete();
        $this->resetForm();
        $this->dispatch('booking-deleted', message: 'Booking berhasil dihapus.', type: 'success');
    }

    public function diffForHumans(string $dateTime)
    {
        return Carbon::parse($dateTime)->diffForHumans();
    }

    public function generateBookingCode(): string
    {
        $prefix = 'TRX';
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
            'bookingEditId',

        ]);
        $this->resetValidation();
    }

    public function render()
    {

        return view('livewire.layout.bookings-manager', [
            $this->bookings = Booking::with('room', 'user')->latest()->get(),
            'users' => $this->users,
            'rooms' => $this->rooms,
        ]);
    }

    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:completed,pending,cancelled,paid',
        ];
    }
}
