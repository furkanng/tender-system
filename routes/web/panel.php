<?php

use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\TenderController;
use Illuminate\Support\Facades\Route;

Route::post('giris-yap', [AuthController::class, 'login'])->name('panel.login');
Route::get('giris-yap', [HomeController::class, 'loginGet'])->name('panel.login.get');

Route::middleware("adminMiddleware")->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('panel.home');
    Route::resource("tender", TenderController::class)->parameters(["tender" => "id"])->names([
        'index' => 'panel.tender.index',
        'create' => 'panel.tender.create',
        'store' => 'panel.tender.store',
        'show' => 'panel.tender.show',
        'edit' => 'panel.tender.edit',
        'update' => 'panel.tender.update',
        'destroy' => 'panel.tender.destroy',
    ]);
    Route::get('cikis-yap', [AuthController::class, 'logout'])->name('panel.logout');
});
