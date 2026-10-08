<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px; font-family: Arial, sans-serif;">
    <!-- Breadcrumb điều hướng -->
    <p style="color: #666; font-size: 14px; margin-bottom: 12px;">
        <a href="/" style="color: #666; text-decoration: none;">Trang chủ</a> / 
        <a href="/san-pham" style="color: #666; text-decoration: none;">Sản phẩm quà lưu niệm</a> / 
        <strong style="color: #1A3A2A;">{{ $product->name ?? $product->title ?? 'Sản phẩm lưu niệm' }}</strong>
    </p>

    <!-- Tên sản phẩm -->
    <h1 style="font-size: 28px; font-weight: 700; color: #1A3A2A; margin-bottom: 20px;">
        {{ $product->name ?? $product->title ?? 'Mật ong hoa nhãn Sơn La' }}
    </h1>

    <!-- Thông báo Session (Thành công / Lỗi) -->
    @if (session('success'))
        <div style="background: #DEF7EC; border: 1px solid #31C48D; color: #03543F; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 15px; font-weight: 600;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #FDE8E8; border: 1px solid #F8B4B4; color: #9B1C1C; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 15px; font-weight: 600;">
            ✕ {{ session('error') }}
        </div>
    @endif

    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        
        <!-- Khối Thông tin Truy xuất nguồn gốc -->
        <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="background: #16A34A; color: #fff; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; display: inline-block; margin-bottom: 6px;">
                    ✓ Đã xác minh nguồn gốc
                </span>
                <p style="margin: 4px 0 0 0; color: #166534; font-size: 14px;"><strong>Xuất xứ:</strong> {{ $product->location ?? 'Sơn La' }}</p>
                <p style="margin: 4px 0 0 0; color: #166534; font-size: 13px;"><strong>Mã truy xuất:</strong> TX-{{ $product->id ?? '1' }}-2026</p>
            </div>
            <div style="text-align: center;">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M7 7h.01M18 7h.01M7 18h.01M18 18h.01"/></svg>
                <span style="display: block; font-size: 11px; color: #166534; margin-top: 2px;">Tem QR Nguồn gốc</span>
            </div>
        </div>

        <!-- Thông tin kho & Giá -->
        <h2 style="font-size: 18px; font-weight: 700; color: #0B3B2C; margin-bottom: 12px; border-bottom: 2px solid #F1F5F9; padding-bottom: 8px;">
            Thông tin tồn kho & Đặt mua
        </h2>

        @if ($availability)
            <div style="margin-bottom: 20px; font-size: 15px; color: #334155; line-height: 1.8;">
                <p style="margin: 0;">Tổng số lượng nhập kho: <strong style="color: #0F172A;">{{ $totalSeats }}</strong></p>
                <p style="margin: 0;">Đã bán: <strong style="color: #D97706;">{{ $bookedSeats }}</strong></p>
                <p style="margin: 0;">Còn lại trong kho: <strong style="color: #16A34A;">{{ $remainingSeats }}</strong> sản phẩm</p>
            </div>

            <!-- Form mua sản phẩm -->
            <form method="POST" action="{{ \Illuminate\Support\Facades\Route::has('bookings.store') ? route('bookings.store') : url('/booking') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #1E293B; margin-bottom: 8px;">
                        Số lượng mua:
                    </label>
                    <input 
                        type="number" 
                        name="quantity" 
                        value="{{ old('quantity', 1) }}" 
                        min="1" 
                        max="{{ $remainingSeats }}" 
                        required 
                        style="width: 100%; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px 14px; font-size: 15px; box-sizing: border-box;"
                    >
                    @error('quantity')
                        <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" style="width: 100%; background: #2563EB; color: #ffffff; border: none; border-radius: 8px; padding: 14px; font-size: 16px; font-weight: 600; cursor: pointer;">
                    GỬI ĐƠN ĐẶT HÀNG SẢN PHẨM
                </button>
            </form>
        @else
            <div style="padding: 16px; background: #FEF2F2; color: #991B1B; border-radius: 8px; font-weight: 600; text-align: center;">
                Sản phẩm hiện tại đã hết hàng trong kho.
            </div>
        @endif

    </div>
</div>