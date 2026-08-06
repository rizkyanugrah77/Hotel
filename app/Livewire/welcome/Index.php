<?php

namespace App\Livewire\welcome;

use App\Models\Room;
use Livewire\Component;

class Index extends Component
{
    public $rooms;

    public function mount()
    {
        $this->rooms = Room::with('galleries', 'facilities', 'bookings')->latest()->get();

    }

    public function render()
    {
        return view('index', [
            'rooms' => $this->rooms,
        ])->layout('layouts.guest');
    }
}
