@extends('layouts.app')

@section('title', 'Trang chủ - Nội thất cao cấp')

@section('content')
<!-- ==================== HERO SLIDER ==================== -->
<div class="relative">
    <!-- Main Slider -->
    <div class="swiper-container hero-slider">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="relative h-[500px] md:h-[600px] lg:h-[700px] bg-gray-900">
                    <div class="absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1616627561839-074385245ff6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80"
                             alt="Sofa cao cấp"
                             class="w-full h-full object-cover opacity-70">
                    </div>
                    <div class="relative max-w-7xl mx-auto px-4 h-full flex items-center">
                        <div class="text-white max-w-2xl">
                            <span class="inline-block px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm mb-4">Bộ sưu tập mới</span>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Sofa Thông Minh<br>Cho Không Gian Hiện Đại</h1>
                            <p class="text-lg text-gray-200 mb-8">Thiết kế tinh tế, chất liệu cao cấp, đa dạng mẫu mã</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition">
                                Khám phá ngay
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="relative h-[500px] md:h-[600px] lg:h-[700px] bg-gray-900">
                    <div class="absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80"
                             alt="Bàn ăn cao cấp"
                             class="w-full h-full object-cover opacity-70">
                    </div>
                    <div class="relative max-w-7xl mx-auto px-4 h-full flex items-center">
                        <div class="text-white max-w-2xl text-right ml-auto">
                            <span class="inline-block px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm mb-4">Giảm giá 30%</span>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Phòng Ăn Sang Trọng<br>Cho Gia Đình Bạn</h1>
                            <p class="text-lg text-gray-200 mb-8">Bộ bàn ghế gỗ tự nhiên, thiết kế tối giản</p>
                            <a href="{{ route('products.index') }}?category=dining" class="inline-flex items-center px-8 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition">
                                Mua ngay
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- ==================== CATEGORIES ==================== -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Danh Mục Sản Phẩm</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Khám phá bộ sưu tập nội thất đa dạng cho mọi không gian sống</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories->take(8) as $category)
            <a href="{{ $category->slug ? route('product.category', $category->slug) : route('products.index') }}"
               class="group relative overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="aspect-square overflow-hidden">
                    @if($category->image_url)
                        <img src="{{ asset('storage/' . $category->image_url) }}"
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    @php
                        $categoryImages = [
                            'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=800',
                            'https://images.pexels.com/photos/1866149/pexels-photo-1866149.jpeg?auto=compress&cs=tinysrgb&w=800',
                            'https://images.unsplash.com/photo-1540574163026-643ea20ade25?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
                        ];
                        $imageIndex = $loop->index % 8;
                    @endphp
                    <img src="{{ $categoryImages[$imageIndex] }}"
                         alt="{{ $category->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-blue-600 transition">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $category->products_count ?? 0 }} sản phẩm</p>
                </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>
</div>

<!-- ==================== BEST SELLERS ==================== -->
<div class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Sản Phẩm Bán Chạy</h2>
                <p class="text-gray-600 mt-2">Được khách hàng yêu thích nhất</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                Xem tất cả
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @if(isset($bestSellers) && $bestSellers->count() > 0)
                @foreach($bestSellers as $product)
                <div class="group">
                    <div class="relative overflow-hidden rounded-lg bg-gray-100 aspect-square mb-4">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}"
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-4 left-4">
                            @if($product->original_price > $product->price)
                            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                -{{ round(100 - ($product->price / $product->original_price * 100)) }}%
                            </span>
                            @endif
                        </div>
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h3 class="font-medium text-gray-900 group-hover:text-blue-600">
                            <a href="{{ route('product.show', $product->product_id) }}">{{ $product->product_name }}</a>
                        </h3>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(4.5)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-gray-900">{{ number_format($product->price) }} đ</span>
                                @if($product->original_price > $product->price)
                                <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($product->original_price) }} đ</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Demo products -->
                @for($i = 1; $i <= 4; $i++)
                <div class="group">
                    <div class="relative overflow-hidden rounded-lg bg-gray-100 aspect-square mb-4">
                        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                             alt="Product {{ $i }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-medium text-gray-900">Sofa Modern {{ $i }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-gray-900">{{ number_format(15000000 + $i*1000000) }} đ</span>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </div>
</div>

<!-- ==================== NEW ARRIVALS ==================== -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Sản Phẩm Mới</h2>
                <p class="text-gray-600 mt-2">Cập nhật những mẫu thiết kế mới nhất</p>
            </div>
            <a href="{{ route('products.index') }}?sort=newest" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                Xem tất cả
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($newArrivals) && $newArrivals->count() > 0)
                @foreach($newArrivals->take(3) as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow">
                    <div class="relative h-64">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}"
                             alt="{{ $product->product_name }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="text-sm font-medium">Mới về</span>
                            <h3 class="text-xl font-bold">{{ $product->product_name }}</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($product->price) }} đ</span>
                            <a href="{{ route('product.show', $product->product_id) }}"
                               class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Demo new arrivals -->
                @for($i = 1; $i <= 3; $i++)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow">
                    <div class="relative h-64">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                             alt="New Arrival {{ $i }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="text-sm font-medium">Mới về</span>
                            <h3 class="text-xl font-bold">Bàn làm việc {{ $i }}</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Thiết kế hiện đại, chất liệu gỗ tự nhiên cao cấp</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">{{ number_format(5000000 + $i*1000000) }} đ</span>
                            <a href="#" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </div>
</div>

<!-- ==================== BRANDS ==================== -->
<div class="py-12 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Thương Hiệu Đối Tác</h3>
            <p class="text-gray-600">Hợp tác cùng những thương hiệu nội thất hàng đầu</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
            @foreach(['IKEA', 'Ashley', 'Roche Bobois', 'Natuzzi', 'BoConcept', 'Fendi Casa'] as $brand)
            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-700 mb-1">{{ substr($brand, 0, 1) }}</div>
                    <span class="text-gray-600 font-medium">{{ $brand }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ==================== CTA ==================== -->
<div class="relative bg-gray-900 py-20 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80"
             alt="Showroom"
             class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Nâng Tầm Không Gian Sống Của Bạn</h2>
        <p class="text-gray-300 text-lg mb-8">Khám phá bộ sưu tập nội thất cao cấp với hơn 1000+ sản phẩm đa dạng</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products.index') }}" class="px-8 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition">
                Mua sắm ngay
            </a>
            <a href="{{ route('contact.index') }}" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-gray-900 transition">
                Liên hệ tư vấn
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<style>
.swiper-container {
    width: 100%;
    height: 100%;
}
.swiper-slide {
    text-align: center;
    font-size: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.swiper-button-next,
.swiper-button-prev {
    color: white;
    background: rgba(0,0,0,0.3);
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px;
}
.swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: white;
    opacity: 0.5;
}
.swiper-pagination-bullet-active {
    opacity: 1;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hero Slider
    const heroSwiper = new Swiper('.hero-slider', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
</script>
@endpush
