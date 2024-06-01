<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("test", function (Request $request) {

    #(new \App\Service\Autogong\AutogongService())->allCarsGet();
    #(new \App\Service\Autogong\AutogongService())->getArchives();

    #(new \App\Service\Otopert\OtopertService())->getAllCarsLite();
    #(new \App\Service\Otopert\OtopertService())->getArchiveData();

    #(new \App\Service\SovtajYeri\SovtajyeriService())->AllCarsGet();
    #(new \App\Service\SovtajYeri\SovtajyeriService())->AllArchivesGet();
});
