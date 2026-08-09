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
            'name' => 'Rizky Anugrah',
            'email' => 'rizky123@mail.com',
            'password' => bcrypt('rizky123'),
            'role' => 'customer',
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'asterixkun560@gmail.com',
            'password' => bcrypt('rizky123'),
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
                'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48"><title xmlns="">air-conditioning</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><rect width="40" height="20" x="4" y="8" rx="2"/><path d="M12 20h24v8H12zm20-6h4M24 34v6m-8-4v2m16-2v2"/></g></svg>',
                'name' => 'Air Conditioning',
                'description' => 'Stay cool with our individually controlled air conditioning system',
            ],
            [
                'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1em" viewBox="0 0 1920 1536"><title xmlns="">television</title><path fill="currentColor" d="M1792 1120V160q0-13-9.5-22.5T1760 128H160q-13 0-22.5 9.5T128 160v960q0 13 9.5 22.5t22.5 9.5h1600q13 0 22.5-9.5t9.5-22.5m128-960v960q0 66-47 113t-113 47h-736v128h352q14 0 23 9t9 23v64q0 14-9 23t-23 9H544q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h352v-128H160q-66 0-113-47T0 1120V160Q0 94 47 47T160 0h1600q66 0 113 47t47 113"/></svg>',
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
                'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><title xmlns="">bathroom</title><path fill="currentColor" d="M464 280H80V100a51.26 51.26 0 0 1 15.113-36.485l.4-.4a51.69 51.69 0 0 1 58.6-10.162a79.1 79.1 0 0 0 11.778 96.627l10.951 10.951l-20.157 20.158l22.626 22.626l20.157-20.157L311.157 71.471l20.157-20.157l-22.627-22.627l-20.158 20.157l-10.951-10.951a79.086 79.086 0 0 0-100.929-8.976A83.61 83.61 0 0 0 72.887 40.485l-.4.4A83.05 83.05 0 0 0 48 100v180H16v32h32v30.7a24 24 0 0 0 1.232 7.589L79 439.589A23.97 23.97 0 0 0 101.766 456h12.9L103 496h33.333L148 456h208.1l12 40h33.4l-12-40h20.73A23.97 23.97 0 0 0 433 439.589l29.766-89.3A24 24 0 0 0 464 342.7V312h32v-32ZM188.52 60.52a47.025 47.025 0 0 1 66.431 0L265.9 71.471L199.471 137.9l-10.951-10.949a47.027 47.027 0 0 1 0-66.431M432 341.4L404.468 424H107.532L80 341.4V312h352Z"/></svg>',
                'name' => 'Private Bathroom',
                'description' => 'En-suite bathroom with complimentary toiletries and fresh towels',
            ],
            [
                'icon'=> ' <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><title xmlns="">bar</title><path fill="currentColor" d="M25 11H15a1 1 0 0 0-1 1v4a6.005 6.005 0 0 0 5 5.91V28h-3v2h8v-2h-3v-6.09A6.005 6.005 0 0 0 26 16v-4a1 1 0 0 0-1-1m-1 5a4 4 0 0 1-8 0v-3h8Z"/><path fill="currentColor" d="M15 1h-5a1 1 0 0 0-1 1v7.37A6.09 6.09 0 0 0 6 15v14a1 1 0 0 0 1 1h5v-2H8V15c0-3.187 2.231-4.02 2.316-4.051L11 10.72V3h3v5h2V2a1 1 0 0 0-1-1"/></svg>',
                'name' => 'Minibar',
                'description' => 'A compact refrigerator stocked with your favorite drinks and snacks, available upon request.',
           
            ],
            [   
                'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><title xmlns="">balcony</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 13v8m4-8v8m8-8v8m-4-8v8m8-8v8M2 21h20M2 13h20m-4-3V3.6a.6.6 0 0 0-.6-.6H6.6a.6.6 0 0 0-.6.6V10"/></svg>',
                'name' => 'Private Balcony',
                'description' => 'Enjoy the fresh air and scenic views from your private balcony',
              
            ],
            [
                'icon'=> '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64"><title xmlns="">beach</title><circle cx="32" cy="32" r="30" fill="#fff"/><path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 46c8-7 18-6 20 0m10-30L42 28m-10 10L32 42l-4-8m-10-10L14 28m12-10c-3 7-8 14-8 18M20 26c12-7 20 0 20-10"/><path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M42 28l-4-8M32 42l-4-8m24 14V44m-48 0V44"/><circle cx="32" cy="24" r="5" fill="none" stroke="#000" stroke-width="2"/></svg>',
                'name' => 'Beachfront',
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
