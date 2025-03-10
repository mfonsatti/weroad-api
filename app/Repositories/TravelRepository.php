<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\Interfaces\TravelRepositoryInterface;

class TravelRepository implements TravelRepositoryInterface
{
    public function findAvailableTravels()
    {
        return Travel::whereIn('id', function ($query) {
            $query->select('travel_id')
                ->from('bookings')
                ->where('status', Booking::STATUS_CONFIRMED)
                ->groupBy('travel_id')
                ->havingRaw('SUM(seats) < 5');
        })->get();
    }

    public function findById(int $id)
    {
        return Travel::findOrFail($id);
    }
}
