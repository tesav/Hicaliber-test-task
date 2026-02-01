<?php

namespace Database\Factories\Domains\Property\Models;

use App\Domains\Property\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Property\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(50_000, 500_000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'storeys' => $this->faker->numberBetween(1, 3),
            'garages' => $this->faker->numberBetween(0, 2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
