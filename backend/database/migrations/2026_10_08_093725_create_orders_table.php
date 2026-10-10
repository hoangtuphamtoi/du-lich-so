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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết người mua
            $table->string('order_code')->unique();                          // Mã đơn hàng (VD: DH-8X9A21)
            $table->decimal('total_amount', 15, 2);                          // Tổng tiền đơn hàng
            $table->string('receiver_name');                                 // Tên người nhận
            $table->string('phone');                                         // SĐT người nhận
            $table->string('shipping_address');                              // Địa chỉ giao hàng đầy đủ
            
            // Thanh toán: 'cod' (Khi nhận hàng) hoặc 'e_wallet' (Ví điện tử)
            $table->string('payment_method')->default('cod'); 
            $table->string('payment_status')->default('pending');            // pending (Chưa trả) / paid (Đã trả)
            
            // Trạng thái đơn hàng Shopee
            // processing: Đang lấy đơn | preparing: Chờ vận chuyển | shipping: Đang giao | completed: Thành công
            $table->string('status')->default('processing'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};