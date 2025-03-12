<?php

namespace App\Repositories;

use App\Models\Travel;
use App\Repositories\Interfaces\TravelRepositoryInterface;

class TravelRepository implements TravelRepositoryInterface
{
    public function findAvailableTravels()
    {
        return Travel::leftJoin('bookings', function ($join) {
            $join->on('travels.id', '=', 'bookings.travel_id')
                ->whereIn('bookings.status', ['confirmed', 'pending'])
                ->where('bookings.expires_at', '>', now());
        })
            ->select('travels.*')
            ->groupBy('travels.id')
            ->havingRaw('COALESCE(SUM(bookings.seats), 0) < 5')
            ->get();

    }

    public function findById(int $id)
    {
        return Travel::findOrFail($id);
    }
}
