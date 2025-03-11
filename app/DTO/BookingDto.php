<?php

namespace App\DTO;

class BookingDto
{
    public function __construct(
        public string $travel_id,
        public string $user_email,
        public int $seats
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            travel_id: $data['travel_id'],
            user_email: $data['user_email'],
            seats: $data['seats']
        );
    }
}
