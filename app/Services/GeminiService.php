<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function recommendation(array $facts): array
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (empty($apiKey) || empty($model)) {
            throw new \RuntimeException('Gemini API configuration is not available.');
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $prompt = $this->buildPrompt($facts);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url . '?key=' . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.3,
                'maxOutputTokens' => 700,
            ],
        ]);

        $response->throw();

        return $response->json();
    }

    protected function buildPrompt(array $facts): string
    {
        return <<<PROMPT
You are an environmental planning assistant.

Use only the facts below. Do not invent measurements.
Write:
1. A short summary for a normal user
2. A Miyawaki forest suggestion if suitable
3. A 3-step local action plan
4. A short disclaimer that these are estimates

Facts:
- Location: {$facts['location_name']}
- AQI: {$facts['aqi']}
- AQI category: {$facts['aqi_category']}
- PM2.5: {$facts['pm25']}
- PM10: {$facts['pm10']}
- Current tree cover estimate: {$facts['tree_cover_percent']}%
- Estimated existing trees: {$facts['existing_trees']}
- Estimated tree gap: {$facts['tree_gap']}
- Miyawaki possible: {$facts['miyawaki_possible']}
- Suggested Miyawaki area: {$facts['miyawaki_area_sq_m']} sq m
- Recommended trees: {$facts['recommended_trees']}
- Estimated annual carbon capture: {$facts['annual_carbon_kg']} kg
- Nearby Miyawaki candidate places: {$facts['nearby_candidates']}

Keep the tone practical and concise.
PROMPT;
    }
}
