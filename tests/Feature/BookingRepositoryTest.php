<?php

namespace Tests\Feature;

use App\Exceptions\ExpiredBookingException;
use App\Exceptions\FullyBookedException;
use App\Http\Requests\BookingConfirmRequest;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\BookingRepository;
use Faker\Provider\Uuid;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected BookingRepository $bookingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travel = Travel::create([
            'price' => 199900,
            'slug' => 'test-travel',
            'name' => 'Test Travel',
            'description' => 'A test travel description',
            'startingDate' => '2025-01-01',
            'endingDate' => '2025-01-10',
            'moods' => ['nature' => 80, 'relax' => 20],
        ]);
        $this->bookingRepository = new BookingRepository();
    }

    #[Test]
    public function it_creates_a_pending_booking_successfully()
    {
        $bookingRequest = new BookingRequest([
            'travel_id' => $this->travel->id,
            'user_email' => 'test@example.com',
            'seats' => 2,
        ]);

        $booking = $this->bookingRepository->reserve($bookingRequest);

        $this->assertDatabaseHas('bookings', [
            'travel_id' => $this->travel->id,
            'user_email' => 'test@example.com',
            'seats' => 2,
            'status' => Booking::STATUS_PENDING,
        ]);

        $expectedExpiration = now()->addMinutes(15)->format('Y-m-d H:i:s');
        $this->assertEquals($expectedExpiration, $booking->expires_at->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function it_fails_if_travel_does_not_exist()
    {
        $bookingRequest = new BookingRequest([
            'travel_id' => Uuid::uuid(),
            'user_email' => 'test@example.com',
            'seats' => 2,
        ]);

        $this->expectException(QueryException::class);

        $this->bookingRepository->reserve($bookingRequest);
    }

    #[Test]
    public function it_fails_if_seats_are_more_than_allowed()
    {
        $data = [
            'travel_id' => $this->travel->id,
            'user_email' => 'test@example.com',
            'seats' => 99,
        ];

        $rules = (new BookingRequest())->rules();

        $this->expectException(ValidationException::class);

        Validator::make($data, $rules)->validate();
    }

    /**
     * @throws FullyBookedException
     * @throws ExpiredBookingException
     */
    #[Test]
    public function it_fails_if_travel_is_fully_booked()
    {
        $bookingRequest1 = new BookingRequest([
            'travel_id' => $this->travel->id,
            'user_email' => 'test1@example.com',
            'seats' => 1,
        ]);

        // Slow user reservation
        $booking1 = $this->bookingRepository->reserve($bookingRequest1);

        $bookingRequest2 = new BookingRequest([
            'travel_id' => $this->travel->id,
            'user_email' => 'test2@example.com',
            'seats' => 5,
        ]);

        // Fast user causing Fully Booked
        $booking2 = $this->bookingRepository->reserve($bookingRequest2);
        $bookingConfirmRequest2 = new BookingConfirmRequest([
            'booking_id' => $booking2->id
        ]);
        $this->bookingRepository->confirm($bookingConfirmRequest2);

        // Slow user confirmation attempt, but already Fully Booked
        $this->expectException(FullyBookedException::class);
        $bookingConfirmRequest1 = new BookingConfirmRequest([
            'booking_id' => $booking1->id
        ]);
        $this->bookingRepository->confirm($bookingConfirmRequest1);
    }
}
