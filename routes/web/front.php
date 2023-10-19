<?php

use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/giris-yap', [HomeController::class, 'login'])->name('front.login');
Route::get('/kayit-ol', [HomeController::class, 'register'])->name('front.register');
Route::get('/kurumsal', [HomeController::class, 'about'])->name('front.about');
Route::get('/iletisim', [HomeController::class, 'contact'])->name('front.contact');
