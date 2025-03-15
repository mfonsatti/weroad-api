<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\TravelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TravelRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected TravelRepository $travelRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelBali = Travel::factory()->create();
        $this->travelBangkok = Travel::factory()->create();
        $this->travelSingapore = Travel::factory()->create();

        $this->booking1 = Booking::factory()->create([
            'travel_id'  => $this->travelBali->id,
            'seats'      => 4,
            'status'     => Booking::STATUS_CONFIRMED
        ]);

        $this->booking2 = Booking::factory()->create([
            'travel_id'  => $this->travelBali->id,
            'user_email' => 'user@example.com',
            'seats'      => 1
        ]);

        $this->booking3 = Booking::factory()->create([
            'travel_id'  => $this->travelBangkok->id,
            'seats'      => 1,
            'status'     => Booking::STATUS_CONFIRMED
        ]);

        // expired
        $this->booking4 = Booking::factory()->create([
            'travel_id'  => $this->travelBangkok->id,
            'seats'      => 4,
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
