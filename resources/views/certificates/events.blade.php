@extends('layouts.user-layout')

@section('title', 'Events')

@section('content')
<style>
    :root {
        --sand:      #F7F3EC;
        --sand-dark: #EDE8DF;
        --parchment: #FAF7F2;
        --moss:      #1E2B18;
        --moss-mid:  #2E4023;
        --moss-lt:   #D6E8C8;
        --olive:     #5C7A38;
        --gold:      #C9A84C;
        --gold-lt:   #F5EDD6;
        --ink:       #131008;
        --ink-mid:   #4A4535;
        --ink-muted: #8A8370;
        --ink-faint: #C2BDB0;
        --r-sm: 6px;
        --r-md: 14px;
        --r-lg: 20px;
    }

    /* ── HERO ── */
    .hero {
        background: var(--moss);
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        background-size: 300px;
        pointer-events: none;
        z-index: 0;
    }

    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 55% 70% at 12% 65%, rgba(201,168,76,0.14) 0%, transparent 55%),
            radial-gradient(ellipse 45% 60% at 88% 28%, rgba(92,122,56,0.22) 0%, transparent 50%);
        z-index: 0;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1100px;
        margin: 0 auto;
        padding: 56px 40px 48px;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
    }

    .eyebrow-line {
        width: 24px;
        height: 1px;
        background: var(--gold);
        opacity: 0.65;
    }

    .eyebrow-text {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--gold);
        opacity: 0.85;
    }

    .hero-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(36px, 5vw, 56px);
        font-weight: 300;
        color: #FFFFFF;
        line-height: 1.05;
        letter-spacing: -0.03em;
        margin-bottom: 14px;
    }

    .hero-title em {
        font-style: italic;
        color: #A8D88A;
    }

    .hero-desc {
        font-size: 14px;
        color: rgba(255,255,255,0.42);
        line-height: 1.7;
    }

    /* ── PAGE BODY ── */
    .page-body {
        max-width: 1100px;
        margin: 0 auto;
        padding: 24px 40px 32px;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 32px;
        align-items: stretch;
    }

    /* ── MAIN COLUMN (100vh scroll area) ── */
    .main-col {
        min-width: 0;
        display: flex;
        flex-direction: column;
        height: 100vh;
        max-height: 100vh;
    }

    .events-scroll {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding-right: 6px;
        margin-right: -6px;
    }

    .events-scroll::-webkit-scrollbar { width: 6px; }
    .events-scroll::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.12);
        border-radius: 3px;
    }

    .toolbar {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .toolbar-title {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.02em;
        margin-right: auto;
    }

    .toolbar-title span {
        font-family: 'Geist', sans-serif;
        font-size: 12px;
        font-weight: 500;
        color: var(--ink-muted);
        background: rgba(0,0,0,0.05);
        padding: 3px 10px;
        border-radius: 100px;
        margin-left: 10px;
        vertical-align: middle;
    }

    .search-wrap {
        position: relative;
        width: 100%;
        max-width: 280px;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        color: var(--ink-faint);
        pointer-events: none;
    }

    #eventSearch {
        width: 100%;
        padding: 9px 12px 9px 36px;
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        color: var(--ink);
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.10);
        border-radius: var(--r-sm);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    #eventSearch::placeholder { color: var(--ink-faint); }

    #eventSearch:focus {
        border-color: var(--olive);
        box-shadow: 0 0 0 3px rgba(92,122,56,0.10);
    }

    .search-count {
        font-size: 12px;
        color: var(--ink-muted);
        white-space: nowrap;
    }

    /* Alert */
    .alert-error {
        background: var(--danger-lt, #F9EDE9);
        border: 1px solid rgba(140,44,26,0.15);
        border-radius: var(--r-md);
        padding: 14px 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: var(--danger, #8C2C1A);
    }

    .alert-error svg { flex-shrink: 0; }

    /* ── EVENT LIST ── */
    .events-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .event-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        overflow: hidden;
        display: grid;
        grid-template-columns: 140px 1fr auto;
        align-items: stretch;
        transition: border-color 0.2s, box-shadow 0.2s;
        animation: riseIn 0.45s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes riseIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .event-card:nth-child(1) { animation-delay: 0ms; }
    .event-card:nth-child(2) { animation-delay: 60ms; }
    .event-card:nth-child(3) { animation-delay: 120ms; }
    .event-card:nth-child(4) { animation-delay: 180ms; }
    .event-card:nth-child(5) { animation-delay: 240ms; }
    .event-card:nth-child(6) { animation-delay: 300ms; }

    .event-card:hover {
        border-color: rgba(0,0,0,0.12);
        box-shadow: 0 8px 28px rgba(0,0,0,0.07);
    }

    .card-thumb {
        width: 140px;
        min-height: 120px;
        background: linear-gradient(145deg, var(--moss-lt) 0%, #E8F0DC 100%);
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        min-height: 120px;
    }

    .card-thumb-placeholder {
        width: 100%;
        height: 100%;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-thumb-placeholder svg {
        width: 28px;
        height: 28px;
        color: var(--olive);
        opacity: 0.5;
    }

    .card-content {
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
    }

    .card-badges {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .badge-open {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--olive);
        background: var(--moss-lt);
        padding: 3px 9px;
        border-radius: 100px;
        border: 1px solid rgba(46,64,35,0.12);
    }

    .badge-dot {
        width: 5px;
        height: 5px;
        background: var(--olive);
        border-radius: 50%;
        animation: pulse 2.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    .badge-claims {
        font-size: 11px;
        color: var(--ink-faint);
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 17px;
        font-weight: 300;
        color: var(--ink);
        line-height: 1.3;
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }

    .card-desc {
        font-size: 12.5px;
        color: var(--ink-muted);
        line-height: 1.55;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        color: var(--ink-mid);
        background: var(--sand);
        padding: 4px 10px;
        border-radius: 100px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .chip svg {
        width: 12px;
        height: 12px;
        color: var(--ink-faint);
        flex-shrink: 0;
    }

    .card-action {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 22px;
        border-left: 1px solid rgba(0,0,0,0.05);
        background: var(--parchment);
        min-width: 148px;
    }

    .cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: var(--moss);
        color: #FFFFFF;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 500;
        padding: 10px 18px;
        border-radius: var(--r-sm);
        letter-spacing: 0.02em;
        transition: background 0.15s, transform 0.1s;
        white-space: nowrap;
        width: 100%;
    }

    .cta-btn:hover { background: var(--moss-mid); }
    .cta-btn:active { transform: scale(0.98); }

    .cta-hint {
        font-size: 10.5px;
        color: var(--ink-faint);
        margin-top: 8px;
        text-align: center;
        line-height: 1.35;
    }

    /* Empty & no-results */
    .empty-state,
    .no-results {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        padding: 64px 32px;
        text-align: center;
    }

    .no-results { display: none; }

    .empty-ring {
        width: 64px;
        height: 64px;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        background: var(--sand);
    }

    .empty-ring svg { color: var(--ink-faint); }

    .empty-title {
        font-family: 'Fraunces', serif;
        font-size: 22px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }

    .empty-desc {
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.65;
        max-width: 340px;
        margin: 0 auto;
    }

    /* Pagination */
    .pagination-wrap {
        flex-shrink: 0;
        padding-top: 16px;
        margin-top: 4px;
        border-top: 1px solid rgba(0,0,0,0.06);
    }

    .pagination-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .page-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-mid);
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.10);
        border-radius: var(--r-sm);
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s, color 0.15s;
    }

    .page-btn:hover:not(.disabled) {
        background: var(--moss-lt);
        border-color: rgba(46,64,35,0.2);
        color: var(--moss);
    }

    .page-btn.disabled {
        opacity: 0.38;
        cursor: not-allowed;
        pointer-events: none;
    }

    .page-info {
        font-size: 12px;
        color: var(--ink-muted);
        text-align: center;
    }

    .page-info strong {
        color: var(--ink);
        font-weight: 500;
    }

    /* ── SIDEBAR ── */
    .sidebar {
        position: sticky;
        top: 88px;
        align-self: start;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sidebar-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        padding: 22px;
    }

    .sidebar-card h4 {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 16px;
    }

    .step-item {
        display: flex;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 14px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .step-item:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: none;
    }

    .step-num {
        width: 24px;
        height: 24px;
        background: var(--moss);
        color: #fff;
        border-radius: 50%;
        font-size: 11px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .step-text h5 {
        font-size: 13px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 2px;
    }

    .step-text p {
        font-size: 12px;
        color: var(--ink-muted);
        line-height: 1.4;
    }

    .track-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #FFFFFF;
        background: var(--moss);
        border: 1px solid var(--moss);
        border-radius: var(--r-sm);
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(30,43,24,0.25);
        transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
    }

    .track-link svg { color: rgba(255,255,255,0.9); }

    .track-link:hover {
        background: var(--moss-mid);
        border-color: var(--moss-mid);
        box-shadow: 0 4px 14px rgba(30,43,24,0.3);
    }

    .track-link:active { transform: scale(0.99); }

    @media (max-width: 900px) {
        .page-body {
            grid-template-columns: 1fr;
            padding: 28px 24px 60px;
        }

        .sidebar { position: static; order: -1; }
        .main-col {
            height: auto;
            max-height: none;
            min-height: 60vh;
        }

        .event-card {
            grid-template-columns: 100px 1fr;
            grid-template-rows: auto auto;
        }

        .card-action {
            grid-column: 1 / -1;
            border-left: none;
            border-top: 1px solid rgba(0,0,0,0.05);
            flex-direction: row;
            justify-content: space-between;
            padding: 14px 18px;
        }

        .cta-btn { width: auto; flex: 1; max-width: 220px; }
        .cta-hint { margin-top: 0; margin-left: 12px; text-align: left; }
        .card-thumb { width: 100px; }
    }

    @media (max-width: 560px) {
        .hero-inner { padding: 40px 20px 36px; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-wrap { max-width: none; }
        .toolbar-title { margin-right: 0; }

        .event-card {
            grid-template-columns: 1fr;
        }

        .card-thumb {
            width: 100%;
            min-height: 140px;
        }

        .card-action {
            flex-direction: column;
            align-items: stretch;
        }

        .cta-btn { max-width: none; }
        .cta-hint { margin-left: 0; margin-top: 8px; text-align: center; }
    }
</style>

<!-- Hero -->
<div class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">
            <span class="eyebrow-line"></span>
            <span class="eyebrow-text">Certificate Claim</span>
        </div>
        <h1 class="hero-title">Choose your <em>event</em></h1>
        <p class="hero-desc">Browse events currently accepting certificate claims. Select an event and complete the form to request your official certificate.</p>
    </div>
</div>

<!-- Page body -->
<div class="page-body">

    <!-- Main -->
    <div class="main-col">

        @if(session('error'))
            <div class="alert-error">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="toolbar">
            <h2 class="toolbar-title">
                Available Events
                @if($events->total() > 0)
                    <span id="searchCount">{{ $events->total() }}</span>
                @endif
            </h2>
            @if($events->total() > 0)
            <div class="search-wrap">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="eventSearch" placeholder="Search events…">
            </div>
            @endif
        </div>

        <div class="events-scroll">
        <div class="events-list" id="eventsGrid">

            @if($events->total() === 0)
                <div class="empty-state">
                    <div class="empty-ring">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <h2 class="empty-title">No active events</h2>
                    <p class="empty-desc">There are no events currently accepting certificate claims. Please check back later or contact the administrator.</p>
                </div>

            @else
                @foreach($events as $event)
                <article class="event-card" data-title="{{ strtolower($event->name) }}">

                    <div class="card-thumb">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}">
                        @else
                            <div class="card-thumb-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/>
                                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="card-content">
                        <div class="card-badges">
                            <span class="badge-open">
                                <span class="badge-dot"></span>
                                Open
                            </span>
                            <span class="badge-claims">{{ $event->certificates_count }} {{ Str::plural('claim', $event->certificates_count) }}</span>
                        </div>

                        <h3 class="card-title">{{ $event->name }}</h3>

                        @if($event->description)
                            <p class="card-desc">{{ $event->description }}</p>
                        @endif

                        <div class="card-chips">
                            @if($event->date)
                            <span class="chip">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $event->date->format('d M Y') }}
                            </span>
                            @endif
                            @if($event->location)
                            <span class="chip">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $event->location }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="card-action">
                        <a href="{{ route('certificate.claim-form', $event->slug) }}" class="cta-btn">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                            </svg>
                            Claim Certificate
                        </a>
                        <span class="cta-hint">~2 min form</span>
                    </div>

                </article>
                @endforeach

                <div class="no-results" id="noResults">
                    No events match "<strong id="noResultsTerm"></strong>"
                </div>
            @endif

        </div>
        </div>

        @if($events->hasPages())
        <div class="pagination-wrap">
            <nav class="pagination-nav" aria-label="Pagination">
                @if($events->onFirstPage())
                    <span class="page-btn disabled">← Previous</span>
                @else
                    <a href="{{ $events->previousPageUrl() }}" class="page-btn">← Previous</a>
                @endif

                <span class="page-info">
                    Page <strong>{{ $events->currentPage() }}</strong> of <strong>{{ $events->lastPage() }}</strong>
                    <span style="color:var(--ink-faint)"> · </span>
                    {{ $events->total() }} {{ Str::plural('event', $events->total()) }}
                </span>

                @if($events->hasMorePages())
                    <a href="{{ $events->nextPageUrl() }}" class="page-btn">Next →</a>
                @else
                    <span class="page-btn disabled">Next →</span>
                @endif
            </nav>
        </div>
        @endif

    </div>

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="sidebar-card">
            <h4>How to Claim</h4>
            <div class="step-item">
                <span class="step-num">1</span>
                <div class="step-text">
                    <h5>Select an event</h5>
                    <p>Choose the event you attended from the list</p>
                </div>
            </div>
            <div class="step-item">
                <span class="step-num">2</span>
                <div class="step-text">
                    <h5>Complete the form</h5>
                    <p>Fill in your details and optional feedback</p>
                </div>
            </div>
            <div class="step-item">
                <span class="step-num">3</span>
                <div class="step-text">
                    <h5>Receive certificate</h5>
                    <p>PDF sent to your email once approved</p>
                </div>
            </div>
        </div>

        <a href="{{ route('certificate.track') }}" class="track-link">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Track claim status
        </a>

    </aside>

</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('eventSearch');
    const cards       = document.querySelectorAll('.event-card');
    const countEl     = document.getElementById('searchCount');
    const noResults   = document.getElementById('noResults');
    const termEl      = document.getElementById('noResultsTerm');

    searchInput?.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(card => {
            const title = card.dataset.title || '';
            const show  = title.includes(q);
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        if (countEl) countEl.textContent = visible;
        if (noResults && termEl) {
            noResults.style.display = (visible === 0 && q !== '') ? 'block' : 'none';
            termEl.textContent = this.value.trim();
        }
    });
</script>
@endpush
@endsection
