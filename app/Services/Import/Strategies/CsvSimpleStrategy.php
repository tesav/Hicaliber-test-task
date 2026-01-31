<?php

namespace App\Services\Import\Strategies;

use Illuminate\Support\Facades\DB;
use App\Services\Import\AbstractCsvImportStrategy;

class CsvSimpleStrategy extends AbstractCsvImportStrategy
{
    public function import(): string
    {
        $rows = [];
        $skipped = 0;

        foreach ($this->readCsv($this->getAbsolutePath()) as $data) {
            if (!$this->isValidRow($data)) {
                $skipped++;
                continue;
            }

            $rows[] = $this->normalizeRow($data);
        }

        DB::table('properties')->upsert(
            $rows,
            ['name'],
            ['price']
        );

        return "CSV imported successfully. Processed: "
            . count($rows) . ", Skipped: {$skipped}.";
    }

    protected function isValidRow(array $data): bool
    {
        return
            !empty($data['name']) &&
            is_numeric($data['price']) &&
            is_numeric($data['bedrooms']) &&
            is_numeric($data['bathrooms']) &&
            is_numeric($data['storeys']) &&
            is_numeric($data['garages']);
    }
}
