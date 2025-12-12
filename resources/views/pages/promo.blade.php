@extends('layouts.app')

@section('title', 'Khuyến mãi')

@section('content')
<div class="text-center mb-10">
    <h1 class="text-3xl font-bold text-red-600">🎉 Khuyến mãi HOT</h1>
    <p class="mt-2 text-gray-600">Nhanh tay săn ngay những ưu đãi cực khủng từ VoMuoi-Home!</p>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <!-- Promo Card 1 -->
    <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
        <img src="https://via.placeholder.com/400x250?text=Sofa+Sale"
             alt="Sofa Sale"
             class="w-full h-48 object-cover rounded mb-3">
        <h5 class="text-lg font-semibold text-gray-800">Sofa cao cấp</h5>
        <p class="text-gray-600 text-sm mb-2">Giảm giá tới <span class="text-red-600 font-bold">50%</span> cho các mẫu sofa hiện đại.</p>
        <a href="{{ route('products.index') }}" class="text-red-600 hover:underline text-sm">Xem sản phẩm</a>
    </div>

    <!-- Promo Card 2 -->
    <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
        <img src="https://via.placeholder.com/400x250?text=Ghế+Massage"
             alt="Ghế Massage"
             class="w-full h-48 object-cover rounded mb-3">
        <h5 class="text-lg font-semibold text-gray-800">Ghế massage thư giãn</h5>
        <p class="text-gray-600 text-sm mb-2">Ưu đãi lên đến <span class="text-red-600 font-bold">30 triệu</span> cho các mẫu ghế cao cấp.</p>
        <a href="{{ route('products.index') }}" class="text-red-600 hover:underline text-sm">Xem sản phẩm</a>
    </div>

    <!-- Promo Card 3 -->
    <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
        <img src="https://via.placeholder.com/400x250?text=Ghe+SoFa+Chu+L"
             alt="Ghế sofa chữ L"
             class="w-full h-48 object-cover rounded mb-3">
        <h5 class="text-lg font-semibold text-gray-800">Ghế sofa chữ L</h5>
        <p class="text-gray-600 text-sm mb-2">Tặng kèm phụ kiện + giảm giá <span class="text-red-600 font-bold">20%</span>.</p>
        <a href="{{ route('products.index') }}" class="text-red-600 hover:underline text-sm">Xem sản phẩm</a>
    </div>
</div>
@endsection
