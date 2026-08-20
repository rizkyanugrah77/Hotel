<?php

namespace App\Livewire\welcome;

use App\Models\Gallery;
use App\Models\Room;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $rooms = Room::with([
            'galleries',
            'facilities',
            'bookings.user',
            'units',
        ])->latest()->get();

        foreach ($rooms as $room) {
            $room->hasAvailableUnit = $room->units()->where('status', 'available')->exists();
        }


        $featuredGalleries = Gallery::where('is_featured', 1)->latest()->take(8)->get();

        return view('index', [
            'rooms' => $rooms,
            'featuredGalleries' => $featuredGalleries,
        ])->layout('layouts.guest');
    }
}
