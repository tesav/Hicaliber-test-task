<?php

namespace Domains\Property\Services\Import\Strategies;

use App\Domains\Property\Entities\Property;
use App\Domains\Property\Services\Import\Strategies\CsvGeneratorStrategy;
use App\Domains\Property\Services\Import\Strategies\CsvSimpleStrategy;
use App\Services\Import\Contracts\CsvReader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CsvStrategiesTest extends TestCase
{
    public static function strategiesProvider(): array
    {
        return [
            [CsvSimpleStrategy::class],
            [CsvGeneratorStrategy::class],
        ];
    }

    #[DataProvider('strategiesProvider')]
    public function test_entities_filters_invalid_rows_and_maps_to_properties(string $strategyClass): void
    {
        $reader = new class implements CsvReader {
            public function rows(): iterable
            {
                yield [
                    'name' => 'Property 1',
                    'price' => 100,
                    'bedrooms' => 1,
                    'bathrooms' => 1,
                    'storeys' => 1,
                    'garages' => 0,
                ];

                yield [ // invalid
                    'name' => '',
                    'price' => 200,
                    'bedrooms' => 2,
                    'bathrooms' => 1,
                    'storeys' => 2,
                    'garages' => 1,
                ];

                yield [
                    'name' => 'Property 3',
                    'price' => 300,
                    'bedrooms' => 3,
                    'bathrooms' => 2,
                    'storeys' => 2,
                    'garages' => 1,
                ];
            }
        };

        $strategy = new $strategyClass($reader);

        $entities = iterator_to_array($strategy->entities());

        $this->assertCount(2, $entities);
        $this->assertInstanceOf(Property::class, $entities[0]);
        $this->assertEquals('Property 1', $entities[0]->name);
        $this->assertEquals('Property 3', $entities[1]->name);
    }
}
