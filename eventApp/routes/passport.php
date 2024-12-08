<?php

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
    // Token oluşturma (login)
    Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])
        ->middleware(['throttle']);

    // Yetkilendirme
    Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize'])
        ->middleware(['auth']);

    // Geçici token alma
    Route::post('/oauth/token/refresh', [TransientTokenController::class, 'refresh']);
});
