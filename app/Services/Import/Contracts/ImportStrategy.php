<?php

namespace App\Services\Import\Contracts;

interface ImportStrategy
{
    /**
     * @return iterable<\App\Domains\Property\Entities\Property>
     */
    public function entities(): iterable;
}
