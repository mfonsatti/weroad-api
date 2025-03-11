<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingController extends Controller
{
    protected BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function reserve(BookingRequest $request): JsonResponse
    {
        $booking = $this->bookingRepository->reserve($request);

        return response()->json([
            'message' => 'Booking reserved successfully',
            'data' => $booking,
        ], 201);
    }

    public function confirm(): JsonResponse
    {
        $travels = $this->bookingRepository->confirm();
        return response()->json($travels);
    }
}
