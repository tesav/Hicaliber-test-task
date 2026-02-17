<?php

namespace App\Domains\Property\Entities;

class Property
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly int $bedrooms,
        public readonly int $bathrooms,
        public readonly int $storeys,
        public readonly int $garages,
        public readonly float $price,
    ) {
    }
}
