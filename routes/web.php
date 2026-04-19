<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationAssessmentController;
use App\Http\Controllers\Api\AirQualityController;
use App\Http\Controllers\Api\AiRecommendationController;
use App\Http\Controllers\Api\LocationSearchController;

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('/assess', [LocationAssessmentController::class, 'create'])
    ->name('assess.location');

Route::post('/assess', [LocationAssessmentController::class, 'store'])
    ->name('assess.location.store');

Route::get('/community', [CommunityController::class, 'index'])
    ->name('community.index');

Route::middleware('auth:auth0-session')->group(function () {
    Route::post('/community/posts', [CommunityController::class, 'store'])
        ->name('community.posts.store');

    Route::post('/community/posts/{post}/comments', [CommunityController::class, 'comment'])
        ->name('community.comments.store');
});

Route::prefix('api')->group(function () {
    Route::post('/air-quality', [AirQualityController::class, 'show']);
    Route::post('/ai-recommendation', [AiRecommendationController::class, 'store']);
    Route::get('/location-search', [LocationSearchController::class, 'index']);
});
