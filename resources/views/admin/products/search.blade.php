@extends('layouts.app')

@section('title', 'Tìm kiếm: ' . $keyword)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Search Header -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center space-x-3">
                <a href="{{ route('homepage') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                <span class="text-gray-600">Tìm kiếm</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mt-4">
                Kết quả tìm kiếm cho: "{{ $keyword }}"
            </h1>
            <p class="text-gray-600 mt-2">
                Tìm thấy {{ $products->total() }} sản phẩm
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        @if($products->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    Không tìm thấy sản phẩm nào
                </h3>
                <p class="text-gray-600 mb-6">
                    Không tìm thấy sản phẩm phù hợp với từ khóa "{{ $keyword }}"
                </p>
                <div class="space-y-3">
                    <p class="text-sm text-gray-600">Gợi ý:</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Kiểm tra lại chính tả từ khóa</li>
                        <li>• Thử sử dụng từ khóa khác</li>
                        <li>• Sử dụng từ khóa ngắn gọn hơn</li>
                    </ul>
                </div>
                <a href="{{ route('products.index') }}"
                   class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Xem tất cả sản phẩm
                </a>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition group">
                    <a href="{{ route('product.show', $product->product_id) }}">
                        <div class="relative overflow-hidden rounded-t-lg">
                            @if($product->image_url)
                                <img src="{{ asset('storage/' . $product->image_url) }}"
                                     alt="{{ $product->product_name }}"
                                     class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-couch text-6xl text-gray-400"></i>
                                </div>
                            @endif

                            @if($product->original_price && $product->original_price > $product->price)
                                <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                </div>
                            @endif
                        </div>
                    </a>

                    <div class="p-4">
                        <a href="{{ route('product.show', $product->product_id) }}">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition">
                                {{ $product->product_name }}
                            </h3>
                        </a>

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <span class="text-xl font-bold text-blue-600">
                                    {{ number_format($product->price, 0, ',', '.') }} ₫
                                </span>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <span class="text-sm text-gray-400 line-through ml-2">
                                        {{ number_format($product->original_price, 0, ',', '.') }} ₫
                                    </span>
                                @endif
                            </div>
                        </div>

                        <button onclick="addToCart({{ $product->product_id }}, '{{ $product->product_name }}', {{ $product->price }}, '{{ $product->image_url }}')"
                                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-cart-plus mr-2"></i>
                            Thêm vào giỏ
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
