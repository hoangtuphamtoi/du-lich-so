<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">Chi tiết đơn hàng #{{ $order->order_code ?? $order->id }}</h2>
            <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                ← Quay lại danh sách đơn
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @php $status = strtolower($order->status); @endphp

            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-6">
                <div class="flex flex-wrap justify-between items-center pb-4 border-b border-gray-100 gap-2">
                    <div>
                        <span class="text-xs text-gray-400 block">Thời gian đặt hàng</span>
                        <span class="font-bold text-gray-800">{{ $order->created_at ? $order->created_at->format('H:i - d/m/Y') : '' }}</span>
                    </div>

                    <div>
                        @if(in_array($status, ['pending', 'cho_xu_ly', 'chờ xử lý']))
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">⏳ Chờ xử lý</span>
                        @elseif(in_array($status, ['pending_approval', 'cho_duyet']))
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">⏳ Chờ duyệt thanh toán</span>
                        @elseif(in_array($status, ['processing']))
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">📦 Đang chuẩn bị hàng</span>
                        @elseif(in_array($status, ['shipping']))
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">🚚 Đang giao hàng</span>
                        @elseif(in_array($status, ['completed', 'hoan_thanh', 'hoàn thành']))
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">✅ Hoàn thành</span>
                        @elseif(in_array($status, ['cancelled', 'da_huy', 'đã hủy']))
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">❌ Đã hủy</span>
                        @endif
                    </div>
                </div>

                {{-- Thông tin người nhận --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-1">
                        <span class="text-xs font-black uppercase text-gray-400">Thông tin giao hàng</span>
                        <div class="font-bold text-gray-900">{{ $order->customer_name }}</div>
                        <div class="text-gray-600">📞 {{ $order->customer_phone }}</div>
                        <div class="text-gray-600">📍 {{ $order->customer_address }}</div>
                    </div>

                    <div class="space-y-1">
                        <span class="text-xs font-black uppercase text-gray-400">Thanh toán & Ghi chú</span>
                        <div class="text-gray-700">Phương thức: <span class="font-bold uppercase">{{ $order->payment_method }}</span></div>
                        <div class="text-gray-700">Trạng thái: 
                            <span class="font-bold {{ $order->payment_status == 'completed' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $order->payment_status == 'completed' ? 'Đã thanh toán' : 'Chưa / Chờ xác nhận' }}
                            </span>
                        </div>
                        @if($order->note)
                            <div class="text-xs text-amber-700 bg-amber-50 p-2 rounded-lg border border-amber-100 italic mt-1">
                                📝 {{ $order->note }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Thông tin sản phẩm --}}
                <div class="border-t border-gray-100 pt-4">
                    <span class="text-xs font-black uppercase text-gray-400 block mb-3">Sản phẩm / Dịch vụ</span>
                    <div class="flex items-center justify-between gap-4 bg-slate-50 p-3 rounded-xl">
                        <div class="flex items-center gap-3">
                            @if(!empty($order->product->image))
                                <img src="{{ asset('storage/' . $order->product->image) }}" class="w-14 h-14 object-cover rounded-xl border border-gray-200 shrink-0">
                            @endif
                            <div>
                                <div class="font-bold text-gray-900">{{ $order->product->title ?? $order->product->name ?? 'Sản phẩm' }}</div>
                                <div class="text-xs text-gray-500">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></div>
                            </div>
                        </div>
                        <div class="font-black text-emerald-600 text-lg">
                            {{ number_format($order->total_amount) }}đ
                        </div>
                    </div>
                </div>

                {{-- Minh chứng chuyển khoản (nếu có) --}}
                @if($order->payment_proof)
                    <div class="border-t border-gray-100 pt-4">
                        <span class="text-xs font-black uppercase text-gray-400 block mb-2">Ảnh minh chứng đã gửi</span>
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="inline-block">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-32 h-32 object-cover rounded-xl border border-gray-200 hover:opacity-90 transition">
                        </a>
                    </div>
                @endif

                {{-- Nút Hủy đơn trong trang chi tiết --}}
                @if(in_array($status, ['pending', 'pending_approval', 'cho_xu_ly', 'chờ xử lý']))
                    <div class="border-t border-gray-100 pt-4">
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-sm transition">
                                Hủy đơn hàng này
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>