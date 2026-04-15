<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\Auth\SocialLoginController;

// Social Login
Route::get('auth/{provider}', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');

// Auth routes — must come BEFORE our routes so /home is registered by Laravel first
Auth::routes(['verify' => true]);

// Override Laravel's /home redirect to go to /
Route::get('/home', function () { return redirect('/'); });

// All routes require authentication — guests are redirected to login
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [HomeController::class, 'products'])->name('products');
    Route::get('/product/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Protected routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [InvoiceController::class, 'view'])->name('invoice.view');
    Route::get('/invoice/{order}/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.history');
    Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.detail');
    Route::patch('/orders/{order}/cancel', [OrderHistoryController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/reorder', [OrderHistoryController::class, 'reorder'])->name('orders.reorder');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payment Webhooks
Route::post('/midtrans/notification', [CheckoutController::class, 'notification'])->name('midtrans.notification');
Route::post('/chapa/webhook', [CheckoutController::class, 'chapaWebhook'])->name('chapa.webhook');

// Chatbot
Route::post('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'chat'])
    ->middleware('throttle:30,1')
    ->name('chatbot');
