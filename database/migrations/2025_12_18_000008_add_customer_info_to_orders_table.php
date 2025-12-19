<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kiểm tra từng cột trước khi thêm
            if (!Schema::hasColumn('orders', 'order_code')) {
                $table->string('order_code', 20)->unique()->after('order_id');
            }
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone', 20)->after('customer_name');
            }
            if (!Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_phone');
            }
            if (!Schema::hasColumn('orders', 'customer_address')) {
                $table->text('customer_address')->after('customer_email');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->enum('payment_method', ['cod', 'bank_transfer', 'momo'])
                      ->default('cod')
                      ->after('customer_address');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('payment_method');
            }
        });

        // Cập nhật enum cho order_status
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `order_status`
            ENUM('pending','confirmed','paid','shipped','delivered','completed','cancelled')
            DEFAULT 'pending'");
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'order_code',
                'customer_name',
                'customer_phone',
                'customer_email',
                'customer_address',
                'payment_method',
                'notes'
            ];

            // Chỉ xóa những cột tồn tại
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `order_status`
            ENUM('pending','paid','shipped','completed','cancelled')
            DEFAULT 'pending'");
    }
};
