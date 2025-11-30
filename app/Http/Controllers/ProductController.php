<?php
 // Hiển thị sản phẩm cho khách hàng
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        // SỬA: Bỏ điều kiện is_active vì cột này chưa tồn tại
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // SỬA: Bỏ điều kiện is_active
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // SỬA: Bỏ điều kiện is_active
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // SỬA: Bỏ điều kiện is_active
        $products = Product::where('category_id', $category->id)
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }
}
