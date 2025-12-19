<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Gọi các seeder khác
        $this->call([
            UserTableSeeder::class,
            CategoryTableSeeder::class,
            ProductTableSeeder::class,
            OrderTableSeeder::class,
            OrderItemTableSeeder::class,
            PaymentTableSeeder::class,
        ]);
    }
}
