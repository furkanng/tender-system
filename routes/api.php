<?php

use App\Mail\ErrorMail;
use App\Service\Autogong\AutogongService;
use App\Service\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("test", function (Request $request) {

    #(new \App\Service\Autogong\AutogongService())->allCarsSave();
    #(new \App\Service\Autogong\AutogongService())->getTender();
    #(new \App\Service\Autogong\AutogongService())->archiveSave();


    (new \App\Service\Otopert\OtopertService())->getAllCarsLite();
    #(new \App\Service\Otopert\OtopertService())->getArchiveData();

});
