<?php

use App\Http\Controllers\User\BidController;
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
    Route::resource("bid", BidController::class)->parameters(["bid" => "id"])->names([
        'index' => 'user.bid.index',
        'show' => 'user.bid.show',
        'create' => 'user.bid.create',
        'store' => 'user.bid.store',
        'edit' => 'user.bid.edit',
        'update' => 'user.bid.update',
        'destroy' => 'user.bid.destroy',
    ]);


    Route::get('cikis-yap', [AuthController::class, 'logout'])->name('user.logout');
});


