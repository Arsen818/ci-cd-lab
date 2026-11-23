<?php

use App\Http\Controllers\StockItemController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['status' => 'OK']));

Route::prefix('warehouse')->name('warehouse.')->group(function () {
    Route::get('/', [StockItemController::class, 'index'])->name('index');
    Route::post('/', [StockItemController::class, 'store'])
        ->middleware('warehouse.access')
        ->name('store');
    Route::get('/{id}', [StockItemController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});
