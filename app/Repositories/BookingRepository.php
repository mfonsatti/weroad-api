<?php

namespace App\Repositories;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\Interfaces\BookingRepositoryInterface;

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

    public function confirm()
    {
        // TODO: Implement confirm() method.
    }
}
