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
        ])->latest()->get();

        $featuredGalleries = Gallery::where('is_featured', 1)->latest()->take(8)->get();

        return view('index', [
            'rooms' => $rooms,
            'featuredGalleries' => $featuredGalleries,
        ])->layout('layouts.guest');
    }
}
