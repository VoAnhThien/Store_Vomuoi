<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$product->product_id])) {
            $cart[$product->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->product_id] = [
                'product_id' => $product->product_id,
                'name' => $product->product_name,
                'price' => $product->price,
                'original_price' => $product->original_price,
                'quantity' => $request->quantity,
                'image' => $product->image_url,
                'category' => $product->category->name ?? '',
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->getCartTotal(),
                'cart_items' => array_values($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật số lượng!',
                'item_total' => $cart[$request->product_id]['price'] * $cart[$request->product_id]['quantity'],
                'cart_total' => $this->getCartTotal(),
                'cart_count' => $this->getCartCount(),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng!']);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                    'cart_total' => $this->getCartTotal(),
                    'cart_count' => $this->getCartCount(),
                    'cart_items' => array_values($cart),
                ]);
            }

            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        session()->forget('cart');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa toàn bộ giỏ hàng!',
                'cart_count' => 0,
                'cart_total' => 0,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    /**
     * Lấy số lượng sản phẩm trong giỏ hàng
     */
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    /**
     * Lấy tổng tiền giỏ hàng
     */
    public function getCartTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * API: Lấy thông tin đầy đủ giỏ hàng (cho AJAX/Modal)
     */
    public function getCartInfo()
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'count' => $this->getCartCount(),
            'total' => $this->getCartTotal(),
            'items' => array_values($cart), // Convert to indexed array for easier iteration
        ]);
    }

    /**
     * Chuyển đến trang thanh toán
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống! Vui lòng thêm sản phẩm trước khi thanh toán.');
        }

        $total = $this->getCartTotal();

        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Xử lý thanh toán
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:500',
            'shipping_method' => 'required|in:standard,express',
            'payment_method' => 'required|in:cash,cod,bank_transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // TODO: Lưu đơn hàng vào database
        // Tạm thời xóa giỏ hàng sau khi đặt
        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
    }
}
