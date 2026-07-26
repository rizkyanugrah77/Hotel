<?php

namespace App\View\Components;

use App\Models\Room;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
     public string $search = '';
      public string $filterStatus = '';
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
         $rooms = Room::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus, fn($query) => $query->where('status', $this->filterStatus))
            ->latest()
            ->get();

        return view('layouts.guest',[
            'rooms' => $rooms,

        ]);
    }
}
