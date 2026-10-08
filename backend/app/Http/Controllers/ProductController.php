<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\PythonDataService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo Query Builder từ Model Product
        $query = Product::query();

        // 2. Xử lý TÌM KIẾM an toàn (chống SQL Injection dùng ORM)
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // 3. Xử lý SẮP XẾP an toàn (Allow list / Whitelist)
        $sortColumn = match ($request->sort) {
            'gia' => 'base_price',
            'moi' => 'created_at',
            default => 'id',
        };

        // 4. Thực thi truy vấn và phân trang 12 mục / trang
        $products = $query->orderBy($sortColumn, 'desc')->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Lấy danh sách sản phẩm gợi ý từ Python Microservice
     */
    public function recommend(int $id, PythonDataService $pythonService)
    {
        $items = $pythonService->recommend($id);

        return response()->json([
            'status' => 'success',
            'data' => $items,
        ]);
    }
}