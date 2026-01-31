<?php

namespace Tests\Unit\Services\Import;

use App\Services\Import\PropertyImportService;
use App\Services\Import\Contracts\ImportStrategyContract;
use Tests\TestCase;
use Mockery;

class PropertyImportServiceTest extends TestCase
{
    public function test_import_delegates_to_strategy()
    {
        $mockStrategy = Mockery::mock(ImportStrategyContract::class);
        $mockStrategy->shouldReceive('import')
            // ->once()
            ->andReturn('import done');

        $service = new PropertyImportService($mockStrategy);

        $result = $service->import();

        $this->assertEquals('import done', $result);
    }

    public function test_set_strategy_changes_strategy()
    {
        $firstMock = Mockery::mock(ImportStrategyContract::class);
        $secondMock = Mockery::mock(ImportStrategyContract::class);

        $service = new PropertyImportService($firstMock);
        $service->setStrategy($secondMock);

        $this->assertSame($secondMock, $this->getProtectedProperty($service, 'strategy'));
    }

    private function getProtectedProperty($object, string $property)
    {
        $reflection = new \ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);
        return $prop->getValue($object);
    }
}
