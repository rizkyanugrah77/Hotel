<?php

namespace Database\Seeders;

use App\Models\Facility;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gallery;
use App\Models\RoomFacility;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('pasword123'),
            'role' => 'customer',
        ]);
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'asterixkun560@gmail.com',
            'password' => bcrypt('pasword123'),
            'role' => 'admin',
        ]);

        $this->call([
            RoomSeeder::class,
        ]);

        $galleries = [
            ['image' => 'hero.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Hero Image'],
            ['image' => 'restaurant.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Restaurant'],
            ['image' => 'pool.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Pool'],
            ['image' => 'room-deluxe.png', 'is_featured' => true, 'room_id' => 1, 'caption' => 'Deluxe Room'],
            ['image' => 'room-superior.png', 'is_featured' => true, 'room_id' => 2, 'caption' => 'Superior Room'],
            ['image' => 'room-villa.png', 'is_featured' => true, 'room_id' => 3, 'caption' => 'Villa'],
        ];

        Gallery::insert($galleries);

        $facilities = [
            [
                'icon'=> ' <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                                </svg>',
                'name' => 'Wi-Fi',
                'description' => 'Free high-speed Wi-Fi throughout the property',
            ],
            [
                'icon'=> '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 7.5l-.625-1.659a1.875 1.875 0 0 0-1.282-1.282L15 5.25 14.205 3.61c-.164-.468-.63-.808-1.122-.808-.492 0-.958.34-.124.808L12.75 7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>',
                'name' => 'Air Conditioning',
                'description' => 'Stay cool with our individually controlled air conditioning system',
            ],
            [
                'icon'=> '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.362 5.174a4.3 4.3 0 0 0-5.941 0M4 8v11a2 2 0 0 0 2 2h6l2-3V9a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2Zm3 2v5l1 1 1-1V9l-1-1-1 1zM21 15a2 2 0 0 1-2 2H17l-2-3v-3l2.5-2.5A2.002 2.002 0 0 1 21 12v3z" />
                                </svg>',
                'name' => 'Television',
                'description' => 'Flat-screen TV with premium cable channels and streaming access',
            ],
            [
                'icon'=> '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 20h6a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10l4.553-2.276A1.5 1.5 0 0 1 21 8.618v6.764a1.5 1.5 0 0 1-1.447 1.342L15 14M5 18H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2v12Z" />
                                </svg>',
                'name' => 'Mini Fridge',
                'description' => 'A compact refrigerator to keep your drinks and snacks cool',
            ],
            [
                'icon'=> '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 12.75l6 6 9-13.5" />
                                </svg>',
                'name' => 'Private Bathroom',
                'description' => 'En-suite bathroom with complimentary toiletries and fresh towels',
            ],
            [
                'icon'=> '  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>',
                'name' => 'Minibar',
                'description' => 'A compact refrigerator stocked with your favorite drinks and snacks, available upon request.',
           
            ],
            [
                'icon'=> '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>',
                'name' => 'Private Balcony',
                'description' => 'Enjoy the fresh air and scenic views from your private balcony',
              
            ],
 
        ];
        Facility::insert($facilities);

        $facilityRoom = [
        ['room_id' => 1, 'facility_id' => 1,],
        ['room_id' => 1, 'facility_id' => 2,],
        ['room_id' => 1, 'facility_id' => 3,],
        ['room_id' => 1, 'facility_id' => 4,],
        ['room_id' => 1, 'facility_id' => 5,],
        ['room_id' => 1, 'facility_id' => 6,],
        ['room_id' => 1, 'facility_id' => 7,],
        ['room_id' => 2, 'facility_id' => 1,],
        ['room_id' => 2, 'facility_id' => 2,],
        ['room_id' => 2, 'facility_id' => 3,],
        ['room_id' => 2, 'facility_id' => 4,],
        ['room_id' => 2, 'facility_id' => 5,],
        ['room_id' => 2, 'facility_id' => 6,],
        ['room_id' => 2, 'facility_id' => 7,],
        ['room_id' => 3, 'facility_id' => 1,],
        ['room_id' => 3, 'facility_id' => 2,],
        ['room_id' => 3, 'facility_id' => 3,],
        ['room_id' => 3, 'facility_id' => 4,],
        ['room_id' => 3, 'facility_id' => 5,],
        ['room_id' => 3, 'facility_id' => 6,],
        ['room_id' => 3, 'facility_id' => 7,],
        ];
        RoomFacility::insert($facilityRoom);

    }
}
