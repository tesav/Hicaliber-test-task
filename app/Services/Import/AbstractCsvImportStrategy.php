<?php

namespace App\Services\Import;

use App\Services\Import\Contracts\ImportStrategyContract;
use Illuminate\Support\Facades\Storage;

abstract class AbstractCsvImportStrategy implements ImportStrategyContract
{
    protected string $filePath;
    protected string $disk;

    public function __construct(string $filePath, string $disk = 'local')
    {
        $this->filePath = $filePath;
        $this->disk = $disk;
    }

    protected function getAbsolutePath(): string
    {
        $storage = Storage::disk($this->disk);

        if (!$storage->exists($this->filePath)) {
            throw new \RuntimeException(
                "CSV file not found: " . $storage->path($this->filePath)
            );
        }

        return $storage->path($this->filePath);
    }

    protected function readCsv(string $path): \Generator
    {
        $handle = fopen($path, 'r');

        $header = array_map('mb_strtolower', fgetcsv($handle));

        while (($row = fgetcsv($handle)) !== false) {
            yield array_combine($header, array_map('trim', $row));
        }

        fclose($handle);
    }

    protected function normalizeRow(array $data): array
    {
        return [
            'name' => $data['name'],
            'price' => (int)$data['price'],
            'bedrooms' => (int)$data['bedrooms'],
            'bathrooms' => (int)$data['bathrooms'],
            'storeys' => (int)$data['storeys'],
            'garages' => (int)$data['garages'],
        ];
    }

    abstract protected function isValidRow(array $data): bool;
}
