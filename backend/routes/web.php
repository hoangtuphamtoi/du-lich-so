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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - Dự án Du Lịch Số
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', function () {
    $featuredProducts = Product::where('is_featured', true)->latest()->take(8)->get();
    $discountProducts = Product::where('is_discount', true)->orWhereNotNull('discount_price')->latest()->take(8)->get();

    return view('welcome', compact('featuredProducts', 'discountProducts'));
});

// Route Danh mục sản phẩm
Route::get('/danh-muc', function () {
    $products = Product::latest()->paginate(12);

    return view('categories.categories', compact('products'));
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

// User Dashboard & Profile & Checkout & Order Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Thông tin cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mua hàng & Thanh toán
    Route::get('/checkout/{product_id}', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/addresses/store', [CheckoutController::class, 'storeAddress'])->name('addresses.store');

    // Quản lý đơn hàng người dùng
    Route::get('/don-hang', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/don-hang/{id}/thanh-toan-qr', [OrderController::class, 'paymentQr'])->name('orders.payment_qr');
    Route::post('/don-hang/{id}/upload-minh-chung', [OrderController::class, 'uploadProof'])->name('orders.upload_proof');
    
    // Đơn hàng chi tiết & Hủy đơn
    Route::get('/don-hang/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/don-hang/{id}/huy', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Nhóm dành riêng cho Admin
Route::middleware(['auth', 'role:admin'])->prefix('quan-tri')->group(function () {
    Route::get('/bang-dieu-khien', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Quản lý sản phẩm
    Route::get('/san-pham', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/san-pham/them', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/san-pham', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/san-pham/{id}/sua', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/san-pham/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/san-pham/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::match(['post', 'patch'], '/san-pham/{id}/noi-bat', [AdminProductController::class, 'toggleFeatured'])->name('admin.products.toggleFeatured');
    Route::match(['post', 'patch'], '/san-pham/{id}/giam-gia', [AdminProductController::class, 'updateDiscount'])->name('admin.products.updateDiscount');

    // Quản lý người dùng
    Route::get('/nguoi-dung', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::delete('/nguoi-dung/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/nguoi-dung/{id}/doi-mat-khau', [AdminUserController::class, 'updatePassword'])->name('admin.users.update-password');

    // Quản lý Đơn hàng dành cho Admin (Đã đổi name thành admin.orders.updateStatus)
    Route::get('/don-hang', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::match(['post', 'patch'], '/don-hang/{id}/cap-nhat-trang-thai', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
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