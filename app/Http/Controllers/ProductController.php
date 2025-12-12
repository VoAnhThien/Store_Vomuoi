<?php
// app/Http\Controllers\ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Hiển thị trang chủ (banner + sản phẩm nổi bật)
     */
    public function homepage()
    {
        // Danh mục nổi bật
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Kiểm tra cột sold_count có tồn tại không
        $hasSoldCount = Schema::hasColumn('products', 'sold_count');

        // Sản phẩm bán chạy
        $bestSellers = Product::where('is_active', true)
            ->when($hasSoldCount, function($query) {
                $query->orderBy('sold_count', 'desc');
            }, function($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->limit(4)
            ->get();

        // Sản phẩm mới
        $newArrivals = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('pages.homepage', compact('categories', 'bestSellers', 'newArrivals'));
    }

    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // Sửa lỗi: where('category_id', '!=', $id) thành where('product_id', '!=', $id)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $id) // SỬA TỪ category_id thành product_id
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->category_id) // Sửa $category->id thành $category->category_id
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }

    
}
