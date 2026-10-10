<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Quản lý Đơn hàng Admin</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-400 text-emerald-800 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left font-semibold text-gray-500 uppercase text-xs">
                            <th class="p-3">Mã đơn</th>
                            <th class="p-3">Khách hàng</th>
                            <th class="p-3">Sản phẩm</th>
                            <th class="p-3">Tổng tiền</th>
                            <th class="p-3">Minh chứng QR</th>
                            <th class="p-3">Trạng thái</th>
                            <th class="p-3 text-right">Thao tác duyệt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr>
                                <td class="p-3 font-bold text-indigo-600">#{{ $order->order_code }}</td>
                                <td class="p-3">
                                    <div class="font-bold">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="p-3">
    {{ $order->product?->title ?? $order->product?->name ?? 'Sản phẩm không tồn tại / Đã xóa' }} 
    (x{{ $order->quantity ?? 1 }})
</td>
                                <td class="p-3 font-bold text-emerald-600">{{ number_format($order->total_amount) }}đ</td>
                                <td class="p-3">
                                    @if($order->payment_proof)
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline flex items-center gap-1">
                                            🔍 Xem ảnh CK
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">Không có</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                        {{ $order->status == 'pending_approval' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status == 'shipping' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                        {{ $order->status == 'completed' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                                        {{ $order->status == 'pending_approval' ? 'Chờ duyệt' : '' }}
                                        {{ $order->status == 'processing' ? 'Đang chuẩn bị' : '' }}
                                        {{ $order->status == 'shipping' ? 'Đang giao' : '' }}
                                        {{ $order->status == 'completed' ? 'Đã giao' : '' }}
                                    </span>
                                </td>
                                <td class="p-3 text-right">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 py-1 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="pending_approval" {{ $order->status == 'pending_approval' ? 'selected' : '' }}>Chờ duyệt</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang chuẩn bị hàng</option>
                                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã giao thành công</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>