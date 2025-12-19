<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'total_amount' => 15990000,
                'order_status' => 'completed',
                'order_date' => '2025-11-28 14:00:00',
            ],
            [
                'user_id' => 2,
                'total_amount' => 24990000,
                'order_status' => 'shipped',
                'order_date' => '2025-11-27 10:30:00',
            ],
        ]);
    }
}
