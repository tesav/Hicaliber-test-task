<?php

namespace App\Services\Import\Contracts;

interface CsvReader
{
    public function rows(): iterable;
}