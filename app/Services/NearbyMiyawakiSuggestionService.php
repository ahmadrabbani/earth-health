<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class NearbyMiyawakiSuggestionService
{
    public function suggest(float $lat, float $lng, int $radiusM): array
    {
        $apiKey = config('services.google.maps_key');

        if (empty($apiKey)) {
            return [];
        }

        $radius = max(500, min($radiusM, 3000));
        $typePlans = [
            'park' => 'Use park edges, buffer strips, or underused green pockets for dense native planting.',
            'school' => 'Use school boundaries and open setbacks to create educational micro-forests.',
            'university' => 'Use campus edges, side lawns, and institutional green belts for Miyawaki plots.',
            'hospital' => 'Use hospital perimeter greens for air quality buffers and shaded recovery spaces.',
        ];

        $candidates = collect();

        foreach ($typePlans as $placeType => $reason) {
            try {
                $response = Http::withHeaders([
                    'X-Goog-Api-Key' => $apiKey,
                    'X-Goog-FieldMask' => 'places.displayName,places.formattedAddress,places.primaryType',
                    'Content-Type' => 'application/json',
                ])->post('https://places.googleapis.com/v1/places:searchNearby', [
                    'includedTypes' => [$placeType],
                    'maxResultCount' => 2,
                    'locationRestriction' => [
                        'circle' => [
                            'center' => [
                                'latitude' => $lat,
                                'longitude' => $lng,
                            ],
                            'radius' => (float) $radius,
                        ],
                    ],
                    'rankPreference' => 'DISTANCE',
                ]);

                if (! $response->successful()) {
                    continue;
                }

                $places = collect($response->json('places', []))
                    ->map(fn (array $place) => [
                        'name' => data_get($place, 'displayName.text'),
                        'address' => data_get($place, 'formattedAddress'),
                        'type' => data_get($place, 'primaryType', $placeType),
                        'reason' => $reason,
                    ])
                    ->filter(fn (array $place) => filled($place['name']) || filled($place['address']));

                $candidates = $candidates->merge($places);
            } catch (\Throwable $exception) {
                continue;
            }
        }

        return $candidates
            ->unique(fn (array $candidate) => strtolower(($candidate['name'] ?? '') . '|' . ($candidate['address'] ?? '')))
            ->take(4)
            ->values()
            ->all();
    }
}
