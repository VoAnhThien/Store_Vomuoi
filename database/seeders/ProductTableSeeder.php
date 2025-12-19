<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            // 1. Sofa Thư Giãn
            [
                'category_id' => 1,
                'product_name' => 'Sofa Thư Giãn Relax Pro',
                'description' => 'Sofa thiết kế ergonomic, đệm memory foam êm ái, hỗ trợ lưng tối ưu. Chất liệu vải microfiber chống bám bẩn.',
                'price' => 12500000,
                'original_price' => 14900000,
                'stock' => 8,
                'image_url' => 'products/sofa-thu-gian-relax.jpg',
                'is_active' => 1,
                'is_featured' => 1,
                'color' => 'Xám khói',
                'dimensions' => '200x90x85 cm',
                'created_at' => now(),
            ],

            // 2. Sofa Gỗ Cao Cấp
            [
                'category_id' => 2,
                'product_name' => 'Sofa Gỗ Sồi Classic',
                'description' => 'Khung gỗ sồi tự nhiên, bọc đệm cao su non êm ái. Thiết kế cổ điển, phù hợp phòng khách truyền thống.',
                'price' => 18500000,
                'original_price' => 22000000,
                'stock' => 5,
                'image_url' => 'sofa-go-soui.jpg',
                'is_active' => 1,
                'is_featured' => 0,
                'color' => 'Nâu gỗ',
                'dimensions' => '220x95x88 cm',
                'created_at' => now(),
            ],

            // 3. Sofa Băng Dài
            [
                'category_id' => 3,
                'product_name' => 'Sofa Băng Dài Modern',
                'description' => 'Sofa dài 2.4m, thiết kế tối giản, chân kim loại mạ chrome. Phù hợp phòng khách hiện đại.',
                'price' => 15900000,
                'original_price' => 18900000,
                'stock' => 7,
                'image_url' => 'sofa-bang-dai.jpg',
                'is_active' => 1,
                'is_featured' => 1,
                'color' => 'Đen',
                'dimensions' => '240x90x75 cm',
                'created_at' => now(),
            ],

            // 4. Sofa Đơn
            [
                'category_id' => 4,
                'product_name' => 'Sofa Đơn Armchair',
                'description' => 'Ghế sofa 1 chỗ, tay tựa cao, phù làm ghế đọc sách hoặc góc thư giãn riêng.',
                'price' => 4500000,
                'original_price' => 5900000,
                'stock' => 15,
                'image_url' => 'sofa-don-armchair.jpg',
                'is_active' => 1,
                'is_featured' => 0,
                'color' => 'Xanh navy',
                'dimensions' => '90x95x85 cm',
                'created_at' => now(),
            ],

            // 5. Sofa Da (2 sản phẩm)
            [
                'category_id' => 5,
                'product_name' => 'Sofa Da Italy Luxury',
                'description' => 'Da bò Ý cao cấp, mềm mại và bền màu. Khung gỗ óc chó, đệm lò xo túi độc lập.',
                'price' => 38900000,
                'original_price' => 45000000,
                'stock' => 3,
                'image_url' => 'sofa-da-italy.jpg',
                'is_active' => 1,
                'is_featured' => 1,
                'color' => 'Nâu đậm',
                'dimensions' => '230x100x90 cm',
                'created_at' => now(),
            ],
            [
                'category_id' => 5,
                'product_name' => 'Sofa Da Simili',
                'description' => 'Da simili cao cấp nhập Hàn Quốc, chống trầy xước, dễ vệ sinh. Giá thành hợp lý.',
                'price' => 12900000,
                'original_price' => 15900000,
                'stock' => 12,
                'image_url' => 'sofa-da-simili.jpg',
                'is_active' => 1,
                'is_featured' => 0,
                'color' => 'Đen bóng',
                'dimensions' => '210x95x85 cm',
                'created_at' => now(),
            ],

            // 6. Sofa Vải (2 sản phẩm)
            [
                'category_id' => 6,
                'product_name' => 'Sofa Vải Nỉ Cao Cấp',
                'description' => 'Vải nỉ Hàn Quốc mềm mại, chống xù lông. Có thể tháo rửa vỏ bọc.',
                'price' => 11500000,
                'original_price' => 13900000,
                'stock' => 10,
                'image_url' => 'sofa-vai-ni.jpg',
                'is_active' => 1,
                'is_featured' => 1,
                'color' => 'Xám nhạt',
                'dimensions' => '215x92x83 cm',
                'created_at' => now(),
            ],
            [
                'category_id' => 6,
                'product_name' => 'Sofa Vải Canvas',
                'description' => 'Vải canvas bền chắc, chống bám bụi. Nhiều màu sắc trẻ trung.',
                'price' => 9500000,
                'original_price' => 11900000,
                'stock' => 18,
                'image_url' => 'sofa-vai-canvas.jpg',
                'is_active' => 1,
                'is_featured' => 0,
                'color' => 'Xanh rêu',
                'dimensions' => '205x90x80 cm',
                'created_at' => now(),
            ],

            // 7. Sofa Góc
            [
                'category_id' => 7,
                'product_name' => 'Sofa Góc Chữ L Modular',
                'description' => 'Thiết kế module, có thể tách rời thành 2 sofa riêng. Tiết kiệm diện tích.',
                'price' => 23500000,
                'original_price' => 27900000,
                'stock' => 6,
                'image_url' => 'sofa-goc-modular.jpg',
                'is_active' => 1,
                'is_featured' => 1,
                'color' => 'Be',
                'dimensions' => '280x180x85 cm',
                'created_at' => now(),
            ],

            // 8. Sofa Băng 3 Chỗ
            [
                'category_id' => 8,
                'product_name' => 'Sofa Băng 3 Chỗ Manhattan',
                'description' => 'Sofa 3 chỗ thiết kế đơn giản, phù hợp mọi không gian. Đệm ngồi dày 30cm.',
                'price' => 14500000,
                'original_price' => 17500000,
                'stock' => 9,
                'image_url' => 'sofa-bang-3-cho.jpg',
                'is_active' => 1,
                'is_featured' => 0,
                'color' => 'Xám đá',
                'dimensions' => '210x90x82 cm',
                'created_at' => now(),
            ],
        ]);
    }
}
