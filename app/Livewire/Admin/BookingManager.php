<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class BookingManager extends Component
{
    use WithPagination;

    public string $booking_code = '';

    public ?int $room_id = null;

    public ?int $room_unit_id = null;

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

    public $search = '';

    public $payments;

    public ?string $filterStatus = null;
    public ?int $filterRoom = null;

    // Payment
    public $orderId;
    public $date;
    public $bookingCode;
    public $paymentMethod;
    public $gross_amount;
    public function mount()
    {
        $this->users = User::where('role', '!=', 'admin')->get();
        $this->rooms = Room::with('units')->get();
    }

    public function updatedRoomId(): void
    {
        $this->room_unit_id = null;
    }

    public function save()
    {
        $validation = $this->validate();
        $isUpdate = (bool) $this->bookingEditId;

        try {
            $booking = DB::transaction(function () use ($validation) {
                $room = Room::findOrFail($this->room_id);
                $booking = $this->bookingEditId
                    ? Booking::lockForUpdate()->findOrFail($this->bookingEditId)
                    : null;
                $wasCheckedIn = $booking?->status === 'checked_in';
                $previousUnitId = $booking?->room_unit_id;

                $unit = $room->units()
                    ->whereKey($this->room_unit_id)
                    ->where(function ($query) use ($booking) {
                        $query->where('status', 'available')
                            ->when($booking, function ($query) use ($booking) {
                                $query->orWhere(function ($query) use ($booking) {
                                    $query->where('status', 'occupied')
                                        ->whereKey($booking->room_unit_id);
                                });
                            });
                    })
                    ->lockForUpdate()
                    ->whereDoesntHave('bookings', function ($query) {
                        $query->whereIn('status', ['paid', 'checked_in'])
                            ->when($this->bookingEditId, function ($query) {
                                $query->where('id', '!=', $this->bookingEditId);
                            })
                            ->where('check_in', '<', $this->check_out)
                            ->where('check_out', '>', $this->check_in);
                    })
                    ->first();

                if (! $unit) {
                    return null;
                }

                $attributes = collect($validation)->except('status')->all();
                $attributes['booking_code'] = $booking
                    ? $booking->booking_code
                    : $this->generateBookingCode();
                $attributes['room_id'] = $room->id;
                $attributes['room_unit_id'] = $unit->id;
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
                $attributes['total_price'] = $room->price * max(
                    Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out)),
                    1
                );
                $attributes['status'] = $this->status;

                $previousUnit = $wasCheckedIn && $previousUnitId !== $unit->id
                    ? RoomUnit::whereKey($previousUnitId)->lockForUpdate()->first()
                    : null;

                if ($booking) {
                    $booking->update($attributes);
                } else {
                    $booking = Booking::create($attributes);
                }

                if ($previousUnit) {
                    $previousUnit->newQuery()
                        ->whereKey($previousUnit->id)
                        ->where('status', 'occupied')
                        ->update(['status' => 'available']);
                }

                if ($booking->status === 'checked_in' || $booking->status === 'paid') {
                    $unit->update(['status' => 'occupied']);
                } elseif ($wasCheckedIn) {
                    $unit->newQuery()
                        ->whereKey($unit->id)
                        ->where('status', 'occupied')
                        ->update(['status' => 'available']);
                }

                return $booking;
            }, 3);

            if (! $booking) {
                $this->dispatch(
                    'booking-error',
                    message: 'Unit kamar tidak tersedia pada tanggal tersebut.',
                    type: 'error'
                );

                return;
            }

            $this->resetForm();

            $this->dispatch(
                'booking-saved',
                message: $isUpdate
                    ? 'Booking berhasil diupdate.'
                    : 'Booking berhasil ditambahkan.',
                type: 'success'
            );
        } catch (\Throwable $th) {
            $this->dispatch('booking-error', message: $th->getMessage(), type: 'error');
        }
    }

    public function edit(int $bookingId)
    {
        $this->bookingEditId = $bookingId;
        $booking = Booking::with(['room', 'roomUnit', 'user'])->findOrFail($bookingId);
        $this->booking_code = $booking->booking_code;
        $this->room_id = $booking->room->id;
        $this->room_unit_id = $booking->roomUnit?->id;
        $this->user_id = $booking->user->id;
        $this->check_in = $booking->check_in->format('Y-m-d');
        $this->check_out = $booking->check_out->format('Y-m-d');
        $this->total_guests = $booking->total_guests;
        $this->total_price = $booking->total_price;
        $this->status = $booking->status;

        $this->resetValidation();
        $this->dispatch('booking-editing');
    }

    public function show(int $bookingId)
    {
        $this->bookingId = $bookingId;
        $booking = Booking::with('payments')->findOrFail($bookingId);
        $this->payments = $booking->payments->first();

        $this->resetValidation();
        $this->dispatch('booking-detail');
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
            'user_id',
            'room_unit_id',
            'check_in',
            'check_out',
            'total_guests',
            'total_price',
            'status',
            'bookingEditId',
            'orderId',
            'date',
            'bookingCode',
            'paymentMethod',
            'gross_amount',
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        $bookings = Booking::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('booking_code', 'like', "%{$this->search}%")
                        ->orWhereHas('room', function ($query) {
                            $query->where('name', 'like', "%{$this->search}%");
                        })
                        ->orWhereHas('user', function ($query) {
                            $query->where('name', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterRoom, function ($query) {
                $query->where('room_id', $this->filterRoom);
            })
            ->with('room', 'user')
            ->latest()
            ->paginate(10);

        $bookingStats = Booking::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END), 0) as pending")
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END), 0) as paid")
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'paid' THEN total_price ELSE 0 END), 0) as total_price")
            ->first()
            ->only(['total', 'pending', 'paid', 'total_price']);

        return view('livewire.layout.bookings-manager', [
            'bookings' => $bookings,
            'users' => $this->users,
            'rooms' => $this->rooms,
            'bookingStats' => $bookingStats,
            'payments' => $this->payments,
        ]);
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'room_unit_id' => 'required|exists:room_units,id',
            'check_in' => [
                'required',
                'date',
            ],
            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],
            'status' => 'required|in:pending,paid,checked_in,checked_out,cancelled',
        ];
    }
}
