<?php

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;
use App\Livewire\Welcome\RoomDetail;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

function createPendingBooking(Carbon $expiresAt): Booking
{
    $user = User::factory()->create();
    $room = Room::create([
        'name' => 'Test Room',
        'slug' => 'test-room-' . fake()->unique()->uuid(),
        'capacity' => 2,
        'price' => 500000,
        'status' => 'available',
    ]);
    $unit = RoomUnit::create([
        'room_id' => $room->id,
        'room_number' => 'T-' . fake()->unique()->numerify('####'),
        'status' => 'available',
    ]);

    return Booking::create([
        'booking_code' => 'TRX-' . fake()->unique()->bothify('????????'),
        'room_id' => $room->id,
        'room_unit_id' => $unit->id,
        'user_id' => $user->id,
        'check_in' => now()->addDay(),
        'check_out' => now()->addDays(2),
        'total_guests' => 1,
        'total_price' => 500000,
        'status' => 'pending',
        'expires_at' => $expiresAt,
    ]);
}

it('expires pending bookings from their persisted hold deadline', function () {
    $expired = createPendingBooking(now()->subMinute());
    $active = createPendingBooking(now()->addMinute());

    $this->artisan('bookings:expire-pending')->assertSuccessful();

    expect($expired->fresh()->status)->toBe('cancelled')
        ->and($active->fresh()->status)->toBe('pending');
});

it('does not assign a unit to another active hold for overlapping dates', function () {
    $user = User::factory()->create();
    $room = Room::create([
        'name' => 'Hold Test Room',
        'slug' => 'hold-test-room',
        'capacity' => 2,
        'price' => 500000,
        'status' => 'available',
    ]);
    RoomUnit::create([
        'room_id' => $room->id,
        'room_number' => 'H-1001',
        'status' => 'available',
    ]);
    $checkIn = now()->addDays(3)->toDateString();
    $checkOut = now()->addDays(4)->toDateString();

    Livewire::actingAs($user)
        ->test(RoomDetail::class, ['slug' => $room->slug])
        ->set('check_in', $checkIn)
        ->set('check_out', $checkOut)
        ->set('total_guests', 1)
        ->call('save')
        ->assertDispatched('room-detail-saved');

    Livewire::actingAs($user)
        ->test(RoomDetail::class, ['slug' => $room->slug])
        ->set('check_in', $checkIn)
        ->set('check_out', $checkOut)
        ->set('total_guests', 1)
        ->call('save')
        ->assertDispatched('room-detail-error');

    expect(Booking::count())->toBe(1)
        ->and(Booking::first()->expires_at->isFuture())->toBeTrue();
});

it('enforces unique Midtrans order IDs', function () {
    $booking = createPendingBooking(now()->addMinute());
    $attributes = [
        'booking_id' => $booking->id,
        'user_id' => $booking->user_id,
        'order_id' => 'INV-duplicate-order',
        'sub_total_amount' => 500000,
        'tax_amount' => 0,
        'gross_amount' => 500000,
        'transaction_status' => 'PENDING',
    ];

    Payment::create($attributes);
    Payment::create($attributes);
})->throws(Illuminate\Database\UniqueConstraintViolationException::class);
