@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->order_code)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.orders') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Quay lại danh sách đơn hàng
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Đơn hàng #{{ $order->order_code }}
                    </h1>
                    <p class="text-gray-600 mt-1">
                        Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <span class="px-4 py-2 text-sm font-semibold rounded-lg
                    @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->order_status === 'confirmed') bg-blue-100 text-blue-800
                    @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->order_status === 'completed') bg-green-100 text-green-800
                    @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $order->status_label }}
                </span>
            </div>

            <!-- Order Timeline -->
            <div class="border-t pt-6">
                <h3 class="font-semibold text-gray-900 mb-4">Trạng thái đơn hàng</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Đơn hàng đã được đặt</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if(in_array($order->order_status, ['confirmed', 'shipped', 'delivered', 'completed']))
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Đã xác nhận</p>
                        </div>
                    </div>
                    @endif

                    @if(in_array($order->order_status, ['shipped', 'delivered', 'completed']))
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Đang giao hàng</p>
                        </div>
                    </div>
                    @endif

                    @if(in_array($order->order_status, ['delivered', 'completed']))
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Đã giao hàng</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Thông tin người nhận</h3>
            <div class="space-y-2">
                <p class="text-gray-700"><span class="font-medium">Họ tên:</span> {{ $order->customer_name }}</p>
                <p class="text-gray-700"><span class="font-medium">Số điện thoại:</span> {{ $order->customer_phone }}</p>
                @if($order->customer_email)
                <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $order->customer_email }}</p>
                @endif
                <p class="text-gray-700"><span class="font-medium">Địa chỉ:</span> {{ $order->customer_address }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Sản phẩm đã đặt</h3>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                <div class="flex items-center space-x-4 pb-4 border-b last:border-0">
                    @if($item->product && $item->product->image_url)
                        <img src="{{ asset('storage/' . $item->product->image_url) }}"
                             alt="{{ $item->product_name }}"
                             class="w-20 h-20 object-cover rounded-lg">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-couch text-2xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                        <p class="text-sm text-gray-500">
                            Số lượng: {{ $item->quantity }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Đơn giá: {{ number_format($item->price, 0, ',', '.') }} ₫
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Tổng quan đơn hàng</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-gray-700">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->total_amount, 0, ',', '.') }} ₫</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Phương thức thanh toán:</span>
                    <span>{{ $order->payment_method_label }}</span>
                </div>
                <div class="border-t pt-2 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Tổng cộng:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                        </span>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="mt-4 pt-4 border-t">
                <p class="text-sm text-gray-600"><span class="font-medium">Ghi chú:</span> {{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
