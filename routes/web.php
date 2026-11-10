<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockItemController;

Route::get('/health', fn () => response()->json([
    'status' => 'OK', 
    'timestamp' => now()
]));

Route::prefix('warehouse')->name('warehouse.')->group(function () {
    Route::get('/', [StockItemController::class, 'index'])->name('index');
    Route::post('/', [StockItemController::class, 'store'])->middleware('warehouse.access')->name('store');
    Route::get('/{id}', [StockItemController::class, 'show'])->whereNumber('id')->name('show');
});