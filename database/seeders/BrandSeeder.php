<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'description' => 'Innovative technology company known for iPhone, Mac, and more.'],
            ['name' => 'Samsung', 'description' => 'Global electronics brand offering smartphones, TVs, and appliances.'],
            ['name' => 'Sony', 'description' => 'Japanese brand famous for audio, video, and gaming products.'],
            ['name' => 'Dell', 'description' => 'Leading manufacturer of laptops, desktops, and computer accessories.'],
            ['name' => 'HP', 'description' => 'Trusted brand for printers, laptops, and business solutions.'],
            ['name' => 'Lenovo', 'description' => 'Global PC brand offering powerful laptops and workstations.'],
            ['name' => 'Microsoft', 'description' => 'Tech giant behind Windows, Surface devices, and cloud services.'],
            ['name' => 'Logitech', 'description' => 'Specializes in computer peripherals like keyboards, mice, and webcams.'],
            ['name' => 'Canon', 'description' => 'Renowned for cameras, printers, and imaging technology.'],
            ['name' => 'Nikon', 'description' => 'Professional-grade cameras and optical equipment.'],
            ['name' => 'ASUS', 'description' => 'High-performance laptops, motherboards, and gaming gear.'],
            ['name' => 'Acer', 'description' => 'Affordable laptops and monitors for everyday use.'],
            ['name' => 'Razer', 'description' => 'Gaming-focused brand with cutting-edge peripherals and laptops.'],
            ['name' => 'TP-Link', 'description' => 'Reliable networking devices including routers and extenders.'],
            ['name' => 'Google', 'description' => 'Innovator in mobile, smart home, and cloud technologies.'],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'image' => null,
                'description' => $brand['description'],
            ]);
        }
    }
}
