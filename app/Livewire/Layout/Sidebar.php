<?php

namespace App\Livewire\Layout;

use App\Models\Room;
use Illuminate\View\View;
use Livewire\Component;

class Sidebar extends Component
{
    public function render(): View
    {
        return view('livewire.layout.sidebar', [
            'sidebarRooms' => Room::query()->select(['id', 'name', 'slug'])->orderBy('name')->get(),
        ]);
    }
}
