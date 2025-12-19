<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmation;
use App\Mail\AdminOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout
     */
    public function show()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống! Vui lòng thêm sản phẩm trước khi thanh toán.');
        }

        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer,momo',
            'notes' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại',
            'customer_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            // Tính tổng tiền
            $total = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));

            // Tạo order code
            $orderCode = 'SF' . date('ymdHis') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $orderCode,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'customer_address' => $validated['customer_address'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'],
                'total_amount' => $total,
                'order_status' => 'pending',
            ]);

            // =============== XỬ LÝ THANH TOÁN MOMO (nếu có) ===============
            if ($validated['payment_method'] === 'momo') {
                // Tạo order items trước khi redirect MoMo
                foreach ($cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->order_id,
                        'product_id' => $item['product_id'],
                        'product_name' => $item['name'] ?? ($item['product_name'] ?? ''),
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }

                DB::commit();
                session()->put('pending_order', $order->order_code);

                // Redirect to MoMo payment (nếu có MomoController)
                if (class_exists(\App\Http\Controllers\MomoController::class)) {
                    return app(\App\Http\Controllers\MomoController::class)->createPayment(
                        $request->merge([
                            'total' => $total,
                            'order_code' => $order->order_code
                        ])
                    );
                }
            }

            // Tạo chi tiết đơn hàng (cho COD và Bank Transfer)
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'] ?? ($item['product_name'] ?? ''), // tránh lỗi not null
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Commit transaction
            DB::commit();

            // ==================== GỬI EMAIL ====================
            try {
                // 1. Gửi email cho khách hàng (nếu có email)
                if (!empty($validated['customer_email'])) {
                    Mail::to($validated['customer_email'])
                        ->send(new OrderConfirmation($order->load('items.product')));

                    Log::info('✅ Email sent to customer: ' . $validated['customer_email']);
                }

                // 2. Gửi email cho admin
                $adminEmail = env('MAIL_ADMIN', 'vothien817@gmail.com');
                Mail::to($adminEmail)
                    ->send(new AdminOrderNotification($order->load('items.product')));

                Log::info('✅ Email sent to admin: ' . $adminEmail);

            } catch (\Exception $emailError) {
                // Không throw error nếu email fail, chỉ log lại
                Log::error('❌ Email sending failed: ' . $emailError->getMessage());
                // Đơn hàng vẫn được tạo thành công, chỉ email bị lỗi
            }

            // Xóa giỏ hàng
            session()->forget('cart');

            // Redirect về trang success
            return redirect()->route('checkout.success', ['order_code' => $order->order_code])
                ->with('success', 'Đặt hàng thành công! Vui lòng kiểm tra email để xem thông tin đơn hàng.');

        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            DB::rollBack();

            Log::error('❌ Order creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    /**
     * Trang thông báo đặt hàng thành công
     */
    public function success($order_code)
    {
        $order = Order::where('order_code', $order_code)
            ->with('items.product')
            ->first();

        if (!$order) {
            return redirect()->route('homepage')
                ->with('error', 'Không tìm thấy đơn hàng!');
        }

        return view('cart.checkout-success', compact('order'));
    }


}

