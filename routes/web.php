<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('savings')->name('savings.')->group(function () {
        Route::post('/', [StudentDashboardController::class, 'store'])->name('store');
        Route::get('/{saving}/confirm', [StudentDashboardController::class, 'confirm'])->name('confirm');
        Route::post('/{saving}/upload-proof', [StudentDashboardController::class, 'uploadProof'])->name('upload-proof');
        Route::get('/{saving}/receipt', [StudentDashboardController::class, 'downloadReceipt'])->name('receipt');
        Route::delete('/{saving}', [StudentDashboardController::class, 'cancel'])->name('cancel');
        Route::delete('/{saving}/delete', [StudentDashboardController::class, 'delete'])->name('delete');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
