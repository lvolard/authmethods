<?php

namespace App\Twig;

use App\Service\OpenWeatherService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WeatherExtension extends AbstractExtension
{
    private OpenWeatherService $weatherService;

    public function __construct(OpenWeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_weather', [$this, 'getWeather']),
        ];
    }

    public function getWeather(string $city): array
    {
        return $this->weatherService->getWeather($city);
    }
}