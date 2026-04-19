<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AiRecommendation;
use App\Models\CommunityComment;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tablesReady = Schema::hasTable('assessments') && Schema::hasTable('ai_recommendations');

        $latestAssessment = null;
        $stats = [
            'total_assessments' => 0,
            'total_recommendations' => 0,
            'total_recommended_trees' => 0,
            'average_green_score' => null,
        ];
        $recentRecommendations = collect();
        $communityPreview = collect();
        $communityStats = [
            'posts' => 0,
            'comments' => 0,
            'contributors' => 0,
        ];
        $communityReady = Schema::hasTable('community_posts') && Schema::hasTable('community_comments');

        if ($tablesReady) {
            $latestAssessment = Assessment::with([
                'location',
                'airQualitySnapshot',
                'greeningScenarios',
                'aiRecommendation',
            ])->latest()->first();

            $stats = [
                'total_assessments' => Assessment::count(),
                'total_recommendations' => AiRecommendation::count(),
                'total_recommended_trees' => (int) Assessment::sum('recommended_trees'),
                'average_green_score' => Assessment::whereNotNull('green_score')->avg('green_score'),
            ];

            $recentRecommendations = AiRecommendation::query()
                ->with('assessment.location')
                ->whereNotNull('summary')
                ->latest()
                ->take(3)
                ->get();
        }

        if ($communityReady) {
            $communityPreview = CommunityPost::query()
                ->withCount('comments')
                ->latest()
                ->take(3)
                ->get();

            $communityStats = [
                'posts' => CommunityPost::count(),
                'comments' => CommunityComment::count(),
                'contributors' => CommunityPost::distinct('auth0_user_id')->count('auth0_user_id'),
            ];
        }

        return view('welcome', [
            'latestAssessment' => $latestAssessment,
            'stats' => $stats,
            'recentRecommendations' => $recentRecommendations,
            'tablesReady' => $tablesReady,
            'communityPreview' => $communityPreview,
            'communityStats' => $communityStats,
            'communityReady' => $communityReady,
        ]);
    }
}
