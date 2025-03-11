<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
class ExpiredBookingException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $this->getMessage(),
        ], 410);
    }
}
