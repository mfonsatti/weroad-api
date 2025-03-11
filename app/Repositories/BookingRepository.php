<?php

namespace App\Repositories;

use App\Exceptions\ExpiredBookingException;
use App\Http\Requests\BookingConfirmRequest;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingRepository implements BookingRepositoryInterface
{
    public function findByEmail(string $email)
    {
        // TODO: Implement findByEmail() method.
    }

    public function findByTravel(Travel $travel_id)
    {
        // TODO: Implement findByTravel() method.
    }

    public function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    public function reserve(BookingRequest $bookingRequest)
    {
        return Booking::create([
            'travel_id' => $bookingRequest['travel_id'],
            'user_email' => $bookingRequest['user_email'],
            'seats' => $bookingRequest['seats'],
            'status' => Booking::STATUS_PENDING,
            'expires_at' => now()->addMinutes(15),
        ]);
    }

    /**
     * @throws ExpiredBookingException
     */
    public function confirm(BookingConfirmRequest $bookingConfirmRequest)
    {
        $booking = Booking::where('id', $bookingConfirmRequest->input('booking_id'))
            ->where('status', Booking::STATUS_PENDING)
            ->first();

        if ($booking->expires_at <= now()) {
            throw new ExpiredBookingException("Booking has expired and cannot be confirmed.");
        }

        //TODO: check concurrency seats availability for this travel

        $booking->update(['status' => Booking::STATUS_CONFIRMED]);

        return $booking;
    }
}
