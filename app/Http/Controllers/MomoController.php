<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class MomoController extends Controller
{
    /**
     * Tạo yêu cầu thanh toán MoMo
     */
    public function createPayment(Request $request)
    {
        try {
            // ✅ Validate input
            $request->validate([
                'total' => 'required|numeric|min:1000',
                'order_code' => 'required|string'
            ]);

            // ✅ Kiểm tra đơn hàng có tồn tại không
            $order = Order::where('order_code', $request->order_code)->first();
            if (!$order) {
                return redirect()->route('cart.index')
                    ->with('error', 'Không tìm thấy đơn hàng!');
            }

            // ✅ Lấy cấu hình từ .env
            $endpoint = env('MOMO_ENDPOINT');
            $partnerCode = env('MOMO_PARTNER_CODE');
            $accessKey = env('MOMO_ACCESS_KEY');
            $secretKey = env('MOMO_SECRET_KEY');
            $redirectUrl = env('MOMO_RETURN_URL');
            $ipnUrl = env('MOMO_NOTIFY_URL');

            // ✅ Kiểm tra config có đầy đủ không
            if (!$endpoint || !$partnerCode || !$accessKey || !$secretKey) {
                Log::error('❌ MoMo configuration missing');
                return redirect()->route('cart.index')
                    ->with('error', 'Cấu hình thanh toán MoMo chưa đầy đủ!');
            }

            // ✅ Tạo các tham số
            $orderId = 'MOMO' . time() . rand(1000, 9999);
            $amount = (int) $request->total;
            $orderInfo = "Thanh toán đơn hàng #" . $request->order_code;
            $requestId = time() . rand(100, 999);
            $requestType = "payWithMethod";
            $extraData = base64_encode(json_encode([
                'order_code' => $request->order_code,
                'order_id' => $order->order_id
            ]));

            // ✅ Tạo signature (chữ ký bảo mật)
            $rawHash = "accessKey=" . $accessKey .
                "&amount=" . $amount .
                "&extraData=" . $extraData .
                "&ipnUrl=" . $ipnUrl .
                "&orderId=" . $orderId .
                "&orderInfo=" . $orderInfo .
                "&partnerCode=" . $partnerCode .
                "&redirectUrl=" . $redirectUrl .
                "&requestId=" . $requestId .
                "&requestType=" . $requestType;

            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            // ✅ Chuẩn bị data gửi đến MoMo
            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Sofa Thiên Store",
                'storeId' => "SofaThienStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];

            // ✅ Log request để debug
            Log::info('📤 MoMo Payment Request', [
                'order_code' => $request->order_code,
                'amount' => $amount,
                'orderId' => $orderId
            ]);

            // ✅ Gọi API MoMo
            $response = Http::timeout(10)->post($endpoint, $data);

            if (!$response->successful()) {
                Log::error('❌ MoMo API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return redirect()->route('cart.index')
                    ->with('error', 'Không thể kết nối đến cổng thanh toán MoMo!');
            }

            $result = $response->json();

            // ✅ Kiểm tra response từ MoMo
            if (!isset($result['payUrl']) || empty($result['payUrl'])) {
                Log::error('❌ MoMo Invalid Response', ['response' => $result]);
                return redirect()->route('cart.index')
                    ->with('error', 'Lỗi khi tạo link thanh toán MoMo: ' . ($result['message'] ?? 'Unknown error'));
            }

            // ✅ Lưu thông tin tạm vào session
            session()->put('pending_momo_payment', [
                'order_code' => $request->order_code,
                'momo_order_id' => $orderId,
                'amount' => $amount,
                'created_at' => now()
            ]);

            Log::info('✅ MoMo Payment URL created', ['payUrl' => $result['payUrl']]);

            // ✅ Redirect đến trang thanh toán MoMo
            return redirect()->away($result['payUrl']);

        } catch (\Exception $e) {
            Log::error('❌ MoMo Payment Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'Có lỗi xảy ra khi tạo thanh toán MoMo. Vui lòng thử lại!');
        }
    }

    /**
     * Xử lý callback từ MoMo (người dùng quay lại)
     */
    public function callback(Request $request)
    {
        try {
            Log::info('📥 MoMo Callback Received', $request->all());

            // ✅ Validate signature từ MoMo (BẢO MẬT)
            $secretKey = env('MOMO_SECRET_KEY');
            $accessKey = env('MOMO_ACCESS_KEY');

            $rawHash = "accessKey=" . $accessKey .
                "&amount=" . $request->amount .
                "&extraData=" . $request->extraData .
                "&message=" . $request->message .
                "&orderId=" . $request->orderId .
                "&orderInfo=" . $request->orderInfo .
                "&orderType=" . $request->orderType .
                "&partnerCode=" . $request->partnerCode .
                "&payType=" . $request->payType .
                "&requestId=" . $request->requestId .
                "&responseTime=" . $request->responseTime .
                "&resultCode=" . $request->resultCode .
                "&transId=" . $request->transId;

            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            // ✅ Kiểm tra chữ ký có khớp không (chống giả mạo)
            if ($signature !== $request->signature) {
                Log::error('❌ MoMo Invalid Signature', [
                    'expected' => $signature,
                    'received' => $request->signature
                ]);

                return redirect()->route('cart.index')
                    ->with('error', 'Giao dịch không hợp lệ!');
            }

            // ✅ Lấy thông tin đơn hàng từ extraData
            $extraData = json_decode(base64_decode($request->extraData), true);
            $orderCode = $extraData['order_code'] ?? session()->get('pending_momo_payment.order_code');

            if (!$orderCode) {
                Log::error('❌ Order code not found in MoMo callback');
                return redirect()->route('cart.index')
                    ->with('error', 'Không tìm thấy thông tin đơn hàng!');
            }

            // ✅ Tìm đơn hàng
            $order = Order::where('order_code', $orderCode)->first();
            if (!$order) {
                Log::error('❌ Order not found', ['order_code' => $orderCode]);
                return redirect()->route('cart.index')
                    ->with('error', 'Không tìm thấy đơn hàng!');
            }

            // ✅ Kiểm tra kết quả thanh toán
            if ($request->resultCode == 0) {
                // ✅ THANH TOÁN THÀNH CÔNG
                $order->update([
                    'order_status' => 'paid',
                    'payment_method' => 'momo',
                    'notes' => ($order->notes ?? '') . "\n[MoMo] TransID: " . $request->transId
                ]);

                // Xóa session
                session()->forget(['pending_momo_payment', 'cart']);

                Log::info('✅ MoMo Payment Success', [
                    'order_code' => $orderCode,
                    'transId' => $request->transId,
                    'amount' => $request->amount
                ]);

                return redirect()->route('checkout.success', ['order_code' => $orderCode])
                    ->with('success', 'Thanh toán MoMo thành công! Cảm ơn quý khách!');

            } else {
                // ❌ THANH TOÁN THẤT BẠI
                Log::warning('⚠️ MoMo Payment Failed', [
                    'order_code' => $orderCode,
                    'resultCode' => $request->resultCode,
                    'message' => $request->message
                ]);

                // Có thể đánh dấu đơn hàng là failed hoặc giữ nguyên pending
                $order->update([
                    'notes' => ($order->notes ?? '') . "\n[MoMo Failed] Code: " . $request->resultCode . " - " . $request->message
                ]);

                return redirect()->route('checkout.show')
                    ->with('error', 'Thanh toán MoMo thất bại: ' . $request->message . '. Vui lòng thử lại!');
            }

        } catch (\Exception $e) {
            Log::error('❌ MoMo Callback Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'Có lỗi xảy ra khi xử lý thanh toán. Vui lòng liên hệ hỗ trợ!');
        }
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ MoMo
     * Đây là webhook mà MoMo gọi đến server (không qua trình duyệt)
     */
    public function ipn(Request $request)
    {
        try {
            Log::info('📥 MoMo IPN Received', $request->all());

            // ✅ Validate signature (giống callback)
            $secretKey = env('MOMO_SECRET_KEY');
            $accessKey = env('MOMO_ACCESS_KEY');

            $rawHash = "accessKey=" . $accessKey .
                "&amount=" . $request->amount .
                "&extraData=" . $request->extraData .
                "&message=" . $request->message .
                "&orderId=" . $request->orderId .
                "&orderInfo=" . $request->orderInfo .
                "&orderType=" . $request->orderType .
                "&partnerCode=" . $request->partnerCode .
                "&payType=" . $request->payType .
                "&requestId=" . $request->requestId .
                "&responseTime=" . $request->responseTime .
                "&resultCode=" . $request->resultCode .
                "&transId=" . $request->transId;

            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            if ($signature !== $request->signature) {
                Log::error('❌ MoMo IPN Invalid Signature');
                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 400);
            }

            // ✅ Xử lý đơn hàng
            $extraData = json_decode(base64_decode($request->extraData), true);
            $orderCode = $extraData['order_code'] ?? null;

            if ($orderCode && $request->resultCode == 0) {
                $order = Order::where('order_code', $orderCode)->first();
                if ($order && $order->order_status !== 'paid') {
                    $order->update([
                        'order_status' => 'paid',
                        'payment_method' => 'momo',
                        'notes' => ($order->notes ?? '') . "\n[MoMo IPN] TransID: " . $request->transId
                    ]);

                    Log::info('✅ MoMo IPN Processed', ['order_code' => $orderCode]);
                }
            }

            // ✅ Trả về response cho MoMo
            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('❌ MoMo IPN Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Kiểm tra trạng thái giao dịch MoMo
     */
    public function checkStatus($orderId)
    {
        try {
            $endpoint = env('MOMO_ENDPOINT_QUERY', 'https://test-payment.momo.vn/v2/gateway/api/query');
            $partnerCode = env('MOMO_PARTNER_CODE');
            $accessKey = env('MOMO_ACCESS_KEY');
            $secretKey = env('MOMO_SECRET_KEY');

            $requestId = time() . rand(100, 999);

            $rawHash = "accessKey=" . $accessKey .
                "&orderId=" . $orderId .
                "&partnerCode=" . $partnerCode .
                "&requestId=" . $requestId;

            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = [
                'partnerCode' => $partnerCode,
                'requestId' => $requestId,
                'orderId' => $orderId,
                'signature' => $signature,
                'lang' => 'vi'
            ];

            $response = Http::timeout(10)->post($endpoint, $data);
            $result = $response->json();

            Log::info('🔍 MoMo Status Check', ['orderId' => $orderId, 'result' => $result]);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('❌ MoMo Status Check Failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
