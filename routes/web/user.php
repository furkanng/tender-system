<?php

use App\Http\Controllers\User\ArchiveController;
use App\Http\Controllers\User\BidController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\TenderController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('kayit-ol', [AuthController::class, 'register'])->name('user.register');
Route::post('giris-yap', [AuthController::class, 'login'])->name('user.login');
Route::post('sifremi-unuttum', [AuthController::class, 'forgotPassword'])->name('user.forgot');
Route::get('sifremi-unuttum', [AuthController::class, 'forgotPasswordGet'])->name('user.forgot.get');
Route::get('sifre-yenileme', [AuthController::class, 'resetPasswordGet'])->name('user.reset.get');
Route::post('sifre-yenileme', [AuthController::class, 'resetPassword'])->name('user.reset');

Route::middleware("userMiddleware")->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('user.home');

    Route::middleware("UserCredentialsMiddleware")->group(function (){
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

        Route::resource("archive", ArchiveController::class)->parameters(["archive" => "id"])->names([
            'index' => 'user.archive.index',
            'show' => 'user.archive.show',
            'create' => 'user.archive.create',
            'store' => 'user.archive.store',
            'edit' => 'user.archive.edit',
            'update' => 'user.archive.update',
            'destroy' => 'user.archive.destroy',
        ]);
    });



    Route::resource("profile", UserController::class)->parameters(["profile" => "id"])->names([
        'index' => 'user.profile.index',
        'update' => 'user.profile.update',
        'destroy' => 'user.profile.destroy',
    ]);


    Route::resource("support", SupportController::class)->parameters(["support" => "id"])->names([
        'index' => 'user.support.index',
        'create' => 'user.support.create',
        'show' => 'user.support.show',
        'update' => 'user.support.update',
        'store' => 'user.support.store',
        'destroy' => 'user.support.destroy',
    ]);

    Route::get('cikis-yap', [AuthController::class, 'logout'])->name('user.logout');
});


