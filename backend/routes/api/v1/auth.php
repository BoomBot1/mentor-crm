<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/send-code', 'sendCode');
        Route::post('/refresh', 'refresh');
        Route::post('/login', 'login');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/logout', 'logout');
        });
    });
