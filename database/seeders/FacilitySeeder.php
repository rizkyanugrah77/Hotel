<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            'Wi-Fi' => [
                'description' => 'Akses internet di dalam kamar.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856a9.75 9.75 0 0 1 13.788 0M1.924 8.674a14.25 14.25 0 0 1 20.152 0M12 18.75h.008v.008H12V18.75Z" /></svg>',
            ],
            'AC' => [
                'description' => 'Pendingin udara di dalam kamar.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m12 2.25 1.5 3.75L17.25 4.5 15.75 8.25 19.5 9.75l-3.75 1.5 1.5 3.75-3.75-1.5L12 17.25l-1.5-3.75-3.75 1.5 1.5-3.75-3.75-1.5 3.75-1.5L6.75 4.5 10.5 6 12 2.25Z" /></svg>',
            ],
            'TV' => [
                'description' => 'Televisi di dalam kamar.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5v10.5H3.75V6.75ZM8.25 21h7.5M12 17.25V21M8.25 3l3.75 3.75L15.75 3" /></svg>',
            ],
            'Kamar Mandi Pribadi' => [
                'description' => 'Kamar mandi pribadi dengan perlengkapan mandi.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75h15m-13.5 0V9a1.5 1.5 0 0 1 3 0v3.75m-6 0v2.25a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2.25M6 21v-3m12 3v-3" /></svg>',
            ],
            'Balkon' => [
                'description' => 'Area balkon pribadi.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 21V3.75h15V21M3 21h18M8.25 8.25h.008v.008H8.25V8.25Zm3.75 0h.008v.008H12V8.25Zm3.75 0h.008v.008H15.75V8.25ZM7.5 21v-5.25h9V21" /></svg>',
            ],
            'Kolam Renang Pribadi' => [
                'description' => 'Kolam renang khusus untuk kamar villa.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15.75c1.5 1.5 3 1.5 4.5 0s3-1.5 4.5 0 3 1.5 4.5 0 3-1.5 4.5 0M3 19.5c1.5 1.5 3 1.5 4.5 0s3-1.5 4.5 0 3 1.5 4.5 0 3-1.5 4.5 0M7.5 12V5.25a2.25 2.25 0 0 1 4.5 0V12M12 5.25h4.5V12" /></svg>',
            ],
            'Dapur' => [
                'description' => 'Area dapur di dalam kamar villa.',
                'icon' => '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v7.5m-3-7.5v4.5a3 3 0 0 0 6 0V3m-3 7.5V21m7.5-18v7.5m0 0a3 3 0 0 0 3-3V3m-3 7.5V21" /></svg>',
            ],
        ];

        $facilityIds = [];

        foreach ($facilities as $name => $attributes) {
            $facilityIds[$name] = Facility::updateOrCreate(
                ['name' => $name],
                $attributes
            )->id;
        }

        $roomFacilities = [
            'deluxe-lake-view' => ['Wi-Fi', 'AC', 'TV', 'Kamar Mandi Pribadi', 'Balkon'],
            'superior-garden' => ['Wi-Fi', 'AC', 'TV', 'Kamar Mandi Pribadi'],
            'lake-villa' => ['Wi-Fi', 'AC', 'TV', 'Kamar Mandi Pribadi', 'Balkon', 'Kolam Renang Pribadi', 'Dapur'],
        ];

        foreach ($roomFacilities as $roomSlug => $facilityNames) {
            $room = Room::where('slug', $roomSlug)->first();

            if ($room) {
                $room->facilities()->syncWithoutDetaching(
                    array_map(fn (string $name) => $facilityIds[$name], $facilityNames)
                );
            }
        }
    }
}
