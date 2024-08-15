<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\UserController\ClientDashboard;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\ShopRentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\TenantController;
use Barryvdh\Debugbar\Facades\Debugbar;

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
    return view('/client.userlogin');
});
// Route::get('/dashboard', [ClientDashboard::class, 'dashboard'])->name('dashboard');

Route::get('/admin', function () {
    return view('/auth.login');
});

Route::get('/user', function () {
    return view('/users.user');
});
Route::get('/newuser', function () {
    return view('/users.new_user');
});
Route::get('/assessmentSummary', function () {
    return view('/assessment');
});




// Show the login form
Route::get('/login', [ClientDashboard::class, 'showUserLoginForm'])->name('login.form');
// Handle the login form submission
Route::post('/admin', [AuthController::class, 'login'])->name('login');
Route::post('/', [ClientDashboard::class, 'userLogin'])->name('userLogin');
// Logout the user


//Registeration
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:web'])->group(function () {
    // Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    // Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    // Route::post('/profile/update', [AuthController::class, 'updatePassword'])->name('profile.update');
    Route::post('/user-logout', [ClientDashboard::class, 'userLogout'])->name('userLogout');

    Route::get('/user-dashboard', [ClientDashboard::class, 'userDashboard'])->name('userDashboard');
    // View User Shops
    Route::get('/user-shops', [ClientDashboard::class, 'viewUserShops'])->name('viewUserShops');

    // View User Agreements
    Route::get('/user-agreements', [ClientDashboard::class, 'viewUserAgreements'])->name('viewUserAgreements');

    // View User Bills
    Route::get('/user-bills', [ClientDashboard::class, 'viewUserBills'])->name('viewUserBills');

    // View User Payments
    Route::get('/user-payments', [ClientDashboard::class, 'viewUserPayments'])->name('viewUserPayments');
});



Route::group(['middleware' => ['admin_auth']], function () {
    // Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    // Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updatePassword'])->name('profile.update');
    Route::get('/admin-dashboard', [IndexController::class, 'dashboard'])->name('dashboard');

    // Shop Routes
    Route::get('/shops', [ShopRentController::class, 'index'])->name('shops.index');
    Route::get('/shops/create', [ShopRentController::class, 'create'])->name('shops.create');
    Route::post('/shops/store', [ShopRentController::class, 'store'])->name('shops.store');
    Route::get('/shops/{shop_id}', [ShopRentController::class, 'show'])->name('shops.show');
    Route::get('/shops/{shop_id}/edit', [ShopRentController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop_id}', [ShopRentController::class, 'update'])->name('shops.update');
    Route::delete('/shops/{shop_id}', [ShopRentController::class, 'destroy'])->name('shops.destroy');
    Route::post('/checkShopId', [ShopRentController::class, 'checkShopId'])->name('checkShopId');

    // Tenant Routes
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::get('/tenants/search', [TenantController::class, 'search'])->name('tenants.search');
    Route::post('/tenants/store', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant_id}', [TenantController::class, 'show'])->name('tenants.show');
    Route::get('/tenants/{tenant_id}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant_id}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant_id}', [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/checkTenantId', [TenantController::class, 'checkTenantId'])->name('checkTenantId');
    Route::post('/tenants/searched', [TenantController::class, 'searchTenant'])->name('tenants.searchTenant');

    //Autocomplete
    Route::match(['get', 'post'], '/autocomplete-search', [ShopRentController::class, 'autocompleteSearch'])->name('autocomplete.search');
    Route::match(['get', 'post'], '/autocomplete-tenants', [TenantController::class, 'autocompleteSearch'])->name('autocomplete.tenants');

    //Property Allocation
    Route::get('/allocate-shop', [AgreementController::class, 'showAllocateShopForm'])->name('allocate.shop.form');
    Route::post('/allocate-shop', [AgreementController::class, 'allocateShop']);
    Route::get('/allocation-list', [AgreementController::class, 'allocationList'])->name('allocation.list');
    Route::get('/allocation/{shop_id}' ,[AgreementController::class, 'allocatevacantShop'])->name('shop.index');

    // Agreement Routes
    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreements.index');
    Route::get('/agreements/{agreement_id}', [AgreementController::class, 'show'])->name('agreements.show');
    Route::get('/agreements/{agreement_id}/edit', [AgreementController::class, 'edit'])->name('agreements.edit');
    Route::put('/agreements/{agreement_id}', [AgreementController::class, 'update'])->name('agreements.update');
    Route::post('/checkAgreementId', [AgreementController::class, 'checkAgreementId'])->name('checkAgreementId');
    // Route::delete('/agreements/{agreement_id}', [AgreementController::class, 'destroy'])->name('tenants.destroy');

    // View all bills
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    // Route::get('/billpayment', [BillController::class, 'billpayment'])->name('bills.billpayment');
    // Route::get('/bills/bills_list', [BillController::class, 'billsList'])->name('bills.bills_list');
    // Route::get('/bills/bills_list/{year?}/{month?}', [BillController::class, 'billsList'])->name('bills.billsList');
    Route::get('/bills/bills_list', [BillController::class, 'billsList'])->name('bills.bills_list');
    Route::get('/bills/bills_list/{year?}/{month?}', [BillController::class, 'billsList'])->name('bills.billsList');
    Route::get('/bills/{id}', [BillController::class, 'show'])->name('bills.show');
    Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
    Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
    Route::get('/bills/{agreement_id}/edit', [BillController::class, 'edit'])->name('bills.edit');
    Route::put('/bills/{agreement_id}', [BillController::class, 'update'])->name('bills.update');
    Route::delete('/bills/{agreement_id}', [BillController::class, 'destroy'])->name('bills.destroy');
    Route::get('/bills/paid' , [BillController::class, 'paidBills'])->name('bills.paid');
    ///genrate bill
    Route::post('/bills/generate/{year?}/{month?}', [BillController::class, 'generate'])->name('bills.generate');
    Route::post('/bills/regenerate/{transaction_number}/{year?}/{month?}', [BillController::class, 'regenerate'])->name('bills.regenerate');
    Route::get('/bills/print/{id}/{agreement_id}', [BillController::class, 'print'])->name('bills.print');

    // Bill Routes
    // Route::get('/bill_list', [BillController::class, 'index'])->name('bill_list');
    // Payment routes
    Route::get('/payments/create/{bill_id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store/{bill_id}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/search', [PaymentController::class, 'search'])->name('payments.search');
    Route::post('/payments/searched', [PaymentController::class, 'searchBy'])->name('payments.searchBy');


    //Reports
    Route::get('/reports/monthwise', [reportController::class , 'monthReport'])->name('reports.monthwise');
    Route::get('/reports/monthwise/{year?}/{month?}', [reportController::class , 'monthReport'])->name('reports.monthswise');
    Route::get('/reports/collection', [reportController::class, 'collectionReport'])->name('reports.collection');

    Route::get('/generate_bill', function () {
        return view('generate_bill');
    });
    Route::get('/payments', function (){
        return view('payment');
    });

    Route::get('/billpay', [BillController::class, 'paidBills'])->name('billsPaid');
});


//setting Dbeugbar 
// if (app()->environment('local')) {
//     Debugbar::enable();
// } else {
//     Debugbar::disable();
// }
