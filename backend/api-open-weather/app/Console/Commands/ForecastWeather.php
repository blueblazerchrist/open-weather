<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class ForecastWeather extends Command
{
    protected $signature = 'forecast {location} {--days=5}';
    protected $description = 'Consulta la previsión del clima (máx. 5 días)';

    public function handle(WeatherService $weather)
    {
        $location = $this->argument('location');
        $days = min((int) $this->option('days'), 5);

        preg_match('/^(.+?)([A-Z]{2})$/', $location, $matches);

        if (!$matches) {
            $this->error('Formato inválido. Usa: CiudadPA');
            return;
        }

        [$_, $city, $country] = $matches;
        $data = $weather->getForecast($city, $country);

        if (!isset($data['list'])) {
            $this->error('No se pudo obtener la previsión.');
            return;
        }

        $this->info("📍 {$data['city']['name']} ({$country})");
        $grouped = [];

        foreach ($data['list'] as $item) {
            $date = date('M d Y', strtotime($item['dt_txt']));
            if (!isset($grouped[$date])) {
                $grouped[$date] = [
                    'desc' => $item['weather'][0]['description'],
                    'temp' => round($item['main']['temp'], 2)
                ];
            }
        }

        foreach (array_slice($grouped, 0, $days) as $date => $info) {
            $this->line("📅 {$date} → ☁️ {$info['desc']}, 🌡️ {$info['temp']}°F");
        }
    }
}
