<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TravelRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TravelController extends Controller
{
    protected TravelRepositoryInterface $travelRepository;

    public function __construct(TravelRepositoryInterface $travelRepository)
    {
        $this->travelRepository = $travelRepository;
    }

    public function getAvailableTravels(): JsonResponse
    {
        $travels = $this->travelRepository->findAvailableTravels();
        return response()->json($travels);
    }
}
