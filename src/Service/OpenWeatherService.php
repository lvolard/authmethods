<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

class OpenWeatherService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getWeather(string $city): array
    {
        try {
            $response = $this->client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
                'query' => [
                    'q'     => $city,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                    'lang'  => 'fr',
                ],
            ]);

            $data = $response->toArray();

            return [
                'city'        => $data['name'] ?? $city,
                'temperature' => round($data['main']['temp'] ?? 0),
                'description' => ucfirst($data['weather'][0]['description'] ?? 'Inconnu'),
                'icon'        => $data['weather'][0]['icon'] ?? null,
            ];
        } catch (
            TransportExceptionInterface |
            ClientExceptionInterface |
            ServerExceptionInterface |
            RedirectionExceptionInterface $e
        ) {
            // Tu peux loguer l'erreur ici si besoin (logger service)
            return [
                'city'        => $city,
                'temperature' => null,
                'description' => 'Météo indisponible',
                'icon'        => null,
            ];
        }
    }
}