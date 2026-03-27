<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Latest Samsung flagship smartphone with advanced camera and AI features.',
                'price' => 15000000,
                'id_category' => Category::where('slug', 'electronics')->first()->id,
                'id_brand' => Brand::where('slug', 'samsung')->first()->id,
                'is_featured' => true,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Apple iPhone 15 Pro with titanium design and A17 Pro chip.',
                'price' => 18000000,
                'id_category' => Category::where('slug', 'electronics')->first()->id,
                'id_brand' => Brand::where('slug', 'apple')->first()->id,
                'is_featured' => true,
            ],
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'Comfortable running shoes with Air Max technology.',
                'price' => 2500000,
                'id_category' => Category::where('slug', 'sports')->first()->id,
                'id_brand' => Brand::where('slug', 'nike')->first()->id,
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'slug' => 'adidas-ultraboost-22',
                'description' => 'Premium running shoes with Boost technology.',
                'price' => 3000000,
                'id_category' => Category::where('slug', 'sports')->first()->id,
                'id_brand' => Brand::where('slug', 'adidas')->first()->id,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'description' => 'Industry-leading noise canceling wireless headphones.',
                'price' => 5000000,
                'id_category' => Category::where('slug', 'electronics')->first()->id,
                'id_brand' => Brand::where('slug', 'sony')->first()->id,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
