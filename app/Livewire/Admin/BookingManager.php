<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Services\BookingStateMachine;
use App\Services\PromoReservationService;
use Illuminate\Support\Carbon;
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
    public $deposit_status = 'none';

    public $users;

    public $rooms;

    public $bookingDeleteId;

    public $search = '';

    public $payments;

    public ?string $filterStatus = null;
    public ?int $filterRoom = null;

    public string $viewMode = 'calendar';
    public string $calendarStartDate = '';

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
        $this->calendarStartDate = Carbon::today('Asia/Jakarta')->toDateString();
    }

    public function setViewMode(string $mode): void
    {
        $this->viewMode = in_array($mode, ['calendar', 'table'], true) ? $mode : 'calendar';
    }

    public function shiftCalendar(int $days): void
    {
        $current = Carbon::parse($this->calendarStartDate ?: Carbon::today('Asia/Jakarta')->toDateString(), 'Asia/Jakarta');
        $this->calendarStartDate = $current->addDays($days)->toDateString();
    }

    public function resetCalendarToday(): void
    {
        $this->calendarStartDate = Carbon::today('Asia/Jakarta')->toDateString();
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
                $previousStatus = $booking?->status;

                $checkIn = Carbon::parse($this->check_in)->setTimezone('Asia/Jakarta');
                $checkOut = Carbon::parse($this->check_out)->setTimezone('Asia/Jakarta')->setTime(12, 0, 0);

                $unit = $room->units()
                    ->whereKey($this->room_unit_id)
                    ->where(function ($query) use ($booking) {
                        $query->where('status', 'available');

                        if ($booking) {
                            $query->orWhere('id', $booking->room_unit_id);
                        }
                    })
                    ->lockForUpdate()
                    ->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut) {
                        $query->overlapping($checkIn, $checkOut)
                            ->blocking()
                            ->when($this->bookingEditId, function ($query) {
                                $query->whereKeyNot($this->bookingEditId);
                            });
                    })
                    ->first();

                if (! $unit) {
                    return null;
                }

                $targetStatus = BookingStatus::PENDING->value;

                if ($booking) {
                    $targetStatus = $this->status;
                    app(BookingStateMachine::class)
                        ->assertAdminTransitionAllowed($previousStatus, $targetStatus);
                }

                $attributes = collect($validation)->except('status')->all();
                $attributes['booking_code'] = $booking
                    ? $booking->booking_code
                    : $this->generateBookingCode();
                $attributes['room_id'] = $room->id;
                $attributes['room_unit_id'] = $unit->id;
                $attributes['user_id'] = $this->user_id;
                $attributes['check_in'] = $checkIn
                    ->copy()
                    ->setTimeFrom(Carbon::now('Asia/Jakarta'))
                    ->format('Y-m-d H:i:s');
                $attributes['check_out'] = $checkOut->format('Y-m-d H:i:s');
                $attributes['total_guests'] = $room->capacity;
                $attributes['total_price'] = $room->price * max(
                    Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out)),
                    1
                );
                $attributes['status'] = $targetStatus;

                if ($booking) {
                    $booking->update($attributes);
                } else {
                    $booking = Booking::create($attributes);
                }

                if (
                    $targetStatus === BookingStatus::CANCELLED->value
                    && $previousStatus === BookingStatus::PENDING->value
                ) {
                    app(PromoReservationService::class)->release($booking);
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
        $this->deposit_status = $booking->deposit_status;
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
        $booking = Booking::with(['payments', 'room.facilities', 'user'])->findOrFail($bookingId);
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

        if ($booking->payments()->exists()) {
            $this->dispatch(
                'booking-error',
                message: 'Booking dengan riwayat pembayaran tidak dapat dihapus.',
                type: 'error'
            );

            return;
        }

        DB::transaction(function () use ($booking) {
            if ($booking->status === BookingStatus::PENDING->value) {
                app(PromoReservationService::class)->release($booking);
            }

            $booking->delete();
        });

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

            'deposit_status',
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
        $baseFilteredQuery = Booking::query()
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
            });

        $bookings = (clone $baseFilteredQuery)
            ->with('room', 'roomUnit', 'user')
            ->latest()
            ->paginate(10);

        $todayJakarta = Carbon::today('Asia/Jakarta');
        $calendarStart = Carbon::parse($this->calendarStartDate ?: $todayJakarta->toDateString(), 'Asia/Jakarta')->startOfDay();
        $calendarEnd = $calendarStart->copy()->addDays(6)->endOfDay();

        $calendarBookingsList = (clone $baseFilteredQuery)
            ->with(['room', 'roomUnit', 'user'])
            ->whereBetween('check_in', [
                $calendarStart->copy()->format('Y-m-d H:i:s'),
                $calendarEnd->copy()->format('Y-m-d H:i:s'),
            ])
            ->orderBy('check_in')
            ->get();

        $calendarBookings = $calendarBookingsList->groupBy(
            fn ($booking) => $booking->check_in->copy()->timezone('Asia/Jakarta')->format('Y-m-d')
        );

        $calendarBookingsByRoomAndDate = $calendarBookingsList
            ->groupBy('room_id')
            ->map(fn ($roomBookings) => $roomBookings->groupBy(
                fn ($booking) => $booking->check_in->copy()->timezone('Asia/Jakarta')->format('Y-m-d')
            ));

        $calendarRooms = $this->rooms
            ->when($this->filterRoom, fn ($rooms) => $rooms->where('id', (int) $this->filterRoom))
            ->values();

        $calendarDays = collect(range(0, 6))->map(function (int $offset) use ($calendarStart, $calendarBookings, $todayJakarta) {
            $date = $calendarStart->copy()->addDays($offset);
            $dateKey = $date->format('Y-m-d');
            $dayBookings = $calendarBookings->get($dateKey, collect());

            $activeRoomBookings = $dayBookings->reject(fn ($booking) => in_array($booking->status, [
                BookingStatus::CANCELLED->value,
                BookingStatus::REFUNDED->value,
            ], true));

            return [
                'date' => $date,
                'dateKey' => $dateKey,
                'isToday' => $date->isSameDay($todayJakarta),
                'bookings' => $dayBookings,
                'bookingCount' => $dayBookings->count(),
                'totalRooms' => $activeRoomBookings->count(),
                'checkedInCount' => $dayBookings->where('status', BookingStatus::CHECKED_IN->value)->count(),
            ];
        });

        $upcomingOutsideCount = (clone $baseFilteredQuery)
            ->where('check_in', '>', $calendarEnd->copy()->format('Y-m-d H:i:s'))
            ->count();

        $bookingStats = Booking::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END), 0) as pending")
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END), 0) as paid")
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'paid' THEN total_price ELSE 0 END), 0) as total_price")
            ->first()
            ->only(['total', 'pending', 'paid', 'total_price']);

        $unavailableUnitIds = [];

        if ($this->room_id && $this->check_in && $this->check_out) {
            try {
                $checkIn = Carbon::parse($this->check_in)->setTimezone('Asia/Jakarta');
                $checkOut = Carbon::parse($this->check_out)->setTimezone('Asia/Jakarta')->setTime(12, 0, 0);

                $unavailableUnitIds = Booking::query()
                    ->where('room_id', $this->room_id)
                    ->whereNotNull('room_unit_id')
                    ->overlapping($checkIn, $checkOut)
                    ->blocking()
                    ->when($this->bookingEditId, function ($query) {
                        $query->whereKeyNot($this->bookingEditId);
                    })
                    ->pluck('room_unit_id')
                    ->unique()
                    ->all();
            } catch (\Throwable) {
                $unavailableUnitIds = [];
            }
        }

        return view('livewire.layout.bookings-manager', [
            'bookings' => $bookings,
            'calendarDays' => $calendarDays,
            'calendarRooms' => $calendarRooms,
            'calendarBookingsByRoomAndDate' => $calendarBookingsByRoomAndDate,
            'calendarStart' => $calendarStart,
            'calendarEnd' => $calendarStart->copy()->addDays(6),
            'upcomingOutsideCount' => $upcomingOutsideCount,
            'users' => $this->users,
            'rooms' => $this->rooms,
            'bookingStats' => $bookingStats,
            'payments' => $this->payments,
            'unavailableUnitIds' => $unavailableUnitIds,
        ])->layout('layouts.app');
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'room_unit_id' => 'required|exists:room_units,id',
            'deposit_status' => 'required|in:ktp,cash,passport,none',
            'check_in' => [
                'required',
                'date',
            ],
            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],
            'status' => 'required|in:pending,paid,checked_in,checked_out,cancelled,refunded,refund_required',

            'total_guests' => 'required|integer|min:1|max:100',
            'total_price' => 'required|integer|min:1|max:999999999',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User harus diisi.',
            'user_id.exists' => 'User tidak ditemukan.',
            'room_id.required' => 'Room harus diisi.',
            'room_id.exists' => 'Room tidak ditemukan.',
            'room_unit_id.required' => 'Room unit harus diisi.',
            'room_unit_id.exists' => 'Room unit tidak ditemukan.',
            'deposit_status.required' => 'Deposit status harus diisi.',
            'deposit_status.in' => 'Deposit status tidak valid.',
            'check_in.required' => 'Check in harus diisi.',
            'check_in.date' => 'Check in harus berupa tanggal.',
            'check_out.required' => 'Check out harus diisi.',
            'check_out.date' => 'Check out harus berupa tanggal.',
            'check_out.after' => 'Check out harus setelah check in.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status tidak valid.',
            'total_guests.required' => 'Total guests harus diisi.',
            'total_guests.integer' => 'Total guests harus berupa angka.',
            'total_guests.min' => 'Total guests minimal 1.',
            'total_guests.max' => 'Total guests maksimal 100.',
            'total_price.required' => 'Total price harus diisi.',
            'total_price.integer' => 'Total price harus berupa angka.',
            'total_price.min' => 'Total price minimal 1.',
            'total_price.max' => 'Total price maksimal 999999999.',
        ];
    }
}
