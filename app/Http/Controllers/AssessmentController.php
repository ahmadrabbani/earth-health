<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Assessment;
use App\Models\AirQualitySnapshot;
use App\Models\AiRecommendation;
use App\Services\GoogleAirQualityService;
use App\Services\TreeEstimationService;
use App\Services\MiyawakiPlannerService;
use App\Services\CarbonEstimationService;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class LocationAssessmentController extends Controller
{
    public function store(
        Request $request,
        GoogleAirQualityService $airQualityService,
        TreeEstimationService $treeService,
        MiyawakiPlannerService $miyawakiService,
        CarbonEstimationService $carbonService,
        GeminiService $geminiService
    ) {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'radius_m' => ['nullable', 'integer', 'min:100', 'max:5000'],
            'urban_density' => ['nullable', 'in:high,medium,low'],
        ]);

        $radius = $validated['radius_m'] ?? 500;
        $areaSqM = pi() * ($radius ** 2);

        $location = Location::create([
            'name' => $validated['name'] ?? null,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        $aq = $airQualityService->current($location->latitude, $location->longitude);

        $tree = $treeService->estimate($areaSqM, $validated['urban_density'] ?? 'medium');
        $miyawaki = $miyawakiService->plan($areaSqM, $tree['tree_gap']);
        $annualCarbon = $carbonService->annualKgFromTrees($miyawaki['recommended_trees']);

        $assessment = Assessment::create([
            'location_id' => $location->id,
            'radius_m' => $radius,
            'area_sq_m' => $areaSqM,
            'estimated_tree_cover_percent' => $tree['tree_cover_percent'],
            'estimated_existing_trees' => $tree['existing_trees'],
            'estimated_tree_gap' => $tree['tree_gap'],
            'miyawaki_possible' => $miyawaki['miyawaki_possible'],
            'miyawaki_area_sq_m' => $miyawaki['miyawaki_area_sq_m'],
            'recommended_trees' => $miyawaki['recommended_trees'],
            'estimated_annual_carbon_kg' => $annualCarbon,
            'green_score' => max(0, min(100, 100 - (($aq['indexes'][0]['aqi'] ?? 50) * 0.6) + ($tree['tree_cover_percent'] * 1.2))),
            'inputs' => $validated,
            'calculation_breakdown' => [
                'tree' => $tree,
                'miyawaki' => $miyawaki,
                'annual_carbon_kg' => $annualCarbon,
            ],
        ]);

        AirQualitySnapshot::create([
            'assessment_id' => $assessment->id,
            'aqi_display' => $aq['indexes'][0]['displayName'] ?? null,
            'aqi_category' => $aq['indexes'][0]['category'] ?? null,
            'aqi_value' => $aq['indexes'][0]['aqi'] ?? null,
            'raw_response' => $aq,
            'observed_at' => now(),
        ]);

        $facts = [
            'location_name' => $location->name ?? 'Selected location',
            'aqi' => $aq['indexes'][0]['aqi'] ?? 'N/A',
            'aqi_category' => $aq['indexes'][0]['category'] ?? 'N/A',
            'pm25' => data_get($aq, 'pollutants.0.concentration.value', 'N/A'),
            'pm10' => data_get($aq, 'pollutants.1.concentration.value', 'N/A'),
            'tree_cover_percent' => $tree['tree_cover_percent'],
            'existing_trees' => $tree['existing_trees'],
            'tree_gap' => $tree['tree_gap'],
            'miyawaki_possible' => $miyawaki['miyawaki_possible'] ? 'Yes' : 'No',
            'miyawaki_area_sq_m' => $miyawaki['miyawaki_area_sq_m'],
            'recommended_trees' => $miyawaki['recommended_trees'],
            'annual_carbon_kg' => $annualCarbon,
        ];

        $ai = $geminiService->recommendation($facts);

        AiRecommendation::create([
            'assessment_id' => $assessment->id,
            'model' => config('services.gemini.model'),
            'summary' => data_get($ai, 'candidates.0.content.parts.0.text'),
            'action_plan' => data_get($ai, 'candidates.0.content.parts.0.text'),
            'raw_response' => $ai,
        ]);

        return redirect()->back()->with('success', 'Assessment generated.');
    }
}
