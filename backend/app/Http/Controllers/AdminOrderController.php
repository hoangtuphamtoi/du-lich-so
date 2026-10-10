<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->status === 'processing' || $request->status === 'completed' ? 'paid' : $order->payment_status,
        ]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}