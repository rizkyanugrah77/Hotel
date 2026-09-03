<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn = now()->addDays(fake()->numberBetween(1, 10))->setTime(14, 0, 0);
        $checkOut = (clone $checkIn)->addDays(fake()->numberBetween(1, 4))->setTime(12, 0, 0);

        return [
            'booking_code' => 'ST' . date('Ymd') . strtoupper(Str::random(4)),
            'room_id' => Room::inRandomOrder()->value('id') ?? 1,
            'room_unit_id' => RoomUnit::inRandomOrder()->value('id') ?? 1,
            'user_id' => User::inRandomOrder()->value('id') ?? 1,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_guests' => fake()->numberBetween(1, 2),
            'total_price' => fake()->numberBetween(500000, 3000000),
            'status' => fake()->randomElement(['pending', 'paid', 'checked_in', 'checked_out', 'cancelled']),
            'expires_at' => now()->addMinutes(30),
            'deposit_status' => fake()->randomElement(['none', 'ktp', 'cash', 'passport']),
        ];
    }
}
