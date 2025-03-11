<?php

namespace App\Repositories;

use App\DTO\BookingDto;
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

    public function reserve(BookingDto $bookingDto)
    {
        return Booking::create([
            'travel_id' => $bookingDto['travel_id'],
            'user_email' => $bookingDto['user_email'],
            'seats' => $bookingDto['seats'],
            'status' => Booking::STATUS_PENDING,
            'expires_at' => now()->addMinutes(15),
        ]);
    }

    public function confirm()
    {
        // TODO: Implement confirm() method.
    }
}
