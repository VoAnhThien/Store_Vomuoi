<?php
// routes/web.php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// TRANG CHỦ: Banner + ít sản phẩm
Route::get('/', [ProductController::class, 'homepage'])->name('homepage');

// TRANG SẢN PHẨM: Tất cả sản phẩm
Route::get('san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// Xem chi tiết sản phẩm
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('product.category');

//pages routes
Route::get('gioi-thieu', function () {return view('pages.about');})->name('about');
Route::get('lien-he', function () {return view('pages.contact');})->name('contact');
Route::get('khuyen-mai', function () {return view('pages.promo');})->name('promo');

// Trang giỏ hàng
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/info', [CartController::class, 'getCartInfo'])->name('cart.info');
});

// User Profile Routes
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change-password');
    Route::get('/orders', [App\Http\Controllers\UserController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [App\Http\Controllers\UserController::class, 'orderDetail'])->name('orders.detail');
});

// Checkout Routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order_code}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// MoMo Payment Routes
Route::prefix('momo')->name('momo.')->group(function () {
    Route::post('/payment', [MomoController::class, 'createPayment'])->name('payment');
    Route::get('/callback', [MomoController::class, 'callback'])->name('callback');
    Route::post('/ipn', [MomoController::class, 'ipn'])->name('ipn');
    Route::get('/status/{orderId}', [MomoController::class, 'checkStatus'])->name('status');
});

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Google OAuth Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

// Logout (phải đăng nhập mới logout được)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::post('/products/{id}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('products.toggle-status');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    Route::post('/categories/{id}/toggle-status', [AdminController::class, 'toggleCategoryStatus'])->name('categories.toggle-status');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
});

