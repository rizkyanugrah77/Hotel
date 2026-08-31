<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'rizky123@mail.com'],
            [
                'name' => 'Rizky Anugrah',
                'password' => bcrypt('rizky123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'asterixkun560@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('rizky123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            RoomSeeder::class,
            RoomUnitSeeder::class,
            BookingSeeder::class,
            FacilitySeeder::class,
        ]);

        $galleries = [
            ['image' => 'hero.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Hero Image'],
            ['image' => 'restaurant.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Restaurant'],
            ['image' => 'pool.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Pool'],
            ['image' => 'room-deluxe.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Deluxe Room'],
            ['image' => 'room-superior.png', 'is_featured' => true, 'room_id' => 2, 'caption' => 'Superior Room'],
            ['image' => 'room-villa.png', 'is_featured' => true, 'room_id' => 3, 'caption' => 'Villa'],
        ];

        if (Gallery::count() === 0) {
            Gallery::insert($galleries);
        }

    }
}
