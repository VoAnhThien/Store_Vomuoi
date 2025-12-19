<?php
// app/Http\Controllers\ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

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

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->category_id)
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        if (empty($keyword)) {
            return redirect()->route('products.index');
        }

        $products = Product::where('is_active', 1)
            ->where(function($query) use ($keyword) {
                $query->where('product_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            })
            ->paginate(12);

        $categories = Category::where('is_active', 1)->get();

        return view('products.index', compact('products', 'keyword', 'categories'));
    }
}
