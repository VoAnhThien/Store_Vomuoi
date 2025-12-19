<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cho phép password nullable (vì Google login không có password)
            $table->string('password')->nullable()->change();

            // Thêm các cột cho Google OAuth
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('avatar')->nullable()->after('address');
            $table->enum('provider', ['local', 'google'])->default('local')->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar', 'provider']);
            $table->string('password')->nullable(false)->change();
        });
    }
};
