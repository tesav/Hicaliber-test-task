<?php

namespace App\Services\Import\Strategies;

use App\Models\Property;
use Illuminate\Support\Facades\Validator;
use App\Services\Import\AbstractCsvImportStrategy;

class CsvGeneratorStrategy extends AbstractCsvImportStrategy
{
    protected int $batchSize;

    public function __construct(
        string $filePath,
        int    $batchSize = 100,
        string $disk = 'local'
    )
    {
        parent::__construct($filePath, $disk);
        $this->batchSize = $batchSize;
    }

    public function import(): string
    {
        $batch = [];
        $added = $updated = $skipped = 0;
        $existing = Property::pluck('name')->flip();

        foreach ($this->readCsv($this->getAbsolutePath()) as $data) {
            if (!$this->isValidRow($data)) {
                $skipped++;
                continue;
            }

            $row = $this->normalizeRow($data);

            isset($existing[$row['name']]) ? $updated++ : $added++;

            $batch[] = $row;

            if (count($batch) >= $this->batchSize) {
                $this->save($batch);
                $batch = [];
            }
        }

        if ($batch) {
            $this->save($batch);
        }

        return "Added: {$added}, Updated: {$updated}, Skipped: {$skipped}.";
    }

    protected function isValidRow(array $data): bool
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required|integer|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'storeys' => 'required|integer|min:0',
            'garages' => 'required|integer|min:0',
        ])->passes();
    }

    protected function save(array $data): void
    {
        Property::upsert($data, ['name'], ['price']);
    }
}
