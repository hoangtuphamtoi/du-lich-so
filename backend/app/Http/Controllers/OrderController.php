<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // ==========================================
    // DÀNH CHO KHÁCH HÀNG (USER)
    // ==========================================

    // 1. Danh sách đơn hàng của riêng khách đang đăng nhập
    public function index()
    {
        $userId = auth()->id();
        $orders = Order::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // 2. Xem chi tiết đơn hàng của khách hàng (MỚI THÊM)
    public function show($id)
    {
        $order = Order::with('product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    // 3. Khách hàng tự hủy đơn hàng (MỚI THÊM)
    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        // Các trạng thái được phép hủy đơn hàng
        $allowedStatuses = ['pending', 'pending_approval', 'cho_xu_ly', 'chờ xử lý'];

        if (in_array(strtolower($order->status), $allowedStatuses)) {
            $order->update([
                'status' => 'cancelled', // Cập nhật trạng thái thành Đã hủy
            ]);

            return redirect()->route('orders.index')->with('success', 'Hủy đơn hàng #' . $order->id . ' thành công!');
        }

        return redirect()->back()->with('error', 'Đơn hàng đã được duyệt hoặc đang giao, không thể hủy!');
    }

    // 4. Trang thanh toán QR và Upload minh chứng
    public function paymentQr($id)
    {
        $order = Order::with('product')->findOrFail($id);
        return view('orders.payment_qr', compact('order'));
    }

    // 5. Upload ảnh minh chứng chuyển khoản
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $order = Order::findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->update([
                'payment_proof'  => $path,
                'payment_status' => 'pending',          // Đánh dấu thanh toán đang chờ xác nhận
                'status'         => 'pending_approval'  // Đổi trạng thái đơn thành Chờ duyệt
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Gửi minh chứng chuyển khoản thành công! Đơn hàng đang chờ duyệt.');
    }

    // ==========================================
    // DÀNH CHO QUẢN TRỊ VIÊN (ADMIN)
    // ==========================================

    // Danh sách TẤT CẢ đơn hàng trong hệ thống dành cho Admin
    public function adminIndex(Request $request)
    {
        $query = Order::with(['product', 'user']);

        // Bộ lọc theo trạng thái nếu Admin chọn
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    // Xem chi tiết 1 đơn hàng dành cho Admin
    public function adminShow($id)
    {
        $order = Order::with(['product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Admin duyệt đơn / Cập nhật trạng thái đơn hàng & thanh toán
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'         => 'required|string',
            'payment_status' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status'         => $request->status,
            'payment_status' => $request->payment_status ?? $order->payment_status,
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}