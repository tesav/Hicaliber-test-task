<?php

namespace App\Services\Import\Contracts;

interface ImportStrategyContract
{
    public function import(): string;
}
