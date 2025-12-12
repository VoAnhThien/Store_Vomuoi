<?php
// app/Http/Controllers/AdminController.php
//Xử lý CRUD sản phẩm, danh mục
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    //truy vấn số liệu tổng hợp rồi trả về view kèm data để hiển thị trên trang dashboard
    public function dashboard(){

    // Sử dụng DB class với import đầy đủ
    $totalSold = DB::table('order_items')
        ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
        ->where('orders.order_status', 'completed')
        ->sum('order_items.quantity');

    $revenue = Order::where('order_status', 'completed')->sum('total_amount');

    $stats = [
        'total_products' => Product::count(),
        'total_categories' => Category::count(),
        'total_orders' => Order::count(),
        'total_sales' => $totalSold,
        'revenue' => $revenue,
        // 'featured_products' => Product::where('is_featured', true)->count(),
        'total_featured_products' => Product::count(),
        'pending_orders' => Order::where('order_status', 'pending')->count(),
    ];

    $recent_products = Product::with('category')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $top_selling = Product::select('products.*')
        ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
        ->leftJoin('order_items', 'products.product_id', '=', 'order_items.product_id')
        ->leftJoin('orders', 'order_items.order_id', '=', 'orders.order_id')
        ->where('orders.order_status', 'completed')
        ->orWhereNull('orders.order_id')
        ->groupBy('products.product_id')
        ->orderBy('total_sold', 'desc')
        ->limit(5)
        ->get();

    $recent_orders = Order::with('items')
        ->orderBy('order_date', 'desc')
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact('stats', 'recent_products', 'top_selling', 'recent_orders'));
}

    // ==================== PRODUCT MANAGEMENT ====================
    public function products(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status == 'featured') {
                $query->where('is_featured', true);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'color' => 'nullable|string|max:100',
            'dimensions' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,hidden,draft'
            //'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image_url'] = $imagePath;
        }

        // Map data vs db
        $productData = [
        'product_name' => $validated['name'], // QUAN TRỌNG: name -> product_name
        'description' => $validated['description'],
        'price' => $validated['price'],
        'original_price' => $validated['original_price'] ?? $validated['price'],
        'category_id' => $validated['category_id'],
        'color' => $validated['color'],
        'dimensions' => $validated['dimensions'],
        'image_url' => $validated['image_url'] ?? null,
        'is_featured' => $request->has('is_featured') ? 1 : 0,
        'is_active' => $request->status == 'active' ? 1 : 0
        ];

        Product::create($productData);

        return redirect()->route('admin.products')
            ->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'color' => 'nullable|string|max:100',
            'dimensions' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image_url'] = $imagePath;
        }

         // Map data với database
        $productData = [
            'product_name' => $validated['name'], // QUAN TRỌNG
            'description' => $validated['description'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? $validated['price'],
            'category_id' => $validated['category_id'],
            'color' => $validated['color'],
            'dimensions' => $validated['dimensions'],
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_active' => $request->status == 'active' ? 1 : 0
        ];

        // Thêm image_url vào productData nếu có upload ảnh
        if (isset($validated['image_url'])) {
            $productData['image_url'] = $validated['image_url'];
        }

        $product->update($productData);

        return redirect()->route('admin.products')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated image
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Sản phẩm đã được xóa thành công!');
    }

    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()
            ->with('success', "Sản phẩm đã được $status!");
    }

    // ==================== CATEGORY MANAGEMENT ====================
    public function categories()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)//kiểu lưu khi user gửi req
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ]);

        Category::create([
            'category_name' => $request->name,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories')->with('success', 'Danh mục đã được thêm thành công!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string'
        ]);

        $category->update([
            'category_name' => $request->name,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        return redirect()->route('admin.categories')->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Không thể xóa danh mục vì có sản phẩm đang thuộc danh mục này!');
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Danh mục đã được xóa thành công!');
    }

    public function toggleCategoryStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        $status = $category->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()
            ->with('success', "Danh mục đã được $status!");
    }

    // ==================== ORDER MANAGEMENT ====================
    public function orders(Request $request)
    {
        $query = Order::with('items.product');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('order_status', $request->status);
        }
        $orders = $query->orderBy('order_date', 'desc')->paginate(15);

        // Stats for cards
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $confirmedOrders = Order::where('order_status', 'confirmed')->count();
        $shippedOrders = Order::where('order_status', 'shipped')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders'
        ));
    }

    public function showOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $order->update(['order_status' => $request->status]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }
}
