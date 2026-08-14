<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        $rooms = Room::with('bookings', 'bookings.user')->get();

        $totalRevenue = Booking::where('status', 'paid')->sum('total_price');
        $totalBookings = Booking::count();
        $activeBookings = Booking::where('status', 'pending')->count();
        $roomStats = $rooms->groupBy('name')->map(function ($group) {
            return [
                'total' => $group->count(),
                'occupied' => $group->where('status', '!=', 'cancelled')->count(),
                'available' => $group->where('status', 'cancelled')->count(),
            ];
        });

        return view('admin.dashboard', compact('rooms', 'totalRevenue', 'totalBookings', 'activeBookings', 'roomStats'))->layout('layouts.app');
    }
}
