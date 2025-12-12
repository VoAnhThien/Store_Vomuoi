@extends('layouts.app')

@section('title', 'Giỏ hàng - VoMuoi Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Giỏ hàng của bạn
        </h1>
        <p class="mt-2 text-gray-600">Bạn có <strong>{{ count($cart) }}</strong> sản phẩm trong giỏ hàng</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    @if(count($cart) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex gap-6">
                        <!-- Product Image -->
                        <div class="flex-shrink-0">
                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/150' }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                        <a href="{{ route('product.show', $item['product_id']) }}">
                                            {{ $item['name'] }}
                                        </a>
                                    </h3>
                                    @if($item['category'])
                                    <p class="mt-1 text-sm text-gray-500">{{ $item['category'] }}</p>
                                    @endif
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-500 hover:text-red-700 transition p-2 hover:bg-red-50 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Price -->
                            <div class="mt-4 flex items-center gap-3">
                                <span class="text-2xl font-bold text-red-600">{{ number_format($item['price']) }} ₫</span>
                                @if(isset($item['original_price']) && $item['original_price'] > $item['price'])
                                <span class="text-sm text-gray-400 line-through">{{ number_format($item['original_price']) }} ₫</span>
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">
                                    -{{ round(100 - ($item['price'] / $item['original_price'] * 100)) }}%
                                </span>
                                @endif
                            </div>

                            <!-- Quantity Controls -->
                            <div class="mt-4 flex items-center gap-4">
                                <span class="text-sm font-medium text-gray-700">Số lượng:</span>
                                <div class="flex items-center border-2 border-gray-300 rounded-lg bg-gray-50">
                                    <button onclick="updateQuantity({{ $item['product_id'] }}, {{ max(1, $item['quantity'] - 1) }})"
                                            class="px-4 py-2 hover:bg-gray-200 transition rounded-l-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number"
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           class="w-16 text-center border-x-2 border-gray-300 py-2 font-semibold bg-white"
                                           onchange="updateQuantity({{ $item['product_id'] }}, this.value)">
                                    <button onclick="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] + 1 }})"
                                            class="px-4 py-2 hover:bg-gray-200 transition rounded-r-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Item Total -->
                                <span class="ml-auto text-lg font-bold text-gray-900">
                                    {{ number_format($item['price'] * $item['quantity']) }} ₫
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Clear Cart Button -->
            <div class="flex justify-end">
                <form action="{{ route('cart.clear') }}" method="POST"
                      onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-6 py-3 text-red-600 border-2 border-red-600 rounded-lg hover:bg-red-600 hover:text-white transition font-semibold">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa toàn bộ giỏ hàng
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg p-6 sticky top-4">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Thông tin đơn hàng
                </h2>

                <div class="space-y-4">
                    <!-- Subtotal -->
                    <div class="flex justify-between text-gray-700">
                        <span>Tạm tính:</span>
                        <span class="font-semibold">{{ number_format($total) }} ₫</span>
                    </div>

                    <!-- Shipping -->
                    <div class="flex justify-between text-gray-700">
                        <span>Phí vận chuyển:</span>
                        <span class="font-semibold text-green-600">Miễn phí</span>
                    </div>

                    <div class="border-t border-gray-300 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Tổng cộng:</span>
                            <span class="text-2xl font-bold text-red-600">{{ number_format($total) }} ₫</span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('cart.checkout') }}"
                       class="block w-full px-6 py-4 bg-red-600 text-white text-center font-bold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-600/30">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Tiến hành thanh toán
                    </a>

                    <!-- Continue Shopping -->
                    <a href="{{ route('products.index') }}"
                       class="block w-full px-6 py-3 text-center text-gray-700 font-semibold border-2 border-gray-300 rounded-xl hover:bg-gray-200 transition">
                        Tiếp tục mua sắm
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="mt-6 pt-6 border-t border-gray-300 space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Miễn phí vận chuyển cho đơn từ 20 triệu</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Bảo hành chính hãng</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Đổi trả trong 7 ngày</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Empty Cart -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Giỏ hàng trống</h2>
            <p class="text-gray-600 mb-8">Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                </svg>
                Khám phá sản phẩm
            </a>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
// Update quantity function
function updateQuantity(productId, quantity) {
    fetch('/cart/update', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(quantity)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload page to update totals
            window.location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Không thể cập nhật số lượng!');
    });
}
</script>
@endpush
@endsection
