<?php

namespace App\Repositories\Interfaces;

interface TravelRepositoryInterface
{
    public function findAvailableTravels();
    public function findById(int $id);
}
