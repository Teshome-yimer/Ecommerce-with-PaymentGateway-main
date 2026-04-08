<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\SocialLoginController;

Route::get('auth/{provider}', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');
// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/product/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout & Protected routes (Login ላደረገ ተጠቃሚ ብቻ)
Route::middleware('auth')->group(function () {
    // Checkout Core
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // User Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Invoice Routes
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [InvoiceController::class, 'view'])->name('invoice.view');
    Route::get('/invoice/{order}/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');

    // Order History Routes
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.history');
    Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.detail');
    Route::patch('/orders/{order}/cancel', [OrderHistoryController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/reorder', [OrderHistoryController::class, 'reorder'])->name('orders.reorder');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payment Webhooks (ከ Authentication ውጭ መሆን አለባቸው)
Route::post('/midtrans/notification', [CheckoutController::class, 'notification'])->name('midtrans.notification');
Route::post('/chapa/webhook', [CheckoutController::class, 'chapaWebhook'])->name('chapa.webhook');

// 1. የኢሜይል ማረጋገጫ ራውቶችን ክፈት
Auth::routes(['verify' => true]);

// 2. ሆም ፔጅህ '/' ከሆነ፣ ተጠቃሚው ገብቶ ሲጨርስ ወደ እሱ እንዲሄድ እንዲህ አድርግ
Route::get('/home', function () {
    return redirect('/'); // ወደ ዋናው ገጽ እንዲመለስ
});

// 3. ዋና ዋና ገጾችህን "verified" በሚለው ሚድልዌር እሰር
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
