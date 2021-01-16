<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\HabitacionController;
use App\Http\Controllers\API\RegistroController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [RegistroController::class, 'registro']);
Route::post('login', [RegistroController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::resource('habitaciones', HabitacionController::class);
});
