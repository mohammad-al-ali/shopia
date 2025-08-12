<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 14 Pro',
                'short_description' => 'Apple flagship smartphone with advanced camera',
                'description' => 'The iPhone 14 Pro features a powerful A16 Bionic chip, ProMotion display, and triple-lens camera system.',
                'regular_price' => 1099.00,
                'sale_price' => 999.00,
                'warehouse_price' => 950.00,
                'quantity' => 50,
                'brand_id' => 1, // Apple
                'category_id' => 6, // Smartphones
                'featured' => true,
            ],
            [
                'name' => 'Galaxy S23 Ultra',
                'short_description' => 'Samsung premium smartphone with S-Pen',
                'description' => 'Galaxy S23 Ultra offers a 200MP camera, Snapdragon 8 Gen 2, and built-in S-Pen for productivity.',
                'regular_price' => 1199.00,
                'sale_price' => 1099.00,
                'warehouse_price' => 1020.00,
                'quantity' => 40,
                'brand_id' => 2, // Samsung
                'category_id' => 6, // Smartphones
                'featured' => true,
            ],
            [
                'name' => 'Dell XPS 13',
                'short_description' => 'Compact and powerful ultrabook',
                'description' => 'Dell XPS 13 features a sleek design, Intel Core i7 processor, and vibrant InfinityEdge display.',
                'regular_price' => 1299.00,
                'sale_price' => 1199.00,
                'warehouse_price' => 1100.00,
                'quantity' => 30,
                'brand_id' => 4, // Dell
                'category_id' => 7, // Laptops
                'featured' => false,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'short_description' => 'Industry-leading noise-canceling headphones',
                'description' => 'Sony WH-1000XM5 offers premium sound quality, adaptive noise cancellation, and long battery life.',
                'regular_price' => 399.00,
                'sale_price' => 349.00,
                'warehouse_price' => 320.00,
                'quantity' => 70,
                'brand_id' => 3, // Sony
                'category_id' => 10, // Headphones
                'featured' => true,
            ],
            [
                'name' => 'Canon EOS R6',
                'short_description' => 'Full-frame mirrorless camera for professionals',
                'description' => 'Canon EOS R6 delivers stunning image quality, fast autofocus, and 4K video recording.',
                'regular_price' => 2499.00,
                'sale_price' => 2299.00,
                'warehouse_price' => 2100.00,
                'quantity' => 20,
                'brand_id' => 9, // Canon
                'category_id' => 12, // Digital Cameras
                'featured' => false,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'short_description' => $product['short_description'],
                'description' => $product['description'],
                'regular_price' => $product['regular_price'],
                'sale_price' => $product['sale_price'],
                'warehouse_price' => $product['warehouse_price'],
                'quantity' => $product['quantity'],
                'brand_id' => $product['brand_id'],
                'category_id' => $product['category_id'],
                'featured' => $product['featured'],
            ]);
        }
    }
}
