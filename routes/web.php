<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function ($city = 'moscow') {
    $coordinates = config('app.cities.'.$city);

    $response = Http::get('https://api.openweathermap.org/data/2.5/weather?id='.$coordinates['id'].'&lang=ru&appid='.env('OPEN_WEATHER_MAP_ID').'&units=metric');

    return view('index', ['data' => $response->json()]);
});
