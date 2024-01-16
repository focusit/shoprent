<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\ShopRentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TenantController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/auth.login');
});



// Show the login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
// Handle the login form submission
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Logout the user

Route::group(['middleware' => 'admin_auth'], function () {
    // Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    // Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');

    // Shop Routes
    Route::get('/shops', [ShopRentController::class, 'index'])->name('shops.index');
    Route::get('/shops/create', [ShopRentController::class, 'create'])->name('shops.create');
    Route::post('/shops/store', [ShopRentController::class, 'store'])->name('shops.store');
    Route::get('/shops/{shop_id}', [ShopRentController::class, 'show'])->name('shops.show');
    Route::get('/shops/{shop_id}/edit', [ShopRentController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop_id}', [ShopRentController::class, 'update'])->name('shops.update');
    Route::delete('/shops/{shop_id}', [ShopRentController::class, 'destroy'])->name('shops.destroy');

    // Tenant Routes
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants/store', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant_id}', [TenantController::class, 'show'])->name('tenants.show');
    Route::get('/tenants/{tenant_id}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant_id}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant_id}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    //Autocomplete
    Route::match(['get', 'post'], '/autocomplete-search', [ShopRentController::class, 'autocompleteSearch'])->name('autocomplete.search');
    Route::match(['get', 'post'], '/autocomplete-tenants', [TenantController::class, 'autocompleteSearch'])
        ->name('autocomplete.tenants');

    //Property Allocation
    Route::get('/allocate-shop', [AgreementController::class, 'showAllocateShopForm'])->name('allocate.shop.form');
    Route::post('/allocate-shop', [AgreementController::class, 'allocateShop']);
    Route::get('/allocation-list', [AgreementController::class, 'allocationList'])->name('allocation.list');

    // Agreement Routes
    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreements.index');
    Route::get('/agreements/{agreement_id}', [AgreementController::class, 'show'])->name('agreements.show');
    Route::get('/agreements/{agreement_id}/edit', [AgreementController::class, 'edit'])->name('agreements.edit');
    Route::put('/agreements/{agreement_id}', [AgreementController::class, 'update'])->name('agreements.update');
    // Route::delete('/agreements/{agreement_id}', [AgreementController::class, 'destroy'])->name('tenants.destroy');

    // View all bills
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    // Route::get('/bills/bills_list', [BillController::class, 'billsList'])->name('bills.bills_list');
    // Route::get('/bills/bills_list/{year?}/{month?}', [BillController::class, 'billsList'])->name('bills.billsList');
    Route::get('/bills/bills_list', [BillController::class, 'billsList'])->name('bills.bills_list');
    Route::get('/bills/bills_list/{year}/{month}', [BillController::class, 'billsList'])->name('bills.billsList');
    Route::get('/bills/{id}', [BillController::class, 'show'])->name('bills.show');
    Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
    Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
    Route::get('/bills/{id}/edit', [BillController::class, 'edit'])->name('bills.edit');
    Route::put('/bills/{id}', [BillController::class, 'update'])->name('bills.update');
    Route::delete('/bills/{id}', [BillController::class, 'destroy'])->name('bills.destroy');
    ///genrate bill
    Route::post('/bills/generate', [BillController::class, 'generate'])->name('bills.generate');
    Route::post('/bills/regenerate/{agreement_id}', [BillController::class, 'regenerate'])->name('bills.regenerate');
    Route::get('/bills/print/{agreement_id}', [BillController::class, 'print'])->name('bills.print');

    // Bill Routes
    // Route::get('/bill_list', [BillController::class, 'index'])->name('bill_list');
    // Payment routes
    Route::get('/payments/create/{bill_id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store/{bill_id}', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/generate_bill', function () {
        return view('generate_bill');
    });
    Route::get('/payments', function () {
        return view('payment');
    });
});



//bills

// Route::get('/bills/generate', [BillController::class, 'generate'])->name('bills.generate');
// Route::post('/bills/generate', [BillController::class, 'storeGeneratedBills'])->name('bills.generate.store');

// Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
// Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
// Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
// Route::get('/bills/{bill}', [BillController::class, 'show'])->name('bills.show');
// Route::get('/bills/{bill}/edit', [BillController::class, 'edit'])->name('bills.edit');
// Route::put('/bills/{bill}', [BillController::class, 'update'])->name('bills.update');
// Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');