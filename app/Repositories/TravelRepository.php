<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\Interfaces\TravelRepositoryInterface;

class TravelRepository implements TravelRepositoryInterface
{
    public function findAvailableTravels()
    {
        return Travel::whereHas('bookings', function ($query) {
            $query->where('status', Booking::STATUS_CONFIRMED);
        }, '<', 5)->get();
    }

    public function findById(int $id)
    {
        return Travel::findOrFail($id);
    }
}
