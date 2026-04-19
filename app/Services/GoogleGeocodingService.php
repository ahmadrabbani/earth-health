<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleGeocodingService
{
    public function search(string $query): array
    {
        $apiKey = config('services.google.maps_key');

        if (empty($apiKey)) {
            throw new \RuntimeException('Google Maps API key is not configured.');
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $query,
            'key' => $apiKey,
        ]);

        $response->throw();

        $payload = $response->json();

        if (($payload['status'] ?? null) !== 'OK') {
            return [];
        }

        return collect($payload['results'] ?? [])
            ->take(5)
            ->map(fn (array $result) => $this->transformResult($result))
            ->values()
            ->all();
    }

    protected function transformResult(array $result): array
    {
        $components = collect($result['address_components'] ?? []);

        $findComponent = function (array $types) use ($components): ?string {
            return optional(
                $components->first(fn (array $component) => count(array_intersect($types, $component['types'] ?? [])) > 0)
            )['long_name'] ?? null;
        };

        $area = $findComponent(['sublocality', 'sublocality_level_1', 'neighborhood', 'route', 'premise'])
            ?? $findComponent(['locality'])
            ?? ($result['formatted_address'] ?? null);

        $city = $findComponent(['locality', 'postal_town', 'administrative_area_level_2'])
            ?? $findComponent(['administrative_area_level_1']);

        return [
            'display_name' => $result['formatted_address'] ?? 'Unknown location',
            'location_name' => $area,
            'city' => $city,
            'country' => $findComponent(['country']),
            'latitude' => data_get($result, 'geometry.location.lat'),
            'longitude' => data_get($result, 'geometry.location.lng'),
            'urban_density' => $this->inferUrbanDensity($result),
        ];
    }

    protected function inferUrbanDensity(array $result): string
    {
        $types = $result['types'] ?? [];

        if (array_intersect($types, ['street_address', 'premise', 'subpremise', 'intersection', 'route'])) {
            return 'high';
        }

        if (array_intersect($types, ['neighborhood', 'sublocality', 'locality', 'postal_town'])) {
            return 'medium';
        }

        return 'low';
    }
}
