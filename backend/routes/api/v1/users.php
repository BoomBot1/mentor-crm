<?php

use App\Http\Controllers\Api\v1\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->controller(UserController::class)
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/my-account', 'getAccount');
    });
