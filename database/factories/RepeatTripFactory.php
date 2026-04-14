<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class RepeatTripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'EndRepeat' => fake()->optional()->date(),
            'DriverSelectedDays' => fake()->randomElement([
                ['monday','wednesday'],
                ['friday'],
                ['saturday','sunday']
            ]),
            'trip_id' => \App\Models\Trip::factory(),
        ];
    }
}
