<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm có bộ lọc và phân trang phía máy chủ.
     */
    public function index(Request $r)
    {
        $filters = $r->validate([
            'keyword'   => 'nullable|string|max:120',
            'type'      => 'nullable|in:tour,stay,transfer,ticket,experience',
            'province'  => 'nullable|string|max:80',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
            'date'      => 'nullable|date_format:Y-m-d',
            'sort'      => 'nullable|in:price_asc,price_desc,newest,rating',
        ]);

        $q = Product::query()->filter($filters)->with(['supplier:id,name']);

        $q = match ($filters['sort'] ?? 'newest') {
            'price_asc'  => $q->orderBy('base_price'),
            'price_desc' => $q->orderByDesc('base_price'),
            'rating'     => $q->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
            default      => $q->orderByDesc('created_at'),
        };

        // paginate() sinh câu lệnh LIMIT/OFFSET và giữ lại tham số bộ lọc trên đường dẫn
        $products = $q->paginate(12)->withQueryString();

        return view('products.index', compact('products', 'filters'));
    }

    /**
     * Hiển thị chi tiết một sản phẩm.
     */
    public function show(Product $product)
    {
        $product->load(['supplier', 'destinations', 'itineraries.destination']);
        $availabilities = $product->availabilities()->where('service_date', '>=', now())->get();
        $related = Product::where('id', '!=', $product->id)->take(4)->get();

        return view('products.show', compact('product', 'availabilities', 'related'));
    }
}