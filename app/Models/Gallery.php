<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'room_id',
        'image',
        'caption',
        'is_featured',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
