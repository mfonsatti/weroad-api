<?php

namespace App\Repositories;

use App\Exceptions\AlreadyConfirmedBookingException;
use App\Exceptions\ExpiredBookingException;
use App\Exceptions\FullyBookedException;
use App\Http\Requests\BookingConfirmRequest;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Travel;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return Booking::where('user_email', $email)->with('travel')->get();
    }

    public function reserve(BookingRequest $bookingRequest)
    {
        Travel::findOrFail($bookingRequest->input('travel_id'));

        return Booking::create([
            'travel_id'  => $bookingRequest['travel_id'],
            'user_email' => $bookingRequest['user_email'],
            'seats'      => $bookingRequest['seats'],
            'status'     => Booking::STATUS_PENDING,
            'expires_at' => now()->addMinutes(15),
        ]);
    }

    /**
     * @throws ExpiredBookingException
     * @throws FullyBookedException
     * @throws AlreadyConfirmedBookingException
     */
    public function confirm(BookingConfirmRequest $bookingConfirmRequest)
    {
        $booking = Booking::where('id', $bookingConfirmRequest->input('booking_id'))->first();
        if($booking->status === Booking::STATUS_CONFIRMED){
            throw new AlreadyConfirmedBookingException("Booking already confirmed.");
        }

        if ($booking->expires_at <= now()) {
            throw new ExpiredBookingException("Booking has expired and cannot be confirmed.");
        }

        // Last check for concurrency confirmed Booking on this travel
        $confirmedSeats = Booking::where('travel_id', $booking->travel_id)
            ->where('status', Booking::STATUS_CONFIRMED)
            ->sum('seats');

        if (($confirmedSeats + $booking->seats) > 5) {
            throw new FullyBookedException("Sorry, you're late! Not enough seats available for this travel.");
        }

        $booking->update(['status' => Booking::STATUS_CONFIRMED]);

        return $booking;
    }
}
