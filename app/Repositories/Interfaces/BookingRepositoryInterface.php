<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\BookingConfirmRequest;
use App\Http\Requests\BookingRequest;
use App\Models\Travel;

interface BookingRepositoryInterface
{
    public function findByEmail(string $email);

    public function reserve(BookingRequest $bookingRequest);

    public function confirm(BookingConfirmRequest $bookingConfirmRequest);
}
