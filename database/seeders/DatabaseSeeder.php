<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}
