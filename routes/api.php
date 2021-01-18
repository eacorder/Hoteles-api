<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RegistroController;
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

Route::middleware(['auth:api'])->group( function () {
    Route::resource('habitaciones',\Api\HabitacionController::class)->only('show','index','store','destroy');
    Route::post('habitaciones/{id}', [\App\Http\Controllers\Api\HabitacionController::class, 'update']);
    Route::resource('clientes',\Api\ClienteController::class)->only('show','index','store','destroy');
    Route::post('clientes/{id}', [\App\Http\Controllers\Api\ClienteController::class, 'update']);
    Route::resource('reservaciones',\Api\ClienteHabitacionController::class)->only('show','index','store','destroy');
    Route::post('reservaciones/{id}', [\App\Http\Controllers\Api\ClienteHabitacionController::class, 'update']);
});
