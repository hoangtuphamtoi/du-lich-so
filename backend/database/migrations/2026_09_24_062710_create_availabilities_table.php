<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $t) {
            $t->id();
           $t->unsignedBigInteger('product_id');
            $t->date('service_date');
            $t->unsignedSmallInteger('seats_total');
            $t->unsignedSmallInteger('seats_held')->default(0);
            $t->unsignedSmallInteger('seats_sold')->default(0);
            $t->decimal('price_override', 12, 2)->nullable();
            
            // Unique key và Index tối ưu hiệu năng
            $t->unique(['product_id', 'service_date'], 'uq_av');
            $t->index('service_date', 'idx_av_date');
        });
    }

    public function down(): void 
    { 
        Schema::dropIfExists('availabilities'); 
    }
};