<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
{
    Trip::create([
        'FromCity' => 'Nablus',
        'ToCity' => 'Ramallah',
        'FromRegion' => 'Nablus',
        'ToRegion' => 'Ramallah',
        'DepartureTime' => '10:00',
        'ArrivalTime' => '11:30',
        'DateTrip' => now(),
        'Price' => 25,
        'BookedSeats' => 1,
        'TotalSeats' => 12,
        'replied_admin' => 0,
        'status' => 'active',
        'trip_repeat' => 0,
        'note' => 'Comfortable trip',
        'driver_id' => 1,
        'transport' => 'Van',
    ]);
}
}
