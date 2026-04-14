<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'driver_id' => \App\Models\Driver::factory(),
            'type' => fake()->randomElement(['Toyota', 'Hyundai', 'BMW']),
            'plate_number' => fake()->unique()->bothify('###-???'),
            'color' => fake()->safeColorName(),
            'seats' => fake()->numberBetween(3, 7),
        ];
    }
}
