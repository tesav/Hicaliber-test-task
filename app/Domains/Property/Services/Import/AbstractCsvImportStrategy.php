<?php

namespace App\Domains\Property\Services\Import;

use App\Domains\Property\Entities\Property;
use App\Services\Import\Contracts\CsvReader;
use App\Services\Import\Contracts\ImportStrategy;

abstract class AbstractCsvImportStrategy implements ImportStrategy
{
    public function __construct(
        protected CsvReader $reader
    )
    {}

    protected function isValidRow(array $data): bool
    {
        return
            trim($data['name'] ?? '') &&

            isset(
                $data['price'],
                $data['bedrooms'],
                $data['bathrooms'],
                $data['storeys'],
                $data['garages']
            ) &&

            is_numeric($data['price']) &&
            is_numeric($data['bedrooms']) &&
            is_numeric($data['bathrooms']) &&
            is_numeric($data['storeys']) &&
            is_numeric($data['garages']);
    }

    protected function toEntry(array $data): Property
    {
        return new Property(
            id: null,
            name: $data['name'],
            price: (int)$data['price'],
            bedrooms: (int)$data['bedrooms'],
            bathrooms: (int)$data['bathrooms'],
            storeys: (int)$data['storeys'],
            garages: (int)$data['garages']
        );
    }
}
