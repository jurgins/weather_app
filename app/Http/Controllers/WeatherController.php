<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{
    public function __invoke($city)
    {
        $coordinates = config('app.cities.'.$city);

        return Cache::remember('city' . $city, 60 * 5, function() use ($coordinates) {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather?id='.$coordinates['id'].'&lang=ru&appid='.env('OPEN_WEATHER_MAP_ID').'&units=metric');

            if($response->successful()) {
                return $response->json();
            }

            return $response->json([]);
        });
    }
}
