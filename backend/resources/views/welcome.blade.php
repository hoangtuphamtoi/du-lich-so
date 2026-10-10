<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bổ sung CSRF Token cho hàm post JS -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Đặc sản Việt – Trang chủ</title>
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
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 's7' : '' }}">Trang chủ</a>
    <a href="{{ route('categories.index') }}">Danh mục</a>
    <a href="{{ route('traceability.index') }}">Truy xuất</a>
    @auth
    <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
        📦 Đơn hàng của tôi
    </a>
@else
    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
        Đăng nhập
    </a>
@endauth
</nav>
<div class="s8">
<button class="s9" aria-label="Tìm kiếm"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17261E" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg></button>
<button class="s9" aria-label="Giỏ hàng"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17261E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4h2l2.5 11h10L20 7H6"/><circle cx="9" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/></svg></button>

@auth
    {{-- Đã đăng nhập: Chuyển tới Bảng điều khiển / Trang cá nhân --}}
    <a href="{{ route('dashboard') }}" class="s10" aria-label="Tài khoản" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4-6 8-6s7 2 8 6"/></svg>
    </a>
@else
    {{-- Chưa đăng nhập: Chuyển tới trang Đăng nhập --}}
    <a href="{{ route('login') }}" class="s10" aria-label="Tài khoản" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4-6 8-6s7 2 8 6"/></svg>
    </a>
@endauth

</div>
</div>
</header>

{{-- KHỐI HIỂN THỊ THÔNG BÁO THÀNH CÔNG / LỖI --}}
@if (session('success'))
    <div style="max-width: 1200px; margin: 20px auto 0; padding: 16px 24px; background-color: #DEF7EC; border: 1px solid #31C48D; color: #03543F; border-radius: 12px; font-weight: 600; text-align: center; font-size: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        🎉 {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="max-width: 1200px; margin: 20px auto 0; padding: 16px 24px; background-color: #FDE8E8; border: 1px solid #F98080; color: #9B1C1C; border-radius: 12px; font-weight: 600; text-align: center; font-size: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        ⚠️ {{ session('error') }}
    </div>
@endif

<section class="s11" style="padding: 16px;">
    <div class="hero s12" style="
        position: relative;
        border-radius: 28px;
        min-height: 480px;
        overflow: hidden;
        background: linear-gradient(90deg, #0B3B2C 0%, #0B3B2C 25%, rgba(11, 59, 44, 0.7) 40%, rgba(11, 59, 44, 0) 55%),
            url('{{ asset('images/adfgg.png') }}') center right / cover no-repeat;
        display: flex;
        align-items: center;
        padding: 48px;
    ">
        <div class="s13" style="max-width: 420px; z-index: 2;">
            <div class="s14" style="
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(11, 59, 44, 0.6);
                border: 1.5px solid #E2B155;
                color: #E2B155;
                padding: 5px 14px;
                border-radius: 99px;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 24px;
            ">
                <span style="
                    width: 18px;
                    height: 18px;
                    background: #E2B155;
                    color: #0B3B2C;
                    border-radius: 50%;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 10px;
                    font-weight: 900;
                ">✓</span>
                QUÀ TỪ BA MIỀN – CÓ NGUỒN GỐC RÕ RÀNG
            </div>

            <h1 class="s15" style="
                font-size: 42px;
                font-weight: 800;
                line-height: 1.15;
                margin: 0 0 16px 0;
                font-family: system-ui, -apple-system, sans-serif;
            ">
                <span style="color: #FFFFFF;">Đặc sản Việt</span><br>
                <span style="color: #FFFFFF;">Nam,</span><br>
                <span style="color: #E2B155;">mua là biết từ</span><br>
                <span style="color: #E2B155;">đâu.</span>
            </h1>

            <p class="s17" style="
                color: #CBD5E1;
                font-size: 14px;
                line-height: 1.5;
                margin: 0 0 28px 0;
            ">
                Đặc sản và quà lưu niệm được xác minh, quét mã QR để xem nơi sản xuất của từng sản phẩm.
            </p>

            <div class="s18" style="
                background: #FFFFFF;
                padding: 5px 5px 5px 18px;
                border-radius: 99px;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.25);
                max-width: 420px;
            ">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input class="s20" placeholder="Tìm kiếm đặc sản, sản phẩm..." style="border: none; outline: none; width: 100%; font-size: 14px; background: transparent; color: #0F172A;">
                <button class="s21" style="background: #E2B155; color: #0B3B2C; border: none; padding: 10px 24px; border-radius: 99px; font-weight: 700; cursor: pointer; white-space: nowrap;">Tìm kiếm</button>
            </div>
        </div>
    </div>
</section>

<section class="s28">
<div class="s29"><span class="s30">DANH MỤC</span><h2 class="s31">Khám phá theo danh mục</h2></div>
<div class="grid4 s32">
<a href="{{ route('categories.index') }}" class="cat s33"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20l7-12 4 7 3-4 6 9z"/></svg><div class="s34"><span>Đặc sản<br>miền Bắc</span><span class="s35">→</span></div></a>
<a href="{{ route('categories.index') }}" class="cat s36"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#8A5A12" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5 9 5M5 9v9M9.5 9v9M14.5 9v9M19 9v9M3 20h18"/></svg><div class="s34"><span>Đặc sản<br>miền Trung</span><span class="s35">→</span></div></a>
<a href="{{ route('categories.index') }}" class="cat s37"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#1F5A70" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21V8M12 8c-1-3-4-4-7-3 2 0 4 1 5 3M12 8c1-3 4-4 7-3-2 0-4 1-5 3M4 21h16"/></svg><div class="s34"><span>Đặc sản<br>miền Nam</span><span class="s35">→</span></div></a>
<a href="{{ route('categories.index') }}" class="cat s38"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#9A4A32" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="9" width="18" height="11" rx="1"/><path d="M2 9h20v-3H2zM12 6v14M12 6c-1-3-5-3-5 0M12 6c1-3 5-3 5 0"/></svg><div class="s34"><span>Quà<br>lưu niệm</span><span class="s35">→</span></div></a>
</div>
</section>

<!-- KHỐI SẢN PHẨM NỔI BẬT -->
<section class="s28">
    <div class="s39">
        <div class="s40">
            <span class="s30">ĐƯỢC YÊU THÍCH ({{ $featuredProducts->count() }} sản phẩm)</span>
            <h2 class="s31">Sản phẩm nổi bật</h2>
        </div>
        <a class="s41" href="{{ route('categories.index') }}">Xem tất cả <span>→</span></a>
    </div>
    <div class="grid4 s32">
        @forelse($featuredProducts as $product)
            <div class="card">
                <div class="ph s42" style="position: relative; overflow: hidden; height: 180px; display: flex; align-items: center; justify-content: center; background: #F1F5F9;">
                    <span class="badge" style="position: absolute; top: 10px; right: 10px; z-index: 2;">Đã xác minh</span>

                    @if(!empty($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    @endif
                </div>
                <div class="s43">
                    <b class="s44">{{ $product->title }}</b>
                    <span class="s45">{{ number_format($product->discount_price ?? $product->base_price) }}đ</span>
                    <span class="s46">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        {{ $product->location ?? 'Việt Nam' }}
                    </span>
                </div>
                <a href="{{ route('products.show', $product->id) }}" class="btn">Xem chi tiết</a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #888; padding: 20px 0;">
                Chưa có sản phẩm nổi bật nào được chọn trong trang quản trị.
            </div>
        @endforelse
    </div>
</section>

<!-- KHỐI SẢN PHẨM GIẢM GIÁ -->
<section class="s28">
<div class="s50">
<div class="s51">
<div class="s40">
    <span class="s52">ƯU ĐÃI CÓ HẠN ({{ $discountProducts->count() }} sản phẩm)</span>
    <h2 class="s31">Đặc sản đang giảm giá</h2>
    <span class="s53">Số lượng có hạn, hết thời gian là trở về giá gốc.</span>
</div>
<div class="s54"><span class="s55">Kết thúc sau</span>
<div class="tm"><b>02</b><span>Ngày</span></div><div class="tm"><b>14</b><span>Giờ</span></div><div class="tm"><b>35</b><span>Phút</span></div><div class="tm s56"><b>08</b><span class="s57">Giây</span></div></div>
</div>
<div class="grid4 s32">
@forelse($discountProducts as $product)
    <div class="card s58">
        <div class="ph s59" style="position: relative; overflow: hidden; height: 180px; display: flex; align-items: center; justify-content: center; background: #F1F5F9;">
            @if($product->base_price && $product->discount_price && $product->base_price > $product->discount_price)
                <span class="off" style="position: absolute; top: 10px; left: 10px; z-index: 2;">-{{ round((($product->base_price - $product->discount_price) / $product->base_price) * 100) }}%</span>
            @else
                <span class="off" style="position: absolute; top: 10px; left: 10px; z-index: 2;">Ưu đãi</span>
            @endif

            @if(!empty($product->image))
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#6B4A33" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg>
            @endif
        </div>
        <div class="s60">
            <b class="s44">{{ $product->title }}</b>
            <span class="s61">
                <span class="s62">{{ number_format($product->discount_price ?? $product->base_price) }}đ</span>
                @if($product->discount_price && $product->base_price)
                    <span class="old">{{ number_format($product->base_price) }}đ</span>
                @endif
            </span>
            <span class="s46">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>
                {{ $product->location ?? 'Việt Nam' }}
            </span>
            <div class="bar s63"><i class="s64" style="width: 60%;"></i></div>
            <span class="s65">Đang bán chạy</span>
        </div>
        <a href="{{ route('products.show', $product->id) }}" class="buy">Mua ngay</a>
    </div>
@empty
    <div style="grid-column: 1 / -1; text-align: center; color: #888; padding: 20px 0;">
        Chưa có sản phẩm giảm giá nào.
    </div>
@endforelse
</div>
</div>
</section>

<section class="s28">
<div class="trace s70">
<div class="s71"><svg width="84" height="84" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8V5a2 2 0 012-2h3M16 3h3a2 2 0 012 2v3M21 16v3a2 2 0 01-2 2h-3M8 21H5a2 2 0 01-2-2v-3"/><rect x="7" y="7" width="4" height="4"/><rect x="13" y="7" width="4" height="4"/><rect x="7" y="13" width="4" height="4"/><path d="M13 13h2v2M17 17h0M15 17v0"/></svg></div>
<div class="s72">
<h2 class="s31">Kiểm tra nguồn gốc</h2>
<p class="s73">Nhập mã sản phẩm hoặc quét mã QR để xem thông tin nguồn gốc của sản phẩm.</p>
<div class="s74">
<input class="s75" aria-label="Mã sản phẩm" placeholder="Nhập mã sản phẩm...">
<button class="s76">Kiểm tra</button>
</div>
</div>
</div>
</section>

<footer class="s77">
<div class="s78">
<div class="foot s79">
<div class="s72"><span class="s80">Đặc sản Việt</span><span class="s81">Đặc sản Việt – Gìn giữ giá trị quê hương</span></div>
<div class="fl s82"><b class="s83">Liên kết nhanh</b><a href="{{ url('/') }}">Trang chủ</a><a href="{{ route('categories.index') }}">Danh mục</a><a href="{{ route('traceability.index') }}">Truy xuất nguồn gốc</a></div>
<div class="fl s82"><b class="s83">Hỗ trợ</b><a href="#">Về chúng tôi</a><a href="#">Chính sách bảo mật</a><a href="#">Điều khoản sử dụng</a><a href="#">Liên hệ</a></div>
<div class="s72"><b class="s83">Kết nối với chúng tôi</b>
<div class="s84">
<a class="s85" href="#" aria-label="Facebook">f</a>
<a class="s86" href="#" aria-label="YouTube"><svg width="16" height="16" viewBox="0 0 24 24" fill="#fff"><path d="M6 4l14 8-14 8z"/></svg></a>
<a class="s86" href="#" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></svg></a>
</div></div>
</div>
<div class="s87">© 2026. Sàn thương mại đặc sản và quà lưu niệm. All rights reserved.</div>
</div>
</footer>

</div>
</body>
</html>