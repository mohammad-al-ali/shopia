<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Electronics', 'parent_category_id' => null, 'description' => 'All kinds of electronic devices'],
            ['name' => 'Audio', 'parent_category_id' => 1, 'description' => 'Headphones and speakers'],
            ['name' => 'Computers', 'parent_category_id' => 1, 'description' => 'Desktops, laptops, and components'],
            ['name' => 'Entertainment', 'parent_category_id' => 1, 'description' => 'Gaming consoles and VR devices'],
            ['name' => 'Networking', 'parent_category_id' => 1, 'description' => 'Routers, modems, and signal boosters'],

            ['name' => 'Smartphones', 'parent_category_id' => 1, 'description' => 'Android and iPhone devices'],
            ['name' => 'Laptops', 'parent_category_id' => 3, 'description' => 'Portable computers for work and play'],
            ['name' => 'Desktops', 'parent_category_id' => 3, 'description' => 'Stationary computers for gaming or office'],
            ['name' => 'Smartwatches', 'parent_category_id' => 1, 'description' => 'Wearable digital watches with smart features'],
            ['name' => 'Headphones', 'parent_category_id' => 2, 'description' => 'Over-ear and in-ear audio devices'],
            ['name' => 'Speakers', 'parent_category_id' => 2, 'description' => 'Portable and home sound systems'],
            ['name' => 'Digital Cameras', 'parent_category_id' => 1, 'description' => 'High-quality photo and video capture devices'],
            ['name' => 'Security Cameras', 'parent_category_id' => 1, 'description' => 'Surveillance devices for home and business'],
            ['name' => 'Printers', 'parent_category_id' => 3, 'description' => 'Inkjet, laser, and 3D printers'],
            ['name' => 'Monitors', 'parent_category_id' => 3, 'description' => 'Display screens for computers and gaming'],
            ['name' => 'Keyboards', 'parent_category_id' => 3, 'description' => 'Input devices for typing and control'],
            ['name' => 'Mice', 'parent_category_id' => 3, 'description' => 'Pointing devices for navigation'],
            ['name' => 'Storage Devices', 'parent_category_id' => 3, 'description' => 'Hard drives, SSDs, and USB flash drives'],
            ['name' => 'Gaming Consoles', 'parent_category_id' => 4, 'description' => 'PlayStation, Xbox, and other platforms'],
            ['name' => 'Gaming Accessories', 'parent_category_id' => 4, 'description' => 'Controllers, headsets, and charging docks'],
            ['name' => 'Virtual Reality Devices', 'parent_category_id' => 4, 'description' => 'VR headsets and AR gear'],
            ['name' => 'Streaming Devices', 'parent_category_id' => 4, 'description' => 'Chromecast, Apple TV, and similar tools'],
            ['name' => 'Network Devices', 'parent_category_id' => 5, 'description' => 'Routers, modems, and Wi-Fi extenders'],
            ['name' => 'Computer Components', 'parent_category_id' => 3, 'description' => 'RAM, CPU, GPU, motherboards, and more'],
        ]);
    }
}
