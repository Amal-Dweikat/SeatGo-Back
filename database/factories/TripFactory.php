<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'FromCity' => fake()->city(),
            'transport' => fake()->randomElement([
                'car',
                'bus',
                'taxi',
                'uber',
                'van',
                'motorcycle'
            ]),
            'ToCity' => fake()->city(),
            'FromRegion' => fake()->state(),
            'ToRegion' => fake()->state(),
            'DepartureTime' => fake()->time(),
            'ArrivalTime' => fake()->time(),
            'DateTrip' => fake()->date(),
            'Price' => fake()->numberBetween(5, 50),
            'BookedSeats' => 0,
            'TotalSeats' => fake()->numberBetween(3, 7),
            'RepliedAdmin' => false,
            'status' => fake()->randomElement(['pending', 'active', 'completed', 'cancelled']),
            'TripRepeat' => fake()->boolean(),
            'driver_id' => \App\Models\Driver::factory(),
        ];
    }
}
