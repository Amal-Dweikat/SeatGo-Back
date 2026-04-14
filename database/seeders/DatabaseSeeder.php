<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = \App\Models\User::factory(30)->create();


        $drivers = $users->where('role', 'driver');

        foreach ($drivers as $user) {
            $driver = \App\Models\Driver::factory()->create([
                'user_id' => $user->id,
            ]);


            \App\Models\Car::factory(1)->create([
                'driver_id' => $driver->id,
            ]);


            $trips = \App\Models\Trip::factory(2)->create([
                'driver_id' => $driver->id,
            ]);

            foreach ($trips as $trip) {

                if (fake()->boolean(50)) {
                    \App\Models\RepeatTrip::factory()->create([
                        'trip_id' => $trip->id,
                    ]);
                }
            }
        }

        \App\Models\Booking::factory(50)->create();
    }
}
