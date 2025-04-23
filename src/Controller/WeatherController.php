<?php

namespace App\Controller;

use App\Service\OpenWeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'weather')]
    public function index(OpenWeatherService $weatherService, string $city = 'Paris'): Response
    {
        $weather = $weatherService->getWeather($city);

        return $this->render('weather/index.html.twig', [
            'city' => $city,
            'weather' => $weather,
        ]);
    }
}