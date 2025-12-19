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
                <div class="relative" x-data="{ searchOpen: false }">
    <button @click="searchOpen = !searchOpen" class="p-2 text-gray-600 hover:text-gray-900 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </button>

             <!-- Search Dropdown -->
                        <div x-show="searchOpen"
                            @click.away="searchOpen = false"
                            x-transition
                            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg p-4 z-50">
                            <form action="{{ route('products.search') }}" method="GET">
                                <div class="relative">
                                    <input type="text"
                                        name="q"
                                        placeholder="Tìm kiếm sản phẩm..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="w-full mt-3 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Tìm kiếm
                                </button>
                            </form>
                        </div>
                    </div>

                <!-- ✅ THÊM: User Account với Dropdown -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 p-2 text-gray-600 hover:text-gray-900 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden md:block font-medium">{{ Auth::user()->fullname }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Quản trị
                                </a>
                            @endif
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Tài khoản
                            </a>
                            <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-shopping-bag mr-2"></i> Đơn hàng
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center space-x-2 p-2 text-gray-600 hover:text-gray-900 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden md:block font-medium">Đăng nhập</span>
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden md:block px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition">
                        Đăng ký
                    </a>
                @endauth

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

            <form action="{{ route('products.search') }}" method="GET" class="mb-3">
                <div class="relative">
                    <input type="text"
                        name="q"
                        placeholder="Tìm kiếm sản phẩm..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </form>

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

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i> Quản trị
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-red-600 hover:bg-gray-100 font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                    <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md bg-gray-900 text-white hover:bg-black font-medium">
                    <i class="fas fa-user-plus mr-2"></i> Đăng ký
                </a>
            @endauth
        </div>
    </div>
</header>

<!-- ✅ THÊM Alpine.js cho dropdown (thêm vào layout chính) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
