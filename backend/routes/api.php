<?php

use App\Http\Controllers\Api\{BookingApiController, ProductApiController, RecommendApiController};
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('products', [ProductApiController::class, 'index']);
    Route::get('products/{product}', [ProductApiController::class, 'show']);
    Route::get('products/{product}/recommend', [RecommendApiController::class, 'show'])
        ->middleware('throttle:60,1'); // Giới hạn tần suất truy cập 60 yêu cầu/phút

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('bookings', [BookingApiController::class, 'store']);
        Route::get('me/bookings', [BookingApiController::class, 'mine']);
    });
});