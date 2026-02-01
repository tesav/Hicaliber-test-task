<?php

namespace App\Domains\Property\Services\Import;

use App\Domains\Property\Repositories\PropertyRepositoryContract;
use App\Services\Import\Contracts\ImportStrategy;

class PropertyImportService
{
    public function __construct(
        private readonly ImportStrategy $strategy,
        private readonly PropertyRepositoryContract $repository,
        private readonly int $batchSize = 100
    ) {}

    public function import(): string
    {
        $batch = [];
        $skipped = 0;
        $processed = 0;

        foreach ($this->strategy->entities() as $entity) {
            $batch[] = $entity;
            $processed++;

            if (count($batch) >= $this->batchSize) {
                $this->repository->saveBulk($batch);
                $batch = [];
            }
        }

        if ($batch) {
            $this->repository->saveBulk($batch);
        }

        return "CSV imported successfully. Processed: {$processed}, Skipped: {$skipped}.";
    }
}
