@extends('layouts.user-layout')

@section('title', 'Events')

@section('content')
<style>
    /* Hero */
    .hero {
        background: var(--ink);
        padding: 72px 40px 60px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(74,128,34,0.18) 0%, transparent 55%),
            radial-gradient(circle at 80% 20%, rgba(74,128,34,0.10) 0%, transparent 45%);
    }

    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 100px;
        padding: 5px 14px 5px 10px;
        margin-bottom: 28px;
    }

    .hero-eyebrow-dot {
        width: 6px; height: 6px;
        background: #6FCF97;
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.8); }
    }

    .hero-eyebrow-text {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.6);
    }

    .hero-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(36px, 6vw, 52px);
        font-weight: 300;
        color: #FFFFFF;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin-bottom: 16px;
        text-align: center;
    }

    .hero-title em {
        font-style: italic;
        color: #A8D88A;
        letter-spacing: -0.01em;
    }

    .hero-desc {
        font-size: 15px;
        color: rgba(255,255,255,0.5);
        line-height: 1.7;
        max-width: 520px;
        margin: 0 auto;
    }

    /* Main */
    .main {
        max-width: 1100px;
        margin: 0 auto;
        padding: 48px 40px 80px;
    }

    /* Alert */
    .alert-error {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.2);
        border-left: 3px solid var(--danger);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-error-icon { color: var(--danger); flex-shrink: 0; }
    .alert-error p { font-size: 14px; color: var(--danger); }

    /* Section Header */
    .section-head {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .section-title {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.01em;
    }

    .section-count {
        font-size: 12px;
        color: var(--ink-muted);
        background: rgba(0,0,0,0.05);
        padding: 3px 10px;
        border-radius: 100px;
    }

    /* Grid */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        gap: 20px;
    }

    /* Event Card */
    .event-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
        animation: fadeUp 0.4s ease both;
    }

    @keyframes fadeUp {
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
        border-color: rgba(0,0,0,0.14);
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        transform: translateY(-3px);
    }

    .card-accent {
        height: 3px;
        background: linear-gradient(90deg, var(--accent) 0%, var(--accent-mid) 100%);
    }

    .card-poster {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }

    .card-poster-placeholder {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, rgba(45,80,22,0.08) 0%, rgba(45,80,22,0.04) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-poster-placeholder svg {
        width: 48px;
        height: 48px;
        color: var(--accent-lt);
    }

    .card-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .card-icon {
        width: 40px; height: 40px;
        background: var(--accent-lt);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-icon svg { color: var(--accent); }

    .card-status {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--accent);
        background: var(--accent-lt);
        padding: 3px 10px;
        border-radius: 100px;
        border: 1px solid rgba(45,80,22,0.15);
    }

    .card-title {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink);
        line-height: 1.35;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }

    .card-desc {
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
    }

    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 7px;
        padding: 16px 0;
        border-top: 1px solid rgba(0,0,0,0.06);
        border-bottom: 1px solid rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }

    .meta-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-icon {
        width: 16px; height: 16px;
        color: var(--ink-faint);
        flex-shrink: 0;
    }

    .meta-text {
        font-size: 12.5px;
        color: var(--ink-mid);
    }

    .card-cta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .cta-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--ink);
        color: #FFFFFF;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        padding: 11px 20px;
        border-radius: var(--radius-sm);
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .cta-btn:hover {
        background: #2A2821;
    }

    .cta-btn:active {
        transform: scale(0.98);
    }

    .cta-btn svg { flex-shrink: 0; }

    .claims-badge {
        font-size: 12px;
        color: var(--ink-muted);
        white-space: nowrap;
    }

    .empty-state {
        grid-column: 1 / -1;
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 72px 40px;
        text-align: center;
    }

    .empty-icon {
        width: 64px; height: 64px;
        background: rgba(0,0,0,0.04);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .empty-icon svg { color: var(--ink-faint); }

    .empty-title {
        font-family: 'Fraunces', serif;
        font-size: 22px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 10px;
    }

    .empty-desc {
        font-size: 14px;
        color: var(--ink-muted);
        line-height: 1.6;
        max-width: 340px;
        margin: 0 auto;
    }

    @media (max-width: 640px) {
        .hero { padding: 48px 20px 40px; }
        .main { padding: 32px 20px 60px; }
    }
</style>

<!-- Hero -->
<div class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-dot"></span>
            <span class="hero-eyebrow-text">Certificates Open</span>
        </div>
        <h1 class="hero-title">Claim your<br><em>certificate</em></h1>
        <p class="hero-desc">Browse active events below and submit your claim. Your certificate will be reviewed and delivered to your inbox.</p>
    </div>
</div>

<!-- Main Content -->
<main class="main">

    @if(session('error'))
        <div class="alert-error">
            <div class="alert-error-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="search-bar" style="margin-bottom: 32px;">
        <div style="position: relative;">
            <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--ink-faint);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="eventSearch" placeholder="Search events..." style="width: 100%; padding: 14px 16px 14px 48px; font-family: 'Geist', sans-serif; font-size: 14px; color: var(--ink); background: var(--card); border: 1px solid rgba(0,0,0,0.12); border-radius: var(--radius-sm); transition: border-color 0.2s, box-shadow 0.2s;">
        </div>
    </div>

    @if($events->count() > 0)
    <div class="section-head">
        <h2 class="section-title">Available events</h2>
        <span class="section-count">{{ $events->count() }} event{{ $events->count() !== 1 ? 's' : '' }}</span>
    </div>
    @endif

    <div class="events-grid">

        @if($events->count() === 0)
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                    </svg>
                </div>
                <h2 class="empty-title">No active events</h2>
                <p class="empty-desc">There are no events currently accepting certificate claims. Please check back later or contact the administrator.</p>
            </div>

        @else
            @foreach($events as $event)
            <div class="event-card">
                <div class="card-accent"></div>
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}" class="card-poster">
                @else
                    <div class="card-poster-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                @endif
                <div class="card-body">

                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                        </div>
                        <span class="card-status">Open</span>
                    </div>

                    <h3 class="card-title">{{ $event->name }}</h3>

                    @if($event->description)
                        <p class="card-desc">{{ Str::limit($event->description, 110) }}</p>
                    @else
                        <div style="flex:1"></div>
                    @endif

                    <div class="card-meta">
                        @if($event->date)
                        <div class="meta-row">
                            <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span class="meta-text">{{ $event->date->format('d F Y') }}</span>
                        </div>
                        @endif
                        @if($event->location)
                        <div class="meta-row">
                            <svg class="meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span class="meta-text">{{ $event->location }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="card-cta">
                        <a href="{{ route('certificate.claim-form', $event->slug) }}" class="cta-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                            </svg>
                            Claim Certificate
                        </a>
                        <span class="claims-badge">{{ $event->certificates->count() }} submitted</span>
                    </div>

                </div>
            </div>
            @endforeach
        @endif

    </div>
</main>

@push('scripts')
<script>
    document.getElementById('eventSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.event-card');
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection