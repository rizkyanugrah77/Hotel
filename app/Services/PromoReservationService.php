<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;

class PromoReservationService
{
    /**
     * Atomically reserve one promo quota slot.
     */
    public function reserve(?int $promoId): bool
    {
        if (! $promoId) {
            return true;
        }

        $now = now();

        $affected = Promo::query()
            ->whereKey($promoId)
            ->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function ($query) {
                $query->whereNull('quota')->orWhereColumn('used_count', '<', 'quota');
            })
            ->increment('used_count');

        return $affected > 0;
    }

    /**
     * Release a reservation exactly once for a booking that was never honoured.
     */
    public function release(Booking $booking): void
    {
        if (! $booking->promo_id || $booking->promo_released_at) {
            return;
        }

        DB::transaction(function () use ($booking) {
            $claimed = Booking::query()
                ->whereKey($booking->id)
                ->whereNull('promo_released_at')
                ->whereNotNull('promo_id')
                ->update(['promo_released_at' => now()]);

            if (! $claimed) {
                return;
            }

            Promo::query()
                ->whereKey($booking->promo_id)
                ->where('used_count', '>', 0)
                ->decrement('used_count');
        });

        $booking->refresh();
    }
}
