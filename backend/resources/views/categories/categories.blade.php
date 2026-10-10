<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Danh mục đặc sản - Đặc sản Việt</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    /* KHẮC PHỤC LỖI VỠ ICON PHÂN TRANG (PAGINATION) LARAVEL */
    nav[role="navigation"] svg {
        width: 18px !important;
        height: 18px !important;
        display: inline-block !important;
        vertical-align: middle;
    }

    nav[role="navigation"] {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        width: 100%;
        margin-top: 24px;
    }

    nav[role="navigation"] > div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    nav[role="navigation"] a, 
    nav[role="navigation"] span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 6px;
        text-decoration: none;
    }
</style>
</head>
<body>
<div class="s1">

<header class="s2">
<div class="s3">
    <!-- Logo -> Về trang chủ -->
    <a class="s4" href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Đặc sản Việt" style="height: 70px; width: auto; object-fit: contain;">
    </a>

    <!-- Menu Điều Hướng -->
    <nav class="nav s6">
        <a href="{{ url('/') }}" class="{{ request()->is('/') ? 's7' : '' }}">Trang chủ</a>
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 's7' : '' }}">Danh mục</a>
        <a href="{{ route('traceability.index') }}" class="{{ request()->routeIs('traceability.index') ? 's7' : '' }}">Truy xuất</a>
    </nav>

    <!-- Nút Hành Động -->
    <div class="s8">
        <button class="s9" aria-label="Tìm kiếm">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17261E" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        </button>
        <button class="s9" aria-label="Giỏ hàng">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17261E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4h2l2.5 11h10L20 7H6"/><circle cx="9" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/></svg>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="s10" aria-label="Tài khoản" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4-6 8-6s7 2 8 6"/></svg>
        </a>
    </div>
</div>
</header>

<!-- NỘI DUNG DANH MỤC SẢN PHẨM -->
<section class="s28" style="padding: 40px 16px;">
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 36px;">
        <span class="s30">KHÁM PHÁ ĐẶC SẢN</span>
        <h1 class="s31" style="font-size: 32px; margin-top: 8px;">Danh Mục Sản Phẩm Cội Nguồn</h1>
        <p style="color: #64748B; margin-top: 8px; font-size: 15px;">Tuyển chọn đặc sản đạt chuẩn OCOP và sản phẩm làng nghề truyền thống ba miền</p>
    </div>

    <!-- Grid Phân Loại Theo Vùng Miền -->
    <div style="margin-bottom: 48px;">
        <h2 style="font-size: 20px; font-weight: 700; color: #0B3B2C; margin-bottom: 20px;">1. Theo Vùng Miền</h2>
        <div class="grid4 s32">
            <a href="#" class="cat s33"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20l7-12 4 7 3-4 6 9z"/></svg><div class="s34"><span>Đặc sản<br>miền Bắc</span><span class="s35">→</span></div></a>
            <a href="#" class="cat s36"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#8A5A12" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5 9 5M5 9v9M9.5 9v9M14.5 9v9M19 9v9M3 20h18"/></svg><div class="s34"><span>Đặc sản<br>miền Trung</span><span class="s35">→</span></div></a>
            <a href="#" class="cat s37"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#1F5A70" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21V8M12 8c-1-3-4-4-7-3 2 0 4 1 5 3M12 8c1-3 4-4 7-3-2 0-4 1-5 3M4 21h16"/></svg><div class="s34"><span>Đặc sản<br>miền Nam</span><span class="s35">→</span></div></a>
            <a href="#" class="cat s38"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#9A4A32" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="9" width="18" height="11" rx="1"/><path d="M2 9h20v-3H2zM12 6v14M12 6c-1-3-5-3-5 0M12 6c1-3 5-3 5 0"/></svg><div class="s34"><span>Quà<br>lưu niệm</span><span class="s35">→</span></div></a>
        </div>
    </div>

    <!-- KHỐI HIỂN THỊ TẤT CẢ SẢN PHẨM TỪ DATABASE -->
    <div style="margin-top: 48px;">
        <h2 style="font-size: 22px; font-weight: 700; color: #0B3B2C; margin-bottom: 24px;">
            2. Tất Cả Sản Phẩm
        </h2>
        
        <div class="grid4 s32">
            @forelse($products as $product)
                <div class="card">
                    <div class="ph s42">
                        <span class="badge">Đã xác minh</span>
                        <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
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
                <div style="grid-column: 1 / -1; text-align: center; color: #888; padding: 40px 0;">
                    Chưa có sản phẩm nào trong hệ thống.
                </div>
            @endforelse
        </div>

        <!-- Phân trang đã được sửa giao diện -->
        @if(method_exists($products, 'links'))
            <div style="margin-top: 32px; display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
</section>

<!-- FOOTER -->
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
<div class="s87">© {{ date('Y') }}. Sàn thương mại đặc sản và quà lưu niệm. All rights reserved.</div>
</div>
</footer>

</div>
</body>
</html>