<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpirePendingBookings extends Command
{
    protected $signature = 'bookings:expire-pending';

    protected $description = 'Cancel pending bookings that have passed their payment deadline';

    public function handle(): int
    {
        $cutoff = now();

        $expired = DB::transaction(function () use ($cutoff) {
            $bookings = Booking::query()
                ->where('status', 'pending')
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', $cutoff)
                ->lockForUpdate()
                ->get();
            $expiredCount = 0;

            foreach ($bookings as $booking) {
                $booking->update(['status' => 'cancelled']);
                $expiredCount++;
            }

            return $expiredCount;
        }, 3);

        $this->info("{$expired} pending booking(s) expired.");

        return self::SUCCESS;
    }
}
