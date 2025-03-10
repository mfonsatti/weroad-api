<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';

    /**
     * @var string[]
     */
    protected $fillable = ['user_email', 'seats', 'travel_id', 'status', 'expires_at'];

    /**
     * @var string[]
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

}
