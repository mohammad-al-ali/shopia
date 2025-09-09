<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $statuses = ['pending', 'processing', 'delivered', 'shipped', 'canceled', 'returned'];
        $paymentStatuses = ['pending', 'completed', 'failed', 'refunded', 'canceled'];

        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found! Please seed users first.');
            return;
        }

        foreach (range(1, 50) as $i) { // إنشاء 50 طلبًا وهميًا
            $month = rand(1, 12);
            $day = rand(1, 28);
            $hour = rand(0, 23);
            $minute = rand(0, 59);
            $second = rand(0, 59);

            Order::create([
                'status'          => $statuses[array_rand($statuses)],
                'payment_status'  => $paymentStatuses[array_rand($paymentStatuses)],
                'total_amount'    => $total = rand(50, 500),
                'subtotal'        => $subtotal = rand(40, $total), // subtotal < total
                'discount'        => rand(0, 50),
                'tax'             => rand(5, 50),
                'user_id'         => $users->random()->id,
                'name'            => 'John Doe ' . $i,
                'phone'           => '+9639' . rand(10000000, 99999999),
                'locality'        => 'Locality ' . rand(1, 20),
                'address'         => 'Street ' . rand(1, 100) . ', Building ' . rand(1, 50),
                'city'            => 'Aleppo',
                'landmark'        => rand(0,1) ? 'Near Park' : null,
                'delivered_date'  => rand(0,1) ? Carbon::create(now()->year, $month, $day) : null,
                'canceled_date'   => rand(0,1) ? Carbon::create(now()->year, $month, $day) : null,
                'created_at'      => Carbon::create(now()->year, $month, $day, $hour, $minute, $second),
                'updated_at'      => now(),
            ]);
        }

        $this->command->info('50 fake orders created successfully!');
    }
}
