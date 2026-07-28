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
}
