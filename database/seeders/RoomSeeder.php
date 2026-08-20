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
                'description' => 'Immerse yourself in the breathtaking beauty of Samosir Island from our Deluxe Lake View
                            Room. Featuring floor-to-ceiling windows and a private balcony, this room offers
                            uninterrupted panoramic views of the magnificent Lake Toba. <br>

                            The interior blends modern luxury with subtle Batak cultural touches, including handwoven
                            ulos textile accents and local woodwork. The spacious 45 sqm room comes equipped with a
                            king-size premium bed, a plush seating area, and a marble bathroom with a rain shower.',
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
                'description' => 'Discover tranquility in our Superior Garden Room, where modern comfort meets natural
                            beauty. Nestled amidst lush tropical greenery, this room offers a serene escape with stunning
                            views of our manicured gardens. <br>

                            The 35 sqm space is designed for relaxation, featuring a queen-size bed, a comfortable
                            seating area, and large windows that invite natural light to fill the room. The ensuite
                            bathroom is fitted with modern amenities, ensuring a comfortable stay.',
                'capacity' => 2,
                'price' => 940000,
                'status' => 'available',
                'bed_type' => 'Queen',
                'image' => 'room-superior.png',
                'size' => '35',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lake Villa',
                'slug' => 'lake-villa',
                'description' => 'Experience ultimate luxury in our Lake Villa, offering spacious living areas and
                            direct access to the stunning shores of Lake Toba. This exclusive villa combines
                            opulent amenities with breathtaking natural surroundings. <br>

                            The 85 sqm villa features a separate living room, a dining area, and a private
                            swimming pool perfect for relaxing while enjoying panoramic views of Lake Toba. The
                            villa is equipped with two bedrooms—one with a king-size bed and the other with two
                            single beds—accommodating up to four guests comfortably. The modern kitchen allows for
                            personalized dining experiences, while the private balcony provides an ideal spot to
                            unwind and soak in the magnificent surroundings.',
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
