<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/counties', [CountyController::class, 'index']);
Route::get('/county/{id}/cities', [CountyController::class, 'getCitiesOfCounty']);
Route::post('/city', [CityController::class, 'store']);
Route::post('/city', [CityController::class, 'update']);
Route::delete('/city', [CityController::class, 'destroy']);
