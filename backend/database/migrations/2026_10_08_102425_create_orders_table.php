<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại liên kết tới bảng users và products
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->text('note')->nullable();
            $table->integer('quantity');
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method')->default('cod'); // 'cod' hoặc 'qr'
            $table->string('payment_status')->default('pending'); // 'pending', 'paid', 'rejected'
            $table->string('payment_proof')->nullable(); // Đường dẫn ảnh minh chứng
            $table->string('status')->default('pending_approval'); 
            // Trạng thái đơn: 'pending_approval' (Chờ duyệt), 'processing' (Đang chuẩn bị hàng), 'shipping' (Đang giao), 'completed' (Đã giao), 'cancelled' (Đã hủy)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};