@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-blue-600">Liên hệ với VoMuoi-Home</h1>
    <p class="mt-2 text-gray-600">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7.</p>
</div>
<div class="grid md:grid-cols-2 gap-8">
    <div>
        <h4 class="font-semibold text-lg">Thông tin liên hệ</h4>
        <p class="mt-2"><i class="fas fa-phone text-red-600"></i> Hotline: 0355897327</p>
        <p><i class="fas fa-envelope text-red-600"></i> Email: vothien817@gmail.com</p>
        <p><i class="fas fa-map-marker-alt text-red-600"></i> Địa chỉ: Hoài Đức, Hoài Nhơn, Bình Định</p>
    </div>
    <div>
        <h4 class="font-semibold text-lg">Gửi tin nhắn cho chúng tôi</h4>
        <form class="mt-4 space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Họ và tên" class="w-full border rounded px-3 py-2">
            <input type="email" name="email" placeholder="Email" class="w-full border rounded px-3 py-2">
            <textarea name="message" rows="4" placeholder="Tin nhắn..." class="w-full border rounded px-3 py-2"></textarea>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Gửi ngay</button>
        </form>
    </div>
</div>
@endsection
