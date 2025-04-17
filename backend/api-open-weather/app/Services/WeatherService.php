<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    public function getCurrent(string $city, string $country): array
    {
        $res = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => "{$city},{$country}",
            'appid' => $this->apiKey,
            'units' => 'imperial',
        ]);

        return $res->json();
    }

    public function getForecast(string $city, string $country): array
    {
        $res = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
            'q' => "{$city},{$country}",
            'appid' => $this->apiKey,
            'units' => 'imperial',
        ]);

        return $res->json();
    }
}
