<?php

namespace App\Domains\Property\Repositories;

use App\Domains\Property\DTO\PropertyFilterDTO;
use App\Domains\Property\Entities\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PropertyRepositoryContract
{
    /**
     * @return LengthAwarePaginator<\App\Domains\Property\Entities\Property>
     */
    public function search(PropertyFilterDTO $filter): LengthAwarePaginator;

    /**
     * @param \App\Domains\Property\Entities\Property[] $entities
     */
    public function saveBulk(array $entities): void;

    /**
     * @param \App\Domains\Property\Entities\Property $entity
     */
    public function save(Property $entity): void;
}
