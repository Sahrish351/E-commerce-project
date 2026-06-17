<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Shoes
            ['name' => 'Nike Air Max Sports Shoes', 'price' => 120, 'stock_quantity' => 50, 'category_id' => 1, 'sku' => 'SH001', 'description' => 'Comfortable sports shoes'],
            ['name' => 'Adidas Ultraboost', 'price' => 100, 'stock_quantity' => 40, 'category_id' => 1, 'sku' => 'SH002', 'description' => 'Running shoes'],
            ['name' => 'Puma Sneakers', 'price' => 80, 'stock_quantity' => 60, 'category_id' => 1, 'sku' => 'SH003', 'description' => 'Casual sneakers'],
            
            // Watches
            ['name' => 'Apple Watch Series 9', 'price' => 200, 'stock_quantity' => 30, 'category_id' => 2, 'sku' => 'WT001', 'description' => 'Smart watch'],
            ['name' => 'Samsung Galaxy Watch', 'price' => 160, 'stock_quantity' => 25, 'category_id' => 2, 'sku' => 'WT002', 'description' => 'Android smart watch'],
            ['name' => 'Sveston Watch', 'price' => 150, 'stock_quantity' => 35, 'category_id' => 2, 'sku' => 'WT003', 'description' => 'Fashion watch'],
            
            // Earbuds
            ['name' => 'Sony WF-1000XM5', 'price' => 70, 'stock_quantity' => 45, 'category_id' => 3, 'sku' => 'EB001', 'description' => 'Noise cancelling earbuds'],
            ['name' => 'Apple AirPods Pro', 'price' => 60, 'stock_quantity' => 40, 'category_id' => 3, 'sku' => 'EB002', 'description' => 'Wireless earbuds'],
            ['name' => 'Samsung Buds Pro', 'price' => 50, 'stock_quantity' => 35, 'category_id' => 3, 'sku' => 'EB003', 'description' => 'Premium sound'],
            
            // Sunglasses
            ['name' => 'Ray-Ban Aviator', 'price' => 37, 'stock_quantity' => 30, 'category_id' => 4, 'sku' => 'SG001', 'description' => 'Classic sunglasses'],
            ['name' => 'Oakley Holbrook', 'price' => 50, 'stock_quantity' => 25, 'category_id' => 4, 'sku' => 'SG002', 'description' => 'Sports sunglasses'],
            
            // Chargers
            ['name' => '65W GaN Fast Charger', 'price' => 35, 'stock_quantity' => 100, 'category_id' => 5, 'sku' => 'CH001', 'description' => 'Fast charging'],
            ['name' => '20W USB-C Charger', 'price' => 20, 'stock_quantity' => 80, 'category_id' => 5, 'sku' => 'CH002', 'description' => 'iPhone fast charger'],
            
            // Power Banks
            ['name' => '20000mAh Power Bank', 'price' => 45, 'stock_quantity' => 50, 'category_id' => 6, 'sku' => 'PB001', 'description' => 'High capacity'],
            ['name' => '10000mAh Slim Power Bank', 'price' => 30, 'stock_quantity' => 60, 'category_id' => 6, 'sku' => 'PB002', 'description' => 'Portable charger'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}