<?php

use App\Http\Controllers\Panel\ArchiveController;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\TenderController;
use App\Http\Controllers\Panel\TenderImagesController;
use App\Http\Controllers\Panel\ContactController;
use Illuminate\Support\Facades\Route;

Route::post('giris-yap', [AuthController::class, 'login'])->name('panel.login');
Route::get('giris-yap', [HomeController::class, 'loginGet'])->name('panel.login.get');

Route::middleware("adminMiddleware")->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('panel.home');
    Route::resource("contact", ContactController::class)->names([
        'index' => 'panel.contact.index',
        'store'=>'panel.contact.store'
    ]);

    Route::resource("tender", TenderController::class)->parameters(["tender" => "id"])->names([
        'index' => 'panel.tender.index',
        'create' => 'panel.tender.create',
        'store' => 'panel.tender.store',
        'edit' => 'panel.tender.edit',
        'update' => 'panel.tender.update',
        'destroy' => 'panel.tender.destroy',
    ]);
    Route::resource("archive", ArchiveController::class)->parameters(["archive" => "id"])->names([
        'index' => 'panel.archive.index',
        'show' => 'panel.archive.show',
        'destroy' => 'panel.archive.destroy',
    ]);
    Route::resource("tender-images", TenderImagesController::class)
        ->parameters(["tender-images" => "id"])->names([
            'update' => 'panel.tender.images.update',
            'destroy' => 'panel.tender.images.destroy',
        ])->only(["update", "destroy"]);

    Route::get('cikis-yap', [AuthController::class, 'logout'])->name('panel.logout');
});
