<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Shoes', 'slug' => 'shoes', 'is_active' => true],
            ['name' => 'Watches', 'slug' => 'watches', 'is_active' => true],
            ['name' => 'Earbuds', 'slug' => 'earbuds', 'is_active' => true],
            ['name' => 'Sunglasses', 'slug' => 'sunglasses', 'is_active' => true],
            ['name' => 'Mobile Accessories', 'slug' => 'mobile-accessories', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}