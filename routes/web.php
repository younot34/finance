<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetPlanController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\TaxeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\ProfitLossReportController;
use App\Models\Expense;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //permissions
    Route::resource('permissions', PermissionController::class)->only([
        'index'
    ]);

    //roles
    Route::resource('roles', RoleController::class)->except([
        'show'
    ]);

    //users
    Route::resource('users', UserController::class)->except([
        'show'
    ]);


    Route::resource('accounts', AccountController::class);
    Route::resource('budget-plans', BudgetPlanController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('journals', JournalController::class);
    Route::get('/check-no-ref', [JournalController::class, 'checkNoRef']);
    Route::resource('taxes', TaxeController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('vendrs', VendorController::class);
    Route::get('/ledgers', [LedgerController::class, 'index'])->name('ledgers.index');
    Route::get('/neracas', [NeracaController::class, 'index'])->name('neracas.index');
    Route::get('/reports', [ProfitLossReportController::class, 'index'])->name('reports.index');
});
