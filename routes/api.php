<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SavingsStatisticsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/savings/statistics', [SavingsStatisticsController::class, 'index']);
    Route::get('/savings/class-progress', [SavingsStatisticsController::class, 'classProgress'])
        ->middleware('role:bendahara,panitia');
});
