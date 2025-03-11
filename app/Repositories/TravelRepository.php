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
                ->whereIn('status', [Booking::STATUS_CONFIRMED, Booking::STATUS_PENDING])
                ->where(function ($query) {
                    $query->where('status', Booking::STATUS_CONFIRMED)
                        ->orWhere('expires_at', '>', now());
                })
                ->groupBy('travel_id')
                ->havingRaw('SUM(seats) < 5');
        })->get();
    }

    public function findById(int $id)
    {
        return Travel::findOrFail($id);
    }
}
