<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockEntryController;

/*
|--------------------------------------------------------------------------
| HOME
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

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | POS (CAIXA)
    |--------------------------------------------------------------------------
    */

    Route::get('/pos', [SaleController::class, 'index'])
        ->name('pos');

    Route::post('/pos/checkout', [SaleController::class, 'checkout'])
        ->name('pos.checkout');

    /*
    |--------------------------------------------------------------------------
    | RECIBO
    |--------------------------------------------------------------------------
    */

    Route::get('/sale/{id}/receipt', [SaleController::class, 'receipt'])
        ->name('sale.receipt');

    /*
    |--------------------------------------------------------------------------
    | PRODUTOS
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class);

    /*
    |--------------------------------------------------------------------------
    | HISTÓRICO DE VENDAS
    |--------------------------------------------------------------------------
    */

    Route::get('/sales', [SaleHistoryController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/{id}', [SaleHistoryController::class, 'show'])
        ->name('sales.show');

    /*
    |--------------------------------------------------------------------------
    | ENTRADAS DE STOCK
    |--------------------------------------------------------------------------
    */

    Route::get('/stock-entry', [StockEntryController::class, 'create'])
        ->name('stock.create');

    Route::post('/stock-entry', [StockEntryController::class, 'store'])
        ->name('stock.store');

    Route::get('/stock-history', [StockEntryController::class, 'index'])
        ->name('stock.history');

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';