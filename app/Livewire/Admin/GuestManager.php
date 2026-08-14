<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class GuestManager extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $guests = User::where('role', 'customer')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->withCount('bookings')
            ->withSum(['bookings as total_spent' => function ($q) {
                $q->where('status', 'paid');
            }], 'total_price')
            ->latest()
            ->paginate(10);

        $totalGuests = User::where('role', 'customer')->count();
        $newGuestsThisMonth = User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $guestsWithBookings = User::where('role', 'customer')->has('bookings')->count();

        return view('livewire.admin.guest-manager', [
            'guests' => $guests,
            'totalGuests' => $totalGuests,
            'newGuestsThisMonth' => $newGuestsThisMonth,
            'guestsWithBookings' => $guestsWithBookings,
        ]);
    }
}
