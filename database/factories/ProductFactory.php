<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => ucfirst(fake()->words(3, true)),
            'sku' => fake()->unique()->regexify('[A-Z]{3}-[0-9]{4}'),
            'price' => fake()->randomFloat(2, 50, 5000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'location_zone' => 'Zone-'.fake()->randomElement(['A1', 'B2', 'C3', 'D4']),
            'is_active' => fake()->boolean(85),
        ];
    }
}
