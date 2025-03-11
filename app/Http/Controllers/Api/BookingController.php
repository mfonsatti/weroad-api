<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingController extends Controller
{
    protected BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function reserve(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'travel_id' => 'required|exists:travels,id',
                'user_email' => 'required|email',
                'seats' => 'required|integer|min:1',
            ]);

            $booking = $this->bookingRepository->reserve($data);

            return response()->json([
                'message' => 'Booking reserved successfully',
                'data' => $booking,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function confirm(): JsonResponse
    {
        $travels = $this->bookingRepository->confirm();
        return response()->json($travels);
    }
}
