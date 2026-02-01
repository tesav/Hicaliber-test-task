<?php

namespace App\Domains\Property\Services\Import\Strategies;

use App\Domains\Property\Services\Import\AbstractCsvImportStrategy;
use App\Domains\Property\Entities\Property;

final class CsvSimpleStrategy extends AbstractCsvImportStrategy
{
    public function entities(): array
    {
        $entities = [];

        foreach ($this->reader->rows() as $row) {
            if (!$this->isValidRow($row)) continue;
            $entities[] = $this->toEntry($row);
        }

        return $entities;
    }
}
