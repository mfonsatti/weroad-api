<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\TravelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TravelRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected TravelRepository $travelRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // 4 Seats confirmed Travel_1
        Booking::create([
            'travel_id'  => '4f4bd032-e7d4-402a-bdf6-aaf6be240d53',
            'user_email' => 'user@example.com',
            'seats'      => 4,
            'status'     => Booking::STATUS_CONFIRMED,
            'expires_at' => now()->addMinutes(15),
        ]);

        // 1 Seats pending Travel_1
        Booking::create([
            'travel_id'  => '4f4bd032-e7d4-402a-bdf6-aaf6be240d53',
            'user_email' => 'user@example.com',
            'seats'      => 1,
            'status'     => Booking::STATUS_PENDING,
            'expires_at' => now()->addMinutes(15),
        ]);

        // 1 Seats confirmed Travel_2
        Booking::create([
            'travel_id'  => 'cbf304ae-a335-43fa-9e56-811612dcb601',
            'user_email' => 'user@example.com',
            'seats'      => 1,
            'status'     => Booking::STATUS_CONFIRMED,
            'expires_at' => now()->addMinutes(15),
        ]);

        // EXPIRED 4 Seats pending Travel_2
        Booking::create([
            'travel_id'  => 'cbf304ae-a335-43fa-9e56-811612dcb601',
            'user_email' => 'user@example.com',
            'seats'      => 4,
            'status'     => Booking::STATUS_PENDING,
            'expires_at' => now()->subMinutes(15),
        ]);

        $this->travelRepository = new TravelRepository();
    }

    #[Test]
    public function it_finds_only_travels_with_less_than_five_confirmed_bookings()
    {
        $travels = $this->travelRepository->findAvailableTravels();
        $this->assertCount(2, $travels);
    }
}
