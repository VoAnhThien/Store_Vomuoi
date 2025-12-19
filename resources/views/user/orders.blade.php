@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Đơn hàng của tôi</h1>
            <p class="text-gray-600 mt-1">Quản lý và theo dõi đơn hàng của bạn</p>
        </div>

        <!-- Back to Profile -->
        <div class="mb-6">
            <a href="{{ route('user.profile') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Quay lại tài khoản
            </a>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-bag text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có đơn hàng nào</h3>
                <p class="text-gray-600 mb-6">Bạn chưa có đơn hàng nào. Hãy mua sắm ngay!</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Mua sắm ngay
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <!-- Order Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Đơn hàng #{{ $order->order_code }}
                                    </h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
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
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="far fa-calendar mr-1"></i>
                                    Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Tổng tiền:</p>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($order->items()->limit(2)->get() as $item)
                            <div class="flex items-center space-x-4">
                                @if($item->product && $item->product->image_url)
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                         alt="{{ $item->product_name }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-couch text-2xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-500">
                                        Số lượng: {{ $item->quantity }} × {{ number_format($item->price, 0, ',', '.') }} ₫
                                    </p>
                                </div>
                            </div>
                            @endforeach

                            @if($order->items()->count() > 2)
                            <p class="text-sm text-gray-500">
                                + {{ $order->items()->count() - 2 }} sản phẩm khác
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Order Footer -->
                    <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-credit-card mr-1"></i>
                            {{ $order->payment_method_label }}
                        </div>
                        <a href="{{ route('user.orders.detail', $order->order_id) }}"
                           class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-eye mr-2"></i>
                            Xem chi tiết
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination if needed -->
            @if($orders->count() >= 10)
            <div class="mt-6 text-center">
                <p class="text-gray-600">Hiển thị {{ $orders->count() }} đơn hàng</p>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
