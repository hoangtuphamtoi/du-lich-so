<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">📦 Đơn hàng của tôi</h2>
            <a href="{{ url('/') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                ← Quay lại trang chủ
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Thông báo thành công --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 fill-current text-emerald-600" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Thông báo lỗi --}}
            @if(session('error'))
                <div class="p-4 bg-rose-100 border border-rose-300 text-rose-800 rounded-xl text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Bảng danh sách đơn hàng --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-4 font-bold">Mã đơn & Ngày đặt</th>
                                <th class="px-5 py-4 font-bold">Sản phẩm</th>
                                <th class="px-5 py-4 font-bold">Tổng tiền</th>
                                <th class="px-5 py-4 font-bold">Trạng thái</th>
                                <th class="px-5 py-4 font-bold text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                                @php $status = strtolower($order->status); @endphp
                                <tr class="hover:bg-gray-50/80 transition">
                                    {{-- Mã đơn & Thời gian --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="font-black text-indigo-600 block">#{{ $order->order_code ?? $order->id }}</span>
                                        <span class="text-xs text-gray-400 block mt-0.5">
                                            {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}
                                        </span>
                                    </td>

                                    {{-- Sản phẩm --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            @if(!empty($order->product->image))
                                                <img src="{{ asset('storage/' . $order->product->image) }}" class="w-12 h-12 object-cover rounded-xl border border-gray-200 shrink-0">
                                            @endif
                                            <div>
                                                <div class="font-bold text-gray-800 line-clamp-1 max-w-xs">
                                                    {{ $order->product->title ?? $order->product->name ?? 'Sản phẩm/Dịch vụ' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Số lượng: <span class="font-bold text-gray-700">{{ $order->quantity ?? 1 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Tổng tiền --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="text-emerald-600 font-black text-base block">
                                            {{ number_format($order->total_amount ?? $order->total_price) }}đ
                                        </span>
                                        <span class="text-[11px] text-gray-400 uppercase font-bold">
                                            PT: {{ strtoupper($order->payment_method ?? 'QR') }}
                                        </span>
                                    </td>

                                    {{-- Trạng thái --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if(in_array($status, ['pending', 'cho_xu_ly', 'chờ xử lý']))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                ⏳ Chờ xử lý
                                            </span>
                                        @elseif(in_array($status, ['pending_approval', 'cho_duyet']))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
                                                ⏳ Chờ duyệt thanh toán
                                            </span>
                                        @elseif(in_array($status, ['processing']))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                📦 Đang chuẩn bị hàng
                                            </span>
                                        @elseif(in_array($status, ['shipping']))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                                🚚 Đang giao hàng
                                            </span>
                                        @elseif(in_array($status, ['completed', 'hoan_thanh', 'hoàn thành']))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                                ✅ Hoàn thành
                                            </span>
                                        @elseif(in_array($status, ['cancelled', 'da_huy', 'đã hủy']))
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                                ❌ Đã hủy
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Hành động --}}
                                    <td class="px-5 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2 items-center">
                                            {{-- Nút Xem --}}
                                            <a href="{{ route('orders.show', $order->id) }}" 
                                               class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                                Xem
                                            </a>

                                            {{-- Nút Thanh toán QR nếu đơn chưa xác nhận --}}
                                            @if(in_array($status, ['pending', 'cho_xu_ly', 'chờ xử lý']))
                                                <a href="{{ route('orders.payment_qr', $order->id) }}" 
                                                   class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                                    Thanh toán
                                                </a>
                                            @endif

                                            {{-- Nút Hủy đơn --}}
                                            @if(in_array($status, ['pending', 'pending_approval', 'cho_xu_ly', 'chờ xử lý']))
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                                        Hủy đơn
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12 text-gray-400 font-medium">
                                        Bạn chưa có đơn hàng nào. <a href="{{ url('/') }}" class="text-indigo-600 font-bold hover:underline">Khám phá sản phẩm ngay</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                @if(method_exists($orders, 'links'))
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>