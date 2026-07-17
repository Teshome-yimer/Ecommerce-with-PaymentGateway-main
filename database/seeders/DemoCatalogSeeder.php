<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoCatalogSeeder extends Seeder
{
    /**
     * Seed a full demo catalog (phones, cars, laptops, etc.) with photo URLs.
     * Idempotent — safe to re-run on every deploy.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Phones', 'slug' => 'phones'],
            ['name' => 'Vehicles', 'slug' => 'vehicles'],
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Fashion', 'slug' => 'fashion'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Books', 'slug' => 'books'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name'], 'is_active' => true]
            );
        }

        $brands = [
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Sony', 'slug' => 'sony'],
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Toyota', 'slug' => 'toyota'],
            ['name' => 'BMW', 'slug' => 'bmw'],
            ['name' => 'Tesla', 'slug' => 'tesla'],
            ['name' => 'Hyundai', 'slug' => 'hyundai'],
            ['name' => 'Dell', 'slug' => 'dell'],
            ['name' => 'HP', 'slug' => 'hp'],
            ['name' => 'Google', 'slug' => 'google'],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                ['name' => $brand['name'], 'is_active' => true]
            );
        }

        $products = [
            // Phones
            [
                'name' => 'iPhone 16 Pro Max',
                'category' => 'phones',
                'brand' => 'apple',
                'price' => 185000,
                'featured' => true,
                'sale' => false,
                'description' => 'Apple flagship with A18 Pro chip, titanium design, and advanced camera system.',
                'images' => [
                    'https://images.unsplash.com/photo-1695048133142-1a204dbd3d66?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'iPhone 15',
                'category' => 'phones',
                'brand' => 'apple',
                'price' => 125000,
                'featured' => true,
                'sale' => true,
                'description' => 'Powerful A16 Bionic chip, Dynamic Island, and dual camera system.',
                'images' => [
                    'https://images.unsplash.com/photo-1695048133142-1a204dbd3d66?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'category' => 'phones',
                'brand' => 'samsung',
                'price' => 165000,
                'featured' => true,
                'sale' => false,
                'description' => 'Galaxy AI, 200MP camera, and S Pen — Samsung’s top Android flagship.',
                'images' => [
                    'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Samsung Galaxy A55',
                'category' => 'phones',
                'brand' => 'samsung',
                'price' => 42000,
                'featured' => false,
                'sale' => true,
                'description' => 'Mid-range Galaxy with bright AMOLED display and solid battery life.',
                'images' => [
                    'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Google Pixel 8',
                'category' => 'phones',
                'brand' => 'google',
                'price' => 78000,
                'featured' => false,
                'sale' => false,
                'description' => 'Clean Android experience with excellent computational photography.',
                'images' => [
                    'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=800&q=80',
                ],
            ],

            // Vehicles
            [
                'name' => 'Toyota Corolla 2024',
                'category' => 'vehicles',
                'brand' => 'toyota',
                'price' => 2850000,
                'featured' => true,
                'sale' => false,
                'description' => 'Reliable sedan with excellent fuel economy — ideal for city and highway driving.',
                'images' => [
                    'https://images.unsplash.com/photo-1623869675781-80aa31012a5a?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Toyota RAV4',
                'category' => 'vehicles',
                'brand' => 'toyota',
                'price' => 4200000,
                'featured' => true,
                'sale' => false,
                'description' => 'Popular compact SUV with spacious cabin and strong resale value.',
                'images' => [
                    'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'BMW X5',
                'category' => 'vehicles',
                'brand' => 'bmw',
                'price' => 8500000,
                'featured' => true,
                'sale' => false,
                'description' => 'Luxury SUV with powerful performance and premium interior.',
                'images' => [
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1617531653332-bd46c24f2068?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Tesla Model 3',
                'category' => 'vehicles',
                'brand' => 'tesla',
                'price' => 6200000,
                'featured' => true,
                'sale' => true,
                'description' => 'Electric sedan with Autopilot features and long driving range.',
                'images' => [
                    'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1617788138017-80ad40651984?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Hyundai Tucson',
                'category' => 'vehicles',
                'brand' => 'hyundai',
                'price' => 3650000,
                'featured' => false,
                'sale' => false,
                'description' => 'Modern crossover SUV with bold styling and advanced safety features.',
                'images' => [
                    'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=800&q=80',
                ],
            ],

            // Laptops
            [
                'name' => 'MacBook Pro 14" M3',
                'category' => 'laptops',
                'brand' => 'apple',
                'price' => 295000,
                'featured' => true,
                'sale' => false,
                'description' => 'Pro laptop with M3 chip, Liquid Retina XDR display, and all-day battery.',
                'images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'MacBook Air M3',
                'category' => 'laptops',
                'brand' => 'apple',
                'price' => 175000,
                'featured' => true,
                'sale' => true,
                'description' => 'Ultra-light MacBook Air — silent, fast, and perfect for students and professionals.',
                'images' => [
                    'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Dell XPS 13',
                'category' => 'laptops',
                'brand' => 'dell',
                'price' => 145000,
                'featured' => false,
                'sale' => false,
                'description' => 'Premium Windows ultrabook with InfinityEdge display.',
                'images' => [
                    'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'HP Pavilion 15',
                'category' => 'laptops',
                'brand' => 'hp',
                'price' => 68000,
                'featured' => false,
                'sale' => true,
                'description' => 'Everyday laptop for work, study, and entertainment.',
                'images' => [
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80',
                ],
            ],

            // Electronics / Audio
            [
                'name' => 'Sony WH-1000XM5',
                'category' => 'electronics',
                'brand' => 'sony',
                'price' => 45000,
                'featured' => true,
                'sale' => false,
                'description' => 'Industry-leading noise canceling wireless headphones.',
                'images' => [
                    'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'AirPods Pro 2',
                'category' => 'electronics',
                'brand' => 'apple',
                'price' => 32000,
                'featured' => true,
                'sale' => true,
                'description' => 'Active Noise Cancellation and Adaptive Audio in a compact design.',
                'images' => [
                    'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Samsung Galaxy Buds3',
                'category' => 'electronics',
                'brand' => 'samsung',
                'price' => 18000,
                'featured' => false,
                'sale' => false,
                'description' => 'Wireless earbuds with rich sound and comfortable fit.',
                'images' => [
                    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=800&q=80',
                ],
            ],

            // Fashion / Sports
            [
                'name' => 'Nike Air Force 1',
                'category' => 'fashion',
                'brand' => 'nike',
                'price' => 12500,
                'featured' => true,
                'sale' => false,
                'description' => 'Classic white sneakers — timeless style for everyday wear.',
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Adidas Samba',
                'category' => 'fashion',
                'brand' => 'adidas',
                'price' => 11000,
                'featured' => false,
                'sale' => true,
                'description' => 'Iconic indoor soccer-inspired sneakers for street style.',
                'images' => [
                    'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Nike Air Max 270',
                'category' => 'sports',
                'brand' => 'nike',
                'price' => 15500,
                'featured' => false,
                'sale' => false,
                'description' => 'Comfortable running shoes with visible Air Max cushioning.',
                'images' => [
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'category' => 'sports',
                'brand' => 'adidas',
                'price' => 18500,
                'featured' => true,
                'sale' => false,
                'description' => 'Premium running shoes with responsive Boost midsole.',
                'images' => [
                    'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?auto=format&fit=crop&w=800&q=80',
                ],
            ],

            // Home
            [
                'name' => 'Smart Robot Vacuum',
                'category' => 'home-garden',
                'brand' => 'samsung',
                'price' => 28000,
                'featured' => false,
                'sale' => true,
                'description' => 'App-controlled robot vacuum for automatic floor cleaning.',
                'images' => [
                    'https://images.unsplash.com/photo-1558317374-067fb5f30001?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Espresso Coffee Machine',
                'category' => 'home-garden',
                'brand' => 'sony',
                'price' => 22000,
                'featured' => false,
                'sale' => false,
                'description' => 'Home espresso maker for café-quality coffee.',
                'images' => [
                    'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?auto=format&fit=crop&w=800&q=80',
                ],
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category'])->first();
            $brand = Brand::where('slug', $item['brand'])->first();

            if (!$category || !$brand) {
                continue;
            }

            $slug = Str::slug($item['name']);

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'id_category' => $category->id,
                    'id_brand' => $brand->id,
                    'images' => $item['images'],
                    'is_active' => true,
                    'is_featured' => $item['featured'],
                    'in_stock' => true,
                    'on_sale' => $item['sale'],
                ]
            );
        }
    }
}
