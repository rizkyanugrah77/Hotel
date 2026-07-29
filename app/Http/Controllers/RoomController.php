<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('facilities')
            ->latest()
            ->get();

        return view('admin.rooms-manager', [
            'rooms' => $rooms,
        ]);
    }

    public function show()
    {
        $rooms = Room::with('facilities')->get();

        return view('index', ['landing_pages' => $rooms]);
    }

    // public function detail($slug)
    // {
    //     $room = Room::with('facilities')->where('slug', $slug)->first();

    //     return view('room-detail', compact('room'));
    // }
}
