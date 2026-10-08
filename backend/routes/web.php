<?php

// use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierBookingController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Danh mục sản phẩm (sửa trỏ vào categories/categories.blade.php)
Route::get('/danh-muc', function () {
    return view('categories.categories');
})->name('categories.index');

// Route Truy xuất nguồn gốc (sửa trỏ vào traceability/traceability.blade.php)
Route::get('/truy-xuat', function () {
    return view('traceability.traceability');
})->name('traceability.index');

// Route xem chi tiết sản phẩm / đặt chỗ
Route::get('/san-pham/{id}', [BookingController::class, 'showProduct'])->name('products.show');

// Route xử lý đặt vé (Submit Form)
Route::post('/dat-ve', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Nhóm dành riêng cho Admin
Route::middleware(['auth', 'role:admin'])->prefix('quan-tri')->group(function () {
    Route::get('/bang-dieu-khien', [DashboardController::class, 'index'])->name('admin.dashboard');
 //   Route::resource('san-pham', AdminProductController::class);
});

// Nhóm dành cho Supplier và Admin
Route::middleware(['auth', 'role:supplier,admin'])->prefix('nha-cung-cap')->group(function () {
    Route::get('/don-hang', [SupplierBookingController::class, 'index']);
});

// Mã hóa tham số & Signed Route (Mục 6.6)
Route::get('/tra-cuu/{token}', [BookingController::class, 'lookup'])->name('bookings.lookup');
Route::get('/hoa-don/{booking}', [BookingController::class, 'downloadInvoice'])
    ->name('invoice.download')
    ->middleware('signed');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});