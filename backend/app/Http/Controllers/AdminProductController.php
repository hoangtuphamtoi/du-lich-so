<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    // Danh sách sản phẩm & Lọc Nổi Bật / Giảm Giá
    public function index(Request $request)
    {
        $query = Product::query()->orderBy('id', 'desc');

        if (class_exists(Category::class)) {
            $query->with('category');
        }

        if ($request->has('filter')) {
            if ($request->filter === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->filter === 'discount') {
                $query->where('is_discount', true);
            }
        }

        $products = $query->get();
        return view('admin.products.index', compact('products'));
    }

    // Trang giao diện thêm sản phẩm mới
    public function create()
    {
        $categories = class_exists(Category::class) ? Category::all() : collect();
        return view('admin.products.create', compact('categories'));
    }

    // Xử lý lưu sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable',
            'base_price'     => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:base_price',
            'capacity'       => 'nullable|integer',
        ]);

        Product::create([
            'title'          => $validated['title'],
            'slug'           => Str::slug($validated['title']) . '-' . time(),
            'category_id'    => $validated['category_id'] ?? null,
            'base_price'     => $validated['base_price'],
            'is_featured'    => $request->has('is_featured'),
            'is_discount'    => $request->filled('discount_price'),
            'discount_price' => $validated['discount_price'] ?? null,
            'capacity'       => $validated['capacity'] ?? 0,
            'status'         => 'published',
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Bật / Tắt trạng thái Nổi Bật
    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();

        $status = $product->is_featured ? 'đã thêm vào' : 'đã xóa khỏi';
        return back()->with('success', "Sản phẩm \"{$product->title}\" {$status} Danh mục Nổi bật!");
    }

    // Cập nhật giá giảm hoặc Xóa khỏi Giảm Giá
    public function updateDiscount(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->has('remove_discount')) {
            $product->is_discount = false;
            $product->discount_price = null;
            $product->save();

            return back()->with('success', "Đã xóa sản phẩm \"{$product->title}\" khỏi Danh mục Giảm giá!");
        }

        $request->validate([
            'discount_price' => 'required|numeric|min:0|lt:' . $product->base_price,
        ], [
            'discount_price.lt' => 'Giá giảm phải nhỏ hơn giá gốc (' . number_format($product->base_price) . 'đ)',
        ]);

        $product->is_discount = true;
        $product->discount_price = $request->discount_price;
        $product->save();

        return back()->with('success', "Đã cập nhật giá giảm cho sản phẩm \"{$product->title}\"!");
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Đã xóa sản phẩm thành công!');
    }
}