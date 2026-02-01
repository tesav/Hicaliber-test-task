<?php

namespace Tests\Unit\Services\Import\Strategies;

use App\Models\Property;
use App\Services\Import\Strategies\CsvGeneratorStrategy;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvGeneratorStrategyTest extends TestCase
{
    public function test_import_adds_and_updates_properties()
    {
        Property::factory()->create(['name' => 'Existing Property', 'price' => 100000]);

        // Создаём CSV
        $csvContent = <<<CSV
name,price,bedrooms,bathrooms,storeys,garages
Existing Property,120000,3,2,2,1
New Property,200000,4,3,2,2
Invalid Property,abc,2,1,1,1
CSV;

        // Сохраняем CSV на fake диск
        Storage::fake('local');
        $filePath = 'test.csv';
        Storage::disk('local')->put($filePath, $csvContent);

        $strategy = new CsvGeneratorStrategy($filePath, 2);
        $result = $strategy->import();

        $this->assertStringContainsString('Added: 1', $result);
        $this->assertStringContainsString('Updated: 1', $result);
        $this->assertStringContainsString('Skipped: 1', $result);

        // Проверяем данные в базе
        $this->assertDatabaseHas('properties', [
            'name' => 'New Property',
            'price' => 200000,
        ]);

        $this->assertDatabaseHas('properties', [
            'name' => 'Existing Property',
            'price' => 120000,
        ]);
    }

    public function test_import_throws_exception_when_file_missing()
    {
        $this->expectException(\RuntimeException::class);
        $strategy = new CsvGeneratorStrategy('non-existent.csv');
        $strategy->import();
    }
}
