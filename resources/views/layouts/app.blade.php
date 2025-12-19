<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token - THÊM DÒNG NÀY -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VoMuoi-Home')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen overflow-x-hidden">

    <!-- Header -->
    @include('layouts.header')

    <!-- Banner -->
    @include('layouts.banner')

    <!-- Main Content -->
    <main class="max-w-screen-xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Nút hỗ trợ Zalo + Messenger -->
    <div class="fixed bottom-6 right-6 flex flex-col items-end gap-3 z-50">
        <!-- Zalo -->
        <a href="https://zalo.me/your-zalo-id" target="_blank"
           class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:bg-blue-600">
            <span class="font-semibold text-sm">Zalo</span>
        </a>

        <!-- Messenger -->
        <a href="https://m.me/your-page-id" target="_blank"
           class="bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:bg-blue-700">
            <i class="fab fa-facebook-messenger text-xl"></i>
        </a>
    </div>

    <!-- Cart Modal -->
    @include('components.cart-modal')

    <!-- Cart JS -->
    <script src="{{ asset('js/cart.js') }}"></script>

    @stack('scripts')
</body>
</html>
