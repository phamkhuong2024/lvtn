<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VoucherController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('product.review.store');

Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
Route::post('/vouchers/apply', [VoucherController::class, 'apply'])->name('vouchers.apply');
Route::post('/vouchers/remove', [VoucherController::class, 'remove'])->name('vouchers.remove');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth:khachhang');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'placeOrder'])->name('checkout.place')->middleware('auth:khachhang');
Route::get('/payment/vnpay-return', [\App\Http\Controllers\PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');
Route::get('/payment/return', [\App\Http\Controllers\PaymentController::class, 'vnpayReturn'])->name('payment.return');
Route::get('/payment/success/{orderId}', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');

Route::get('/login',[LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');
Route::get('/register',[RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register',[RegisterController::class, 'register'])->name('register.post')->middleware('guest');
Route::get('/products',[Controller::class, 'products'])->name('products');

// Admin routes
Route::prefix('admin')->middleware(\App\Http\Middleware\AuthAdmin::class)->group(function () {
    Route::get('/dashboard',[Controller::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brand', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/get-product-types/{categoryId}', [ProductController::class, 'getProductTypes'])->name('product.getProductTypes');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/color', [ColorController::class, 'index'])->name('color.index');
    Route::get('/color/create', [ColorController::class, 'create'])->name('color.create');
    Route::post('/color', [ColorController::class, 'store'])->name('color.store');
    Route::get('/color/{id}/edit', [ColorController::class, 'edit'])->name('color.edit');
    Route::put('/color/{id}', [ColorController::class, 'update'])->name('color.update');
    Route::delete('/color/{id}', [ColorController::class, 'destroy'])->name('color.destroy');

    Route::get('/size', [SizeController::class, 'index'])->name('size.index');
    Route::get('/size/create', [SizeController::class, 'create'])->name('size.create');
    Route::post('/size', [SizeController::class, 'store'])->name('size.store');
    Route::get('/size/{id}/edit', [SizeController::class, 'edit'])->name('size.edit');
    Route::put('/size/{id}', [SizeController::class, 'update'])->name('size.update');
    Route::delete('/size/{id}', [SizeController::class, 'destroy'])->name('size.destroy');

    Route::get('/producttype', [ProductTypeController::class, 'index'])->name('producttype.index');
    Route::get('/producttype/create', [ProductTypeController::class, 'create'])->name('producttype.create');
    Route::post('/producttype', [ProductTypeController::class, 'store'])->name('producttype.store');
    Route::get('/producttype/{id}/edit', [ProductTypeController::class, 'edit'])->name('producttype.edit');
    Route::put('/producttype/{id}', [ProductTypeController::class, 'update'])->name('producttype.update');
    Route::delete('/producttype/{id}', [ProductTypeController::class, 'destroy'])->name('producttype.destroy');

    Route::get('/vouchers', [VoucherController::class, 'adminIndex'])->name('admin.vouchers.index');
    Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('admin.vouchers.create');
    Route::post('/vouchers', [VoucherController::class, 'store'])->name('admin.vouchers.store');
    Route::get('/vouchers/{id}/edit', [VoucherController::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('admin.vouchers.update');
    Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('admin.vouchers.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('admin.order.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.order.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
});

// Nhan vien routes
Route::prefix('nhanvien')->middleware(\App\Http\Middleware\AuthAdmin::class)->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('nhanvien.order.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('nhanvien.order.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('nhanvien.order.updateStatus');
    Route::get('/', [NhanVienController::class, 'index'])->name('nhanvien.index');
    Route::get('/create', [NhanVienController::class, 'create'])->name('nhanvien.create');
    Route::post('/', [NhanVienController::class, 'store'])->name('nhanvien.store');
    Route::get('/{id}/edit', [NhanVienController::class, 'edit'])->name('nhanvien.edit');
    Route::put('/{id}', [NhanVienController::class, 'update'])->name('nhanvien.update');
    Route::delete('/{id}', [NhanVienController::class, 'destroy'])->name('nhanvien.destroy');
    Route::get('/profile', [NhanVienController::class, 'profile'])->name('nhanvien.profile');
    Route::post('/profile', [NhanVienController::class, 'updateProfile'])->name('nhanvien.profile.update');

    Route::get('/vouchers', [VoucherController::class, 'adminIndex'])->name('nhanvien.vouchers.index');
    Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('nhanvien.vouchers.create');
    Route::post('/vouchers', [VoucherController::class, 'store'])->name('nhanvien.vouchers.store');
    Route::get('/vouchers/{id}/edit', [VoucherController::class, 'edit'])->name('nhanvien.vouchers.edit');
    Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('nhanvien.vouchers.update');
    Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('nhanvien.vouchers.destroy');
});

// Khach hang routes
Route::prefix('khachhang')->group(function () {
    Route::get('/', [KhachHangController::class, 'index'])->name('khachhang.index');
    Route::get('/profile', [KhachHangController::class, 'profile'])->name('khachhang.profile');
    Route::post('/profile', [KhachHangController::class, 'updateProfile'])->name('khachhang.profile.update');
    Route::get('/orders', [OrderController::class, 'customerIndex'])->name('khachhang.order.index');
    Route::get('/orders/{id}', [OrderController::class, 'customerShow'])->name('khachhang.order.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'customerCancel'])->name('khachhang.order.cancel');
});

// Google login routes
Route::get('login-google', [\App\Http\Controllers\LoginGoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login-google-callback', [\App\Http\Controllers\LoginGoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');
