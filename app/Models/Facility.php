<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    public function rooms()
    {
        return $this->belongsToMany(
            Room::class,
            'room_facilities',
            'facility_id',
            'room_id'
        );
    }
}
