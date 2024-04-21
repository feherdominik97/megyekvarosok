<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(CountyController::class)->group(function () {
    Route::get('/counties', 'index');
    Route::get('/counties/{id}/cities', 'getCitiesOfCounty');
});

Route::controller(CityController::class)->group(function () {
    Route::prefix('cities')->group(function () {
        Route::post('', 'store');
        Route::prefix('{id}')->group(function (){
            Route::get('', 'show');
            Route::post('', 'update');
            Route::delete('', 'destroy');
        });
    });
});

