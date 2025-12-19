<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
         DB::table('users')->insert([
            // [
            //     'fullname' => 'Thiên Dev',
            //     'email' => 'thienvva040212@gmail.com',
            //     'password' => Hash::make('password123'),
            //     'phone' => NULL,
            //     'address' => NULL,
            //     'role' => 'customer',
            //     'created_at' => now(),
            // ],
            [
                'fullname' => 'Võ Thiên',
                'email' => 'vothien817@gmail.com',
                'password' => Hash::make('password'),
                'phone' => NULL,
                'address' => NULL,
                'role' => 'admin',
                'created_at' => '2025-11-28 13:46:42',
            ]
        ]);
    }
}
