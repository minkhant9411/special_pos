<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
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
    Route::resource('sale', SaleController::class);
    Route::get('history/sale', [HistoryController::class, 'sale'])->name('sale.history');
    Route::get('history/product', [HistoryController::class, 'product'])->name('product.history');
    Route::post('/sale/delete/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');
    Route::resource('history', HistoryController::class);
    // Route::get('/history/purchase', HistoryController::class);

});
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::inertia('/login', 'Auth/Login')->name('login');

});
