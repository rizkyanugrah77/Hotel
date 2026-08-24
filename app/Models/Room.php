<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'capacity',
        'price',
        'status',
        'bed_type',
        'image',
        'size',
        'room_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',

    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(
            Facility::class,
            'room_facilities',
            'room_id',
            'facility_id'
        );
    }

    public function units(): HasMany
    {
        return $this->hasMany(RoomUnit::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class)->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp.' . number_format($this->price, 0, ',', '.');
    }

    public function syncStatusFromUnits(): void
    {
        $totalUnits = $this->units()->count();

        if ($totalUnits === 0) {
            return;
        }

        $availableUnits = $this->units()
            ->where('status', 'available')
            ->count();

        $this->update([
            'status' => $availableUnits === 0 ? 'maintenance' : 'available',
        ]);
    }
}
