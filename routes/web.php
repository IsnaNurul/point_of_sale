<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Bank\ListBank;
use App\Livewire\Cashier\ListCashier;
use App\Livewire\Category\ListCategory;
use App\Livewire\Customers\ListCustomer;
use App\Livewire\Dashboard;
use App\Livewire\Pos\ListHold;
use App\Livewire\Pos\ListTransaction;
use App\Livewire\Discount\ListDiscount;
use App\Livewire\Pos\HoldPos;
use App\Livewire\Pos\Pos;
use App\Livewire\Products\FormProducts;
use App\Livewire\Products\ListProducts;
use App\Livewire\Profile\Profile;
use App\Livewire\Purchases\ListPurchases;
use App\Livewire\Suppliers\ListSuppliers;
use App\Livewire\TodoList;
use App\Livewire\Units\ListUnits;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('form-login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('AuthCheck')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/category', ListCategory::class)->name('category');
    Route::get('/payment_method', ListBank::class)->name('payment_method');
    Route::get('/units', ListUnits::class)->name('units');
    Route::get('/products', ListProducts::class)->name('products');
    Route::get('/products/form/{productId?}', FormProducts::class)->name('products.form');
    Route::get('/discount', ListDiscount::class)->name('discount');
    Route::get('/customers', ListCustomer::class)->name('customers');
    Route::get('/cashier', ListCashier::class)->name('cashier');
    Route::get('/purchases', ListPurchases::class)->name('purchases');
    Route::get('/hold', ListHold::class)->name('hold');
    Route::get('/pos', Pos::class)->name('pos');
    Route::get('/pos/{saleId?}', HoldPos::class)->name('hold-pos');
    Route::get('/transaction', ListTransaction::class)->name('transaction');

    // routes/web.php
    Route::get('/pos/export/pdf', [ListTransaction::class, 'exportToPDF'])->name('pos.export.pdf');
    Route::get('/pos/export/excel', [ListTransaction::class, 'exportToExcel'])->name('pos.export.excel');


    Route::get('/logout', [AuthController::class, 'logot'])->name('logout');
});
