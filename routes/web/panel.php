<?php

use App\Http\Controllers\Panel\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('panel.user.home');
