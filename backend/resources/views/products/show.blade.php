<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name ?? $product->title ?? 'Chi tiết sản phẩm' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; background-color: #FAF9F6; color: #1E293B; margin: 0; padding: 40px 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        
        /* Breadcrumb */
        .breadcrumb { font-size: 14px; color: #64748B; margin-bottom: 20px; }
        .breadcrumb a { color: #64748B; text-decoration: none; }
        .breadcrumb a:hover { color: #0B3B2C; }

        /* Product Main Card */
        .product-card { background: #FFFFFF; border-radius: 20px; box-shadow: 0 4px 25px rgba(0,0,0,0.05); border: 1px solid #E2E8F0; padding: 32px; display: grid; grid-template-columns: 1fr 1.2fr; gap: 40px; }
        @media (max-width: 768px) { .product-card { grid-template-columns: 1fr; } }

        /* Image Section */
        .product-image-box { background: #F8FAFC; border-radius: 16px; border: 1px solid #E2E8F0; display: flex; align-items: center; justify-content: center; min-height: 320px; overflow: hidden; }
        .product-image-box img { width: 100%; height: 100%; object-fit: cover; }
        .no-image { color: #94A3B8; font-size: 14px; font-weight: 500; text-align: center; }

        /* Product Info */
        .product-title { font-size: 28px; font-weight: 800; color: #0B3B2C; margin: 0 0 12px 0; }
        .product-price { font-size: 26px; font-weight: 800; color: #15803D; margin-bottom: 20px; }

        /* Verification Badge Box */
        .origin-box { background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }
        .badge-verified { background: #10B981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 8px; }
        .origin-info p { margin: 4px 0; font-size: 13px; color: #065F46; font-weight: 600; }

        /* Product Details List */
        .info-group { border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; padding: 16px 0; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { color: #64748B; font-weight: 500; }
        .info-value { color: #0F172A; font-weight: 700; }

        /* Order Form */
        .order-box { background: #F8FAFC; border-radius: 12px; padding: 20px; border: 1px solid #E2E8F0; }
        .quantity-control { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .quantity-btn { width: 36px; height: 36px; border: 1px solid #CBD5E1; background: white; border-radius: 8px; font-size: 18px; font-weight: 700; cursor: pointer; color: #334155; }
        .quantity-input { width: 60px; height: 36px; text-align: center; border: 1px solid #CBD5E1; border-radius: 8px; font-weight: 700; font-size: 15px; }
        .btn-buy { width: 100%; background: #0B3B2C; color: white; border: none; padding: 14px; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; transition: background 0.2s; text-decoration: none; display: block; text-align: center; box-sizing: border-box; }
        .btn-buy:hover { background: #14532D; }

        /* Out of Stock Alert */
        .out-of-stock { background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 16px; border-radius: 12px; text-align: center; font-weight: 700; font-size: 15px; }

        /* Description Box */
        .description-box { margin-top: 32px; background: white; border-radius: 20px; padding: 28px; border: 1px solid #E2E8F0; box-shadow: 0 4px 25px rgba(0,0,0,0.05); }
        .description-title { font-size: 18px; font-weight: 800; color: #0B3B2C; margin: 0 0 12px 0; border-bottom: 2px solid #F1F5F9; padding-bottom: 10px; }
        .description-content { font-size: 14px; line-height: 1.7; color: #334155; }
    </style>
</head>
<body>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="/">Trang chủ</a> / <a href="/san-pham">Sản phẩm</a> / <strong>{{ $product->name ?? $product->title ?? 'Sản phẩm' }}</strong>
    </div>

    <!-- Product Card -->
    <div class="product-card">
        <!-- Ảnh sản phẩm -->
        <div class="product-image-box">
            @php
                $rawImg = $product->image_url ?? $product->image ?? null;
                $imageUrl = null;
                if ($rawImg) {
                    if (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) {
                        $imageUrl = $rawImg;
                    } else {
                        $clean = ltrim($rawImg, '/');
                        $imageUrl = str_starts_with($clean, 'storage/') ? asset($clean) : asset('storage/' . $clean);
                    }
                }
            @endphp

            @if($imageUrl)
                <img src="{{ $imageUrl }}" 
                     alt="{{ $product->name ?? $product->title ?? 'Sản phẩm' }}" 
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/500x500?text=Anh+Loi';">
            @else
                <div class="no-image">📷 Chưa có hình ảnh</div>
            @endif
        </div>

        <!-- Thông tin & Đặt hàng -->
        <div>
            <h1 class="product-title">{{ $product->name ?? $product->title ?? 'Chưa có tên' }}</h1>
            
            @php
                // 1. Quét tìm giá bán (khuyến mãi) từ tất cả tên cột có thể sử dụng
                $salePrice = $product->sale_price 
                    ?? $product->discount_price 
                    ?? $product->promotion_price 
                    ?? $product->sell_price 
                    ?? $product->price 
                    ?? $product->gia_ban 
                    ?? $product->gia_khuyen_mai 
                    ?? null;
                
                // 2. Lấy giá gốc
                $basePrice = $product->base_price ?? $product->gia_goc ?? 0;

                // 3. Nếu tìm thấy giá bán > 0 thì dùng giá bán, ngược lại lấy giá gốc
                $finalPrice = ($salePrice && $salePrice > 0) ? $salePrice : $basePrice;
            @endphp

            <div class="product-price">
                {{ number_format($finalPrice, 0, ',', '.') }}đ

                {{-- Nếu giá gốc cao hơn giá bán -> Hiện giá gốc gạch ngang --}}
                @if($basePrice > 0 && $basePrice > $finalPrice)
                    <span style="text-decoration: line-through; color: #94A3B8; font-size: 18px; margin-left: 8px; font-weight: 500;">
                        {{ number_format($basePrice, 0, ',', '.') }}đ
                    </span>
                @endif
            </div>

            <!-- Khung nguồn gốc -->
            <div class="origin-box">
                <div class="origin-info">
                    <span class="badge-verified">✓ Đã xác minh nguồn gốc</span>
                    <p>Xuất xứ: {{ $product->origin ?? $product->xuat_xu ?? 'Sơn La' }}</p>
                    <p>Mã truy xuất: TX-{{ $product->id ?? '0' }}-2026</p>
                </div>
            </div>

            <!-- Thông tin ngày sản xuất & Hạn sử dụng -->
            <div class="info-group">
                <div class="info-row">
                    <span class="info-label">Ngày sản xuất (NSX):</span>
                    <span class="info-value">
                        {{ isset($product->mfg_date) ? \Carbon\Carbon::parse($product->mfg_date)->format('d/m/Y') : 'Xem trên bao bì' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Hạn sử dụng (HSD):</span>
                    <span class="info-value">
                        {{ isset($product->exp_date) ? \Carbon\Carbon::parse($product->exp_date)->format('d/m/Y') : '12 tháng kể từ NSX' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số lượng tồn kho:</span>
                    <span class="info-value" style="color: {{ ($product->stock ?? $product->so_luong ?? 0) > 0 ? '#16A34A' : '#DC2626' }};">
                        {{ $product->stock ?? $product->so_luong ?? 0 }} sản phẩm
                    </span>
                </div>
            </div>

            <!-- Đặt hàng / Hết hàng -->
            @if(($product->stock ?? $product->so_luong ?? 1) > 0)
                <div class="order-box">
                    <div style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: #334155;">Số lượng mua:</div>
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock ?? $product->so_luong ?? 99 }}" class="quantity-input" readonly>
                        <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                    </div>
                    
                    <a id="btnCheckout" href="{{ route('checkout.index', $product->id ?? 1) }}?quantity=1" class="btn-buy">
                        🛒 Đặt mua ngay
                    </a>
                </div>
            @else
                <div class="out-of-stock">
                    ⚠️ Sản phẩm hiện tại đã hết hàng trong kho.
                </div>
            @endif
        </div>
    </div>

    <!-- Mô tả chi tiết sản phẩm -->
    <div class="description-box">
        <h3 class="description-title">Mô tả sản phẩm</h3>
        <div class="description-content">
            {!! nl2br(e($product->description ?? $product->mo_ta ?? 'Chưa có thông tin mô tả chi tiết cho sản phẩm này.')) !!}
        </div>
    </div>
</div>

<script>
    function increaseQuantity() {
        let input = document.getElementById('quantity');
        let btn = document.getElementById('btnCheckout');
        let max = parseInt(input.getAttribute('max')) || 99;
        let value = parseInt(input.value) || 1;
        if (value < max) {
            value++;
            input.value = value;
            btn.href = "{{ route('checkout.index', $product->id ?? 1) }}?quantity=" + value;
        }
    }

    function decreaseQuantity() {
        let input = document.getElementById('quantity');
        let btn = document.getElementById('btnCheckout');
        let value = parseInt(input.value) || 1;
        if (value > 1) {
            value--;
            input.value = value;
            btn.href = "{{ route('checkout.index', $product->id ?? 1) }}?quantity=" + value;
        }
    }
</script>

</body>
</html>