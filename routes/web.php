<?php

use Auth0\Laravel\Controllers\CallbackController as Auth0CallbackController;
use Auth0\Laravel\Controllers\LoginController as Auth0LoginController;
use Auth0\Laravel\Controllers\LogoutController as Auth0LogoutController;
use Auth0\SDK\Exception\InvalidTokenException;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationAssessmentController;
use App\Http\Controllers\Api\AirQualityController;
use App\Http\Controllers\Api\AiRecommendationController;
use App\Http\Controllers\Api\LocationSearchController;

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::middleware('web')->group(function () {
    Route::get('/login', function (\Illuminate\Http\Request $request, Auth0LoginController $controller) {
        $auth0Configured = filled(config('auth.guards.auth0-session'))
            && filled(config('auth0.guards.default.domain'))
            && filled(config('auth0.guards.default.clientId'))
            && filled(config('auth0.guards.default.clientSecret'));

        if (! $auth0Configured) {
            return redirect()
                ->route('home')
                ->with('status', 'Auth0 is not configured for this environment yet.');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $controller($request);
    })->name('login');

    Route::get('/callback', function (\Illuminate\Http\Request $request, Auth0CallbackController $controller) {
        try {
            return $controller($request);
        } catch (InvalidTokenException $exception) {
            report($exception);

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('status', 'Your login session expired. Please try signing in again.');
        }
    })->name('callback');

    Route::get('/logout', function (\Illuminate\Http\Request $request, Auth0LogoutController $controller) {
        return $controller($request);
    })->name('logout');
});

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
