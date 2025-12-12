{{-- resources/views/components/cart-modal.blade.php --}}
<!-- Cart Modal -->
<div id="cartModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">

        <!-- Background overlay with blur -->
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-60 backdrop-blur-sm" id="cartOverlay"></div>

        <!-- Modal panel -->
        <div class="relative z-10 inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-2xl">

            <!-- Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2" id="modal-title">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        GIỎ HÀNG
                    </h3>
                    <button type="button" onclick="closeCartModal()" class="text-gray-400 transition hover:text-gray-600 hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Cart Items Container -->
            <div class="px-6 py-4 overflow-y-auto max-h-96 bg-gray-50" id="cartItemsContainer">
                <!-- Empty cart message -->
                <div class="py-12 text-center text-gray-500" id="emptyCartMessage">
                    <div class="inline-flex items-center justify-center w-20 h-20 mb-4 bg-gray-200 rounded-full">
                        <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-lg font-medium">Giỏ hàng trống</p>
                    <p class="mt-1 text-sm text-gray-400">Thêm sản phẩm để bắt đầu mua sắm</p>
                </div>

                <!-- Cart items will be dynamically inserted here -->
            </div>

            <!-- Footer with total and buttons -->
            <div class="px-6 py-5 bg-white border-t border-gray-100" id="cartFooter" style="display: none;">
                <!-- Total Price -->
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <span class="text-base font-medium text-gray-700">Tổng tạm tính:</span>
                    <span class="text-2xl font-bold text-red-600" id="cartTotalPrice">0 ₫</span>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('cart.index') }}"
                       class="flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-gray-900 transition border-2 border-gray-900 rounded-xl hover:bg-gray-900 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Xem giỏ hàng
                    </a>
                    <a href="{{ route('cart.checkout') }}"
                       class="flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white transition bg-red-600 rounded-xl hover:bg-red-700 shadow-lg shadow-red-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Thanh toán
                    </a>
                </div>

                <!-- Continue Shopping -->
                <button type="button" onclick="closeCartModal()"
                        class="w-full px-4 py-3 mt-3 text-sm font-medium text-gray-600 transition rounded-lg hover:bg-gray-100">
                    Tiếp tục mua hàng
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cart Item Template -->
<template id="cartItemTemplate">
    <div class="flex items-center gap-4 p-4 mb-3 bg-white border border-gray-200 rounded-xl cart-item hover:shadow-md transition-shadow" data-product-id="">
        <!-- Product Image -->
        <div class="relative flex-shrink-0">
            <img src="" alt="" class="object-cover w-20 h-20 border border-gray-200 rounded-lg cart-item-image">
            <button type="button" class="absolute flex items-center justify-center w-6 h-6 text-white transition bg-red-500 rounded-full -top-2 -right-2 hover:bg-red-600 hover:scale-110 cart-item-remove">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Product Info -->
        <div class="flex-1 min-w-0">
            <h4 class="text-sm font-semibold text-gray-900 truncate cart-item-name"></h4>
            <p class="mt-1 text-xs text-gray-500 cart-item-category"></p>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-base font-bold text-red-600 cart-item-price"></span>
                <span class="text-xs text-gray-400 line-through cart-item-original-price"></span>
            </div>
        </div>

        <!-- Quantity Controls -->
        <div class="flex items-center bg-gray-100 border border-gray-300 rounded-lg shadow-sm">
            <button type="button" class="flex items-center justify-center w-8 h-8 transition hover:bg-gray-200 rounded-l-lg cart-item-decrease">
                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path>
                </svg>
            </button>
            <input type="text" value="1" readonly class="w-10 text-sm font-semibold text-center text-gray-900 bg-transparent border-x border-gray-300 cart-item-quantity">
            <button type="button" class="flex items-center justify-center w-8 h-8 transition hover:bg-gray-200 rounded-r-lg cart-item-increase">
                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
        </div>
    </div>
</template>

<style>
/* Modal Animation */
#cartModal {
    animation: fadeIn 0.25s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

#cartModal > div > div:last-child {
    animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUp {
    from {
        transform: translateY(50px) scale(0.95);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

/* Custom scrollbar */
#cartItemsContainer::-webkit-scrollbar {
    width: 6px;
}

#cartItemsContainer::-webkit-scrollbar-track {
    background: transparent;
}

#cartItemsContainer::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

#cartItemsContainer::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth transitions */
.cart-item {
    transition: all 0.2s ease;
}

.cart-item:hover {
    transform: translateX(2px);
}
</style>

<script>
// Global cart functions
function openCartModal() {
    console.log('Opening cart modal...');
    const modal = document.getElementById('cartModal');

    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Delay để tránh conflict
        setTimeout(() => {
            if (window.cartHandler) {
                window.cartHandler.loadCart();
            }

            // Add overlay click handler AFTER modal opened
            const overlay = document.getElementById('cartOverlay');
            if (overlay) {
                overlay.onclick = function(e) {
                    if (e.target === overlay) {
                        closeCartModal();
                    }
                };
            }
        }, 100);
    } else {
        console.error('Modal not found!');
    }
}

function closeCartModal() {
    console.log('Closing cart modal...');
    const modal = document.getElementById('cartModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';

        // Remove overlay click handler
        const overlay = document.getElementById('cartOverlay');
        if (overlay) {
            overlay.onclick = null;
        }
    }
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('cartModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeCartModal();
        }
    }
});
</script>
