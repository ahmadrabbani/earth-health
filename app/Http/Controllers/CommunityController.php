<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunityCommentRequest;
use App\Http\Requests\StoreCommunityPostRequest;
use App\Models\CommunityComment;
use App\Models\CommunityPost;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $tablesReady = Schema::hasTable('community_posts') && Schema::hasTable('community_comments');
        $auth0Configured = $this->auth0Configured();
        $communityUser = $auth0Configured ? auth('auth0-session')->user() : null;

        $posts = collect();
        $stats = [
            'posts' => 0,
            'comments' => 0,
            'contributors' => 0,
        ];

        if ($tablesReady) {
            $posts = CommunityPost::query()
                ->with(['comments'])
                ->withCount('comments')
                ->latest()
                ->paginate(8);

            $stats = [
                'posts' => CommunityPost::count(),
                'comments' => CommunityComment::count(),
                'contributors' => CommunityPost::distinct('auth0_user_id')->count('auth0_user_id'),
            ];
        }

        return view('community.index', [
            'posts' => $posts,
            'stats' => $stats,
            'tablesReady' => $tablesReady,
            'auth0Configured' => $auth0Configured,
            'communityUser' => $communityUser,
        ]);
    }

    public function store(StoreCommunityPostRequest $request): RedirectResponse
    {
        $user = $this->currentUser();

        CommunityPost::create([
            'auth0_user_id' => (string) auth('auth0-session')->id(),
            'author_name' => $this->displayName($user),
            'author_email' => $user?->email,
            'title' => $request->string('title')->toString(),
            'location_name' => $request->filled('location_name') ? $request->string('location_name')->toString() : null,
            'body' => $request->string('body')->toString(),
        ]);

        return redirect()
            ->route('community.index')
            ->with('community_status', 'Your community post is now live.');
    }

    public function comment(StoreCommunityCommentRequest $request, CommunityPost $post): RedirectResponse
    {
        $user = $this->currentUser();

        $post->comments()->create([
            'auth0_user_id' => (string) auth('auth0-session')->id(),
            'author_name' => $this->displayName($user),
            'author_email' => $user?->email,
            'body' => $request->string('body')->toString(),
        ]);

        return redirect()
            ->to(route('community.index') . '#post-' . $post->id)
            ->with('community_status', 'Your reply has been added to the discussion.');
    }

    protected function currentUser(): ?Authenticatable
    {
        return auth('auth0-session')->user();
    }

    protected function displayName(?Authenticatable $user): string
    {
        return trim((string) ($user?->name ?? $user?->nickname ?? $user?->email ?? 'Community member'));
    }

    protected function auth0Configured(): bool
    {
        return filled(config('auth.guards.auth0-session'))
            && filled(config('auth0.guards.default.domain'))
            && filled(config('auth0.guards.default.clientId'))
            && filled(config('auth0.guards.default.clientSecret'));
    }
}
