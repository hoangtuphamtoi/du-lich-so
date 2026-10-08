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
    <a href="{{ route('products.show', 1) }}">Sản phẩm</a>
    <a href="{{ route('categories.index') }}">Danh mục</a>
    <a href="{{ route('traceability.index') }}">Truy xuất</a>
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
        <!-- Khối nội dung duy nhất bên trái -->
        <div class="s13" style="max-width: 420px; z-index: 2;">
            
            <!-- Badge viền vàng -->
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

            <!-- Tiêu đề 4 dòng -->
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

            <!-- Đoạn mô tả -->
            <p class="s17" style="
                color: #CBD5E1;
                font-size: 14px;
                line-height: 1.5;
                margin: 0 0 28px 0;
            ">
                Đặc sản và quà lưu niệm được xác minh, quét mã QR để xem nơi sản xuất của từng sản phẩm.
            </p>

            <!-- Thanh tìm kiếm -->
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
<a href="#" class="cat s33"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20l7-12 4 7 3-4 6 9z"/></svg><div class="s34"><span>Đặc sản<br>miền Bắc</span><span class="s35">→</span></div></a>
<a href="#" class="cat s36"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#8A5A12" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5 9 5M5 9v9M9.5 9v9M14.5 9v9M19 9v9M3 20h18"/></svg><div class="s34"><span>Đặc sản<br>miền Trung</span><span class="s35">→</span></div></a>
<a href="#" class="cat s37"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#1F5A70" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21V8M12 8c-1-3-4-4-7-3 2 0 4 1 5 3M12 8c1-3 4-4 7-3-2 0-4 1-5 3M4 21h16"/></svg><div class="s34"><span>Đặc sản<br>miền Nam</span><span class="s35">→</span></div></a>
<a href="#" class="cat s38"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#9A4A32" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="9" width="18" height="11" rx="1"/><path d="M2 9h20v-3H2zM12 6v14M12 6c-1-3-5-3-5 0M12 6c1-3 5-3 5 0"/></svg><div class="s34"><span>Quà<br>lưu niệm</span><span class="s35">→</span></div></a>
</div>
</section>

<section class="s28">
<div class="s39">
<div class="s40"><span class="s30">ĐƯỢC YÊU THÍCH</span><h2 class="s31">Sản phẩm nổi bật</h2></div>
<a class="s41" href="#">Xem tất cả <span>→</span></a>
</div>
<div class="grid4 s32">
<div class="card"><div class="ph s42"><span class="badge">Đã xác minh</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#B87618" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s43"><b class="s44">Mật ong hoa nhãn</b><span class="s45">180.000đ</span><span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Sơn La</span></div>
<a href="#" class="btn">Xem chi tiết</a></div>
<div class="card"><div class="ph s47"><span class="badge">Đã xác minh</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s43"><b class="s44">Chè Shan tuyết</b><span class="s45">250.000đ</span><span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Hà Giang</span></div>
<a href="#" class="btn">Xem chi tiết</a></div>
<div class="card"><div class="ph s48"><span class="badge">Đã xác minh</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#9A3B52" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s43"><b class="s44">Trà sen Tây Hồ</b><span class="s45">220.000đ</span><span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Hà Nội</span></div>
<a href="#" class="btn">Xem chi tiết</a></div>
<div class="card"><div class="ph s49"><span class="badge">Đã xác minh</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#6B4A33" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s43"><b class="s44">Tượng gỗ truyền thống</b><span class="s45">450.000đ</span><span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Huế</span></div>
<a href="#" class="btn">Xem chi tiết</a></div>
</div>
</section>

<section class="s28">
<div class="s50">
<div class="s51">
<div class="s40"><span class="s52">ƯU ĐÃI CÓ HẠN</span><h2 class="s31">Đặc sản đang giảm giá</h2><span class="s53">Số lượng có hạn, hết thời gian là trở về giá gốc.</span></div>
<div class="s54"><span class="s55">Kết thúc sau</span>
<div class="tm"><b>02</b><span>Ngày</span></div><div class="tm"><b>14</b><span>Giờ</span></div><div class="tm"><b>35</b><span>Phút</span></div><div class="tm s56"><b>08</b><span class="s57">Giây</span></div></div>
</div>
<div class="grid4 s32">
<div class="card s58"><div class="ph s59"><span class="off">-20%</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#6B4A33" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s60"><b class="s44">Cà phê Buôn Ma Thuột</b><span class="s61"><span class="s62">168.000đ</span><span class="old">210.000đ</span></span>
<span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Đắc Lắc</span>
<div class="bar s63"><i class="s64"></i></div><span class="s65">Đã bán 72% suất ưu đãi</span></div>
<a href="#" class="buy">Mua ngay</a></div>

<div class="card s58"><div class="ph s42"><span class="off">-15%</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#B87618" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s60"><b class="s44">Nước mắm Phú Quốc</b><span class="s61"><span class="s62">136.000đ</span><span class="old">160.000đ</span></span>
<span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Kiên Giang</span>
<div class="bar s63"><i class="s66"></i></div><span class="s65">Đã bán 48% suất ưu đãi</span></div>
<a href="#" class="buy">Mua ngay</a></div>

<div class="card s58"><div class="ph s37"><span class="off">-30%</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#1F5A70" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s60"><b class="s44">Bánh pía Sóc Trăng</b><span class="s61"><span class="s62">105.000đ</span><span class="old">150.000đ</span></span>
<span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Sóc Trăng</span>
<div class="bar s63"><i class="s67"></i></div><span class="s68">Sắp hết, còn 15% suất</span></div>
<a href="#" class="buy">Mua ngay</a></div>

<div class="card s58"><div class="ph s47"><span class="off">-25%</span><svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="M4 18l5-5 4 4 3-3 4 4"/></svg></div>
<div class="s60"><b class="s44">Nón lá Huế thêu tay</b><span class="s61"><span class="s62">195.000đ</span><span class="old">260.000đ</span></span>
<span class="s46"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5A6A60" stroke-width="2" stroke-linecap="round"><path d="M12 21s-7-6-7-12a7 7 0 0114 0c0 6-7 12-7 12z"/><circle cx="12" cy="9" r="2.5"/></svg>Huế</span>
<div class="bar s63"><i class="s69"></i></div><span class="s65">Đã bán 35% suất ưu đãi</span></div>
<a href="#" class="buy">Mua ngay</a></div>
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
<div class="fl s82"><b class="s83">Liên kết nhanh</b><a href="#">Trang chủ</a><a href="#">Sản phẩm</a><a href="#">Danh mục</a><a href="#">Truy xuất nguồn gốc</a></div>
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