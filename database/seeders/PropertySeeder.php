<?php

namespace Database\Seeders;

use App\Domains\Property\Repositories\PropertyRepositoryContract;
use App\Domains\Property\Services\Import\PropertyImportService;
use App\Domains\Property\Services\Import\Strategies\CsvGeneratorStrategy;
use App\Domains\Property\Services\Import\Strategies\CsvSimpleStrategy;
use App\Services\Import\FileCsvReader;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reader = new FileCsvReader('imports/property-data.csv');

        // $strategy = new CsvSimpleStrategy($reader);
        $strategy = new CsvGeneratorStrategy($reader);
        $repository = app(PropertyRepositoryContract::class);

        $service = new PropertyImportService(
            $strategy,
            $repository,
            300
        );

        $result = $service->import();

        $this->command->info($result);
    }
}
