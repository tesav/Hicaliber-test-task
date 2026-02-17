<?php

namespace App\Domains\Property\DTO;

final class PropertyFilterDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?int $bathrooms,
        public readonly ?int $bedrooms,
        public readonly ?int $storeys,
        public readonly ?int $garages,
        public readonly ?int $priceMin,
        public readonly ?int $priceMax,
        public readonly ?string $sortBy = null,
        public readonly string $sortOrder = 'asc',
        public readonly int $perPage = 10,
    ) {
    }
}
