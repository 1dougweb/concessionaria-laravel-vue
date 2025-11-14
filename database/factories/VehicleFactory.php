<?php

namespace Database\Factories;

use App\Domain\Vehicles\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->text(30),
            'slug' => Str::slug($this->faker->text(10) . '-' . $this->faker->unique()->numberBetween(1, 1000)),
            'type' => 'car',
            'brand' => $this->faker->randomElement(['Ford', 'Fiat', 'BMW']),
            'model' => $this->faker->word(),
            'year' => $this->faker->numberBetween(2010, 2025),
            'mileage' => $this->faker->numberBetween(0, 100000),
            'price' => $this->faker->randomFloat(2, 50000, 500000),
            'currency' => 'BRL',
            'status' => 'published',
            'stock_count' => 1,
            'specifications' => [],
            'metadata' => [],
        ];
    }
}

