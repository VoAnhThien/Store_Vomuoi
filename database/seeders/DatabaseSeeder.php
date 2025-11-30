<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create categories
       User::create([
            'fullname' => 'Võ Thiên',
            'email' => 'vothien817@gmail.com',
            'password' => Hash::make('password'), // Thay 'password' bằng mật khẩu thật
            'role' => 'admin',
        ]);
    }
}
