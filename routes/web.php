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
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KaryawanPesananController;
use App\Http\Controllers\AdminBahanController;
use App\Http\Controllers\AdminPengeluaranController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\KaryawanGalleryController;
use App\Http\Controllers\ReportController;


Route::middleware('auth')->group(function () {
    Route::get('/report/pdf', [ReportController::class, 'generatePDF'])->name('report.pdf');
    Route::get('/',[RouteController::class, 'index'])->name('home');


    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin',[AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile.index');

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

    Route::get('/admin/user', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/admin/user', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/admin/user/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/admin/user/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/admin/pesanan', [PesananController::class, 'index'])->name('pesanans.index');
    Route::get('/admin/pesanan/create', [PesananController::class, 'create'])->name('pesanans.create');
    Route::post('/admin/pesanan', [PesananController::class, 'store'])->name('pesanans.store');
    Route::get('/admin/pesanan/{pesanan}/edit', [PesananController::class, 'edit'])->name('pesanans.edit');
    Route::get('/admin/pesanan/{pesanan}/detail', [PesananController::class, 'detail'])->name('pesanans.detail');
    Route::patch('/admin/pesanan/{pesanan}', [PesananController::class, 'update'])->name('pesanans.update');
    Route::delete('/admin/pesanan/{pesanan}', [PesananController::class, 'destroy'])->name('pesanans.destroy');
    Route::post('/admin/pesanan/{pesanan}/markAsPaid', [PesananController::class, 'markAsPaid'])->name('pesanans.markAsPaid');
    Route::post('/admin/pesanan/{pesanan}/markAsCompleted', [PesananController::class, 'markAsCompleted'])->name('pesanans.markAsCompleted');
    Route::delete('/admin/pesanan/{pesanan}/deleteWithPemasukan', [PesananController::class, 'destroyWithPemasukan'])->name('pesanans.destroyWithPemasukan');


    Route::get('/admin/transaksi/{transaksi}/edit', [AdminTransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::patch('/admin/transaksi/{transaksi}', [AdminTransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/admin/transaksi/{transaksi}', [AdminTransaksiController::class, 'destroy'])->name('transaksi.destroy');

    Route::get('/admin/bahan/create', [AdminBahanController::class, 'create'])->name('admin.bahan.create');
    Route::post('/admin/bahan', [AdminBahanController::class, 'store'])->name('admin.bahan.store');
    Route::get('/admin/bahan/{bahan}/edit', [AdminBahanController::class, 'edit'])->name('admin.bahan.edit');
    Route::patch('/admin/bahan/{bahan}', [AdminBahanController::class, 'update'])->name('admin.bahan.update');
    Route::delete('/admin/bahan/{bahan}', [AdminBahanController::class, 'destroy'])->name('admin.bahan.destroy');

    Route::get('/admin/pengeluaran', [AdminPengeluaranController::class, 'index'])->name('admin.pengeluaran.index');
    Route::get('/admin/pengeluaran/create', [AdminPengeluaranController::class, 'create'])->name('admin.pengeluaran.create');
    Route::post('/admin/pengeluaran', [AdminPengeluaranController::class, 'store'])->name('admin.pengeluaran.store');
    Route::get('/admin/pengeluaran/{pengeluaran}/edit', [AdminPengeluaranController::class, 'edit'])->name('admin.pengeluaran.edit');
    Route::patch('/admin/pengeluaran/{pengeluaran}', [AdminPengeluaranController::class, 'update'])->name('admin.pengeluaran.update');
    Route::delete('/admin/pengeluaran/{pengeluaran}', [AdminPengeluaranController::class, 'destroy'])->name('admin.pengeluaran.destroy');

    Route::get('/admin/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::delete('/admin/pemasukan/{pemasukan}', [PemasukanController::class, 'destroy'])->name('pemasukan.destroy');
    Route::get('/admin/pemasukan/create', [PemasukanController::class, 'create'])->name('pemasukan.create');
    Route::post('/admin/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
    
});

    Route::get('/forgot-password/phone', [PhonePasswordResetController::class, 'showForgotForm'])
        ->name('password.request.phone');
    Route::post('/forgot-password/phone', [PhonePasswordResetController::class, 'sendResetLink'])
        ->name('password.phone.send');
    Route::get('/reset-password/phone/verify', [PhonePasswordResetController::class, 'showVerifyForm'])
        ->name('password.reset.phone.verify');
    Route::post('/reset-password/phone/verify', [PhonePasswordResetController::class, 'verifyOTP'])
        ->name('password.reset.phone.update');

Route::middleware(['auth'])->group(function () {

    Route::get('/karyawan',[KaryawanController::class, 'index'])->name('karyawan.index');

    Route::get('/karyawan/gallery',[KaryawanGalleryController::class, 'index'])->name('karyawan.gallery.index');
    Route::get('/karyawan/gallery/create', [KaryawanGalleryController::class, 'create'])->name('karyawan.gallery.create');
    Route::post('/karyawan/gallery', [KaryawanGalleryController::class, 'store'])->name('karyawan.gallery.store');
    Route::get('/karyawan/gallery/{product}/edit', [KaryawanGalleryController::class, 'edit'])->name('karyawan.gallery.edit');
    Route::patch('/karyawan/gallery/{product}', [KaryawanGalleryController::class, 'update'])->name('karyawan.gallery.update');
    Route::delete('/karyawan/gallery/{product}', [KaryawanGalleryController::class, 'destroy'])->name('karyawan.gallery.destroy');

    Route::get('/karyawan/profile',[KaryawanController::class, 'profile'])->name('karyawan.profile.index');
    Route::put('/karyawan/profile', [KaryawanController::class, 'profile_update'])
    ->name('karyawan.profile.update');

    Route::get('/pesanan', [KaryawanPesananController::class, 'index'])->name('karyawan.pesanans.index');
    Route::get('/pesanan/create', [KaryawanPesananController::class, 'create'])->name('karyawan.pesanans.create');
    Route::post('/pesanan', [KaryawanPesananController::class, 'store'])->name('karyawan.pesanans.store');
    Route::get('/pesanan/{pesanan}/edit', [KaryawanPesananController::class, 'edit'])->name('karyawan.pesanans.edit');
    Route::get('/pesanan/{pesanan}/detail', [KaryawanPesananController::class, 'detail'])->name('karyawan.pesanans.detail');
    Route::patch('/pesanan/{pesanan}', [KaryawanPesananController::class, 'update'])->name('karyawan.pesanans.update');
    Route::delete('/pesanan/{pesanan}', [KaryawanPesananController::class, 'destroy'])->name('karyawan.pesanans.destroy');
    Route::post('/pesanan/{pesanan}/markAsPaid', [KaryawanPesananController::class, 'markAsPaid'])->name('karyawan.pesanans.markAsPaid');
    Route::post('/pesanan/{pesanan}/markAsCompleted', [KaryawanPesananController::class, 'markAsCompleted'])->name('karyawan.pesanans.markAsCompleted');
    Route::delete('/pesanan/{pesanan}/deleteWithPemasukan', [KaryawanPesananController::class, 'destroyWithPemasukan'])->name('karyawan.pesanans.destroyWithPemasukan');
});

require __DIR__ . '/auth.php';
