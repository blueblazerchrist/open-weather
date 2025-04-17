<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{

    public function current(Request $request)
    {
        $request->validate([
            'location' => 'required|string'
        ]);

        [$city, $country] = $this->parseLocation($request->input('location'));

        $apiKey = config('services.openweather.key');
        $url = 'https://api.openweathermap.org/data/2.5/weather';

        $response = Http::get($url, [
            'q' => "{$city},{$country}",
            'appid' => $apiKey,
            'units' => 'imperial',
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo obtener el clima actual'], 500);
        }

        $data = $response->json();

        return response()->json([
            'city' => "{$data['name']} ({$country})",
            'date' => now()->format('M d Y'),
            'weather' => $data['weather'][0]['description'],
            'temperature' => round($data['main']['temp'], 2) . '°F',
            'icon' => 'http://openweathermap.org/img/wn/'.$data['weather'][0]['icon'].'@2x.png'
        ]);
    }

    public function forecast(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'days' => 'nullable|integer|min:1|max:5'
        ]);

        $days = $request->input('days', 5);
        [$city, $country] = $this->parseLocation($request->input('location'));

        $apiKey = config('services.openweather.key');
        $url = 'https://api.openweathermap.org/data/2.5/forecast';

        $response = Http::get($url, [
            'q' => "{$city},{$country}",
            'appid' => $apiKey,
            'units' => 'imperial',
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo obtener
            la previsión'], 500);
        }

        $data = $response->json();

        $grouped = [];
        foreach ($data['list'] as $entry) {
            $date = date('M d Y', strtotime($entry['dt_txt']));
            if (!isset($grouped[$date])) {
                $grouped[$date] = [
                    'date' => $date,
                    'weather' => $entry['weather'][0]['description'],
                    'temperature' => round($entry['main']['temp'], 2) . '°F',
                    'icon' => 'http://openweathermap.org/img/wn/'.$entry['weather'][0]['icon'].'@2x.png'
                ];
            }
        }

        return response()->json([
            'city' => "{$data['city']['name']} ({$country})",
            'forecast' => array_slice(array_values($grouped), 0, $days)
        ]);
    }

    private function parseLocation(string $location): array
    {
        preg_match('/^(.+?)([A-Z]{2})$/', $location, $matches);
        return [trim($matches[1]), strtoupper($matches[2])];
    }
}
