<?php

// app/Services/WeatherService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherInfo($dueDate, $latitude, $longitude)
    {
        // Generate a unique cache key based on the due date and location
        $cacheKey = 'weather_' . $dueDate->format('Ymd') . '_' . $latitude . '_' . $longitude;

        // Check if weather information is already cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Replace 'your-api-key' with your actual OpenWeatherMap API key
        $apiKey = 'd3d9d422021c3dc4f0cfc6ae8b31b3b9';

        // Assuming $dueDate is a DateTime object
        $formattedDueDate = $dueDate->format('Y-m-d');

        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $apiKey,
        ]);

        $weatherInfo = null;

        if ($response->successful()) {
            $weatherInfo = $response->json();
        }

        // Cache the weather information for 24 hours (adjust as needed)
        Cache::put($cacheKey, $weatherInfo, 60 * 24);

        return $weatherInfo;
    }
}
