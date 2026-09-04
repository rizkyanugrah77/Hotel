<?php

use App\Http\Controllers\MidtransController;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;

function createPaidBookingForRefund(): array
{
    $user = User::factory()->create();
    $room = Room::create([
        'name' => 'Refund Test Room',
        'slug' => 'refund-test-room-'.fake()->unique()->uuid(),
        'capacity' => 2,
        'price' => 500000,
        'status' => 'available',
    ]);
    $unit = RoomUnit::create([
        'room_id' => $room->id,
        'room_number' => 'R-'.fake()->unique()->numerify('####'),
        'status' => 'available',
    ]);
    $booking = Booking::create([
        'booking_code' => 'TRX-'.fake()->unique()->bothify('????????'),
        'room_id' => $room->id,
        'room_unit_id' => $unit->id,
        'user_id' => $user->id,
        'check_in' => now()->addDay(),
        'check_out' => now()->addDays(2),
        'total_guests' => 1,
        'total_price' => 500000,
        'status' => 'paid',
        'expires_at' => now()->addMinute(),
    ]);
    $payment = Payment::create([
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'order_id' => 'INV-'.fake()->unique()->uuid(),
        'sub_total_amount' => 500000,
        'tax_amount' => 0,
        'gross_amount' => 500000,
        'transaction_status' => 'SUCCESS',
    ]);

    return [$booking, $payment];
}

it('records a refund received after a successful payment', function () {
    config()->set('midtrans.serverKey', 'test-server-key');
    [$booking, $payment] = createPaidBookingForRefund();
    $notification = (object) [
        'order_id' => $payment->order_id,
        'status_code' => '200',
        'gross_amount' => '500000.00',
        'signature_key' => hash('sha512', $payment->order_id.'200'.'500000.00test-server-key'),
        'transaction_status' => 'refund',
        'payment_type' => 'bank_transfer',
        'fraud_status' => null,
        'transaction_id' => 'refund-transaction-id',
    ];

    $response = app(MidtransController::class)->handleNotification($notification);

    expect($response->getStatusCode())->toBe(200)
        ->and($payment->fresh()->transaction_status)->toBe('REFUND')
        ->and($booking->fresh()->status)->toBe('refunded');
});
