<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login',[Controller::class, 'index'])->name('login')->middleware('guest');
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

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});

// Nhan vien routes
Route::prefix('nhanvien')->middleware(\App\Http\Middleware\AuthAdmin::class)->group(function () {
    Route::get('/profile', [NhanVienController::class, 'profile'])->name('nhanvien.profile');
    Route::post('/profile', [NhanVienController::class, 'updateProfile'])->name('nhanvien.profile.update');
});

// Khach hang routes
Route::prefix('khachhang')->group(function () {
    Route::get('/profile', [KhachHangController::class, 'profile'])->name('khachhang.profile');
    Route::post('/profile', [KhachHangController::class, 'updateProfile'])->name('khachhang.profile.update');
});
