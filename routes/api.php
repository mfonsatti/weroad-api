<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\TravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/travels', [TravelController::class, 'getAvailableTravels']);

Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'index']);
    Route::post('/reserve', [BookingController::class, 'reserve']);
    Route::post('/confirm', [BookingController::class, 'confirm']);
});

