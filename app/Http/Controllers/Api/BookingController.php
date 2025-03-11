<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExpiredBookingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingConfirmRequest;
use App\Http\Requests\BookingRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Exception;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingController extends Controller
{
    protected BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function reserve(BookingRequest $bookingRequest): JsonResponse
    {
        $booking = $this->bookingRepository->reserve($bookingRequest);

        return response()->json([
            'message' => 'Booking reserved successfully',
            'data'    => $booking,
        ], 201);
    }

    public function confirm(BookingConfirmRequest $bookingConfirmRequest): JsonResponse
    {
        $booking = $this->bookingRepository->confirm($bookingConfirmRequest);

        return response()->json([
            'message' => 'Booking confirmed successfully',
            'data'    => $booking,
        ], 200);
    }
}
