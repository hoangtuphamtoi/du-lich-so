<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierBookingController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes - Dự án Du Lịch Số
|--------------------------------------------------------------------------
*/

// Trang chủ - Lấy dữ liệu sản phẩm Nổi bật & Giảm giá từ Database
Route::get('/', function () {
    $featuredProducts = Product::where('is_featured', true)->latest()->take(4)->get();
    $discountProducts = Product::where('is_discount', true)->orWhereNotNull('discount_price')->latest()->take(4)->get();

    return view('welcome', compact('featuredProducts', 'discountProducts'));
});

// Route Danh mục sản phẩm
Route::get('/danh-muc', function () {
    return view('categories.categories');
})->name('categories.index');

// Route Truy xuất nguồn gốc
Route::get('/truy-xuat', function () {
    return view('traceability.traceability');
})->name('traceability.index');

// Route xem chi tiết sản phẩm / đặt chỗ
Route::get('/san-pham/{id}', [BookingController::class, 'showProduct'])->name('products.show');

// Route Giao diện Đặt vé Test (GET) & Route Xử lý Submit Form (POST)
Route::get('/dat-ve', function () {
    return view('booking-test');
})->name('bookings.test');

Route::post('/dat-ve', [BookingController::class, 'store'])->name('bookings.store');

// Route Alias hỗ trợ kiểm thử API AJAX / Curl
Route::post('/api/v1/bookings', [BookingController::class, 'store']);

// Tra cứu đơn hàng bằng Token đã mã hóa & Tải hóa đơn Signed Route
Route::get('/tra-cuu/{token}', [BookingController::class, 'lookup'])->name('bookings.lookup');
Route::get('/hoa-don/{booking}', [BookingController::class, 'downloadInvoice'])
    ->name('invoice.download')
    ->middleware('signed');

// User Dashboard & Profile Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Nhóm dành riêng cho Admin
Route::middleware(['auth', 'role:admin'])->prefix('quan-tri')->group(function () {
    Route::get('/bang-dieu-khien', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Quản lý sản phẩm (Danh mục, Nổi bật, Giảm giá)
    Route::get('/san-pham', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/san-pham/them', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/san-pham', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::delete('/san-pham/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::match(['post', 'patch'], '/san-pham/{id}/noi-bat', [AdminProductController::class, 'toggleFeatured'])->name('admin.products.toggleFeatured');
    Route::match(['post', 'patch'], '/san-pham/{id}/giam-gia', [AdminProductController::class, 'updateDiscount'])->name('admin.products.updateDiscount');

    // Quản lý người dùng
    Route::get('/nguoi-dung', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::delete('/nguoi-dung/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/nguoi-dung/{id}/doi-mat-khau', [AdminUserController::class, 'changePassword'])->name('admin.users.change-password');
});

// Nhóm dành cho Supplier và Admin
Route::middleware(['auth', 'role:supplier,admin'])->prefix('nha-cung-cap')->group(function () {
    Route::get('/don-hang', [SupplierBookingController::class, 'index']);
});

// Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

require __DIR__ . '/auth.php';