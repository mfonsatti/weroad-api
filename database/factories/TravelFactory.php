<?php

namespace Database\Factories;

use App\Models\Travel;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'           => Uuid::uuid(),
            'slug'         => Str::slug($this->faker->words(3, true)),
            'name'         => $this->faker->sentence(3),
            'description'  => $this->faker->paragraph(),
            'startingDate' => $this->faker->dateTimeBetween('+1 month', '+3 months')->format('Y-m-d'),
            'endingDate'   => $this->faker->dateTimeBetween('+4 months', '+6 months')->format('Y-m-d'),
            'price'        => $this->faker->numberBetween(100000, 300000),
            'moods'        => [
                'nature'  => $this->faker->numberBetween(0, 100),
                'relax'   => $this->faker->numberBetween(0, 100),
                'history' => $this->faker->numberBetween(0, 100),
                'culture' => $this->faker->numberBetween(0, 100),
                'party'   => $this->faker->numberBetween(0, 100),
            ]
        ];
    }
}
