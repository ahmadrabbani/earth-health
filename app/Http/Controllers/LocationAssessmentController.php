<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationAssessmentRequest;
use App\Models\Location;
use App\Services\CarbonEstimationService;
use App\Services\GeminiService;
use App\Services\GoogleAirQualityService;
use App\Services\MiyawakiPlannerService;
use App\Services\NearbyMiyawakiSuggestionService;
use App\Services\TreeEstimationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class LocationAssessmentController extends Controller
{
    public function create()
    {
        return view('assess');
    }

    public function store(
        LocationAssessmentRequest $request,
        GoogleAirQualityService $airQualityService,
        TreeEstimationService $treeEstimationService,
        MiyawakiPlannerService $miyawakiPlannerService,
        NearbyMiyawakiSuggestionService $nearbyMiyawakiSuggestionService,
        CarbonEstimationService $carbonEstimationService,
        GeminiService $geminiService
    ): RedirectResponse {
        $data = $request->validated();

        $location = Location::create([
            'name' => $data['location_name'] ?? null,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
            'meta' => [
                'submitted_at' => now()->toDateTimeString(),
            ],
        ]);

        $areaSqM = round(pi() * ($data['radius_m'] ** 2), 2);
        $treeEstimates = $treeEstimationService->estimate($areaSqM, $data['urban_density']);
        $miyawaki = $miyawakiPlannerService->plan($areaSqM, $treeEstimates['tree_gap']);
        $nearbyCandidates = $nearbyMiyawakiSuggestionService->suggest(
            (float) $data['latitude'],
            (float) $data['longitude'],
            (int) $data['radius_m']
        );
        $annualCarbonKg = $carbonEstimationService->annualKgFromTrees((int) $miyawaki['recommended_trees']);

        $assessment = $location->assessments()->create([
            'radius_m' => $data['radius_m'],
            'area_sq_m' => $areaSqM,
            'estimated_tree_cover_percent' => $treeEstimates['tree_cover_percent'],
            'estimated_existing_trees' => $treeEstimates['existing_trees'],
            'estimated_tree_gap' => $treeEstimates['tree_gap'],
            'miyawaki_possible' => $miyawaki['miyawaki_possible'],
            'miyawaki_area_sq_m' => $miyawaki['miyawaki_area_sq_m'],
            'recommended_trees' => $miyawaki['recommended_trees'],
            'estimated_annual_carbon_kg' => $annualCarbonKg,
            'inputs' => $data,
            'calculation_breakdown' => [
                'area_sq_m' => $areaSqM,
                'tree_estimates' => $treeEstimates,
                'miyawaki' => array_merge($miyawaki, [
                    'nearby_candidates' => $nearbyCandidates,
                ]),
                'annual_carbon_kg' => $annualCarbonKg,
            ],
        ]);

        $airQuality = $this->resolveAirQuality($airQualityService, $data['latitude'], $data['longitude']);

        $snapshot = $assessment->airQualitySnapshot()->create([
            'aqi_display' => $airQuality['aqi_display'],
            'aqi_category' => $airQuality['aqi_category'],
            'aqi_value' => $airQuality['aqi_value'],
            'pm25' => $airQuality['pm25'],
            'pm10' => $airQuality['pm10'],
            'co' => $airQuality['co'],
            'no2' => $airQuality['no2'],
            'o3' => $airQuality['o3'],
            'so2' => $airQuality['so2'],
            'health_recommendations' => $airQuality['health_recommendations'],
            'raw_response' => $airQuality['raw_response'],
            'observed_at' => $airQuality['observed_at'],
        ]);

        $greenScore = $this->calculateGreenScore($airQuality, $treeEstimates);
        $assessment->update(['green_score' => $greenScore]);

        $recommendation = $this->resolveRecommendation(
            $geminiService,
            $location->name ?? ($location->city ?: 'Submitted location'),
            $assessment,
            $snapshot
        );

        $assessment->aiRecommendation()->create($recommendation);

        return redirect()->route('home')->with('status', 'Assessment complete. Scroll down for the results.');
    }

    protected function resolveAirQuality(GoogleAirQualityService $service, float $lat, float $lng): array
    {
        $snapshot = [
            'aqi_display' => 'Unavailable',
            'aqi_category' => 'Unavailable',
            'aqi_value' => null,
            'pm25' => null,
            'pm10' => null,
            'co' => null,
            'no2' => null,
            'o3' => null,
            'so2' => null,
            'health_recommendations' => [],
            'raw_response' => [],
            'observed_at' => now(),
        ];

        try {
            $response = $service->current($lat, $lng);
            $snapshot['raw_response'] = $response;
            $indexes = collect(data_get($response, 'indexes', []));
            $primaryIndex = $indexes->first(fn ($index) => data_get($index, 'code') !== 'uaqi')
                ?: $indexes->firstWhere('code', 'uaqi')
                ?: $indexes->first();
            $pollutants = collect(data_get($response, 'pollutants', []))->keyBy('code');

            $snapshot['aqi_value'] = data_get($primaryIndex, 'aqi');
            $snapshot['aqi_category'] = data_get($primaryIndex, 'category', 'Unavailable');
            $snapshot['aqi_display'] = data_get($primaryIndex, 'aqiDisplay', $snapshot['aqi_category']);
            $snapshot['pm25'] = data_get($pollutants->get('pm2_5'), 'concentration.value');
            $snapshot['pm10'] = data_get($pollutants->get('pm10'), 'concentration.value');
            $snapshot['co'] = data_get($pollutants->get('co'), 'concentration.value');
            $snapshot['no2'] = data_get($pollutants->get('no2'), 'concentration.value');
            $snapshot['o3'] = data_get($pollutants->get('o3'), 'concentration.value');
            $snapshot['so2'] = data_get($pollutants->get('so2'), 'concentration.value');
            $snapshot['health_recommendations'] = data_get($response, 'healthRecommendations', []);
            $snapshot['observed_at'] = data_get($response, 'dateTime') ? now() : now();

            if (! $snapshot['aqi_value']) {
                $snapshot['aqi_display'] = 'Unavailable';
                $snapshot['aqi_category'] = 'Unavailable';
            }
        } catch (\Throwable $exception) {
            $snapshot['raw_response'] = [
                'error' => $exception->getMessage(),
            ];
        }

        return $snapshot;
    }

    protected function aqiCategory(?float $aqi): string
    {
        if ($aqi === null) {
            return 'Unavailable';
        }

        return match (true) {
            $aqi <= 50 => 'Good',
            $aqi <= 100 => 'Moderate',
            $aqi <= 150 => 'Unhealthy for Sensitive Groups',
            $aqi <= 200 => 'Unhealthy',
            $aqi <= 300 => 'Very Unhealthy',
            default => 'Hazardous',
        };
    }

    protected function calculateGreenScore(array $snapshot, array $treeEstimates): float
    {
        $aqi = $snapshot['aqi_value'];
        $aqiScore = match (true) {
            $aqi === null => 50,
            $aqi <= 50 => 90,
            $aqi <= 100 => 75,
            $aqi <= 150 => 60,
            $aqi <= 200 => 45,
            $aqi <= 300 => 30,
            default => 15,
        };

        $treeGap = $treeEstimates['tree_gap'];
        $treeScore = max(0, 100 - min(100, $treeGap));

        return round(($aqiScore * 0.45) + ($treeScore * 0.55), 2);
    }

    protected function resolveRecommendation(GeminiService $service, string $locationName, $assessment, $snapshot): array
    {
        $facts = [
            'location_name' => $locationName,
            'aqi' => $snapshot['aqi_value'] ?? 'Unavailable',
            'aqi_category' => $snapshot['aqi_category'] ?? 'Unavailable',
            'pm25' => $snapshot['pm25'] ?? 'Unavailable',
            'pm10' => $snapshot['pm10'] ?? 'Unavailable',
            'tree_cover_percent' => $assessment->estimated_tree_cover_percent ?? 0,
            'existing_trees' => $assessment->estimated_existing_trees ?? 0,
            'tree_gap' => $assessment->estimated_tree_gap ?? 0,
            'miyawaki_possible' => $assessment->miyawaki_possible ? 'Yes' : 'No',
            'miyawaki_area_sq_m' => $assessment->miyawaki_area_sq_m ?? 0,
            'recommended_trees' => $assessment->recommended_trees ?? 0,
            'annual_carbon_kg' => $assessment->estimated_annual_carbon_kg ?? 0,
            'nearby_candidates' => collect(data_get($assessment->calculation_breakdown, 'miyawaki.nearby_candidates', []))
                ->map(fn (array $candidate) => ($candidate['name'] ?? 'Nearby site') . ' - ' . ($candidate['reason'] ?? 'Potential Miyawaki planting zone'))
                ->implode('; '),
        ];

        try {
            if (! config('services.gemini.api_key')) {
                throw new \RuntimeException('Gemini API key is not configured.');
            }

            $response = $service->recommendation($facts);
            $message = data_get($response, 'candidates.0.content.0.text', 'No recommendation returned.');

            return [
                'model' => config('services.gemini.model'),
                'summary' => Str::of($message)->limit(1000)->toString(),
                'action_plan' => Str::of($message)->limit(2000)->toString(),
                'raw_response' => $response,
            ];
        } catch (\Throwable $exception) {
            $summary = "This recommendation is an estimate based on submitted location data. Please treat it as guidance, not measurement.";
            $plan = "1. Confirm local air quality and tree cover data through verified sources.\n"
                . "2. Consider planting trees in nearby parks, schools, campuses, or hospital buffer zones that can host a small Miyawaki-friendly area.\n"
                . "3. Track progress over time and adjust planting choices based on community needs.";

            return [
                'model' => 'local-estimate',
                'summary' => $summary,
                'action_plan' => $plan,
                'raw_response' => ['error' => $exception->getMessage()],
            ];
        }
    }
}
