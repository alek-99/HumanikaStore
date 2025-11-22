<?php

use App\Models\Order;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\ProdukController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderanUserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware(['auth', 'verified'])->group(function () {

    // route utama: cek role dan arahkan
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // khusus admin
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

        Route::resource('/admin/product', ProductController::class)->names('admin.product');
         Route::get('/orders', [OrderanUserController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderanUserController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/status', [OrderanUserController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/orders/{id}', [OrderanUserController::class, 'destroy'])->name('admin.orders.destroy');
     Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
     Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    });

    // khusus user
    Route::middleware('user')->group(function () {
  Route::get('/user/dashboard', [DashboardController::class, 'index'])
    ->name('user.dashboard');

        Route::get('/Kontak',[DashboardController::class, 'person'])->name('user.person');
        Route::get('/user/produk', [ProdukController::class, 'index'])->name('user.produk.index');
         Route::post('/order/{productId}', [OrderController::class, 'store'])->name('order.store');
        Route::get('/my-orders', [OrderController::class, 'myOrder'])->name('user.orders.index');
         Route::get('/produk/show{id}',[ProdukController::class, 'show'])->name('user.produk.show');
       Route::put('/orders/cancel/{id}', [OrderController::class, 'cancel'])
    ->name('orders.cancel');

    });

    // profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
