<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\WeatherController;


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

Route::prefix('v1')->group(function () {
    Route::resource('city', CityController::class);
    Route::get('weather/{city}', [WeatherController::class, 'index']);
    Route::get('weather/five-days/{city}', [WeatherController::class, 'fiveDaysWeather']);
});