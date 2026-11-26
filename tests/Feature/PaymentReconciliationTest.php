<?php

use App\Enums\BookingStatus;
use App\Http\Controllers\MidtransController;
use App\Livewire\Admin\BookingManager;
use App\Livewire\Welcome\RoomDetail;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;
use Livewire\Livewire;

function p0BookingFixture(array $booking = [], ?string $paymentStatus = 'PENDING'): array
{
    $user = User::factory()->create();
    $room = Room::create([
        'name' => 'P0 Room '.fake()->unique()->numerify('####'),
        'slug' => 'p0-room-'.fake()->unique()->uuid(),
        'capacity' => 2,
        'price' => 500000,
        'status' => 'available',
    ]);
    $unit = RoomUnit::create([
        'room_id' => $room->id,
        'room_number' => 'P0-'.fake()->unique()->numerify('####'),
        'status' => 'available',
    ]);

    $booking = Booking::create(array_merge([
        'booking_code' => 'TRX-'.fake()->unique()->bothify('????????'),
        'room_id' => $room->id,
        'room_unit_id' => $unit->id,
        'user_id' => $user->id,
        'check_in' => now()->addDay(),
        'check_out' => now()->addDays(2),
        'total_guests' => 1,
        'total_price' => 500000,
        'status' => BookingStatus::PENDING->value,
        'expires_at' => now()->addMinutes(30),
    ], $booking));

    $payment = Payment::create([
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'order_id' => 'INV-'.fake()->unique()->uuid(),
        'sub_total_amount' => 500000,
        'tax_amount' => 0,
        'gross_amount' => 500000,
        'transaction_status' => $paymentStatus,
    ]);

    return [$booking, $payment, $unit, $user];
}

function p0Notification(Payment $payment, string $transactionStatus): object
{
    config()->set('midtrans.serverKey', 'p0-server-key');

    $orderId = $payment->order_id;
    $statusCode = '200';
    $grossAmount = (string) $payment->gross_amount;

    return (object) [
        'order_id' => $orderId,
        'status_code' => $statusCode,
        'gross_amount' => $grossAmount,
        'signature_key' => hash('sha512', $orderId.$statusCode.$grossAmount.'p0-server-key'),
        'transaction_status' => $transactionStatus,
        'payment_type' => 'bank_transfer',
        'fraud_status' => null,
        'transaction_id' => 'trx-'.fake()->unique()->uuid(),
    ];
}

it('flags a refund when a successful payment arrives after the hold expired', function () {
    [$booking, $payment, $unit] = p0BookingFixture([
        'expires_at' => now()->subMinute(),
    ]);

    $response = app(MidtransController::class)
        ->handleNotification(p0Notification($payment, 'settlement'));

    expect($response->getStatusCode())->toBe(200)
        ->and($booking->fresh()->status)->toBe(BookingStatus::REFUND_REQUIRED->value)
        ->and($payment->fresh()->transaction_status)->toBe('SUCCESS')
        ->and($payment->fresh()->refund_required)->toBeTrue()
        ->and($unit->fresh()->status)->toBe('available');
});

it('flags a refund when a successful payment arrives for a cancelled booking', function () {
    [$booking, $payment] = p0BookingFixture([
        'status' => BookingStatus::CANCELLED->value,
        'expires_at' => now()->subMinute(),
    ]);

    app(MidtransController::class)->handleNotification(p0Notification($payment, 'settlement'));

    expect($booking->fresh()->status)->toBe(BookingStatus::REFUND_REQUIRED->value)
        ->and($payment->fresh()->refund_required)->toBeTrue();
});

it('flags a duplicate successful payment for an already confirmed booking', function () {
    [$booking, $firstPayment, , $user] = p0BookingFixture([
        'status' => BookingStatus::PAID->value,
    ], 'SUCCESS');

    $secondPayment = Payment::create([
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'order_id' => 'INV-'.fake()->unique()->uuid(),
        'sub_total_amount' => 500000,
        'tax_amount' => 0,
        'gross_amount' => 500000,
        'transaction_status' => 'PENDING',
    ]);

    app(MidtransController::class)->handleNotification(p0Notification($secondPayment, 'settlement'));

    expect($booking->fresh()->status)->toBe(BookingStatus::PAID->value)
        ->and($firstPayment->fresh()->refund_required)->toBeFalse()
        ->and($secondPayment->fresh()->refund_required)->toBeTrue();
});

it('accepts a successful payment that was previously marked failed', function () {
    [$booking, $payment] = p0BookingFixture([], 'FAILED');

    app(MidtransController::class)->handleNotification(p0Notification($payment, 'settlement'));

    expect($payment->fresh()->transaction_status)->toBe('SUCCESS')
        ->and($booking->fresh()->status)->toBe(BookingStatus::PAID->value);
});

it('clears the refund flag when a flagged payment is refunded', function () {
    [$booking, $payment] = p0BookingFixture([
        'status' => BookingStatus::REFUND_REQUIRED->value,
    ], 'SUCCESS');

    $payment->update(['refund_required' => true, 'refund_reason' => 'late payment']);

    app(MidtransController::class)->handleNotification(p0Notification($payment, 'refund'));

    expect($booking->fresh()->status)->toBe(BookingStatus::REFUNDED->value)
        ->and($payment->fresh()->transaction_status)->toBe('REFUND')
        ->and($payment->fresh()->refund_required)->toBeFalse()
        ->and($payment->fresh()->refunded_at)->not->toBeNull();
});

it('does not consume promo quota when applying a promo', function () {
    $user = User::factory()->create();
    $room = Room::create([
        'name' => 'Promo Room',
        'slug' => 'promo-room-'.fake()->unique()->uuid(),
        'capacity' => 2,
        'price' => 500000,
        'status' => 'available',
    ]);
    RoomUnit::create([
        'room_id' => $room->id,
        'room_number' => 'PR-'.fake()->unique()->numerify('####'),
        'status' => 'available',
    ]);
    $promo = Promo::create([
        'code' => 'P0PROMO',
        'name' => 'P0 Promo',
        'discount_type' => 'fixed',
        'discount_value' => 50000,
        'minimum_transaction' => 0,
        'quota' => 1,
        'used_count' => 0,
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->test(RoomDetail::class, ['slug' => $room->slug])
        ->set('promo_code', 'P0PROMO')
        ->call('applyPromo')
        ->assertHasNoErrors();

    expect($promo->fresh()->used_count)->toBe(0);

    Livewire::actingAs($user)
        ->test(RoomDetail::class, ['slug' => $room->slug])
        ->set('promo_code', 'P0PROMO')
        ->call('applyPromo')
        ->set('check_in', now()->addDay()->toDateString())
        ->set('check_out', now()->addDays(2)->toDateString())
        ->set('total_guests', 1)
        ->call('save')
        ->assertDispatched('room-detail-saved');

    expect($promo->fresh()->used_count)->toBe(1)
        ->and(Booking::query()->first()->promo_id)->toBe($promo->id);
});

it('releases promo quota when a pending booking expires', function () {
    [$booking] = p0BookingFixture(['expires_at' => now()->subMinute()]);

    $promo = Promo::create([
        'code' => 'P0EXPIRE',
        'name' => 'P0 Expire',
        'discount_type' => 'fixed',
        'discount_value' => 50000,
        'minimum_transaction' => 0,
        'quota' => 1,
        'used_count' => 1,
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
        'is_active' => true,
    ]);

    $booking->update(['promo_id' => $promo->id]);

    $this->artisan('bookings:expire-pending')->assertSuccessful();

    expect($booking->fresh()->status)->toBe(BookingStatus::CANCELLED->value)
        ->and($promo->fresh()->used_count)->toBe(0)
        ->and($booking->fresh()->promo_released_at)->not->toBeNull();
});

it('blocks an admin from setting a financial booking status directly', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    [$booking] = p0BookingFixture();

    Livewire::actingAs($admin)
        ->test(BookingManager::class)
        ->call('edit', $booking->id)
        ->set('status', BookingStatus::PAID->value)
        ->call('save')
        ->assertDispatched('booking-error');

    expect($booking->fresh()->status)->toBe(BookingStatus::PENDING->value);
});

it('allows an admin to perform a valid booking transition', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    [$booking] = p0BookingFixture();

    Livewire::actingAs($admin)
        ->test(BookingManager::class)
        ->call('edit', $booking->id)
        ->set('status', BookingStatus::CANCELLED->value)
        ->call('save')
        ->assertDispatched('booking-saved');

    expect($booking->fresh()->status)->toBe(BookingStatus::CANCELLED->value);
});

it('refuses to delete a booking that has payment history', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    [$booking] = p0BookingFixture();

    Livewire::actingAs($admin)
        ->test(BookingManager::class)
        ->call('confirmDelete', $booking->id)
        ->call('delete')
        ->assertDispatched('booking-error');

    expect(Booking::query()->find($booking->id))->not->toBeNull();
});

it('soft deletes a booking without payment history', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    [$booking, $payment] = p0BookingFixture();

    $payment->delete();

    Livewire::actingAs($admin)
        ->test(BookingManager::class)
        ->call('confirmDelete', $booking->id)
        ->call('delete')
        ->assertDispatched('booking-deleted');

    expect(Booking::query()->find($booking->id))->toBeNull()
        ->and(Booking::withTrashed()->find($booking->id)?->deleted_at)->not->toBeNull();
});
