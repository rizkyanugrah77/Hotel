<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'room_id',
        'room_unit_id',
        'user_id',
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
    ];

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
