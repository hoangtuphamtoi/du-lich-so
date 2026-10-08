<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bổ sung CSRF Token cho hàm post JS -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $product->title ?? 'Chi tiết sản phẩm' }} - Đặc sản Việt</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Tải cả CSS và JS bằng Vite -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="s1">

<header class="s2">
<div class="s3">
<a class="s4" href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
    <img src="{{ asset('images/logo.png') }}" 
         alt="Logo Đặc sản Việt" 
         style="height: 70px; width: auto; object-fit: contain;">
</a>
<nav class="nav s6">
<nav class="nav s6">
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 's7' : '' }}">Trang chủ</a>
    <a href="{{ route('products.show', 1) }}">Sản phẩm</a>
    <a href="{{ route('categories.index') }}">Danh mục</a>
    <a href="{{ route('traceability.index') }}">Truy xuất</a>
</nav>
</nav>
<div class="s8">
<button class="s9" aria-label="Tìm kiếm"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17261E" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg></button>
<button class="s9" aria-label="Giỏ hàng"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17261E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4h2l2.5 11h10L20 7H6"/><circle cx="9" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/></svg></button>
<a href="{{ route('admin.dashboard') }}" class="s10" aria-label="Tài khoản" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4-6 8-6s7 2 8 6"/></svg>
</a>
</div>
</div>
</header>

<!-- NỘI DUNG CHI TIẾT SẢN PHẨM & FORM ĐẶT VÉ -->
<section class="s28" style="padding: 32px 16px;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Breadcrumb -->
        <nav style="font-size: 14px; color: #64748B; margin-bottom: 20px;">
            <a href="{{ url('/') }}" style="color: #0B3B2C; text-decoration: none; font-weight: 500;">Trang chủ</a> / 
            <span style="color: #1E293B; font-weight: 600;">{{ $product->title ?? 'Chi tiết sản phẩm' }}</span>
        </nav>

        <!-- Tiêu đề sản phẩm -->
        <h1 style="font-size: 32px; font-weight: 800; color: #0B3B2C; margin-bottom: 24px; font-family: 'Be Vietnam Pro', sans-serif;">
            {{ $product->title ?? 'Sản phẩm kiểm thử #'.$id }}
        </h1>

        <!-- Thông báo Trạng thái / Lỗi -->
        @if (session('status'))
            <div style="background: #DCFCE7; border: 1px solid #86EFAC; color: #166534; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;">
                {{ session('status') }}
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;">
                {{ $errors->first() }}
            </div>
        @endif

        @php
            $totalSeats = $availability->seats_total ?? $availability->total ?? $availability->capacity ?? 0;
            $bookedSeats = $availability->seats_booked ?? $availability->booked ?? $availability->reserved ?? 0;
            $remainingSeats = $totalSeats - $bookedSeats;
        @endphp

        <!-- Khối thông tin Tồn kho & Form đặt chỗ -->
        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h2 style="font-size: 20px; font-weight: 700; color: #0B3B2C; margin-bottom: 16px; border-bottom: 2px solid #F1F5F9; padding-bottom: 12px;">
                Tình trạng chỗ trống (Tồn kho)
            </h2>

            @if ($availability)
                <div style="margin-bottom: 24px; font-size: 15px; color: #334155; line-height: 1.8;">
                    <p style="margin: 0;">Tổng số chỗ: <strong style="color: #0F172A;">{{ $totalSeats }}</strong></p>
                    <p style="margin: 0;">Đã đặt: <strong style="color: #D97706;">{{ $bookedSeats }}</strong></p>
                    <p style="margin: 0;">Còn lại: <strong style="color: #16A34A;">{{ $remainingSeats }}</strong> chỗ</p>
                </div>

                <form method="POST" action="{{ \Illuminate\Support\Facades\Route::has('bookings.store') ? route('bookings.store') : url('/dat-ve') }}" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $id }}">

                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #1E293B; margin-bottom: 8px;">Ngày sử dụng:</label>
                        <input type="date" name="service_date" value="{{ date('Y-m-d') }}" required style="width: 100%; border: 1px solid #CBD5E1; padding: 12px 16px; border-radius: 12px; font-size: 15px; outline: none; box-sizing: border-box;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #1E293B; margin-bottom: 8px;">Số lượng (pax):</label>
                        <input type="number" name="pax" value="1" min="1" required style="width: 100%; border: 1px solid #CBD5E1; padding: 12px 16px; border-radius: 12px; font-size: 15px; outline: none; box-sizing: border-box;">
                    </div>

                    <button type="submit" style="background: #2563EB; color: #FFFFFF; border: none; font-weight: 700; font-size: 16px; padding: 14px; border-radius: 99px; cursor: pointer; transition: background 0.2s ease;" onmouseover="this.style.background='#1D4ED8'" onmouseout="this.style.background='#2563EB'">
                        GỬI YÊU CẦU ĐẶT VÉ (SUBMIT)
                    </button>
                </form>
            @else
                <p style="color: #EF4444; font-weight: 600;">Chưa có dữ liệu tồn kho cho sản phẩm ID #{{ $id }}.</p>
            @endif
        </div>

    </div>
</section>

<!-- FOOTER ĐỒNG BỘ 100% VỚI TRANG CHỦ -->
<footer class="s77">
<div class="s78">
<div class="foot s79">
<div class="s72"><span class="s80">Đặc sản Việt</span><span class="s81">Đặc sản Việt – Gìn giữ giá trị quê hương</span></div>
<div class="fl s82"><b class="s83">Liên kết nhanh</b><a href="{{ url('/') }}">Trang chủ</a><a href="#">Sản phẩm</a><a href="#">Danh mục</a><a href="#">Truy xuất nguồn gốc</a></div>
<div class="fl s82"><b class="s83">Hỗ trợ</b><a href="#">Về chúng tôi</a><a href="#">Chính sách bảo mật</a><a href="#">Điều khoản sử dụng</a><a href="#">Liên hệ</a></div>
<div class="s72"><b class="s83">Kết nối với chúng tôi</b>
<div class="s84">
<a class="s85" href="#" aria-label="Facebook">f</a>
<a class="s86" href="#" aria-label="YouTube"><svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M6 4l14 8-14 8z"/></svg></a>
<a class="s86" href="#" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></svg></a>
</div></div>
</div>
<div class="s87">© 2025. Sàn thương mại đặc sản và quà lưu niệm. All rights reserved.</div>
</div>
</footer>

</div>
</body>
</html>