<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        $bookings = Booking::with('room', 'user')->get();

        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $totalBookings = Booking::count();
        $activeBookings = Booking::where('status', 'pending')->count();
        $roomStats = $bookings->groupBy('room.name')->map(function ($group) {
            return [
                'total' => $group->count(),
                'occupied' => $group->where('status', '!=', 'cancelled')->count(),
                'available' => $group->where('status', 'cancelled')->count(),
            ];
        });

        return view('admin.dashboard', compact('bookings', 'totalRevenue', 'totalBookings', 'activeBookings', 'roomStats'))->layout('layouts.app');
    }
}
