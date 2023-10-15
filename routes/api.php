<?php

use App\Http\Controllers\beritaController;
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




Route::get('beritas', [beritaController::class, 'index']);




Route::resource('berita', beritaController::class);

use App\Http\Controllers\AuthController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class ,'login']);
    Route::post('logout', [AuthController::class , 'logout']);
    Route::post('refresh',[AuthController::class , 'refresh'] );
    Route::post('me', [AuthController::class , 'me']);
    Route::post('beritas', [beritaController::class, 'store']);
    Route::put('beritas/{id}', [beritaController::class, 'update']);
    Route::delete('beritas/{id}', [beritaController::class, 'destroy']);
    Route::get('beritas', [beritaController::class, 'index']);

});


use App\Http\Controllers\Auth\RegisterController;

Route::post('register', [RegisterController::class, 'register']);
