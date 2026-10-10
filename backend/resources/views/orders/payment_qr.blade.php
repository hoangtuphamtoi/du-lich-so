<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">Thanh toán Chuyển khoản QR</h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 text-center space-y-6">
                <div>
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Mã đơn: {{ $order->order_code }}</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2">Quét mã QR để hoàn tất thanh toán</h3>
                    <p class="text-xs text-gray-500">Số tiền cần chuyển: <span class="text-emerald-600 font-extrabold text-lg">{{ number_format($order->total_amount) }}đ</span></p>
                </div>

                <!-- Mã QR tự động qua VietQR -->
                <div class="inline-block p-4 bg-gray-50 border-2 border-indigo-100 rounded-2xl shadow-inner">
                    <img src="https://img.vietqr.io/image/MB-0388612606-compact2.png?amount={{ $order->total_amount }}&addInfo={{ $order->order_code }}&accountName=PHAM%20XUAN%20PHAN" 
                         alt="QR Thanh toán" class="w-64 h-64 object-contain mx-auto rounded-xl">
                </div>

                <div class="text-left bg-gray-50 p-4 rounded-xl text-xs space-y-1 text-gray-600 border border-gray-200">
                    <p><b>Ngân hàng:</b> MB Bank</p>
                    <p><b>Số tài khoản:</b> <span class="text-gray-900 font-bold">0388612606</span></p>
                    <p><b>Chủ tài khoản:</b> PHẠM XUÂN PHÁN</p>
                    <p><b>Nội dung chuyển khoản:</b> <span class="text-indigo-600 font-bold">{{ $order->order_code }}</span></p>
                </div>

                <hr>

                <!-- Form Upload Minh Chứng -->
                <form action="{{ route('orders.upload_proof', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-left">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Tải ảnh chụp màn hình / Minh chứng chuyển tiền <span class="text-rose-500">*</span></label>
                        <input type="file" name="payment_proof" required accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-xl">
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-indigo-100">
                        Gửi xác nhận đã chuyển tiền
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>