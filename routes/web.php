<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\ProductController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/order/{product}', [OrderController::class, 'showOrderForm'])->name('order.form');
Route::post('/order/create', [OrderController::class, 'createOrder'])->name('order.create');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
    Route::get('/admin/product', [ProductController::class, 'index'])->name('products');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/admin/product/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


});



require __DIR__ . '/auth.php';
