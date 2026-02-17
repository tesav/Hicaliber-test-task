<?php

namespace App\Domains\Property\Services\Import\Strategies;

use App\Domains\Property\Services\Import\AbstractCsvImportStrategy;

final class CsvGeneratorStrategy extends AbstractCsvImportStrategy
{
    public function entities(): \Generator
    {
        foreach ($this->reader->rows() as $row) {
            if (! $this->isValidRow($row)) {
                continue;
            }
            yield $this->toEntry($row);
        }
    }
}
