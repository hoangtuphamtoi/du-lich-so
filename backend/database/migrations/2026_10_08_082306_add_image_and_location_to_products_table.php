<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột xuất xứ / vị trí
            if (!Schema::hasColumn('products', 'location')) {
                $table->string('location')->nullable();
            }

            // Thêm cột ảnh sản phẩm
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable();
            }

            // Thêm các cột trạng thái nổi bật & giảm giá nếu chưa có
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['location', 'image', 'is_featured', 'is_discount', 'discount_price'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};