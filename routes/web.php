<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\AdminController;

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
    Route::get('/admin',[AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/product', [ProductController::class, 'index'])->name('products');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/admin/product/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/admin/header', [HeaderController::class, 'index'])->name('headers.index');
    Route::get('/admin/header/create', [HeaderController::class, 'create'])->name('headers.create');
    Route::post('/admin/header', [HeaderController::class, 'store'])->name('headers.store');
    Route::get('/admin/header/{header}/edit', [HeaderController::class, 'edit'])->name('headers.edit');
    Route::patch('/admin/header/{header}', [HeaderController::class, 'update'])->name('headers.update');
    Route::delete('/admin/header/{header}', [HeaderController::class, 'destroy'])->name('headers.destroy');

    Route::get('/admin/about', [AboutController::class, 'index'])->name('abouts.index');
    Route::get('/admin/about/create', [AboutController::class, 'create'])->name('abouts.create');
    Route::post('/admin/about', [AboutController::class, 'store'])->name('abouts.store');
    Route::get('/admin/about/{about}/edit', [AboutController::class, 'edit'])->name('abouts.edit');
    Route::patch('/admin/about/{about}', [AboutController::class, 'update'])->name('abouts.update');
    Route::delete('/admin/about/{about}', [AboutController::class, 'destroy'])->name('abouts.destroy');

    Route::get('/admin/contact', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/admin/contact/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/admin/contact', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/admin/contact/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::patch('/admin/contact/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/admin/contact/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/admin/content', [ContentController::class, 'index'])->name('content.index');
});

require __DIR__ . '/auth.php';
