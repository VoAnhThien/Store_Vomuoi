@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-red-600">Về VoMuoi-Home</h1>
    <p class="mt-2 text-gray-600">Chúng tôi mang đến sự thoải mái và phong cách cho không gian sống của bạn.</p>
</div>
<div class="grid md:grid-cols-2 gap-8 items-center">
    <img src="{{ asset('storage/about/2aeVo.jpg') }}"
     alt="Giới thiệu"
     class="w-full h-64 md:h-80 object-cover rounded-lg shadow-md">
    <div>
        <h3 class="text-xl font-semibold text-blue-600">Sứ mệnh của chúng tôi</h3>
        <p class="mt-2 text-gray-700">VoMuoi-Home chuyên cung cấp các sản phẩm nội thất chất lượng cao như sofa, ghế massage, bàn trà và nhiều hơn thế nữa.</p>
        <h4 class="mt-4 text-green-600 font-semibold">Tại sao chọn chúng tôi?</h4>
        <ul class="list-disc list-inside text-gray-700 mt-2">
            <li>Sản phẩm đa dạng, mẫu mã hiện đại</li>
            <li>Giá cả cạnh tranh, khuyến mãi hấp dẫn</li>
            <li>Giao hàng nhanh chóng, hỗ trợ tận nơi</li>
            <li>Bảo hành rõ ràng, chăm sóc khách hàng chu đáo</li>
        </ul>
    </div>
</div>
@endsection
