@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-2">Liên hệ với VoMuoi-Home</h1>
        <p class="text-gray-600">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Form liên hệ -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">Gửi tin nhắn cho chúng tôi</h2>
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2">Họ và tên</label>
                    <input
                        type="text"
                        name="name"
                        placeholder="Nhập họ và tên"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Nhập email"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Số điện thoại</label>
                    <input
                        type="tel"
                        name="phone"
                        placeholder="Nhập số điện thoại"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Tin nhắn</label>
                    <textarea
                        name="message"
                        rows="5"
                        placeholder="Nhập nội dung..."
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition"
                >
                    Gửi ngay
                </button>
            </form>
        </div>

        <!-- Thông tin liên hệ và bản đồ -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">Thông tin liên hệ</h2>
            <div class="space-y-3 mb-6">
                <p class="flex items-start">
                    <span class="text-red-600 mr-2">📞</span>
                    <span><strong>Hotline:</strong> 0355897327</span>
                </p>
                <p class="flex items-start">
                    <span class="text-red-600 mr-2">✉️</span>
                    <span><strong>Email:</strong> vothien817@gmail.com</span>
                </p>
                <p class="flex items-start">
                    <span class="text-red-600 mr-2">📍</span>
                    <span><strong>Địa chỉ:</strong> Hoài Đức, Hoài Nhơn, Bình Định</span>
                </p>
            </div>

            <!-- Bản đồ Google Maps -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-3">Vị trí của chúng tôi</h3>
                <div class="relative w-full h-96 rounded-lg overflow-hidden border-2 border-gray-200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d245894.74712280557!2d109.02686!3d14.166667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3169a3f654d39a9f%3A0x13c3c1e0f1c5d8d3!2zSG_DoGkgTmjGoW4sIELDrG5oIMSQ4buLbmg!5e0!3m2!1svi!2s!4v1234567890123!5m2!1svi!2s"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="absolute inset-0"
                    ></iframe>
                </div>
                <p class="text-sm text-gray-600 mt-2">
                    <a href="https://www.google.com/maps/place/Hoài+Nhơn,+Bình+Định"
                       target="_blank"
                       class="text-blue-600 hover:underline">
                        Xem bản đồ lớn hơn
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
