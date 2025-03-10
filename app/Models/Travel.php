<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Travel extends Model
{
    use HasUuids;

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
     * @return Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => $value / 100
        );
    }

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'moods' => 'array',
        ];
    }
}
