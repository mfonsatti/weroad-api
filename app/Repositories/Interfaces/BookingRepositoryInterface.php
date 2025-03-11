<?php

namespace App\Repositories\Interfaces;

use App\DTO\BookingDto;
use App\Models\Travel;

interface BookingRepositoryInterface
{
    public function findByEmail(string $email);
    public function findByTravel(Travel $travel_id);
    public function findById(int $id);
    public function reserve(BookingDto $bookingDto);
    public function confirm();
}
