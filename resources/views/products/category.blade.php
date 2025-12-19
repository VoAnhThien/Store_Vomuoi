@extends('layouts.app')

@section('title', $category->name . ' - VoMuoi Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center gap-2 text-sm text-gray-600">
        <a href="{{ route('homepage') }}" class="hover:text-blue-600">Trang chủ</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('products.index') }}" class="hover:text-blue-600">Sản phẩm</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-900 font-semibold">{{ $category->name }}</span>
    </div>

    <!-- Category Header -->
    <div class="mb-8 bg-gradient-to-r from-gray-600 to-purple-600 rounded-2xl p-8 text-white">
        <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-blue-100 text-lg">{{ $category->description }}</p>
        @endif
        <div class="mt-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span class="text-blue-100">{{ $products->total() }} sản phẩm</span>
        </div>
    </div>

    @if($products->count() > 0)
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
            <a href="{{ route('product.show', $product->product_id) }}" class="block">
                <!-- Product Image -->
                <div class="relative overflow-hidden bg-gray-100 aspect-square">
                    <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://via.placeholder.com/400' }}"
                         alt="{{ $product->product_name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                    <!-- Discount Badge -->
                    @if($product->original_price && $product->original_price > $product->price)
                    <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                        -{{ round(100 - ($product->price / $product->original_price * 100)) }}%
                    </div>
                    @endif

                    <!-- New Badge -->
                    @if($product->created_at->diffInDays(now()) <= 7)
                    <div class="absolute top-3 left-3 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                        MỚI
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-5">
                    <!-- Category -->
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">
                        {{ $product->category->name ?? 'Chưa phân loại' }}
                    </p>

                    <!-- Product Name -->
                    <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem] group-hover:text-blue-600 transition">
                        {{ $product->product_name }}
                    </h3>

                    <!-- Price -->
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl font-bold text-red-600">
                            {{ number_format($product->price) }} ₫
                        </span>
                        @if($product->original_price && $product->original_price > $product->price)
                        <span class="text-sm text-gray-400 line-through">
                            {{ number_format($product->original_price) }} ₫
                        </span>
                        @endif
                    </div>

                    <!-- Product Details -->
                    @if($product->color || $product->dimensions)
                    <div class="flex flex-wrap gap-2 mb-4 text-xs text-gray-600">
                        @if($product->color)
                        <span class="flex items-center gap-1 bg-gray-100 px-2 py-1 rounded">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $product->color }}
                        </span>
                        @endif
                        @if($product->dimensions)
                        <span class="flex items-center gap-1 bg-gray-100 px-2 py-1 rounded">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            {{ $product->dimensions }}
                        </span>
                        @endif
                    </div>
                    @endif

                    <!-- Add to Cart Button -->
                    <button onclick="event.preventDefault(); addToCart({{ $product->product_id }})"
                            class="w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Thêm vào giỏ
                    </button>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $products->links() }}
    </div>

    @else
    <!-- Empty State -->
    <div class="text-center py-20">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Chưa có sản phẩm nào</h3>
        <p class="text-gray-600 mb-6">Danh mục này hiện chưa có sản phẩm. Vui lòng quay lại sau!</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Xem tất cả sản phẩm
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
function addToCart(productId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }

            // Show success notification
            showNotification('Đã thêm vào giỏ hàng!', 'success');

            // Open cart modal if available
            if (typeof openCartModal === 'function') {
                setTimeout(() => openCartModal(), 500);
            }
        } else {
            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Không thể thêm vào giỏ hàng!', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white font-semibold transform transition-all duration-300`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection
