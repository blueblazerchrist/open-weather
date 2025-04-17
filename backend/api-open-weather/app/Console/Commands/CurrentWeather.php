<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class CurrentWeather extends Command
{
    protected $signature = 'current {location}';
    protected $description = 'Consulta el clima actual';

    public function handle(WeatherService $weather)
    {
        $location = $this->argument('location');
        preg_match('/^(.+?)([A-Z]{2})$/', $location, $matches);

        if (!$matches) {
            $this->error('Formato inválido. Usa: CiudadPA');
            return;
        }

        [$_, $city, $country] = $matches;
        $data = $weather->getCurrent($city, $country);

        if (!isset($data['main'])) {
            $this->error('No se pudo obtener información.');
            return;
        }

        $this->info("📍 {$data['name']} ({$country})");
        $this->line("📅 " . now()->format('M d Y'));
        $this->line("☁️  {$data['weather'][0]['description']}");
        $this->line("🌡️  {$data['main']['temp']}°F");
    }
}

