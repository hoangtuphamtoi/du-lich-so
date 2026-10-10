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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết tới bảng users
            $table->string('receiver_name');  // Tên người nhận
            $table->string('phone');          // Số điện thoại người nhận
            $table->string('address_detail'); // Số nhà, tên đường, thôn/xóm
            $table->string('city');           // Tỉnh / Thành phố
            $table->boolean('is_default')->default(false); // Địa chỉ mặc định (true/false)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};