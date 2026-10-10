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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết bảng orders
            $table->foreignId('product_id')->nullable();                       // ID sản phẩm
            $table->string('product_name');                                    // Tên sản phẩm
            $table->decimal('price', 15, 2);                                   // Giá sản phẩm tại thời điểm mua
            $table->integer('quantity');                                       // Số lượng mua
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};