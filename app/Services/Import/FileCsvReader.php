<?php

namespace App\Services\Import;

use App\Services\Import\Contracts\CsvReader;
use Illuminate\Support\Facades\Storage;

class FileCsvReader implements CsvReader
{
    protected string $filePath;
    protected string $disk;

    public function __construct(string $filePath, string $disk = 'local')
    {
        $this->filePath = $filePath;
        $this->disk = $disk;
    }

    public function rows(): \Generator
    {
        $handle = fopen($this->getAbsolutePath(), 'r');
        $header = array_map('mb_strtolower', fgetcsv($handle));

        while (($row = fgetcsv($handle)) !== false) {
            yield array_combine($header, array_map('trim', $row));
        }

        fclose($handle);
    }

    private function getAbsolutePath(): string
    {
        $storage = Storage::disk($this->disk);

        if (!$storage->exists($this->filePath)) {
            throw new \RuntimeException("CSV file not found: " . $storage->path($this->filePath));
        }

        return $storage->path($this->filePath);
    }
}