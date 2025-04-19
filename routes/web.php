<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::inertia('/', 'Home')->name('home');
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');



    Route::resource('category', CategoryController::class);
    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::resource('supplier', SupplierController::class);
    Route::post('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    Route::resource('product', ProductController::class);
    Route::post('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // Route::inertia('purchase/cart', 'Purchase/Cart')->name('purchase.cart');
    Route::resource('purchase', PurchaseController::class);
    Route::post('/purchase/delete/{id}', [ProductController::class, 'destroy'])->name('purchase.destroy');
});
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::inertia('/login', 'Auth/Login')->name('login');

});
