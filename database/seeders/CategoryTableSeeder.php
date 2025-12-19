<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Sofa Thư Giãn',
                'slug' => 'sofa-thu-gian',
                'description' => 'Sofa thiết kế êm ái, tạo cảm giác thư giãn tối đa',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Gỗ Cao Cấp',
                'slug' => 'sofa-go-cao-cap',
                'description' => 'Sofa khung gỗ tự nhiên, bền đẹp theo thời gian',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Băng (Dài)',
                'slug' => 'sofa-bang-dai',
                'description' => 'Sofa dài thiết kế hiện đại, phù hợp không gian rộng',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Đơn',
                'slug' => 'sofa-don',
                'description' => 'Sofa 1 chỗ ngồi, tiết kiệm diện tích',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Da',
                'slug' => 'sofa-da',
                'description' => 'Sofa bọc da thật, sang trọng và dễ vệ sinh',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Vải',
                'slug' => 'sofa-vai',
                'description' => 'Sofa bọc vải cao cấp, đa dạng màu sắc',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Góc',
                'slug' => 'sofa-goc',
                'description' => 'Sofa góc chữ L, tối ưu không gian',
                'is_active' => 1,
            ],
            [
                'name' => 'Sofa Băng 3 Chỗ',
                'slug' => 'sofa-bang-3-cho',
                'description' => 'Sofa 3 chỗ ngồi, phù hợp gia đình nhỏ',
                'is_active' => 1,
            ],
        ]);
    }
}
