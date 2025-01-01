<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Category\ListCategory;
use App\Livewire\Customers\ListCustomer;
use App\Livewire\Dashboard;
use App\Livewire\Discount\ListDiscount;
use App\Livewire\Pos\Pos;
use App\Livewire\Products\FormProducts;
use App\Livewire\Products\ListProducts;
use App\Livewire\Purchases\ListPurchases;
use App\Livewire\Suppliers\ListSuppliers;
use App\Livewire\TodoList;
use App\Livewire\Units\ListUnits;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('AuthCheck')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/category', ListCategory::class)->name('category');
    Route::get('/units', ListUnits::class)->name('units');
    Route::get('/products', ListProducts::class)->name('products');
    Route::get('/products/form/{productId?}', FormProducts::class)->name('products.form');
    Route::get('/discount', ListDiscount::class)->name('discount');
    Route::get('/customers', ListCustomer::class)->name('customers');
    Route::get('/suppliers', ListSuppliers::class)->name('suppliers');
    Route::get('/purchases', ListPurchases::class)->name('purchases');
    Route::get('/pos', Pos::class)->name('pos');
    Route::get('/logout', [AuthController::class, 'logot'])->name('logout');
});
