<?php

namespace Tests\Unit\Services\Import\Strategies;

use App\Services\Import\Strategies\CsvSimpleStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvSimpleStrategyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_import_adds_and_skips_invalid_rows()
    {
        $csvContent = <<<CSV
name,price,bedrooms,bathrooms,storeys,garages
Test Property 1,100000,3,2,2,1
Invalid Property,abc,2,1,1,1
Test Property 2,200000,4,3,2,2
CSV;

        // Сохраняем CSV через Storage (fake диск)
        $filePath = 'test.csv';
        Storage::disk('local')->put($filePath, $csvContent);

        $strategy = new CsvSimpleStrategy($filePath);
        $result = $strategy->import();

        // Проверяем текст отчёта
        $this->assertStringContainsString('Processed: 2', $result);
        $this->assertStringContainsString('Skipped: 1', $result);

        // Проверяем данные в базе
        $this->assertDatabaseHas('properties', ['name' => 'Test Property 1', 'price' => 100000]);
        $this->assertDatabaseHas('properties', ['name' => 'Test Property 2', 'price' => 200000]);
        $this->assertDatabaseMissing('properties', ['name' => 'Invalid Property']);
    }

    public function test_import_throws_exception_if_file_missing()
    {
        $this->expectException(\RuntimeException::class);

        $strategy = new CsvSimpleStrategy('non_existent.csv');
        $strategy->import();
    }
}
