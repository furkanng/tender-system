<?php

use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/giris-yap', [HomeController::class, 'login'])->name('front.login');
Route::get('/kayit-ol', [HomeController::class, 'register'])->name('front.register');
Route::get('/kurumsal', [HomeController::class, 'about'])->name('front.about');
Route::get('/iletisim', [HomeController::class, 'contact'])->name('front.contact');

Route::post('/kayit', [HomeController::class, 'storeContact'])->name('front.contact.store');

Route::get("autogong-getcars", function () {
   (new \App\Service\Autogong\AutogongService())->allCarsGet();
});

Route::get("autogong-getarchive", function () {
    (new \App\Service\Autogong\AutogongService())->getArchives();
});

Route::get("otopert-getcars", function () {
    (new \App\Service\Otopert\OtopertService())->getAllCarsLite();
});

Route::get("otopert-getarchive", function () {
    (new \App\Service\Otopert\OtopertService())->getArchiveData();
});

Route::get("sovtajyeri-getcars", function () {
    (new \App\Service\SovtajYeri\SovtajyeriService())->AllCarsGet();
});

Route::get("sovtajyeri-getarchive", function () {
    (new \App\Service\SovtajYeri\SovtajyeriService())->AllArchivesGet();
});

Route::get("run-queue", function () {
    Artisan::call('queue:work --max-time=3600');
});
