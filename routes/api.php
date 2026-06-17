<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WishlistController;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Product Routes (Public)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/new-arrivals', [ProductController::class, 'newArrivals']);
Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/categories/{id}/products', [ProductController::class, 'categoryProducts']);
Route::get('/products/{id}/reviews', [ProductController::class, 'getReviews']);

// Protected Routes (Require Auth)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/password', [AuthController::class, 'updatePassword']);
    Route::put('/customer', [AuthController::class, 'updateCustomer']);
    Route::get('/user/orders', [AuthController::class, 'userOrders']);
    Route::get('/user/wishlist', [AuthController::class, 'userWishlist']);
    
    // Reviews (Auth required)
    Route::post('/products/{id}/reviews', [ProductController::class, 'addReview']);
    
    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon']);
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/{productId}', [WishlistController::class, 'add']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'remove']);
    Route::post('/wishlist/{productId}/move-to-cart', [WishlistController::class, 'moveToCart']);
    Route::get('/wishlist/count', [WishlistController::class, 'count']);
});

// Public Track Order
Route::post('/order/track', [OrderController::class, 'track']);