<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GreenLens | Urban Greening Intelligence Dashboard</title>
    <meta name="description" content="GreenLens is a professional urban greening dashboard for air quality analysis, tree planting recommendations, green score tracking, and sustainability planning.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --bg: #f5f8f4;
            --surface: rgba(255, 255, 255, 0.9);
            --surface-strong: #ffffff;
            --text: #122117;
            --muted: #5d6d63;
            --line: rgba(18, 33, 23, 0.08);
            --shadow: 0 22px 60px rgba(23, 37, 29, 0.08);
            --primary: #1f7a53;
            --primary-dark: #14563b;
            --highlight: #d7f0e2;
            --blue-soft: #eaf2ff;
            --amber-soft: #fff3df;
            --violet-soft: #f3ebff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            background:
                radial-gradient(circle at top left, rgba(109, 185, 143, 0.18), transparent 28%),
                radial-gradient(circle at top right, rgba(102, 157, 255, 0.14), transparent 30%),
                linear-gradient(180deg, #f7faf7 0%, #eef5ef 42%, #f8fbf8 100%);
        }

        a {
            text-decoration: none;
        }

        .page-shell {
            position: relative;
            overflow: clip;
        }

        .page-shell::before,
        .page-shell::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(6px);
            opacity: 0.65;
        }

        .page-shell::before {
            width: 26rem;
            height: 26rem;
            top: 6rem;
            left: -8rem;
            background: radial-gradient(circle, rgba(76, 175, 128, 0.16), transparent 70%);
        }

        .page-shell::after {
            width: 28rem;
            height: 28rem;
            top: 14rem;
            right: -8rem;
            background: radial-gradient(circle, rgba(83, 129, 255, 0.12), transparent 70%);
        }

        .site-container {
            width: min(100% - 2rem, 1280px);
            margin-inline: auto;
        }

        .section-space {
            margin-top: 1.5rem;
        }

        .glass-nav,
        .surface-card,
        .hero-card,
        .floating-panel {
            background: var(--surface);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .glass-nav {
            border-radius: 1.25rem;
        }

        .hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 248, 242, 0.96) 52%, rgba(231, 242, 255, 0.92) 100%);
        }

        .hero-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 18% 22%, rgba(31, 122, 83, 0.14), transparent 25%),
                radial-gradient(circle at 82% 18%, rgba(72, 121, 255, 0.12), transparent 22%),
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: auto, auto, 26px 26px, 26px 26px;
            pointer-events: none;
        }

        .hero-content,
        .hero-visual {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            background: rgba(31, 122, 83, 0.1);
            color: var(--primary-dark);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: clamp(2.4rem, 4vw, 4.5rem);
            line-height: 1.02;
            letter-spacing: -0.04em;
            max-width: 11ch;
        }

        .hero-lead {
            max-width: 60ch;
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.75;
        }

        .cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.9rem;
        }

        .btn-primary-hero {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            padding: 0.95rem 1.4rem;
            border-radius: 0.95rem;
            border: 0;
            background: linear-gradient(135deg, var(--primary) 0%, #2c8c62 100%);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 18px 32px rgba(31, 122, 83, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 40px rgba(31, 122, 83, 0.25);
            color: #ffffff;
        }

        .btn-secondary-hero {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            padding: 0.95rem 1.4rem;
            border-radius: 0.95rem;
            border: 1px solid rgba(18, 33, 23, 0.12);
            background: rgba(255, 255, 255, 0.72);
            color: var(--text);
            font-weight: 700;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .btn-secondary-hero:hover {
            transform: translateY(-2px);
            border-color: rgba(31, 122, 83, 0.35);
            color: var(--primary-dark);
        }

        .mini-proof {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem;
            margin-top: 1.25rem;
        }

        .proof-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.7rem 0.9rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(18, 33, 23, 0.08);
            color: var(--muted);
            font-size: 0.92rem;
            font-weight: 600;
        }

        .hero-metrics {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .floating-panel {
            border-radius: 1.5rem;
        }

        .dashboard-preview {
            padding: 1.1rem;
            border-radius: 1.4rem;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(18, 33, 23, 0.08);
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .preview-stat {
            padding: 1rem;
            border-radius: 1rem;
            background: linear-gradient(180deg, #ffffff 0%, #f3f8f4 100%);
            border: 1px solid rgba(18, 33, 23, 0.08);
        }

        .section-kicker {
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--primary);
        }

        .section-title {
            font-size: clamp(1.75rem, 2.3vw, 2.8rem);
            letter-spacing: -0.03em;
            line-height: 1.08;
            margin-bottom: 0.9rem;
        }

        .section-copy {
            color: var(--muted);
            line-height: 1.8;
            max-width: 64ch;
        }

        .stats-strip {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            min-width: 0;
            padding: 1.25rem;
            border-radius: 1.35rem;
            border: 1px solid rgba(18, 33, 23, 0.08);
            box-shadow: 0 16px 40px rgba(16, 24, 20, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover,
        .feature-card:hover,
        .surface-card:hover,
        .cta-banner:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 46px rgba(16, 24, 20, 0.08);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 7rem;
            height: 7rem;
            right: -2rem;
            bottom: -2rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.45);
        }

        .stat-card-one {
            background: linear-gradient(135deg, #ffffff 0%, var(--highlight) 100%);
        }

        .stat-card-two {
            background: linear-gradient(135deg, #ffffff 0%, var(--blue-soft) 100%);
        }

        .stat-card-three {
            background: linear-gradient(135deg, #ffffff 0%, var(--amber-soft) 100%);
        }

        .stat-card-four {
            background: linear-gradient(135deg, #ffffff 0%, var(--violet-soft) 100%);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .icon-badge {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.75);
            color: var(--primary-dark);
            font-size: 1.15rem;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.38rem 0.72rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.7);
            color: var(--primary-dark);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .surface-card,
        .feature-card,
        .cta-banner {
            border-radius: 1.6rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .surface-card {
            padding: 1.6rem;
        }

        .feature-card {
            height: 100%;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid var(--line);
            box-shadow: 0 18px 48px rgba(20, 30, 23, 0.06);
        }

        .feature-icon {
            width: 3.25rem;
            height: 3.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: var(--primary-dark);
            background: linear-gradient(135deg, rgba(31, 122, 83, 0.14), rgba(118, 171, 255, 0.16));
        }

        .metric-block {
            padding: 1.15rem;
            border-radius: 1.2rem;
            background: linear-gradient(180deg, #ffffff 0%, #f4f8f5 100%);
            border: 1px solid rgba(18, 33, 23, 0.08);
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .timeline-card {
            padding: 1rem 0 0;
        }

        .timeline-item {
            padding: 1rem 0;
            border-top: 1px solid rgba(18, 33, 23, 0.08);
        }

        .timeline-item:first-child {
            border-top: 0;
            padding-top: 0;
        }

        .empty-state {
            padding: 1.4rem;
            border-radius: 1.2rem;
            background: linear-gradient(180deg, #ffffff 0%, #f7faf8 100%);
            border: 1px dashed rgba(18, 33, 23, 0.16);
            color: var(--muted);
        }

        .content-list {
            display: grid;
            gap: 1rem;
        }

        .content-list-item {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
        }

        .content-list-icon {
            width: 2.4rem;
            height: 2.4rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.85rem;
            background: rgba(31, 122, 83, 0.1);
            color: var(--primary);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .map-panel {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .location-map {
            min-height: 360px;
            border-radius: 1.35rem;
            overflow: hidden;
            border: 1px solid rgba(18, 33, 23, 0.08);
            background: linear-gradient(180deg, rgba(240, 248, 242, 0.96) 0%, rgba(233, 242, 255, 0.96) 100%);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .map-caption {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .map-caption-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 0.9rem;
            border-radius: 999px;
            border: 1px solid rgba(18, 33, 23, 0.08);
            background: rgba(255, 255, 255, 0.78);
            color: var(--muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .map-caption-chip i {
            color: var(--primary);
        }

        .faq-accordion {
            --bs-accordion-border-color: transparent;
            --bs-accordion-btn-bg: transparent;
            --bs-accordion-active-bg: transparent;
            --bs-accordion-bg: transparent;
            --bs-accordion-btn-focus-box-shadow: none;
            --bs-accordion-btn-color: var(--text);
            --bs-accordion-active-color: var(--primary-dark);
        }

        .faq-accordion .accordion-item {
            overflow: hidden;
            border: 1px solid rgba(18, 33, 23, 0.08);
            border-radius: 1.2rem;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 14px 34px rgba(16, 24, 20, 0.05);
        }

        .faq-accordion .accordion-item + .accordion-item {
            margin-top: 1rem;
        }

        .faq-accordion .accordion-header {
            margin: 0;
        }

        .faq-accordion .accordion-button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 1.25rem;
            font-weight: 700;
            gap: 1rem;
            line-height: 1.45;
            border-radius: 0;
        }

        .faq-accordion .accordion-button::after {
            display: none;
        }

        .faq-accordion .accordion-button:not(.collapsed) {
            box-shadow: none;
            border-bottom: 1px solid rgba(18, 33, 23, 0.06);
        }

        .faq-accordion .accordion-body {
            padding: 1rem 1.25rem 1.25rem;
            line-height: 1.75;
        }

        .faq-symbol {
            width: 2.15rem;
            height: 2.15rem;
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: rgba(18, 33, 23, 0.06);
            color: var(--text);
            font-size: 1.15rem;
            transition: transform 0.25s ease, background-color 0.25s ease, color 0.25s ease;
        }

        .faq-accordion .accordion-button:not(.collapsed) .faq-symbol {
            transform: rotate(45deg);
            background: var(--primary);
            color: #ffffff;
        }

        .cta-banner {
            position: relative;
            overflow: hidden;
            padding: 2rem;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.18), transparent 25%),
                linear-gradient(135deg, #174e38 0%, #1f7a53 55%, #2f8ccf 100%);
            color: #ffffff;
            box-shadow: 0 26px 60px rgba(23, 80, 56, 0.18);
        }

        .cta-banner::after {
            content: "";
            position: absolute;
            inset: auto -4rem -4rem auto;
            width: 14rem;
            height: 14rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
        }

        .footer-note {
            color: var(--muted);
            font-size: 0.95rem;
        }

        @media (max-width: 1199.98px) {
            .stats-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .hero-title {
                max-width: none;
            }

            .hero-metrics,
            .preview-grid,
            .result-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .site-container {
                width: min(100% - 1.25rem, 1280px);
            }

            .glass-nav,
            .hero-card,
            .surface-card,
            .feature-card,
            .cta-banner {
                border-radius: 1.3rem;
            }

            .hero-metrics,
            .preview-grid,
            .stats-strip,
            .result-grid {
                grid-template-columns: 1fr;
            }

            .hero-card {
                padding: 1.4rem !important;
            }

            .section-space {
                margin-top: 1rem;
            }

            .cta-row {
                flex-direction: column;
            }

            .btn-primary-hero,
            .btn-secondary-hero {
                width: 100%;
            }

            .faq-accordion .accordion-button {
                padding: 1rem 1rem;
                font-size: 0.98rem;
            }

            .faq-accordion .accordion-body {
                padding: 0.9rem 1rem 1rem;
            }
        }
    </style>
</head>
<body>
    @php
        $auth0Configured = filled(config('auth0.guards.default.domain'))
            && filled(config('auth0.guards.default.clientId'))
            && filled(config('auth0.guards.default.clientSecret'));
        $communityUser = null;

        if ($auth0Configured) {
            try {
                $communityUser = auth('auth0-session')->user();
            } catch (\Throwable $exception) {
                report($exception);
                $communityUser = null;
            }
        }
        $hasCommunitySession = $communityUser || session()->boolean('auth0_logged_in');
        $loginUrl = url('/login');
        $logoutUrl = url('/logout');
    @endphp

    <div class="page-shell">
        <div class="site-container py-4 py-lg-5">
            <nav class="glass-nav px-3 px-lg-4 py-3 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4 mb-lg-5">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-badge" style="background: linear-gradient(135deg, rgba(31, 122, 83, 0.18), rgba(47, 140, 207, 0.16));">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">GreenLens</p>
                        <p class="mb-0 small text-secondary">Urban greening intelligence</p>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="#insights" class="btn btn-sm btn-light border rounded-pill px-3">Insights</a>
                    <a href="{{ route('community.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">Community</a>
                    <a href="#faq" class="btn btn-sm btn-light border rounded-pill px-3">FAQ</a>
                    @if ($auth0Configured)
                        @if ($hasCommunitySession)
                            <a href="{{ $logoutUrl }}" class="btn btn-sm btn-light border rounded-pill px-3">Logout</a>
                        @else
                            <a href="{{ $loginUrl }}" class="btn btn-sm btn-light border rounded-pill px-3">Login</a>
                        @endif
                    @endif
                    <a href="{{ route('assess.location') }}" class="btn btn-success rounded-pill px-3">Start assessment</a>
                </div>
            </nav>

            <header class="hero-card p-4 p-lg-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7 hero-content">
                        <span class="eyebrow mb-3">
                            <i class="bi bi-stars"></i>
                            Premium planning dashboard
                        </span>
                        <h1 class="hero-title fw-bold mb-3">Turn location data into confident urban greening decisions.</h1>
                        <p class="hero-lead mb-4">GreenLens helps teams evaluate air quality, estimate planting opportunity, review AI-backed recommendations, and communicate sustainability outcomes through a clean, trusted dashboard.</p>

                        <div class="cta-row mb-4">
                            <a href="{{ route('assess.location') }}" class="btn-primary-hero">
                                <i class="bi bi-arrow-up-right-circle"></i>
                                Run a new assessment
                            </a>
                            <a href="{{ route('community.index') }}" class="btn-secondary-hero">
                                <i class="bi bi-people-fill"></i>
                                {{ $communityUser ? 'Join the community' : 'Explore community ideas' }}
                            </a>
                        </div>

                        <div class="mini-proof">
                            <span class="proof-pill"><i class="bi bi-shield-check"></i> Cleaner, trustworthy presentation</span>
                            <span class="proof-pill"><i class="bi bi-tree"></i> Tree planning guidance</span>
                            <span class="proof-pill"><i class="bi bi-wind"></i> Air quality context</span>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success mt-4 mb-0 border-0 rounded-4">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-5 hero-visual">
                        <div class="floating-panel p-3 p-lg-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <p class="section-kicker mb-1">Live overview</p>
                                    <h2 class="h4 mb-0">Dashboard snapshot</h2>
                                </div>
                                <span class="meta-chip"><i class="bi bi-activity"></i> Real data</span>
                            </div>

                            <div class="dashboard-preview mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <p class="text-secondary small text-uppercase mb-1">Latest result</p>
                                        <p class="fw-semibold mb-0">{{ $latestAssessment?->location?->name ?: $latestAssessment?->location?->city ?: 'Waiting for first assessment' }}</p>
                                    </div>
                                    @if ($latestAssessment)
                                        <span class="badge rounded-pill text-bg-success px-3 py-2">{{ $latestAssessment->airQualitySnapshot?->aqi_category ?: 'Pending' }}</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-light border px-3 py-2">Empty state</span>
                                    @endif
                                </div>

                                <div class="preview-grid">
                                    <div class="preview-stat">
                                        <p class="text-secondary small mb-1">AQI</p>
                                        <p class="h3 fw-bold mb-0">{{ $latestAssessment?->airQualitySnapshot?->aqi_value ?? 'N/A' }}</p>
                                    </div>
                                    <div class="preview-stat">
                                        <p class="text-secondary small mb-1">Trees</p>
                                        <p class="h3 fw-bold mb-0">{{ number_format($latestAssessment?->recommended_trees ?? 0) }}</p>
                                    </div>
                                    <div class="preview-stat">
                                        <p class="text-secondary small mb-1">Green score</p>
                                        <p class="h3 fw-bold mb-0">{{ $stats['average_green_score'] !== null ? number_format($stats['average_green_score'], 1) : 'N/A' }}</p>
                                    </div>
                                    <div class="preview-stat">
                                        <p class="text-secondary small mb-1">Recommendations</p>
                                        <p class="h3 fw-bold mb-0">{{ number_format($stats['total_recommendations']) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="hero-metrics">
                                <div class="metric-block">
                                    <p class="text-secondary small text-uppercase mb-2">People used</p>
                                    <p class="h3 fw-bold mb-1">{{ number_format($stats['total_assessments']) }}</p>
                                    <p class="mb-0 small text-secondary">Total submitted assessments</p>
                                </div>
                                <div class="metric-block">
                                    <p class="text-secondary small text-uppercase mb-2">Tree impact</p>
                                    <p class="h3 fw-bold mb-1">{{ number_format($stats['total_recommended_trees']) }}</p>
                                    <p class="mb-0 small text-secondary">Suggested trees across reports</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="section-space" id="insights">
                <div class="stats-strip">
                    <article class="stat-card stat-card-one">
                        <div class="stat-top">
                            <div>
                                <p class="text-secondary text-uppercase small mb-2">People used</p>
                                <span class="meta-chip"><i class="bi bi-people-fill"></i> Adoption</span>
                            </div>
                            <span class="icon-badge"><i class="bi bi-person-check-fill"></i></span>
                        </div>
                        <h2 class="display-6 fw-bold mb-1">{{ number_format($stats['total_assessments']) }}</h2>
                        <p class="mb-0 text-secondary">How many assessments have been submitted through the dashboard.</p>
                    </article>

                    <article class="stat-card stat-card-two">
                        <div class="stat-top">
                            <div>
                                <p class="text-secondary text-uppercase small mb-2">Recommendations</p>
                                <span class="meta-chip"><i class="bi bi-stars"></i> AI guidance</span>
                            </div>
                            <span class="icon-badge"><i class="bi bi-lightbulb-fill"></i></span>
                        </div>
                        <h2 class="display-6 fw-bold mb-1">{{ number_format($stats['total_recommendations']) }}</h2>
                        <p class="mb-0 text-secondary">Recommendation summaries stored for review and stakeholder reporting.</p>
                    </article>

                    <article class="stat-card stat-card-three">
                        <div class="stat-top">
                            <div>
                                <p class="text-secondary text-uppercase small mb-2">Trees proposed</p>
                                <span class="meta-chip"><i class="bi bi-tree-fill"></i> Planning</span>
                            </div>
                            <span class="icon-badge"><i class="bi bi-flower1"></i></span>
                        </div>
                        <h2 class="display-6 fw-bold mb-1">{{ number_format($stats['total_recommended_trees']) }}</h2>
                        <p class="mb-0 text-secondary">The total planting volume estimated across all completed analyses.</p>
                    </article>

                    <article class="stat-card stat-card-four">
                        <div class="stat-top">
                            <div>
                                <p class="text-secondary text-uppercase small mb-2">Average green score</p>
                                <span class="meta-chip"><i class="bi bi-bar-chart-fill"></i> Benchmark</span>
                            </div>
                            <span class="icon-badge"><i class="bi bi-graph-up-arrow"></i></span>
                        </div>
                        <h2 class="display-6 fw-bold mb-1">{{ $stats['average_green_score'] !== null ? number_format($stats['average_green_score'], 1) : 'N/A' }}</h2>
                        <p class="mb-0 text-secondary">An at-a-glance benchmark for portfolio-level environmental quality.</p>
                    </article>
                </div>
            </section>

            <section class="section-space py-lg-3">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="pe-lg-4">
                            <p class="section-kicker mb-2">Why teams choose GreenLens</p>
                            <h2 class="section-title fw-bold">Turn location data into practical urban greening decisions.</h2>
                            <p class="section-copy mb-4">GreenLens helps teams evaluate air quality, estimate planting opportunity, and turn raw site inputs into credible recommendations for healthier, greener places.</p>

                            <div class="content-list">
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-check2-circle"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">Grounded in local conditions</p>
                                        <p class="mb-0 text-secondary">Each assessment combines location inputs, air quality signals, and site context to build recommendations that reflect real environmental conditions.</p>
                                    </div>
                                </div>
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-layers"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">Designed for action</p>
                                        <p class="mb-0 text-secondary">Tree estimates, Miyawaki feasibility, and improvement guidance are organized so planners can move from assessment to intervention quickly.</p>
                                    </div>
                                </div>
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-phone"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">Useful for reporting</p>
                                        <p class="mb-0 text-secondary">The dashboard turns technical outputs into summaries that are easier to share with leadership, partners, and sustainability stakeholders.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <article class="feature-card">
                                    <span class="feature-icon"><i class="bi bi-wind"></i></span>
                                    <h3 class="h5 fw-bold mb-2">Air quality context</h3>
                                    <p class="mb-0 text-secondary">Capture AQI and pollution context so recommendations are grounded in actual environmental conditions rather than generic sustainability claims.</p>
                                </article>
                            </div>
                            <div class="col-md-6">
                                <article class="feature-card">
                                    <span class="feature-icon"><i class="bi bi-tree-fill"></i></span>
                                    <h3 class="h5 fw-bold mb-2">Tree opportunity mapping</h3>
                                    <p class="mb-0 text-secondary">Translate site inputs into understandable tree planting estimates and make canopy improvement easier to communicate.</p>
                                </article>
                            </div>
                            <div class="col-md-6">
                                <article class="feature-card">
                                    <span class="feature-icon"><i class="bi bi-stars"></i></span>
                                    <h3 class="h5 fw-bold mb-2">Recommendation summaries</h3>
                                    <p class="mb-0 text-secondary">Surface recent AI guidance in a clean feed so teams can quickly review what the platform is recommending across locations.</p>
                                </article>
                            </div>
                            <div class="col-md-6">
                                <article class="feature-card">
                                    <span class="feature-icon"><i class="bi bi-graph-up"></i></span>
                                    <h3 class="h5 fw-bold mb-2">Executive-ready reporting feel</h3>
                                    <p class="mb-0 text-secondary">A premium homepage helps the product feel credible for stakeholders, partners, and sustainability programs from the first impression.</p>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-space">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="surface-card h-100 p-4 p-lg-5">
                            <div class="d-flex flex-column flex-sm-row align-items-start justify-content-between gap-3 mb-4">
                                <div>
                                    <p class="section-kicker mb-2">Latest assessment</p>
                                    <h2 class="h3 fw-bold mb-1">{{ $latestAssessment?->location?->name ?: $latestAssessment?->location?->city ?: 'No assessments yet' }}</h2>
                                    <p class="mb-0 text-secondary">Review the latest live environmental snapshot generated inside the platform.</p>
                                </div>
                                @if ($latestAssessment)
                                    <span class="badge rounded-pill text-bg-success px-3 py-2">{{ $latestAssessment->airQualitySnapshot?->aqi_category ?: 'Pending' }}</span>
                                @endif
                            </div>

                            @if ($latestAssessment)
                                <div class="result-grid">
                                    <div class="metric-block">
                                        <p class="text-secondary small text-uppercase mb-2">AQI</p>
                                        <p class="h2 fw-bold mb-1">{{ $latestAssessment->airQualitySnapshot?->aqi_value ?? 'N/A' }}</p>
                                        <p class="mb-0 small text-secondary">Current air quality reading</p>
                                    </div>
                                    <div class="metric-block">
                                        <p class="text-secondary small text-uppercase mb-2">Recommended trees</p>
                                        <p class="h2 fw-bold mb-1">{{ number_format($latestAssessment->recommended_trees ?? 0) }}</p>
                                        <p class="mb-0 small text-secondary">Suggested planting volume</p>
                                    </div>
                                    <div class="metric-block">
                                        <p class="text-secondary small text-uppercase mb-2">Green score</p>
                                        <p class="h2 fw-bold mb-1">{{ $latestAssessment->green_score !== null ? number_format($latestAssessment->green_score, 1) : 'N/A' }}</p>
                                        <p class="mb-0 small text-secondary">Composite planning benchmark</p>
                                    </div>
                                    <div class="metric-block">
                                        <p class="text-secondary small text-uppercase mb-2">Annual carbon kg</p>
                                        <p class="h2 fw-bold mb-1">{{ number_format((float) ($latestAssessment->estimated_annual_carbon_kg ?? 0), 0) }}</p>
                                        <p class="mb-0 small text-secondary">Estimated yearly capture potential</p>
                                    </div>
                                </div>

                                @php
                                    $nearbyCandidates = data_get($latestAssessment->calculation_breakdown, 'miyawaki.nearby_candidates', []);
                                @endphp

                                <div class="mt-4">
                                    <p class="section-kicker mb-2">Nearby Miyawaki opportunities</p>
                                    @if (!empty($nearbyCandidates))
                                        @php
                                            $mapCenter = [
                                                'name' => $latestAssessment->location?->name ?: 'Assessed location',
                                                'latitude' => (float) ($latestAssessment->location?->latitude ?? 0),
                                                'longitude' => (float) ($latestAssessment->location?->longitude ?? 0),
                                            ];

                                            $mapCandidates = collect($nearbyCandidates)
                                                ->filter(fn (array $candidate) => filled($candidate['latitude'] ?? null) && filled($candidate['longitude'] ?? null))
                                                ->map(fn (array $candidate, int $index) => [
                                                    'id' => 'candidate-' . $index,
                                                    'name' => $candidate['name'] ?? 'Nearby site',
                                                    'address' => $candidate['address'] ?? 'Address unavailable',
                                                    'reason' => $candidate['reason'] ?? 'Potential Miyawaki planting location',
                                                    'latitude' => (float) $candidate['latitude'],
                                                    'longitude' => (float) $candidate['longitude'],
                                                ])
                                                ->values();
                                        @endphp

                                        <div class="row g-4 align-items-start">
                                            <div class="col-xl-6">
                                                <div class="content-list">
                                                    @foreach ($nearbyCandidates as $candidate)
                                                        <div class="content-list-item">
                                                            <span class="content-list-icon"><i class="bi bi-geo-alt-fill"></i></span>
                                                            <div>
                                                                <p class="fw-semibold mb-1">{{ $candidate['name'] ?? 'Nearby site' }}</p>
                                                                <p class="mb-1 text-secondary">{{ $candidate['address'] ?? 'Address unavailable' }}</p>
                                                                <p class="mb-0 small text-secondary">{{ $candidate['reason'] ?? 'Potential Miyawaki planting location' }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                @if ($mapCandidates->isNotEmpty() && $mapCenter['latitude'] && $mapCenter['longitude'])
                                                    <div class="map-panel">
                                                        <div id="nearbyLocationMap"
                                                            class="location-map"
                                                            data-center='@json($mapCenter)'
                                                            data-candidates='@json($mapCandidates)'></div>
                                                        <div class="map-caption">
                                                            <span class="map-caption-chip"><i class="bi bi-bullseye"></i> Assessment center</span>
                                                            <span class="map-caption-chip"><i class="bi bi-pin-map-fill"></i> Suggested Miyawaki sites</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="empty-state">
                                                        Map pins will appear here when suggested locations include coordinate data.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="empty-state">
                                            No nearby Miyawaki candidate places were suggested for this assessment yet.
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="empty-state">
                                    No completed assessments are available yet. Start the first assessment to populate this result panel with AQI, tree estimate, green score, and carbon potential.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="surface-card h-100 p-4 p-lg-5">
                            <p class="section-kicker mb-2">Recent recommendations</p>
                            <h2 class="h4 fw-bold mb-2">What the platform is recommending</h2>
                            <p class="text-secondary mb-4">A concise feed of the latest recommendation summaries generated by completed assessments.</p>

                            <div class="timeline-card">
                                @forelse ($recentRecommendations as $recommendation)
                                    <div class="timeline-item">
                                        <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                            <p class="fw-semibold mb-0">{{ $recommendation->assessment?->location?->name ?: $recommendation->assessment?->location?->city ?: 'Submitted location' }}</p>
                                            <span class="meta-chip"><i class="bi bi-stars"></i> {{ $recommendation->model ?: 'AI' }}</span>
                                        </div>
                                        <p class="text-secondary mb-2">{{ $recommendation->summary }}</p>
                                        <p class="small text-secondary mb-0">{{ $recommendation->created_at?->format('d M Y, h:i A') }}</p>
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        No recommendation records yet. Once assessments are submitted, this section will display the latest AI-generated recommendation summaries.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-space">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="surface-card h-100 p-4 p-lg-5">
                            <p class="section-kicker mb-2">About the platform</p>
                            <h2 class="section-title fw-bold">Urban greening dashboard for air quality and tree planning.</h2>
                            <p class="section-copy mb-0">GreenLens is a professional sustainability dashboard designed to help teams analyze air quality, estimate tree planting opportunities, and review AI-generated greening recommendations. The homepage presents key product signals clearly so visitors understand the platform quickly and trust what they are seeing.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="surface-card h-100 p-4 p-lg-5">
                            <p class="section-kicker mb-2">How it works</p>
                            <div class="content-list">
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-geo-alt-fill"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">1. Submit a location</p>
                                        <p class="mb-0 text-secondary">Enter coordinates and site details to run a new assessment from the main workflow.</p>
                                    </div>
                                </div>
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-cpu-fill"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">2. Generate insights</p>
                                        <p class="mb-0 text-secondary">GreenLens calculates environmental metrics, tree opportunities, and recommendation summaries.</p>
                                    </div>
                                </div>
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-clipboard-data-fill"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">3. Review the dashboard</p>
                                        <p class="mb-0 text-secondary">Return to the homepage to review usage stats, latest outcomes, and recommendation history in one place.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-space">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="surface-card h-100 p-4 p-lg-5">
                            <p class="section-kicker mb-2">Community intelligence</p>
                            <h2 class="section-title fw-bold">Pair environmental data with local knowledge from real people.</h2>
                            <p class="section-copy mb-4">GreenLens now includes a community hub where planners, residents, and sustainability teams can discuss site conditions, Miyawaki opportunities, and greening ideas around specific locations.</p>

                            <div class="content-list mb-4">
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-shield-lock-fill"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">Identity through Auth0</p>
                                        <p class="mb-0 text-secondary">Participation is tied to authenticated accounts so the discussion space feels more credible and less anonymous.</p>
                                    </div>
                                </div>
                                <div class="content-list-item">
                                    <span class="content-list-icon"><i class="bi bi-chat-square-dots-fill"></i></span>
                                    <div>
                                        <p class="fw-semibold mb-1">Grounded discussion</p>
                                        <p class="mb-0 text-secondary">Posts can capture field observations, local constraints, and practical planting suggestions that raw metrics alone cannot show.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('community.index') }}" class="btn btn-success rounded-pill px-4 py-3 fw-semibold">Open community hub</a>
                                @if ($auth0Configured && ! $communityUser)
                                    <a href="{{ $loginUrl }}" class="btn btn-light border rounded-pill px-4 py-3 fw-semibold">Login with Auth0</a>
                                @elseif ($communityUser)
                                    <a href="{{ route('community.index') }}#start-post" class="btn btn-light border rounded-pill px-4 py-3 fw-semibold">Start a discussion</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="surface-card h-100 p-4 p-lg-5">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                                <div>
                                    <p class="section-kicker mb-2">Latest conversations</p>
                                    <h2 class="h4 fw-bold mb-0">What the community is discussing</h2>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="meta-chip"><i class="bi bi-chat-square-text-fill"></i> {{ number_format($communityStats['posts']) }} posts</span>
                                    <span class="meta-chip"><i class="bi bi-reply-fill"></i> {{ number_format($communityStats['comments']) }} replies</span>
                                    <span class="meta-chip"><i class="bi bi-people-fill"></i> {{ number_format($communityStats['contributors']) }} contributors</span>
                                </div>
                            </div>

                            <div class="timeline-card">
                                @forelse ($communityPreview as $post)
                                    <div class="timeline-item">
                                        <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                            <div>
                                                <p class="fw-semibold mb-1">{{ $post->title }}</p>
                                                <p class="small text-secondary mb-0">{{ $post->author_name }}{{ $post->location_name ? ' • ' . $post->location_name : '' }}</p>
                                            </div>
                                            <span class="meta-chip"><i class="bi bi-chat-dots-fill"></i> {{ $post->comments_count }} replies</span>
                                        </div>
                                        <p class="text-secondary mb-2">{{ \Illuminate\Support\Str::limit($post->body, 165) }}</p>
                                        <a href="{{ route('community.index') }}#post-{{ $post->id }}" class="small fw-semibold text-success">View discussion</a>
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        No community posts yet. Open the community hub to start the first discussion around a location, air quality issue, or Miyawaki opportunity.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-space" id="faq">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="pe-lg-4">
                            <p class="section-kicker mb-2">FAQ</p>
                            <h2 class="section-title fw-bold">Answers that help visitors understand the product quickly.</h2>
                            <p class="section-copy mb-0">The FAQ is designed as a proper accordion so it reads cleanly, expands smoothly, and remains easy to use on mobile.</p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="accordion faq-accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="false" aria-controls="faqOne">
                                        How do I use this dashboard?
                                        <span class="faq-symbol">+</span>
                                    </button>
                                </h3>
                                <div id="faqOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-secondary">
                                        Open the homepage, review the live usage and recommendation sections, then click <strong>Run a new assessment</strong> to submit a location and generate a fresh result.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                                        What does “people used” mean?
                                        <span class="faq-symbol">+</span>
                                    </button>
                                </h3>
                                <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-secondary">
                                        It currently reflects the number of submitted assessments. If you later want unique-user counts, the product would need user tracking or authentication-based reporting.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                                        Where do the recommendations come from?
                                        <span class="faq-symbol">+</span>
                                    </button>
                                </h3>
                                <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-secondary">
                                        Recommendations are pulled from saved AI recommendation summaries generated after each completed assessment, then displayed here as a recent activity feed.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                                        Why might some values show zero or “N/A”?
                                        <span class="faq-symbol">+</span>
                                    </button>
                                </h3>
                                <div id="faqFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-secondary">
                                        That happens when no assessments have been recorded yet or when a specific metric is unavailable for the latest result. The homepage is intentionally designed to handle that empty state cleanly.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-space">
                <div class="cta-banner">
                    <div class="row g-4 align-items-center position-relative" style="z-index: 1;">
                        <div class="col-lg-8">
                            <p class="text-uppercase small fw-semibold opacity-75 mb-2">Ready to use GreenLens</p>
                            <h2 class="section-title fw-bold text-white mb-3">Launch a new assessment and turn raw location input into a cleaner sustainability story.</h2>
                            <p class="mb-0 text-white-50">Use the assessment workflow to generate fresh environmental insights, then return here to review results in a homepage that feels production-ready and stakeholder-safe.</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="{{ route('assess.location') }}" class="btn btn-light btn-lg rounded-pill px-4 py-3 fw-semibold">
                                Start assessment
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="py-4 py-lg-5">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                    <div>
                        <p class="mb-1 fw-semibold">GreenLens</p>
                        <p class="footer-note mb-0">Professional urban greening intelligence for clearer planning and better presentation.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#insights" class="btn btn-sm btn-light border rounded-pill px-3">Insights</a>
                        <a href="#faq" class="btn btn-sm btn-light border rounded-pill px-3">FAQ</a>
                        <a href="{{ route('assess.location') }}" class="btn btn-sm btn-success rounded-pill px-3">Run assessment</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function initNearbyLocationMap() {
            const mapElement = document.getElementById('nearbyLocationMap');

            if (!mapElement || !window.google || !window.google.maps) {
                return;
            }

            const center = JSON.parse(mapElement.dataset.center || '{}');
            const candidates = JSON.parse(mapElement.dataset.candidates || '[]');

            if (!center.latitude || !center.longitude) {
                return;
            }

            const map = new google.maps.Map(mapElement, {
                center: {
                    lat: Number(center.latitude),
                    lng: Number(center.longitude),
                },
                zoom: candidates.length ? 13 : 14,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                styles: [
                    { featureType: 'poi.business', stylers: [{ visibility: 'off' }] },
                    { featureType: 'transit', stylers: [{ visibility: 'off' }] },
                ],
            });

            const bounds = new google.maps.LatLngBounds();
            const infoWindow = new google.maps.InfoWindow();

            const centerMarker = new google.maps.Marker({
                position: { lat: Number(center.latitude), lng: Number(center.longitude) },
                map,
                title: center.name || 'Assessment center',
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: '#1f7a53',
                    fillOpacity: 1,
                    strokeColor: '#ffffff',
                    strokeWeight: 3,
                },
            });

            bounds.extend(centerMarker.getPosition());

            centerMarker.addListener('click', () => {
                infoWindow.setContent(
                    `<div style="max-width:220px"><strong>${center.name || 'Assessment center'}</strong><br><span style="color:#5d6d63">Assessment location</span></div>`
                );
                infoWindow.open({ anchor: centerMarker, map });
            });

            candidates.forEach((candidate, index) => {
                const marker = new google.maps.Marker({
                    position: { lat: Number(candidate.latitude), lng: Number(candidate.longitude) },
                    map,
                    title: candidate.name || `Suggested site ${index + 1}`,
                    label: {
                        text: String(index + 1),
                        color: '#ffffff',
                        fontWeight: '700',
                    },
                });

                bounds.extend(marker.getPosition());

                marker.addListener('click', () => {
                    infoWindow.setContent(
                        `<div style="max-width:260px"><strong>${candidate.name || 'Nearby site'}</strong><br><span style="color:#5d6d63">${candidate.address || 'Address unavailable'}</span><br><span style="color:#14563b">${candidate.reason || 'Potential Miyawaki planting location'}</span></div>`
                    );
                    infoWindow.open({ anchor: marker, map });
                });
            });

            if (candidates.length) {
                map.fitBounds(bounds, 64);
            }
        }
    </script>
    @if (config('services.google.maps_key'))
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ urlencode(config('services.google.maps_key')) }}&callback=initNearbyLocationMap"></script>
    @endif
</body>
</html>
