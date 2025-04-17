<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/weather/current', [WeatherController::class, 'current']);
Route::post('/weather/forecast', [WeatherController::class, 'forecast']);
