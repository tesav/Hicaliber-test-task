<?php

namespace Database\Seeders;

use App\Services\Import\PropertyImportService;
use App\Services\Import\Strategies\CsvGeneratorStrategy;
use App\Services\Import\Strategies\CsvSimpleStrategy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'imports/property-data.csv';

        // $strategy = new CsvSimpleStrategy($filePath);
        $strategy = new CsvGeneratorStrategy($filePath, 300);

        $result = (new PropertyImportService($strategy))->import();

        $this->command->info($result);
    }
}


