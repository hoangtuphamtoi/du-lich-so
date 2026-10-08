<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Tự động thêm cột price nếu CSDL chưa có
            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (!Schema::hasColumn('products', 'is_discount')) {
                $table->boolean('is_discount')->default(false);
            }
            if (!Schema::hasColumn('products', 'discount_price')) {
                $table->decimal('discount_price', 15, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'is_featured', 'is_discount', 'discount_price']);
        });
    }
};