<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'UserWantRepeat' => fake()->boolean(),
            'numSeatBooked' => fake()->numberBetween(1,3),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'trip_id' => \App\Models\Trip::inRandomOrder()->first()->id,
        ];
    }
}
