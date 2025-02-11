<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Event::factory(100)->create();
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
