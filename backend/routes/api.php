<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Route gợi ý sản phẩm kết nối tới Python microservice
    Route::get('products/{id}/recommend', [ProductController::class, 'recommend']);
});