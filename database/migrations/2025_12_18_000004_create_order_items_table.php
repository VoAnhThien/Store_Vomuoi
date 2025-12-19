<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');

            // Foreign keys
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();

            // ← THÊM: Lưu tên sản phẩm để tránh mất data
            $table->string('product_name', 150)->comment('Lưu tên để tránh mất data khi xóa product');

            $table->integer('quantity');
            $table->decimal('price', 10, 2)->comment('Giá tại thời điểm mua');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('orders')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('product_id')
                  ->references('product_id')
                  ->on('products')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            // Indexes
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
