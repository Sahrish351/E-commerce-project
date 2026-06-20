<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        // ✅ Product names with categories
        $productNames = [
            'Shoes' => ['Nike Air Max', 'Adidas Ultraboost', 'Puma Running', 'Reebok Classic', 'New Balance', 'Converse Chuck', 'Vans Old Skool', 'Skechers Go Walk'],
            'Watches' => ['Rolex Submariner', 'Apple Watch Series', 'Samsung Galaxy Watch', 'Casio G-Shock', 'Fossil Gen', 'Tissot PRX', 'Seiko 5 Sports', 'Citizen Eco-Drive'],
            'Earbuds' => ['Sony WF-1000XM5', 'Apple AirPods Pro', 'Samsung Galaxy Buds', 'Bose QuietComfort', 'Jabra Elite', 'Sennheiser Momentum', 'Nothing Ear', 'Pixel Buds Pro'],
            'Sunglasses' => ['Ray-Ban Wayfarer', 'Oakley Holbrook', 'Persol PO', 'Maui Jim', 'Costa Del Mar', 'Prada Sunglasses', 'Gucci GG', 'Dior Sunglasses'],
            'Mobile Accessories' => ['Spigen Case', 'OtterBox Defender', 'PopSocket Grip', 'Anker Charger', 'Belkin Screen Protector', 'Mophie Power Bank', 'Ringke Case', 'UAG Case'],
            'Power Banks' => ['Anker Power Bank', 'Samsung Power Bank', 'Xiaomi Power Bank', 'Belkin Power Bank', 'Mophie Power Bank', 'Aukey Power Bank', 'RavPower Power Bank', 'Baseus Power Bank'],
            'Chargers' => ['Anker Charger', 'Samsung Super Fast Charger', 'Apple USB-C Charger', 'Belkin Charger', 'Ugreen Charger', 'Aukey Charger', 'Baseus Charger', 'Spigen Charger'],
        ];

        // Get random category and product name
        $category = Category::inRandomOrder()->first();
        $categoryName = $category ? $category->name : 'Shoes';
        $names = $productNames[$categoryName] ?? $productNames['Shoes'];
        $productName = $this->faker->randomElement($names);

        // ✅ High ratings (3.5 to 5.0)
        $rating = $this->faker->randomFloat(1, 3.8, 5.0);
        
        // ✅ High orders (50 to 5000)
        $orders = $this->faker->numberBetween(50, 5000);

        // ✅ Random images from picsum.photos
        $images = [
            'https://picsum.photos/seed/' . rand(1, 999) . '/400/400',
            'https://picsum.photos/seed/' . rand(1, 999) . '/400/400',
            'https://picsum.photos/seed/' . rand(1, 999) . '/400/400',
            'https://picsum.photos/seed/' . rand(1, 999) . '/400/400',
            'https://picsum.photos/seed/' . rand(1, 999) . '/400/400',
        ];

        return [
            'category_id' => $category->id ?? 1,
            'name' => $productName . ' ' . $this->faker->randomElement(['Pro', 'Max', 'Lite', 'Plus', 'Elite', 'Premium', 'Sport', 'Classic']),
            'slug' => $this->faker->unique()->slug(3),
            'description' => $this->faker->paragraphs(3, true),
            'short_description' => $this->faker->sentence(10),
            'price' => $this->faker->numberBetween(25, 500),
            'sale_price' => $this->faker->optional(0.3)->numberBetween(15, 450),
            'sku' => $this->faker->unique()->ean13(),
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'rating' => $rating, // ✅ Rating 3.8 to 5.0
            'sold_count' => $orders, // ✅ Orders 50 to 5000
            'is_active' => true,
            'is_featured' => $this->faker->boolean(20),
            'image_url' => $this->faker->randomElement($images),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}