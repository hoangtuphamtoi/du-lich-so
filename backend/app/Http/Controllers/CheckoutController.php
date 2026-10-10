<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $quantity = $request->query('quantity', 1);

        return view('checkout.index', compact('product', 'quantity'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'payment_method' => 'required|in:cod,qr',
        ]);

        try {
            // Sử dụng Transaction + lockForUpdate() để khóa dòng sản phẩm trong DB
            $order = DB::transaction(function () use ($request) {
                
                // Khóa dòng sản phẩm lại, ép request đến sau phải CHỜ
                $product = Product::where('id', $request->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Kiểm tra số lượng trong kho
                if ($product->stock < $request->quantity) {
                    throw new \Exception('Sản phẩm đã hết hàng hoặc không đủ số lượng trong kho!');
                }

                // Trừ tồn kho
                $product->decrement('stock', $request->quantity);

                // Tính tổng tiền
                $unitPrice = $product->discount_price ?? $product->base_price ?? $product->price;
                $totalAmount = $unitPrice * $request->quantity;

                // Tạo đơn hàng
                return Order::create([
                    'user_id'          => auth()->id(),
                    'product_id'       => $product->id,
                    'order_code'       => 'DH' . strtoupper(Str::random(6)),
                    'customer_name'    => $request->name,
                    'customer_phone'   => $request->phone,
                    'customer_address' => $request->address,
                    'note'             => $request->note ?? null,
                    'quantity'         => $request->quantity,
                    'total_amount'     => $totalAmount,
                    'payment_method'   => $request->payment_method,
                    'payment_status'   => 'pending',
                    'status'           => $request->payment_method === 'cod' ? 'processing' : 'pending_approval',
                ]);
            });

            // Nếu chọn Chuyển khoản QR -> sang trang quét QR + upload ảnh
            if ($request->payment_method === 'qr') {
                return redirect()->route('orders.payment_qr', $order->id)
                    ->with('info', 'Vui lòng quét mã QR để chuyển khoản và tải lên minh chứng!');
            }

            // Chuyển hướng trực tiếp về Trang chủ kèm thông báo thành công
            return redirect('/')->with('success', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}