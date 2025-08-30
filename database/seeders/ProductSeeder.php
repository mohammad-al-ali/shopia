<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Gaming Laptop GTX1650',
                'slug' => 'gaming-laptop-gtx1650',
                'short_description' => ' GPGaming laptop with GTXU and SSD',
                'description' => 'High-performance gaming laptop with GTX1650 GPU, Intel i7, 16GB RAM, and 512GB SSD.',
                'regular_price' => 999.99,
                'sale_price' => 899.99,
                'warehouse_price' => 750.00,
                'quantity' => 10,
                'image' => 'products/laptop1.jpg',
                'images' => json_encode([
                    'products/laptop1.jpg',
                    'products/laptop1_alt1.jpg'
                ]),
                'brand_id' => 1,
                'category_id' => 1,
                'featured' => true,
                'price' => 899.99, // لو كنت تستخدمه للذكاء الاصطناعي لاحقاً
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'c',
                'slug' => 'mechanical-keyboard-rgb',
                'short_description' => 'RGB keyboard with blue switches',
                'description' => 'RGB mechanical keyboard with blue switches, anti-ghosting, and aluminum frame.',
                'regular_price' => 89.99,
                'sale_price' => 79.99,
                'warehouse_price' => 65.00,
                'quantity' => 20,
                'image' => 'products/keyboard1.jpg',
                'images' => json_encode([
                    'products/keyboard1.jpg',
                    'products/keyboard1_alt1.jpg'
                ]),
                'brand_id' => 2,
                'category_id' => 2,
                'featured' => false,
                'price' => 79.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'slug' => 'wireless-gaming-mouse',
                'short_description' => 'Ergonomic wireless mouse for gamers',
                'description' => 'Ergonomic wireless gaming mouse with adjustable DPI and long battery life.',
                'regular_price' => 59.99,
                'sale_price' => 49.99,
                'warehouse_price' => 40.00,
                'quantity' => 15,
                'image' => 'products/mouse1.jpg',
                'images' => json_encode([
                    'products/mouse1.jpg',
                    'products/mouse1_alt1.jpg'
                ]),
                'brand_id' => 3,
                'category_id' => 2,
                'featured' => false,
                'price' => 49.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
