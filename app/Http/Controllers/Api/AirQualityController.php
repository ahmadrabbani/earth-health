<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AirQualityController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Air quality API endpoint is not configured for direct use in this MVP.',
        ], 404);
    }
}
