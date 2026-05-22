@extends('layouts.user-layout')

@section('title', 'Events')

@section('content')
<style>
    /* ── TOKENS ── */
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
        padding: 0;
    }

    /* decorative grain overlay */
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        background-size: 300px;
        pointer-events: none;
        z-index: 0;
    }

    /* radial glows */
    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 15% 60%, rgba(201,168,76,0.12) 0%, transparent 60%),
            radial-gradient(ellipse 50% 70% at 85% 30%, rgba(92,122,56,0.20) 0%, transparent 55%);
        z-index: 0;
    }

    .hero-layout {
        position: relative;
        z-index: 1;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 40px;
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: end;
        gap: 40px;
        padding-top: 72px;
        padding-bottom: 60px;
    }

    .hero-left {}

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .eyebrow-line {
        width: 28px;
        height: 1px;
        background: var(--gold);
        opacity: 0.6;
    }

    .eyebrow-text {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--gold);
        opacity: 0.8;
    }

    .hero-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(44px, 6vw, 72px);
        font-weight: 300;
        color: #FFFFFF;
        line-height: 1.0;
        letter-spacing: -0.03em;
        margin-bottom: 20px;
    }

    .hero-title em {
        font-style: italic;
        color: #A8D88A;
    }

    .hero-title sup {
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 400;
        vertical-align: super;
        color: rgba(255,255,255,0.35);
        letter-spacing: 0.02em;
        margin-left: 4px;
    }

    .hero-desc {
        font-size: 14px;
        color: rgba(255,255,255,0.42);
        line-height: 1.75;
        max-width: 420px;
    }

    /* Stats column */
    .hero-stats {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0;
        padding-bottom: 4px;
    }

    .stat-block {
        text-align: right;
        padding: 14px 0;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .stat-block:last-child { border-bottom: none; }

    .stat-num {
        font-family: 'Fraunces', serif;
        font-size: 32px;
        font-weight: 300;
        color: #FFFFFF;
        line-height: 1;
        letter-spacing: -0.03em;
    }

    .stat-label {
        font-size: 10px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.3);
        margin-top: 3px;
    }

    /* ── SEARCH STRIP ── */
    .search-strip {
        background: var(--parchment);
        border-bottom: 1px solid rgba(0,0,0,0.07);
        padding: 0 40px;
    }

    .search-inner {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 0;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px; height: 16px;
        color: var(--ink-faint);
        pointer-events: none;
    }

    #eventSearch {
        width: 100%;
        padding: 10px 14px 10px 40px;
        font-family: 'Geist', sans-serif;
        font-size: 13.5px;
        color: var(--ink);
        background: #FFFFFF;
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
        margin-left: auto;
    }

    /* ── MAIN ── */
    .main {
        max-width: 1100px;
        margin: 0 auto;
        padding: 48px 40px 80px;
    }

    /* Alert */
    .alert-error {
        background: #FDF0EE;
        border: 1px solid rgba(140,44,26,0.18);
        border-left: 3px solid #8C2C1A;
        border-radius: var(--r-md);
        padding: 14px 18px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-error-icon { color: #8C2C1A; flex-shrink: 0; }
    .alert-error p { font-size: 14px; color: #8C2C1A; }

    /* Section head */
    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .section-head-left {
        display: flex;
        align-items: baseline;
        gap: 12px;
    }

    .section-title {
        font-family: 'Fraunces', serif;
        font-size: 18px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .section-count {
        font-size: 11px;
        color: var(--ink-faint);
        background: rgba(0,0,0,0.05);
        padding: 2px 9px;
        border-radius: 100px;
    }

    /* ── GRID ── */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 18px;
    }

    /* ── EVENT CARD ── */
    .event-card {
        background: var(--parchment);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
        animation: riseIn 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes riseIn {
        from { opacity: 0; transform: translateY(20px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    .event-card:nth-child(1) { animation-delay: 0ms; }
    .event-card:nth-child(2) { animation-delay: 80ms; }
    .event-card:nth-child(3) { animation-delay: 160ms; }
    .event-card:nth-child(4) { animation-delay: 240ms; }
    .event-card:nth-child(5) { animation-delay: 320ms; }
    .event-card:nth-child(6) { animation-delay: 400ms; }

    .event-card:hover {
        border-color: rgba(0,0,0,0.12);
        box-shadow: 0 12px 40px rgba(0,0,0,0.09), 0 2px 8px rgba(0,0,0,0.04);
        transform: translateY(-4px) scale(1.005);
    }

    /* Poster */
    .card-poster {
        width: 100%;
        height: 192px;
        object-fit: cover;
        display: block;
    }

    .card-poster-placeholder {
        width: 100%;
        height: 192px;
        background: linear-gradient(145deg, var(--moss-lt) 0%, #E8F0DC 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* decorative circles in placeholder */
    .card-poster-placeholder::before {
        content: '';
        position: absolute;
        width: 180px; height: 180px;
        border: 1px solid rgba(45,64,35,0.12);
        border-radius: 50%;
        top: -40px; right: -40px;
    }

    .card-poster-placeholder::after {
        content: '';
        position: absolute;
        width: 100px; height: 100px;
        border: 1px solid rgba(45,64,35,0.08);
        border-radius: 50%;
        bottom: -20px; left: 20px;
    }

    .placeholder-icon-wrap {
        position: relative;
        z-index: 1;
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .placeholder-icon-wrap svg {
        width: 22px; height: 22px;
        color: var(--olive);
    }

    /* Card body */
    .card-body {
        padding: 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Top row: status + index */
    .card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .card-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--olive);
        background: var(--moss-lt);
        padding: 4px 10px;
        border-radius: 100px;
        border: 1px solid rgba(46,64,35,0.15);
    }

    .status-dot {
        width: 5px; height: 5px;
        background: var(--olive);
        border-radius: 50%;
        animation: pulse 2.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0.4; }
    }

    .card-index {
        font-family: 'Fraunces', serif;
        font-size: 28px;
        font-weight: 300;
        color: var(--ink-faint);
        letter-spacing: -0.04em;
        line-height: 1;
        opacity: 0.5;
    }

    /* Title */
    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 17px;
        font-weight: 300;
        color: var(--ink);
        line-height: 1.35;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }

    .card-desc {
        font-size: 12.5px;
        color: var(--ink-muted);
        line-height: 1.65;
        margin-bottom: 18px;
        flex: 1;
    }

    /* Meta */
    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 14px 0;
        border-top: 1px solid rgba(0,0,0,0.06);
        margin-bottom: 18px;
    }

    .meta-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-icon {
        width: 14px; height: 14px;
        color: var(--ink-faint);
        flex-shrink: 0;
    }

    .meta-text {
        font-size: 12px;
        color: var(--ink-mid);
    }

    /* CTA */
    .card-cta {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cta-btn {
        flex: 1;
        display: flex;
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
        transition: background 0.2s, transform 0.1s;
        white-space: nowrap;
    }

    .cta-btn:hover { background: var(--moss-mid); }
    .cta-btn:active { transform: scale(0.98); }

    .claims-badge {
        font-size: 11px;
        color: var(--ink-faint);
        white-space: nowrap;
        text-align: right;
        line-height: 1.3;
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        grid-column: 1 / -1;
        background: var(--parchment);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        padding: 80px 40px;
        text-align: center;
    }

    .empty-ring {
        width: 72px; height: 72px;
        border: 1px solid rgba(0,0,0,0.09);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .empty-ring svg { color: var(--ink-faint); }

    .empty-title {
        font-family: 'Fraunces', serif;
        font-size: 24px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 10px;
        letter-spacing: -0.02em;
    }

    .empty-desc {
        font-size: 13.5px;
        color: var(--ink-muted);
        line-height: 1.7;
        max-width: 360px;
        margin: 0 auto;
    }

    /* ── NO RESULTS (JS) ── */
    .no-results {
        display: none;
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: var(--ink-muted);
        font-size: 14px;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .hero-layout {
            grid-template-columns: 1fr;
            padding: 48px 24px 40px;
            gap: 32px;
        }

        .hero-stats {
            flex-direction: row;
            align-items: flex-start;
            gap: 24px;
        }

        .stat-block {
            text-align: left;
            border-bottom: none;
            border-right: 1px solid rgba(255,255,255,0.07);
            padding-right: 24px;
        }
        .stat-block:last-child { border-right: none; }

        .search-strip { padding: 0 24px; }

        .main { padding: 32px 24px 60px; }

        .events-grid { grid-template-columns: 1fr; gap: 14px; }

        .card-index { display: none; }
    }

    @media (max-width: 480px) {
        .hero-stats { flex-wrap: wrap; gap: 16px; }
        .stat-num { font-size: 26px; }
        .empty-state { padding: 52px 24px; }
    }
</style>

<!-- ── HERO ── -->
<div class="hero">
    <div class="hero-layout">
        <div class="hero-left">
            <div class="hero-eyebrow">
                <span class="eyebrow-line"></span>
                <span class="eyebrow-text">Certificates Open</span>
            </div>
            <h1 class="hero-title">
                Claim your<br><em>certificate</em><sup>&#10022;</sup>
            </h1>
            <p class="hero-desc">Browse active events and submit your claim. Your certificate will be reviewed and delivered to your inbox.</p>
        </div>

    </div>
</div>

<!-- ── SEARCH STRIP ── -->
<div class="search-strip">
    <div class="search-inner">
        <div class="search-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="eventSearch" placeholder="Search events…">
        </div>
        @if($events->count() > 0)
        <span class="search-count" id="searchCount">{{ $events->count() }} event{{ $events->count() !== 1 ? 's' : '' }}</span>
        @endif
    </div>
</div>

<!-- ── MAIN ── -->
<main class="main">

    @if(session('error'))
        <div class="alert-error">
            <div class="alert-error-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($events->count() > 0)
    <div class="section-head">
        <div class="section-head-left">
            <h2 class="section-title">Available events</h2>
            <span class="section-count">{{ $events->count() }}</span>
        </div>
    </div>
    @endif

    <div class="events-grid" id="eventsGrid">

        @if($events->count() === 0)
            <div class="empty-state">
                <div class="empty-ring">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                    </svg>
                </div>
                <h2 class="empty-title">No active events</h2>
                <p class="empty-desc">There are no events currently accepting certificate claims. Please check back later or contact the administrator.</p>
            </div>

        @else
            @foreach($events as $i => $event)
            <div class="event-card" data-title="{{ strtolower($event->name) }}">

                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}" class="card-poster">
                @else
                    <div class="card-poster-placeholder">
                        <div class="placeholder-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/>
                                <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    <div class="card-top">
                        <span class="card-status">
                            <span class="status-dot"></span>
                            Open
                        </span>
                    </div>

                    <h3 class="card-title">{{ $event->name }}</h3>

                    @if($event->description)
                        <p class="card-desc">{{ Str::limit($event->description, 110) }}</p>
                    @else
                        <div style="flex:1;min-height:8px;"></div>
                    @endif

                    <div class="card-meta">
                        @if($event->date)
                        <div class="meta-row">
                            <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span class="meta-text">{{ $event->date->format('d F Y') }}</span>
                        </div>
                        @endif
                        @if($event->location)
                        <div class="meta-row">
                            <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span class="meta-text">{{ $event->location }}</span>
                        </div>
                        @endif
                        <div class="meta-row">
                            <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                            <span class="meta-text">{{ $event->certificates->count() }} claim{{ $event->certificates->count() !== 1 ? 's' : '' }} submitted</span>
                        </div>
                    </div>

                    <div class="card-cta">
                        <a href="{{ route('certificate.claim-form', $event->slug) }}" class="cta-btn">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                            </svg>
                            Claim Certificate
                        </a>
                    </div>

                </div>
            </div>
            @endforeach

            <!-- No results placeholder (JS-driven) -->
            <div class="no-results" id="noResults">
                No events match "<span id="noResultsTerm"></span>"
            </div>
        @endif

    </div>
</main>

@push('scripts')
<script>
    const searchInput  = document.getElementById('eventSearch');
    const cards        = document.querySelectorAll('.event-card');
    const countEl      = document.getElementById('searchCount');
    const noResults    = document.getElementById('noResults');
    const termEl       = document.getElementById('noResultsTerm');
    const total        = cards.length;

    searchInput?.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(card => {
            const title = card.dataset.title || '';
            const show  = title.includes(q);
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        if (countEl) countEl.textContent = `${visible} event${visible !== 1 ? 's' : ''}`;
        if (noResults && termEl) {
            noResults.style.display = (visible === 0 && q !== '') ? 'block' : 'none';
            termEl.textContent = this.value.trim();
        }
    });
</script>
@endpush
@endsection