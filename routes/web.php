<?php

declare(strict_types=1);

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json([
    'status' => 'OK',
    'timestamp' => now(),
]));

Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::post('/', [BookController::class, 'store'])->middleware('product.access')->name('store');
    Route::get('/{id}', [BookController::class, 'show'])->whereNumber('id')->name('show');
});
