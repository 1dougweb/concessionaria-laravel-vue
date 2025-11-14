<?php

namespace Database\Factories;

use App\Domain\Customers\Models\Customer;
use App\Domain\Vehicles\Models\Vehicle;
use App\Models\User;
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
            'customer_id' => Customer::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'title' => $this->faker->text(30),
            'slug' => Str::slug($this->faker->text(10) . '-' . $this->faker->unique()->numberBetween(1, 1000)),
            'type' => $this->faker->randomElement(['car', 'motorcycle', 'truck']),
            'brand' => $this->faker->randomElement(['Ford', 'Fiat', 'BMW']),
            'model' => $this->faker->word(),
            'year' => $this->faker->numberBetween(2015, 2025),
            'mileage' => $this->faker->numberBetween(0, 100000),
            'price' => $this->faker->randomFloat(2, 50000, 500000),
            'currency' => 'BRL',
            'status' => $this->faker->randomElement(['draft', 'published', 'reserved']),
            'stock_count' => 1,
            'specifications' => [
                'engine' => $this->faker->randomElement(['1.0', '1.4', '2.0']),
                'color' => $this->faker->safeColorName(),
            ],
            'metadata' => [],
        ];
    }
}

