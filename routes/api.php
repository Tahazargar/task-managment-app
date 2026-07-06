<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/stats', [UserController::class, 'stats']);

    Route::get('/email/{email}', [UserController::class, 'findByEmail'])->name('findByEmail');
    Route::get('/phone/{phone}', [UserController::class, 'findByPhone'])->name('findByPhone');

    Route::get('/{uuid}', [UserController::class, 'show'])->name('api.users.show');
    Route::get('/{uuid}/exists', [UserController::class, 'exists'])->name('api.users.exists');

    Route::post('/', [UserController::class, 'store']);
    Route::put('/{uuid}', [UserController::class, 'update']);

    Route::delete('/{uuid}', [UserController::class, 'destroy']);

    Route::post('/{uuid}/restore', [UserController::class, 'restore']);
    Route::delete('/{uuid}/force', [UserController::class, 'forceDelete']);
});
