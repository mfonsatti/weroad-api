<?php

namespace Database\Factories;

use App\Models\Booking;
use Faker\Provider\Uuid;
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
            'travel_id' => Uuid::uuid(),
            'user_email' => $this->faker->unique()->safeEmail(),
            'seats' => $this->faker->numberBetween(1, 5),
            'status' => Booking::STATUS_PENDING,
            'expires_at' => now()->addMinutes(15),
        ];
    }
}
