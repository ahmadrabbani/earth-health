<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoogleGeocodingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationSearchController extends Controller
{
    public function index(Request $request, GoogleGeocodingService $geocodingService): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        if ($query === '') {
            return response()->json([
                'message' => 'Query is required.',
                'results' => [],
            ], 422);
        }

        try {
            return response()->json([
                'results' => $geocodingService->search($query),
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Location search is unavailable.',
                'results' => [],
            ], 503);
        }
    }
}
