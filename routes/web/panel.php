<?php

use App\Http\Controllers\Panel\ArchiveController;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\BidController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\Setting\ApiController;
use App\Http\Controllers\Panel\Setting\ContactController;
use App\Http\Controllers\Panel\Setting\MailController;
use App\Http\Controllers\Panel\Setting\MediaController;
use App\Http\Controllers\Panel\TenderController;
use App\Http\Controllers\Panel\TenderImagesController;
use App\Http\Controllers\Panel\UserController;
use Illuminate\Support\Facades\Route;

Route::post('giris-yap', [AuthController::class, 'login'])->name('panel.login');
Route::get('giris-yap', [HomeController::class, 'loginGet'])->name('panel.login.get');

Route::middleware("adminMiddleware")->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('panel.home');

    Route::resource("contact", ContactController::class)->parameters(["contact" => "id"])->names([
        'index' => 'panel.contact.index',
        'store' => 'panel.contact.store'
    ]);

    Route::resource("api", ApiController::class)->parameters(["api" => "id"])->names([
        'index' => 'panel.api.index',
        'store' => 'panel.api.store'
    ]);

    Route::resource("mail", MailController::class)->parameters(["mail" => "id"])->names([
        'index' => 'panel.mail.index',
        'store' => 'panel.mail.store'
    ]);

    Route::resource("media", MediaController::class)->parameters(["media" => "id"])->names([
        'index' => 'panel.media.index',
        'store' => 'panel.media.store'
    ]);

    Route::resource("tender", TenderController::class)->parameters(["tender" => "id"])->names([
        'index' => 'panel.tender.index',
        'create' => 'panel.tender.create',
        'store' => 'panel.tender.store',
        'edit' => 'panel.tender.edit',
        'update' => 'panel.tender.update',
        'destroy' => 'panel.tender.destroy',
    ]);
    Route::resource("user", UserController::class)->parameters(["user" => "id"])->names([
        'index' => 'panel.user.index',
        'create' => 'panel.user.create',
        'store' => 'panel.user.store',
        'edit' => 'panel.user.edit',
        'update' => 'panel.user.update',
        'destroy' => 'panel.user.destroy',
    ]); 
    Route::resource("bid", BidController::class)->parameters(["bid" => "id"])->names([
        'index' => 'panel.bid.index',
        'create' => 'panel.bid.create',
        'store' => 'panel.bid.store',
        'edit' => 'panel.bid.edit',
        'update' => 'panel.bid.update',
        'destroy' => 'panel.bid.destroy',
    ]);
    Route::get('transfer-bids', [BidController::class, 'transferBids'])->name('panel.transferBid');

    Route::resource("archive", ArchiveController::class)->parameters(["archive" => "id"])->names([
        'index' => 'panel.archive.index',
        'show' => 'panel.archive.show',
        'destroy' => 'panel.archive.destroy',
        'edit' => 'panel.archive.edit',
        'update' => 'panel.archive.update'
    ]);
    Route::resource("tender-images", TenderImagesController::class)
        ->parameters(["tender-images" => "id"])->names([
            'update' => 'panel.tender.images.update',
            'destroy' => 'panel.tender.images.destroy',
        ])->only(["update", "destroy"]);

    Route::get('cikis-yap', [AuthController::class, 'logout'])->name('panel.logout');
});
