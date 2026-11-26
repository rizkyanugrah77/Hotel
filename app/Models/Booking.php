<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'room_id',
        'room_unit_id',
        'user_id',
        'promo_id',
        'promo_released_at',
        'check_in',
        'check_out',
        'total_guests',
        'total_price',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'check_in' => 'datetime:Y-m-d, H:i:s',
        'check_out' => 'datetime:Y-m-d, H:i:s',
        'total_price' => 'decimal:2',
        'expires_at' => 'datetime',
        'promo_released_at' => 'datetime',
    ];

    public function scopeBlocking(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->whereIn('status', BookingStatus::blocking())
                ->orWhere(function (Builder $query) {
                    $query->where('status', BookingStatus::PENDING->value)
                        ->where('expires_at', '>', now());
                });
        });
    }

    public function scopeOverlapping(Builder $query, mixed $start, mixed $end): Builder
    {
        return $query->where('check_in', '<', $end)
            ->where('check_out', '>', $start);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function roomUnit(): BelongsTo
    {
        return $this->belongsTo(RoomUnit::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
