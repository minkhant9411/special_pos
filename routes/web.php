<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin,casher'])->group(function () {

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('sale', SaleController::class);
    Route::post('/sale/delete/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');

});
Route::middleware(['auth', 'role:admin'])->group(function () {



    Route::resource('category', CategoryController::class);
    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::resource('supplier', SupplierController::class);
    Route::post('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::resource('customer', CustomerController::class);
    Route::post('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    Route::resource('product', ProductController::class);
    Route::post('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::resource('purchase', PurchaseController::class);
    Route::post('/purchase/delete/{id}', [ProductController::class, 'destroy'])->name('purchase.destroy');

    // Route::post('/sale/{id}', [SaleController::class, 'show'])->name('sale.show');

    Route::get('history/sales', [HistoryController::class, 'sale'])->name('sale.history');
    Route::get('history/purchases', [HistoryController::class, 'purchase'])->name('purchase.history');
    Route::get('history/product', [HistoryController::class, 'product'])->name('product.history');
    Route::resource('history', HistoryController::class);

    Route::resource('account', AccountController::class);

    Route::resource('stuff', StuffController::class);
    Route::post('/stuff/delete/{id}', [StuffController::class, 'destroy'])->name('stuff.destroy');


});
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'index'])->name('login');

});
