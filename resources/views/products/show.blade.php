@extends('layouts.app')

@section('title', $product->name . ' - VoMuoi-Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div>
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500x400?text=No+Image' }}"
                 class="w-full h-96 object-cover rounded-lg shadow-lg"
                 alt="{{ $product->name }}">
        </div>

        <!-- Product Info -->
        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-gray-600">{{ $product->dimensions }}</p>

            <!-- Price -->
            <div class="space-y-1">
                <h2 class="text-3xl font-bold text-red-600">{{ number_format($product->price, 0, ',', '.') }} đ</h2>
                @if($product->original_price && $product->original_price > $product->price)
                    <div class="flex items-center gap-2">
                        <del class="text-gray-500">{{ number_format($product->original_price, 0, ',', '.') }} đ</del>
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            -{{ $product->discount_percentage }}%
                        </span>
                    </div>
                @endif
            </div>

            <!-- Color -->
            <div>
                <strong class="text-gray-900">Màu sắc:</strong>
                <span class="text-gray-700">{{ $product->color }}</span>
            </div>

            <!-- Description -->
            <div>
                <strong class="text-gray-900">Mô tả:</strong>
                <p class="text-gray-700 mt-1">{{ $product->description ?: 'Sản phẩm chất lượng cao, thiết kế hiện đại.' }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 pt-4">
                <!-- Nút Thêm vào giỏ hàng (MỚI) -->
                <button onclick="addToCart({{ $product->product_id }}, 1)"
                        class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Thêm vào giỏ hàng
                </button>

                <!-- Nút Gọi đặt hàng -->
                <button class="w-full px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Gọi đặt hàng: 0355897327
                </button>

                <!-- Nút Tiếp tục mua sắm -->
                <a href="{{ route('products.index') }}"
                   class="block w-full px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-center">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
