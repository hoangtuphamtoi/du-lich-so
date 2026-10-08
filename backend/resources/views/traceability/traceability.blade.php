<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Truy xuất nguồn gốc - Đặc sản Việt</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <a href="{{ route('products.show', 1) }}" class="{{ request()->routeIs('products.show') ? 's7' : '' }}">Sản phẩm</a>
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

<!-- NỘI DUNG TRUY XUẤT NGUỒN GỐC -->
<section class="s28" style="padding: 40px 16px;">
<div style="max-width: 900px; margin: 0 auto;">

    <!-- Khối tìm kiếm tra cứu mã QR -->
    <div class="trace s70" style="margin-bottom: 40px;">
        <div class="s71">
            <svg width="84" height="84" viewBox="0 0 24 24" fill="none" stroke="#1E4D3B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 8V5a2 2 0 012-2h3M16 3h3a2 2 0 012 2v3M21 16v3a2 2 0 01-2 2h-3M8 21H5a2 2 0 01-2-2v-3"/>
                <rect x="7" y="7" width="4" height="4"/><rect x="13" y="7" width="4" height="4"/><rect x="7" y="13" width="4" height="4"/>
                <path d="M13 13h2v2M17 17h0M15 17v0"/>
            </svg>
        </div>
        <div class="s72">
            <h1 class="s31">Tra Cứu & Kiểm Tra Nguồn Gốc</h1>
            <p class="s73">Nhập mã định danh (mã tem QR) ghi trên bao bì sản phẩm để tra cứu nhật ký sản xuất và chứng nhận chất lượng.</p>
            <form action="{{ route('traceability.index') }}" method="GET" class="s74">
                <input name="code" value="{{ request('code', 'DSV-2025-0891') }}" class="s75" aria-label="Mã sản phẩm" placeholder="Nhập mã sản phẩm (Ví dụ: DSV-2025-0891)...">
                <button type="submit" class="s76">Kiểm tra ngay</button>
            </form>
        </div>
    </div>

    <!-- Kết quả tra cứu minh họa -->
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #F1F5F9; padding-bottom: 16px; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #166534; background: #DCFCE7; border: 1px solid #86EFAC; padding: 4px 12px; border-radius: 99px;">
                    ✓ Đã xác minh nguồn gốc
                </span>
                <h2 style="font-size: 22px; font-weight: 800; color: #0B3B2C; margin-top: 8px;">Mật Ong Hoa Nhãn Sơn La</h2>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; color: #64748B;">Mã lô hàng:</span>
                <div style="font-size: 16px; font-weight: 700; color: #0F172A;">DSV-2025-0891</div>
            </div>
        </div>

        <!-- Thông tin chi tiết lô hàng -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
            <div style="background: #F8FAFC; padding: 16px; border-radius: 16px;">
                <span style="font-size: 12px; color: #64748B; font-weight: 600;">CƠ SỞ SẢN XUẤT</span>
                <p style="font-size: 15px; font-weight: 700; color: #1E293B; margin-top: 4px;">HTX Ong Mật Mộc Châu</p>
            </div>
            <div style="background: #F8FAFC; padding: 16px; border-radius: 16px;">
                <span style="font-size: 12px; color: #64748B; font-weight: 600;">VÙNG TRỒNG / NGUYÊN LIỆU</span>
                <p style="font-size: 15px; font-weight: 700; color: #1E293B; margin-top: 4px;">Huyện Sông Mã, Tỉnh Sơn La</p>
            </div>
            <div style="background: #F8FAFC; padding: 16px; border-radius: 16px;">
                <span style="font-size: 12px; color: #64748B; font-weight: 600;">TIÊU CHUẨN CHẤT LƯỢNG</span>
                <p style="font-size: 15px; font-weight: 700; color: #16A34A; margin-top: 4px;">OCOP 4 Sao - VietGAP</p>
            </div>
            <div style="background: #F8FAFC; padding: 16px; border-radius: 16px;">
                <span style="font-size: 12px; color: #64748B; font-weight: 600;">NGÀY ĐÓNG GÓI</span>
                <p style="font-size: 15px; font-weight: 700; color: #1E293B; margin-top: 4px;">15/05/2025</p>
            </div>
        </div>

        <!-- Tiến trình/Nhật ký sản xuất -->
        <h3 style="font-size: 18px; font-weight: 700; color: #0B3B2C; margin-bottom: 16px;">Nhật Ký Truy Xuất Nguồn Gốc</h3>
        <div style="border-left: 2px solid #E2E8F0; padding-left: 20px; margin-left: 8px; display: flex; flex-direction: column; gap: 20px;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #2563EB;">15/05/2025 - 14:30</span>
                <p style="font-weight: 700; color: #1E293B; margin: 2px 0;">Đóng chai & Dán tem xác thực QR</p>
                <p style="font-size: 13px; color: #64748B; margin: 0;">Kiểm định chỉ số đường & thủy phần đạt chuẩn xuất khẩu.</p>
            </div>
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #2563EB;">10/05/2025 - 08:00</span>
                <p style="font-weight: 700; color: #1E293B; margin: 2px 0;">Thu hoạch mật hoa nhãn đợt 2</p>
                <p style="font-size: 13px; color: #64748B; margin: 0;">Quá trình khai thác tự nhiên tại trang trại hoa nhãn Sông Mã.</p>
            </div>
        </div>

    </div>

</div>
</section>

<!-- FOOTER -->
<footer class="s77">
<div class="s78">
<div class="foot s79">
<div class="s72"><span class="s80">Đặc sản Việt</span><span class="s81">Đặc sản Việt – Gìn giữ giá trị quê hương</span></div>
<div class="fl s82"><b class="s83">Liên kết nhanh</b><a href="{{ url('/') }}">Trang chủ</a><a href="#">Sản phẩm</a><a href="{{ route('categories.index') }}">Danh mục</a><a href="{{ route('traceability.index') }}">Truy xuất nguồn gốc</a></div>
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