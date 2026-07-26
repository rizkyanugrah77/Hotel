<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::insert([
            [
                'name' => 'Deluxe Lake View',
                'slug' => 'deluxe-lake-view',
                'description' => 'Kamar premium dengan pemandangan langsung ke Danau Toba. Dilengkapi balkon pribadi dan fasilitas modern.',
                'capacity' => 2,
                'price' => 1330000,
                'status' => 'available',
                'bed_type' => 'King',
                'image' => 'room-deluxe.png',
                'size' => '45',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Superior Garden',
                'slug' => 'superior-garden',
                'description' => 'Kamar nyaman dengan pemandangan taman tropis. Cocok untuk pasangan yang mencari ketenangan.',
                'capacity' => 2,
                'price' => 940000,
                'status' => 'occupied',
                'bed_type' => 'Queen',
                'image' => 'room-superior.png',
                'size' => '35',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lake Villa',
                'slug' => 'lake-villa',
                'description' => 'Villa mewah tepi danau dengan private pool, ruang tamu, dan pemandangan spektakuler.',
                'capacity' => 4,
                'price' => 3870000,
                'status' => 'available',
                'bed_type' => 'King',
                'image' => 'room-villa.png',
                'size' => '85',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
