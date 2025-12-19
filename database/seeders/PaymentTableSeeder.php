<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'order_id' => 1,
                'payment_method' => 'Credit Card',
                'payment_status' => 'completed',
                'payment_date' => '2025-11-28 14:05:00',
            ],
            [
                'order_id' => 2,
                'payment_method' => 'Bank Transfer',
                'payment_status' => 'completed',
                'payment_date' => '2025-11-27 11:00:00',
            ],
        ]);
    }
}
