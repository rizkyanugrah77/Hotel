<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'room_id',
        'user_id',
        'check_in',
        'check_out',
        'total_guests',
        'total_price',
        'status',
    ];

    protected $casts = [
        'check_in' => 'datetime:Y-m-d, H:m:s',
        'check_out' => 'datetime:Y-m-d, H:m:s',
        'total_price' => 'decimal:2',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
