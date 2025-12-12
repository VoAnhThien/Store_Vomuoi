@extends('layouts.app')

@section('title', 'Sản phẩm nổi bật')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-center mb-8 text-gray-900">SẢN PHẨM NỔI BẬT</h2>

    @if($products->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
            <!-- Product Image -->
            <div class="relative overflow-hidden">
                @if($product->original_price && $product->original_price > $product->price)
                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                    -{{ $product->discount_percentage }}%
                </span>
                @endif

                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                     alt="{{ $product->name }}">
            </div>

            <!-- Product Info -->
            <div class="p-4 space-y-3">
                <h3 class="font-semibold text-gray-900 hover:text-blue-600 transition line-clamp-2">
                    {{ $product->name }}
                </h3>
                <p class="text-sm text-gray-500">{{ $product->dimensions }}</p>

                <!-- Rating -->
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= floor($product->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    @endfor
                    <span class="text-xs text-gray-500 ml-1">({{ $product->review_count }})</span>
                </div>

                <!-- Price -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg font-bold text-red-600">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                        @if($product->original_price && $product->original_price > $product->price)
                        <p class="text-sm text-gray-400 line-through">{{ number_format($product->original_price, 0, ',', '.') }} đ</p>
                        @endif
                    </div>
                </div>

                <p class="text-sm text-gray-500">Đã bán: {{ $product->sold_count }}</p>

                <!-- Action Buttons -->
                <div class="space-y-2 mt-4">
                    <!-- Nút Thêm vào giỏ (MỚI) -->
                    <button onclick="addToCart({{ $product->product_id }}, 1)"
                            class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Thêm vào giỏ
                    </button>

                    <!-- Nút Xem chi tiết -->
                    <a href="{{ route('product.show', $product->product_id) }}"
                       class="block w-full px-4 py-2 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition text-center">
                        Xem chi tiết
                    </a>

                    <!-- Nút Gọi đặt hàng -->
                    <button class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Gọi đặt
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-8">
        {{ $products->links() }}
    </div>
    @else
        <p class="text-center text-gray-500 py-8">Hiện chưa có sản phẩm nào.</p>
    @endif
</div>
@endsection
