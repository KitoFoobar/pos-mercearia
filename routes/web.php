<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| ROTAS PRINCIPAIS
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| POS (CAIXA)
|--------------------------------------------------------------------------
*/
Route::get('/pos', [SaleController::class, 'index'])->name('pos');
Route::post('/pos/checkout', [SaleController::class, 'checkout'])->name('pos.checkout');

/*
|--------------------------------------------------------------------------
| PRODUTOS (CRUD)
|--------------------------------------------------------------------------
*/
Route::resource('products', ProductController::class);

use App\Http\Controllers\SaleHistoryController;

Route::get('/sales', [SaleHistoryController::class, 'index'])
    ->name('sales.index');

Route::get('/sales/{id}', [SaleHistoryController::class, 'show'])
    ->name('sales.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';