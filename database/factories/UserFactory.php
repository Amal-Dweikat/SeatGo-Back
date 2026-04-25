<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('123456'),
            'phone_number' => fake()->unique()->phoneNumber(),
            'role' => fake()->randomElement(['passenger', 'driver']),
            'average_rating' => fake()->randomFloat(2, 0, 5),
            'profile_picture' => fake()->randomElement([
                'Driver1.jpg',
                'Driver2.jpg',
                'Driver3.jpg',
                'Driver4.jpg',
                'Driver5.jpg',
                'Driver6.jpg',
            ]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
