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

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp.'.number_format($this->price, 0, ',', '.');
    }
}
