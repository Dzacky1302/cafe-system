<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\ResolveMicrosite;
use Illuminate\Support\Facades\Route;

Route::middleware(ResolveMicrosite::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->whereNumber('id')->name('menu.show');

    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/{id}', [CartController::class, 'store'])->whereNumber('id')->name('cart.store');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->whereNumber('id')->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->whereNumber('id')->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pesanan/{code}', [CheckoutController::class, 'success'])->name('order.success');
    Route::get('/lacak', [CheckoutController::class, 'track'])->name('order.track');
});

