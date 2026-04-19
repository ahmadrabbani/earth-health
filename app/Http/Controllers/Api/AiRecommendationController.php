<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AiRecommendationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'AI recommendation API endpoint is not configured for direct use in this MVP.',
        ], 404);
    }
}
