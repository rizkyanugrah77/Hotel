<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpirePendingBookings extends Command
{
    protected $signature = 'bookings:expire-pending {--minutes=30 : Pending booking expiry period in minutes}';

    protected $description = 'Cancel pending bookings that have passed their payment deadline';

    public function handle(): int
    {
        $minutes = max((int) $this->option('minutes'), 1);
        $cutoff = now()->subMinutes($minutes);

        $expired = DB::transaction(function () use ($cutoff) {
            $bookings = Booking::query()
                ->where('status', 'pending')
                ->where('created_at', '<=', $cutoff)
                ->lockForUpdate()
                ->get();
            $expiredCount = 0;

            foreach ($bookings as $booking) {
                if (! $booking->payments()->where('transaction_status', 'SUCCESS')->exists()) {
                    $booking->update(['status' => 'cancelled']);
                    $expiredCount++;
                }
            }

            return $expiredCount;
        }, 3);

        $this->info("{$expired} pending booking(s) expired.");

        return self::SUCCESS;
    }
}
