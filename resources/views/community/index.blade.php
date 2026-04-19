<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Community Hub - GreenLens</title>
    <meta name="description" content="GreenLens Community Hub brings planners, sustainability teams, and local advocates together to share greening ideas, field observations, and planting strategies.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --bg: #f4f8f4;
            --surface: rgba(255, 255, 255, 0.92);
            --surface-strong: #ffffff;
            --text: #122117;
            --muted: #5d6d63;
            --line: rgba(18, 33, 23, 0.08);
            --shadow: 0 22px 60px rgba(20, 30, 23, 0.08);
            --primary: #1f7a53;
            --primary-dark: #14563b;
            --blue-soft: #ebf3ff;
            --green-soft: #e5f4ec;
            --amber-soft: #fff5df;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            color: var(--text);
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(109, 185, 143, 0.15), transparent 28%),
                radial-gradient(circle at top right, rgba(102, 157, 255, 0.11), transparent 30%),
                linear-gradient(180deg, #f8fbf8 0%, #eef5ef 46%, #f6faf7 100%);
        }

        a {
            text-decoration: none;
        }

        .site-container {
            width: min(100% - 2rem, 1280px);
            margin-inline: auto;
        }

        .glass-nav,
        .surface-card,
        .hero-card,
        .post-card,
        .comment-card {
            background: var(--surface);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .glass-nav {
            border-radius: 1.25rem;
        }

        .hero-card {
            border-radius: 2rem;
            padding: 2rem;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(238, 248, 242, 0.95) 50%, rgba(233, 242, 255, 0.9) 100%);
        }

        .surface-card,
        .post-card {
            border-radius: 1.5rem;
        }

        .hero-title {
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 1.03;
            letter-spacing: -0.04em;
            max-width: 11ch;
        }

        .hero-copy,
        .section-copy,
        .muted {
            color: var(--muted);
        }

        .eyebrow,
        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .stat-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            padding: 1.25rem;
            border-radius: 1.25rem;
            border: 1px solid var(--line);
        }

        .stat-card.one { background: linear-gradient(135deg, #fff 0%, var(--green-soft) 100%); }
        .stat-card.two { background: linear-gradient(135deg, #fff 0%, var(--blue-soft) 100%); }
        .stat-card.three { background: linear-gradient(135deg, #fff 0%, var(--amber-soft) 100%); }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 6rem;
            height: 6rem;
            right: -2rem;
            bottom: -2rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.45);
        }

        .icon-badge {
            width: 2.9rem;
            height: 2.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.75);
            color: var(--primary-dark);
            font-size: 1.05rem;
        }

        .post-card {
            padding: 1.4rem;
        }

        .post-card + .post-card {
            margin-top: 1.25rem;
        }

        .post-meta,
        .comment-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            align-items: center;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.42rem 0.76rem;
            border-radius: 999px;
            background: rgba(31, 122, 83, 0.08);
            color: var(--primary-dark);
            font-size: 0.8rem;
            font-weight: 700;
        }

        .form-control,
        .form-control:focus {
            border-radius: 1rem;
            border-color: rgba(18, 33, 23, 0.12);
            box-shadow: none;
        }

        textarea.form-control {
            min-height: 9rem;
        }

        .btn-primary-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            padding: 0.92rem 1.25rem;
            border: 0;
            border-radius: 0.95rem;
            background: linear-gradient(135deg, var(--primary) 0%, #2c8c62 100%);
            color: #fff;
            font-weight: 700;
        }

        .btn-primary-soft:hover {
            color: #fff;
        }

        .btn-secondary-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            padding: 0.92rem 1.25rem;
            border-radius: 0.95rem;
            border: 1px solid rgba(18, 33, 23, 0.1);
            background: rgba(255, 255, 255, 0.8);
            color: var(--text);
            font-weight: 700;
        }

        .comment-card {
            margin-top: 1rem;
            padding: 1rem 1rem 1rem 1.1rem;
            border-radius: 1rem;
        }

        .empty-state {
            padding: 1.4rem;
            border-radius: 1.2rem;
            background: linear-gradient(180deg, #ffffff 0%, #f7faf8 100%);
            border: 1px dashed rgba(18, 33, 23, 0.16);
            color: var(--muted);
        }

        @media (max-width: 991.98px) {
            .stat-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $hasCommunitySession = $communityUser || session()->boolean('auth0_logged_in');
        $loginUrl = url('/login');
        $logoutUrl = url('/logout');
    @endphp

    <div class="site-container py-4 py-lg-5">
        <nav class="glass-nav px-3 px-lg-4 py-3 mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 text-reset">
                    <span class="icon-badge"><i class="bi bi-globe2"></i></span>
                    <div>
                        <div class="fw-bold">GreenLens</div>
                        <div class="small text-secondary">Community hub for urban greening ideas</div>
                    </div>
                </a>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('home') }}" class="btn btn-light border rounded-pill px-3">Home</a>
                    <a href="{{ route('assess.location') }}" class="btn btn-light border rounded-pill px-3">Assessment</a>
                    @if ($auth0Configured)
                        @if ($communityUser)
                            <span class="meta-chip"><i class="bi bi-person-check-fill"></i> {{ $communityUser->name ?? $communityUser->email ?? 'Signed in' }}</span>
                            <a href="{{ $logoutUrl }}" class="btn btn-success rounded-pill px-3">Logout</a>
                        @elseif ($hasCommunitySession)
                            <a href="{{ $logoutUrl }}" class="btn btn-success rounded-pill px-3">Logout</a>
                        @else
                            <a href="{{ $loginUrl }}" class="btn btn-success rounded-pill px-3">Login with Auth0</a>
                        @endif
                    @else
                        <span class="meta-chip"><i class="bi bi-shield-lock"></i> Auth0 setup required</span>
                    @endif
                </div>
            </div>
        </nav>

        <section class="hero-card mb-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3"><i class="bi bi-people-fill"></i> Community intelligence</p>
                    <h1 class="hero-title fw-bold mb-3">Bring local greening knowledge into one shared conversation.</h1>
                    <p class="hero-copy mb-4">The GreenLens community gives planners, sustainability teams, and local advocates a place to discuss air quality concerns, Miyawaki opportunities, and on-the-ground planting ideas around specific locations.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#discussions" class="btn-primary-soft">Explore discussions</a>
                        @if ($auth0Configured)
                            <a href="{{ $communityUser ? '#start-post' : $loginUrl }}" class="btn-secondary-soft">{{ $communityUser ? 'Start a post' : 'Login to contribute' }}</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="stat-strip">
                        <article class="stat-card one">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="small text-uppercase text-secondary fw-semibold">Posts</span>
                                <span class="icon-badge"><i class="bi bi-chat-square-text-fill"></i></span>
                            </div>
                            <div class="display-6 fw-bold">{{ number_format($stats['posts']) }}</div>
                            <div class="muted small">Ideas, observations, and discussion starters</div>
                        </article>
                        <article class="stat-card two">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="small text-uppercase text-secondary fw-semibold">Replies</span>
                                <span class="icon-badge"><i class="bi bi-reply-fill"></i></span>
                            </div>
                            <div class="display-6 fw-bold">{{ number_format($stats['comments']) }}</div>
                            <div class="muted small">Follow-up context from the community</div>
                        </article>
                        <article class="stat-card three">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="small text-uppercase text-secondary fw-semibold">Contributors</span>
                                <span class="icon-badge"><i class="bi bi-people-fill"></i></span>
                            </div>
                            <div class="display-6 fw-bold">{{ number_format($stats['contributors']) }}</div>
                            <div class="muted small">Distinct contributors across discussions</div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        @if (session('community_status'))
            <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">{{ session('community_status') }}</div>
        @endif

        @if (! $tablesReady)
            <div class="empty-state mb-4">
                The community database tables are not ready yet. Run the latest migrations before using the discussion hub.
            </div>
        @endif

        <div class="row g-4 align-items-start">
            <div class="col-lg-4">
                <div class="surface-card p-4 p-lg-5 sticky-top" style="top: 1.5rem;">
                    <p class="section-kicker mb-2">Contribute</p>
                    <h2 class="h4 fw-bold mb-2" id="start-post">Share what you are seeing on the ground.</h2>
                    <p class="section-copy mb-4">Post local observations, planting ideas, or site-specific concerns so others can respond with practical context.</p>

                    @if (! $auth0Configured)
                        <div class="empty-state">
                            Auth0 is not configured yet. Add your Auth0 domain, client ID, and client secret to enable community login.
                        </div>
                    @elseif (! $communityUser)
                        <div class="empty-state">
                            Sign in with Auth0 to start discussions and reply to other community posts.
                            <div class="mt-3">
                                <a href="{{ $loginUrl }}" class="btn-primary-soft">Login with Auth0</a>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('community.posts.store') }}" class="d-grid gap-3">
                            @csrf
                            <div>
                                <label class="form-label fw-semibold">Post title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Example: Best Miyawaki candidate zone near Lahore ring road">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" name="location_name" class="form-control @error('location_name') is-invalid @enderror" value="{{ old('location_name') }}" placeholder="Optional: Lahore, Johar Town, Gulberg, etc.">
                                @error('location_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Discussion</label>
                                <textarea name="body" class="form-control @error('body') is-invalid @enderror" placeholder="Share what the assessment revealed, what local conditions you know about, or what action you think should happen next.">{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-primary-soft">Publish post</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="col-lg-8" id="discussions">
                <div class="surface-card p-4 p-lg-5 mb-4">
                    <p class="section-kicker mb-2">Why this matters</p>
                    <h2 class="h4 fw-bold mb-2">Environmental intelligence improves when local knowledge has a place to surface.</h2>
                    <p class="section-copy mb-0">AQI values and planting estimates are useful, but they become more meaningful when residents, planners, and field teams can add context about schools, parks, road edges, vacant plots, and real maintenance constraints.</p>
                </div>

                @forelse ($posts as $post)
                    <article class="post-card" id="post-{{ $post->id }}">
                        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-3">
                            <div>
                                <h3 class="h4 fw-bold mb-2">{{ $post->title }}</h3>
                                <div class="post-meta">
                                    <span><i class="bi bi-person-circle"></i> {{ $post->author_name }}</span>
                                    <span><i class="bi bi-clock"></i> {{ $post->created_at?->diffForHumans() }}</span>
                                    @if ($post->location_name)
                                        <span class="meta-chip"><i class="bi bi-geo-alt-fill"></i> {{ $post->location_name }}</span>
                                    @endif
                                    <span class="meta-chip"><i class="bi bi-chat-dots-fill"></i> {{ $post->comments_count }} replies</span>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0">{{ $post->body }}</p>

                        <div class="mt-4">
                            <p class="fw-semibold mb-3">Replies</p>

                            @forelse ($post->comments as $comment)
                                <div class="comment-card">
                                    <div class="comment-meta mb-2">
                                        <span><i class="bi bi-person-badge-fill"></i> {{ $comment->author_name }}</span>
                                        <span><i class="bi bi-clock-history"></i> {{ $comment->created_at?->diffForHumans() }}</span>
                                    </div>
                                    <p class="mb-0">{{ $comment->body }}</p>
                                </div>
                            @empty
                                <div class="empty-state">No replies yet. Start the discussion with a grounded local observation or planning suggestion.</div>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            @if (! $auth0Configured)
                                <div class="empty-state">Configure Auth0 to enable community replies.</div>
                            @elseif (! $communityUser)
                                <div class="empty-state">
                                    Login with Auth0 to join this discussion.
                                    <div class="mt-3">
                                        <a href="{{ $loginUrl }}" class="btn-primary-soft">Login with Auth0</a>
                                    </div>
                                </div>
                            @else
                                <form method="POST" action="{{ route('community.comments.store', $post) }}" class="d-grid gap-3">
                                    @csrf
                                    <div>
                                        <label class="form-label fw-semibold">Add a reply</label>
                                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" style="min-height: 7rem;" placeholder="Add local context, maintenance considerations, or site-specific planting advice."></textarea>
                                        @error('body')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <button type="submit" class="btn-primary-soft">Post reply</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        No community posts yet. Start the first thread about a location, a greening challenge, or a Miyawaki opportunity.
                    </div>
                @endforelse

                @if ($posts instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="mt-4">
                        {{ $posts->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
