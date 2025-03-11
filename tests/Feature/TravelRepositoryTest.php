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

        $this->travel1 = Travel::create([
            'price'        => 199900,
            'slug'         => 'test-travel',
            'name'         => 'Test Travel',
            'description'  => 'A test travel description',
            'startingDate' => '2025-01-01',
            'endingDate'   => '2025-01-10',
            'moods'        => ['nature' => 80, 'relax' => 20],
        ]);

        $this->travel2 = Travel::create([
            'price'        => 199900,
            'slug'         => 'test-travel-2',
            'name'         => 'Test Travel',
            'description'  => 'A test travel description',
            'startingDate' => '2025-01-01',
            'endingDate'   => '2025-01-10',
            'moods'        => ['nature' => 80, 'relax' => 20],
        ]);

        $this->booking1 = Booking::create([
            'travel_id'  => $this->travel1->id,
            'user_email' => 'user@example.com',
            'seats'      => 4,
            'status'     => Booking::STATUS_CONFIRMED,
            'expires_at' => now()->addMinutes(15),
            'amount'     => $this->travel1->price * 4,
        ]);

        $this->booking2 = Booking::create([
            'travel_id'  => $this->travel1->id,
            'user_email' => 'user@example.com',
            'seats'      => 1,
            'status'     => Booking::STATUS_PENDING,
            'expires_at' => now()->addMinutes(15),
            'amount'     => $this->travel1->price * 1,
        ]);

        $this->booking3 = Booking::create([
            'travel_id'  => $this->travel2->id,
            'user_email' => 'user@example.com',
            'seats'      => 1,
            'status'     => Booking::STATUS_CONFIRMED,
            'expires_at' => now()->addMinutes(15),
            'amount'     => $this->travel2->price * 3,
        ]);

        $this->booking4 = Booking::create([
            'travel_id'  => $this->travel2->id,
            'user_email' => 'user@example.com',
            'seats'      => 4,
            'status'     => Booking::STATUS_PENDING,
            'expires_at' => now()->subMinutes(15),
            'amount'     => $this->travel2->price * 4,
        ]);

        $this->travelRepository = new TravelRepository();
    }

    #[Test]
    public function it_finds_only_travels_with_less_than_five_confirmed_bookings()
    {
        $travels = $this->travelRepository->findAvailableTravels();
        $this->assertCount(1, $travels);
    }
}
