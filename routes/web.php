<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;  


use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController as FrontendWishlistController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProfileController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\MarketingController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\StocksController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;


// ============================================
// GUEST ROUTES
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});


// ============================================
// AUTH ROUTES
// ============================================
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});


// ============================================
// FRONTEND ROUTES
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [ProductController::class, 'submitReview'])->name('product.review')->middleware('auth');


// ============================================
// CART ROUTES
// ============================================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.remove.coupon');

// ✅ CART COUNT - ADD THIS
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');


// ============================================
// CHECKOUT ROUTES
// ============================================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/order-confirmation', [CheckoutController::class, 'confirmation'])->name('order.confirmation');


// ============================================
// WISHLIST ROUTES
// ============================================
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [FrontendWishlistController::class, 'index'])->name('index');
    Route::post('/add/{product}', [FrontendWishlistController::class, 'add'])->name('add');
    Route::delete('/remove/{product}', [FrontendWishlistController::class, 'remove'])->name('remove');
    Route::post('/move-to-cart/{product}', [FrontendWishlistController::class, 'moveToCart'])->name('moveToCart');
    Route::get('/count', [FrontendWishlistController::class, 'getWishlistCount'])->name('count');  // ✅ Already exists
});


// ============================================
// ORDERS ROUTES
// ============================================
Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/returns', [OrderController::class, 'returns'])->name('returns');
    Route::get('/cancellations', [OrderController::class, 'cancellations'])->name('cancellations');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    Route::post('/{order}/return', [OrderController::class, 'returnRequest'])->name('return.request');
    Route::post('/{order}/reorder', [OrderController::class, 'reorder'])->name('reorder');
});


// ============================================
// SHOP CATEGORY ROUTES
// ============================================
Route::get('/shop/category/{id}', [ShopController::class, 'index'])->name('shop.category');
Route::get('/shop/category-products', [ShopController::class, 'getCategoryProducts'])->name('shop.category.products');


// ============================================
// PRODUCT ROUTES
// ============================================
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');


// ============================================
// ORDER TRACKING
// ============================================
Route::post('/order/track', [OrderController::class, 'track'])->name('orders.track');


// ============================================
// PROFILE ROUTES
// ============================================
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('password');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses');
    Route::post('/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
    Route::delete('/address/delete/{id}', [ProfileController::class, 'deleteAddress'])->name('address.delete');
    Route::get('/payment', [ProfileController::class, 'payment'])->name('payment');
});


// ============================================
// PAYMENT ROUTES
// ============================================
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/payfast', [PaymentController::class, 'payfast'])->name('payfast');
    Route::post('/process', [PaymentController::class, 'processPayfast'])->name('process');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
});


// ============================================
// STATIC PAGES
// ============================================
Route::view('/about', 'frontend.about')->name('about');
Route::view('/contact', 'frontend.contact')->name('contact');


// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::delete('/products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::post('/products/image/{id}/primary', [AdminProductController::class, 'setPrimaryImage'])->name('products.image.primary');
    Route::post('/products/{id}/stock', [AdminProductController::class, 'updateStock'])->name('products.stock');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::post('/categories/{category}/toggle', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle');
    
    // Orders
    Route::resource('orders', AdminOrderController::class);
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    
    // Users
    Route::resource('users', AdminUserController::class);
    
    // Coupons
    Route::resource('coupons', AdminCouponController::class);
    Route::post('/coupons/{coupon}/toggle', [AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle');
    
    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    
    // Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [AdminSettingsController::class, 'reset'])->name('settings.reset');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Marketing
    Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing.index');
    Route::get('/marketing/create', [MarketingController::class, 'create'])->name('marketing.create');
    Route::post('/marketing', [MarketingController::class, 'store'])->name('marketing.store');
    Route::get('/marketing/{id}', [MarketingController::class, 'show'])->name('marketing.show');
    Route::get('/marketing/{id}/edit', [MarketingController::class, 'edit'])->name('marketing.edit');
    Route::put('/marketing/{id}', [MarketingController::class, 'update'])->name('marketing.update');
    Route::delete('/marketing/{id}', [MarketingController::class, 'destroy'])->name('marketing.destroy');
    Route::post('/marketing/{id}/toggle', [MarketingController::class, 'toggleStatus'])->name('marketing.toggle');
    
    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');

    // Stocks
    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.index');
    Route::post('/stocks/{id}/update', [StocksController::class, 'update'])->name('stocks.update');

    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
});