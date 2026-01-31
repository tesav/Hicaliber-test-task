<?php

namespace App\Services\Import;

use App\Services\Import\Contracts\ImportStrategyContract;

class PropertyImportService
{
    protected ImportStrategyContract $strategy;

    public function __construct(ImportStrategyContract $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(ImportStrategyContract $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function import(): string
    {
        return $this->strategy->import();
    }
}
