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
        $cities = [
            'Ramallah' => ['Al-Tireh', 'Beitunia', 'Al-Bireh'],
            'Nablus' => ['Rafidia', 'Beit Furik', 'Tell'],
            'Hebron' => ['Halhul', 'Dura', 'Yatta'],
            'Bethlehem' => ['Beit Sahour', 'Beit Jala', 'Al-Khader'],
            'Jenin' => ['Qabatiya', 'Arraba', 'Yaabad'],
            'Tulkarm' => ['Anabta', 'Attil', 'Deir al-Ghusun'],
            'Qalqilya' => ['Azzun', 'Habla', 'Kafr Thulth'],
            'Jerusalem' => ['Silwan', 'Shuafat', 'Beit Hanina'],
            'Gaza' => ['Jabalia', 'Rafah', 'Khan Yunis'],
            'Jericho' => ['Al-Auja', 'Ein ad-Duyuk'],
            'Tubas' => ['Tammun', 'Aqqaba'],
        ];
        $fromCity = fake()->randomElement(array_keys($cities));
        $toCity = fake()->randomElement(array_keys($cities));

        $fromRegion = fake()->randomElement($cities[$fromCity]);
        $toRegion = fake()->randomElement($cities[$toCity]);
        return [
            'FromCity' => $fromCity,
            'transport' => fake()->randomElement([
                'car',
                'bus',
                'taxi',
                'uber',
                'van',
                'motorcycle'
            ]),
            'ToCity' => $toCity ,

            'FromRegion' => $fromRegion ,
            'ToRegion' => $toRegion,
            'DepartureTime' => fake()->time('H:i'),
            'ArrivalTime' => fake()->time('H:i'),
            'DateTrip' => fake()->date(),
            'Price' => fake()->numberBetween(50, 100),
            'BookedSeats' => 0,
            'TotalSeats' => fake()->numberBetween(3, 7),
            'RepliedAdmin' => false,
            'status' => fake()->randomElement(['pending','approved', 'active', 'completed', 'cancelled']),
            'TripRepeat' => fake()->boolean(),
            'driver_id' => \App\Models\Driver::factory(),
        ];
    }
}
