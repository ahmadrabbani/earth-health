<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleAirQualityService
{
    public function current(float $lat, float $lng): array
    {
        $apiKey = config('services.google.air_quality_key') ?: config('services.google.maps_key');

        if (empty($apiKey)) {
            throw new \RuntimeException('Google Air Quality or Maps API key is not configured.');
        }

        $url = 'https://airquality.googleapis.com/v1/currentConditions:lookup';

        $payload = [
            'location' => [
                'latitude' => $lat,
                'longitude' => $lng,
            ],
            'universalAqi' => true,
            'extraComputations' => [
                'LOCAL_AQI',
                'POLLUTANT_CONCENTRATION',
                'HEALTH_RECOMMENDATIONS',
            ],
        ];

        $response = Http::withHeaders([
            'X-Goog-Api-Key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        $response->throw();

        return $response->json();
    }
}
