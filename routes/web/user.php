<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\TenderController;
use Illuminate\Support\Facades\Route;

Route::post('kayit-ol', [AuthController::class, 'register'])->name('user.register');
Route::post('giris-yap', [AuthController::class, 'login'])->name('user.login');

Route::middleware("userMiddleware")->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('user.home');
    Route::resource("tender", TenderController::class)->parameters(["tender" => "id"])->names([
        'index' => 'user.tender.index',
        'show' => 'user.tender.show',
    ]);


    Route::get('cikis-yap', [AuthController::class, 'logout'])->name('user.logout');
});


