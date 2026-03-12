<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/cities', [CityController::class, 'index'])->name('cities');
Route::post('/city/{city}', [CityController::class, 'confirm'])->name('city.confirm');
Route::get('/city/{city}', [CityController::class, 'show'])->name('city.show');
