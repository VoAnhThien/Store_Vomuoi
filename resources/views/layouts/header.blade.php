{{-- resources/views/layouts/partials/header.blade.php --}}
<header class="bg-white shadow-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('homepage') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-gray-900">Home_VoMuoi</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('homepage') }}" class="text-gray-700 hover:text-gray-900 font-medium transition">
                    Trang chủ
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900 font-medium transition">
                    Sản phẩm
                </a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-gray-900 font-medium transition">
                    Giới thiệu
                </a>
                <a href="{{ route('promo') }}" class="text-gray-700 hover:text-gray-900 font-medium transition">
                    Khuyến mãi
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-gray-900 font-medium transition">
                    Liên hệ
                </a>
            </nav>

            <!-- Right side actions -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <button class="p-2 text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- User Account -->
                <button class="p-2 text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </button>

                <!-- Cart Button -->
                <button onclick="openCartModal()" class="relative p-2 text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @php
                        $cartCount = 0;
                        $cart = session()->get('cart', []);
                        foreach ($cart as $item) {
                            $cartCount += $item['quantity'];
                        }
                    @endphp
                    @if($cartCount > 0)
                    <span class="cart-count-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                    @else
                    <span class="cart-count-badge hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        0
                    </span>
                    @endif
                </button>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2 text-gray-600 hover:text-gray-900" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('homepage') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Trang chủ
            </a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Sản phẩm
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Giới thiệu
            </a>
            <a href="{{ route('promo') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Khuyến mãi
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Liên hệ
            </a>
        </div>
    </div>
</header>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>
