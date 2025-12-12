// public/js/cart.js
class CartHandler {
    constructor() {
        this.modal = document.getElementById('cartModal');
        this.container = document.getElementById('cartItemsContainer');
        this.emptyMessage = document.getElementById('emptyCartMessage');
        this.footer = document.getElementById('cartFooter');
        this.totalPrice = document.getElementById('cartTotalPrice');
        this.template = document.getElementById('cartItemTemplate');
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        console.log('CartHandler initialized');
    }

    // Format giá tiền
    formatPrice(price) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'decimal',
            minimumFractionDigits: 0
        }).format(price) + ' ₫';
    }

    // Tải giỏ hàng từ server
    async loadCart() {
        console.log('Loading cart...');
        try {
            const response = await fetch('/cart/info');
            const data = await response.json();
            console.log('Cart data:', data);
            this.renderCart(data);
        } catch (error) {
            console.error('Error loading cart:', error);
            this.showNotification('Không thể tải giỏ hàng', 'error');
        }
    }

    // Hiển thị giỏ hàng
    renderCart(data) {
        // Xóa các item cũ
        const oldItems = this.container.querySelectorAll('.cart-item');
        oldItems.forEach(item => item.remove());

        if (data.count === 0) {
            this.emptyMessage.style.display = 'block';
            this.footer.style.display = 'none';
        } else {
            this.emptyMessage.style.display = 'none';
            this.footer.style.display = 'block';
            this.totalPrice.textContent = this.formatPrice(data.total);

            // Render từng sản phẩm
            data.items.forEach(item => {
                this.renderCartItem(item);
            });
        }

        // Update cart count badge
        this.updateCartBadge(data.count);
    }

    // Render một sản phẩm trong giỏ hàng
    renderCartItem(item) {
        const clone = this.template.content.cloneNode(true);
        const wrapper = clone.querySelector('.cart-item');

        wrapper.setAttribute('data-product-id', item.product_id);

        // Image
        const img = clone.querySelector('.cart-item-image');
        img.src = item.image ? `/storage/${item.image}` : 'https://via.placeholder.com/80';
        img.alt = item.name;

        // Product info
        clone.querySelector('.cart-item-name').textContent = item.name;
        clone.querySelector('.cart-item-category').textContent = item.category || '';
        clone.querySelector('.cart-item-price').textContent = this.formatPrice(item.price);

        // Original price
        const originalPriceEl = clone.querySelector('.cart-item-original-price');
        if (item.original_price && item.original_price > item.price) {
            originalPriceEl.textContent = this.formatPrice(item.original_price);
        } else {
            originalPriceEl.style.display = 'none';
        }

        // Quantity
        const quantityInput = clone.querySelector('.cart-item-quantity');
        quantityInput.value = item.quantity;

        // Event listeners
        clone.querySelector('.cart-item-remove').addEventListener('click', () => {
            this.removeItem(item.product_id);
        });

        clone.querySelector('.cart-item-decrease').addEventListener('click', () => {
            this.updateQuantity(item.product_id, Math.max(1, item.quantity - 1));
        });

        clone.querySelector('.cart-item-increase').addEventListener('click', () => {
            this.updateQuantity(item.product_id, item.quantity + 1);
        });

        this.container.appendChild(clone);
    }

    // Thêm sản phẩm vào giỏ hàng
    async addToCart(productId, quantity = 1) {
        console.log('Adding to cart:', productId, quantity);
        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();
            console.log('Add to cart response:', data);

            if (data.success) {
                this.showNotification(data.message, 'success');
                openCartModal(); // Mở modal
            } else {
                this.showNotification(data.message || 'Có lỗi xảy ra', 'error');
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            this.showNotification('Không thể thêm sản phẩm vào giỏ hàng', 'error');
        }
    }

    // Cập nhật số lượng
    async updateQuantity(productId, quantity) {
        try {
            const response = await fetch('/cart/update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                this.loadCart();
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            this.showNotification('Không thể cập nhật số lượng', 'error');
        }
    }

    // Xóa sản phẩm
    async removeItem(productId) {
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            return;
        }

        try {
            const response = await fetch(`/cart/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message, 'success');
                this.loadCart();
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            this.showNotification('Không thể xóa sản phẩm', 'error');
        }
    }

    // Update cart badge in header
    updateCartBadge(count) {
        const badges = document.querySelectorAll('.cart-count-badge');
        badges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });
    }

    // Hiển thị thông báo
    showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success'
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

// Initialize cart handler
let cartHandler;

document.addEventListener('DOMContentLoaded', function() {
    cartHandler = new CartHandler();

    // Global functions
    window.cartHandler = cartHandler;
    window.addToCart = (id, qty) => cartHandler.addToCart(id, qty);
});
