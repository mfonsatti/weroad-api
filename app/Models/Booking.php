<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Booking extends Model
{
    use HasUuids;

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
