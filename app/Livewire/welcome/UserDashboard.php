<?php

namespace App\Livewire\Welcome;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Livewire\Component;

class UserDashboard extends Component
{

    public function cancel($id)
    {
        $cancelled = Booking::whereKey($id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        if ($cancelled) {
            session()->flash('success', 'Booking berhasil dibatalkan.');
        } else {
            session()->flash('error', 'Booking tidak ditemukan atau tidak dapat dibatalkan.');
        }

        return redirect()->route('user.dashboard');
    }

    public function render()
    {
        $user = auth()->user();
        $now = Carbon::now();

        // Active bookings (pending or confirmed, check_out in the future)
        $activeBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'paid'])
            ->where('check_out', '>=', $now)
            ->orderBy('check_in', 'asc')
            ->get();

        // Upcoming check-ins within the next 3 days
        $upcomingCheckins = Booking::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'paid'])
            ->whereBetween('check_in', [$now, $now->copy()->addDays(3)])
            ->orderBy('check_in', 'asc')
            ->get();

        // All bookings (history) — most recent first
        $allBookings = Booking::with('room',)
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $payments = Payment::with('booking')->whereIn('booking_id', $allBookings->pluck('id'))->get();


        // Stats
        $totalBookings = $allBookings->count();
        $totalSpent = $allBookings->where('status', '!=', 'cancelled')->sum('total_price');
        $activeCount = $activeBookings->count();
        $upcomingCount = $upcomingCheckins->count();

        return view('livewire.welcome.user-dashboard', [
            'user' => $user,
            'activeBookings' => $activeBookings,
            'upcomingCheckins' => $upcomingCheckins,
            'allBookings' => $allBookings,
            'totalBookings' => $totalBookings,
            'totalSpent' => $totalSpent,
            'activeCount' => $activeCount,
            'upcomingCount' => $upcomingCount,
            'payments' => $payments,
        ])->layout('layouts.user');
    }
}
