<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static findOrFail(int $id)
 * @method static whereHas(string $string, \Closure $param, string $string1, int $int)
 * @method static whereIn(string $string, \Closure $param)
 * @method static factory()
 * @method static leftJoin(string $string, \Closure $param)
 */
class Travel extends Model
{
    use HasUuids, HasFactory;

    /**
     * @var string
     */
    protected $table = "travels";

    /**
     * @var string[]
     */
    protected $fillable = [
        'slug', 'name', 'description', 'startingDate', 'endingDate', 'price', 'moods',
    ];

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => $value / 100
        );
    }

    protected function casts(): array
    {
        return [
            'moods' => 'array',
        ];
    }
}
