<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TravelController;

Route::get('/travels', [TravelController::class, 'getAvailableTravels']);

