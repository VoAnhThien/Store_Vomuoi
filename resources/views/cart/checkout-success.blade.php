@extends('layouts.app')

@section('title', 'Đặt hàng thành công!')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 text-center">
    <div class="mb-8">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">🎉 Đặt hàng thành công!</h1>
        <p class="text-xl text-gray-600">Mã đơn hàng của bạn:</p>
        <p class="text-4xl font-bold text-red-600 mt-4">{{ $order->order_code }}</p>
    </div>

    <div class="bg-gray-50 rounded-2xl p-8 shadow-lg text-left">
        <p class="text-lg mb-6 text-center">
            Chúng tôi đã nhận đơn hàng và sẽ liên hệ xác nhận trong vòng <strong class="text-red-600">30 phút - 2 giờ</strong>.
        </p>

        <div class="border-t border-b border-gray-200 py-6 mb-6">
            <h3 class="text-xl font-bold mb-4 text-gray-800">📋 Thông tin đơn hàng</h3>
            <div class="space-y-3 text-gray-700">
                <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                @if($order->customer_email)
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                @endif
                <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
                <p>
                    <strong>Thanh toán:</strong>
                    @if($order->payment_method == 'cod')
                        💵 Thanh toán khi nhận hàng (COD)
                    @elseif($order->payment_method == 'bank_transfer')
                        🏦 Chuyển khoản ngân hàng
                    @else
                        📱 MoMo
                    @endif
                </p>
            </div>
        </div>

        <!-- Hiển thị thông tin chuyển khoản nếu chọn bank_transfer -->
        @if($order->payment_method == 'bank_transfer')
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Vui lòng chuyển khoản theo thông tin sau:</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p><strong>Ngân hàng:</strong> Vietcombank</p>
                        <p><strong>Số TK:</strong> 0123456789</p>
                        <p><strong>Chủ TK:</strong> NGUYEN VAN A</p>
                        <p><strong>Số tiền:</strong> <span class="text-red-600 font-bold">{{ number_format($order->total_amount) }} ₫</span></p>
                        <p><strong>Nội dung:</strong> {{ $order->order_code }} {{ $order->customer_phone }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="text-center">
            <p><strong>Tổng tiền:</strong></p>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ number_format($order->total_amount) }} ₫</p>
        </div>

        @if($order->notes)
        <div class="mt-6 bg-blue-50 rounded-lg p-4">
            <p class="text-sm font-semibold text-blue-900 mb-1">📝 Ghi chú của bạn:</p>
            <p class="text-sm text-blue-800">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Email notification -->
    @if($order->customer_email)
    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <p class="text-sm text-green-800">
            ✉️ Chúng tôi đã gửi email xác nhận đến <strong>{{ $order->customer_email }}</strong>
        </p>
    </div>  
    @endif

    <!-- Important info -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3 text-left">
                <h3 class="text-sm font-medium text-blue-800">Lưu ý quan trọng:</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Thời gian giao hàng dự kiến: <strong>3-5 ngày làm việc</strong></li>
                        <li>Vui lòng giữ điện thoại để nhận cuộc gọi xác nhận</li>
                        <li>Liên hệ hotline: <strong class="text-red-600">1900 xxxx</strong> nếu cần hỗ trợ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('homepage') }}" class="px-10 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
            🏠 Về trang chủ
        </a>
        <a href="{{ route('products.index') }}" class="px-10 py-4 bg-white text-gray-700 font-bold border-2 border-gray-300 rounded-xl hover:bg-gray-100 transition">
            🛍️ Tiếp tục mua sắm
        </a>
    </div>
</div>

<style>
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
.animate-bounce {
    animation: bounce 1s infinite;
}
</style>
@endsection
