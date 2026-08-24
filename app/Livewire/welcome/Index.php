<?php

namespace App\Livewire\welcome;

use App\Models\Gallery;
use App\Models\Promo;
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
        $promotions = Promo::with([
            'payments'
        ])->where('is_active', 1)->latest()->get();

        foreach ($rooms as $room) {
            $room->hasAvailableUnit = $room->units()->where('status', 'available')->exists();
        }


        $featuredGalleries = Gallery::where('is_featured', 1)->latest()->take(8)->get();

        return view('index', [
            'rooms' => $rooms,
            'promos' => $promotions,
            'featuredGalleries' => $featuredGalleries,
        ])->layout('layouts.guest');
    }
}
