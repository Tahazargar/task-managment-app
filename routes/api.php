<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('users')->middleware('auth:sanctum')->group(function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('/search', [UserController::class, 'search']);
    Route::get('/stats', [UserController::class, 'stats']);

    Route::get('/email/{email}', [UserController::class, 'findByEmail']);
    Route::get('/phone/{phone}', [UserController::class, 'findByPhone']);

    Route::get('/{uuid}', [UserController::class, 'show']);
    Route::get('/{uuid}/exists', [UserController::class, 'exists']);

    Route::post('/', [UserController::class, 'store']);
    Route::put('/{uuid}', [UserController::class, 'update']);

    Route::delete('/{uuid}', [UserController::class, 'destroy']);

    Route::post('/{uuid}/restore', [UserController::class, 'restore']);
    Route::delete('/{uuid}/force', [UserController::class, 'forceDelete']);
});
