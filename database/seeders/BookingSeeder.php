<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', '!=', 'admin')->get();
        if ($users->isEmpty()) {
            $users = User::all();
        }

        if ($users->isEmpty()) {
            $this->command?->warn('No users found. Creating a test customer.');
            $users = collect([
                User::firstOrCreate(
                    ['email' => 'customer@mail.com'],
                    [
                        'name' => 'John Customer',
                        'password' => bcrypt('password'),
                        'role' => 'customer',
                        'email_verified_at' => now(),
                    ]
                )
            ]);
        }

        $rooms = Room::with('units')->get();
        if ($rooms->isEmpty()) {
            $this->command?->warn('No rooms found. Skipping booking seeding.');
            return;
        }

        $allUnits = RoomUnit::all();
        if ($allUnits->isEmpty()) {
            $this->command?->warn('No room units found. Skipping booking seeding.');
            return;
        }

        $bookingTemplates = [
            [
                'days_ago_in' => 5,
                'days_ago_out' => 3,
                'status' => 'checked_out',
                'deposit_status' => 'none',
            ],
            [
                'days_ago_in' => 2,
                'days_ago_out' => -1, // ends tomorrow
                'status' => 'checked_in',
                'deposit_status' => 'ktp',
            ],
            [
                'days_ago_in' => -2, // in 2 days
                'days_ago_out' => -4,
                'status' => 'paid',
                'deposit_status' => 'none',
            ],
            [
                'days_ago_in' => -5, // in 5 days
                'days_ago_out' => -7,
                'status' => 'pending',
                'deposit_status' => 'none',
            ],
            [
                'days_ago_in' => -10, // in 10 days
                'days_ago_out' => -12,
                'status' => 'cancelled',
                'deposit_status' => 'none',
            ],
            [
                'days_ago_in' => 10,
                'days_ago_out' => 8,
                'status' => 'checked_out',
                'deposit_status' => 'cash',
            ],
            [
                'days_ago_in' => -3,
                'days_ago_out' => -5,
                'status' => 'paid',
                'deposit_status' => 'none',
            ],
            [
                'days_ago_in' => -1,
                'days_ago_out' => -2,
                'status' => 'pending',
                'deposit_status' => 'none',
            ],
        ];

        foreach ($bookingTemplates as $template) {
            $room = $rooms->random();
            $unit = $room->units->isNotEmpty() ? $room->units->random() : $allUnits->random();
            $user = $users->random();

            $checkIn = Carbon::today()->subDays($template['days_ago_in'])->setTime(14, 0, 0);
            $checkOut = Carbon::today()->subDays($template['days_ago_out'])->setTime(12, 0, 0);

            $nights = max(1, $checkIn->diffInDays($checkOut));
            $totalPrice = $room->price * $nights;
            $bookingCode = 'ST' . date('Ymd') . strtoupper(Str::random(4));

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'room_id' => $room->id,
                'room_unit_id' => $unit->id,
                'user_id' => $user->id,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'total_guests' => min(2, $room->capacity ?? 2),
                'total_price' => $totalPrice,
                'status' => $template['status'],
                'deposit_status' => $template['deposit_status'],
            ]);

            // Create payment records for paid or completed/checked bookings
            if (in_array($booking->status, ['paid', 'checked_in', 'checked_out'])) {
                $subTotal = (float) $totalPrice;
                $taxAmount = round($subTotal * 0.1, 2);
                $grossAmount = $subTotal + $taxAmount;

                Payment::create([
                    'user_id' => $user->id,
                    'booking_id' => $booking->id,
                    'order_id' => 'ORDER-' . $booking->booking_code,
                    'sub_total_amount' => $subTotal,
                    'tax_amount' => $taxAmount,
                    'gross_amount' => $grossAmount,
                    'payment_type' => 'qris',
                    'transaction_id' => (string) Str::uuid(),
                    'snap_token' => Str::random(32),
                    'transaction_status' => 'settlement',
                    'payment_method' => 'qris',
                ]);
            }
        }

        $this->command?->info('Sample bookings and payments seeded successfully.');
    }
}
