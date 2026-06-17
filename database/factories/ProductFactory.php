<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => rand(1, 5),
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug(),
            'price' => $this->faker->numberBetween(500, 50000),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraph(),
            'is_active' => true,
        ];
    }
}