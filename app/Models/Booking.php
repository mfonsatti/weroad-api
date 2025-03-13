<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $booking_id)
 */
class Booking extends Model
{
    use HasUuids;

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';

    /**
     * @var string[]
     */
    protected $fillable = ['user_email', 'seats', 'travel_id', 'status', 'expires_at', 'amount', 'session_token'];

    /**
     * @var string[]
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * This set the booking amount equal to price*seats on creation
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($booking) {
            $travel = Travel::findOrFail($booking->travel_id);
            if ($travel) {
                $booking->amount = $travel->price * $booking->seats;
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }
}
