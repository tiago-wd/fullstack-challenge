<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherService
{
    protected $client;
    protected $apiKey;
    protected $cacheDuration;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.openweathermap.base_url'),
        ]);
        $this->apiKey = config('services.openweathermap.api_key');
        $this->cacheDuration = config('cache.duration');
    }

    public function getWeatherData($latitude, $longitude)
    {
        $cacheKey = 'weather-' . $latitude . '-' . $longitude;
        if (\Cache::has($cacheKey)) {
            $data = \Cache::get($cacheKey);
        } else {
            $data = $this->updateCachedWeather($latitude, $longitude);
        }
        return json_decode($data, true);
    }

    public function updateCachedWeather($latitude, $longitude)
    {
        $cacheKey = 'weather-' . $latitude . '-' . $longitude;
        $response = $this->client->get('weather', [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ],
        ]);
        $data = $response->getBody()->getContents();
        \Cache::put($cacheKey, $data, $this->cacheDuration);
        return $data;
    }
}