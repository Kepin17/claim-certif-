@extends('layouts.user-layout')

@section('title', 'Events')

@push('scripts')
@include('certificates.partials.oui-shared')
<style>
    /* Modern Hero with gradient */
    .oui-hero-modern {
        background: linear-gradient(135deg, #3478F6 0%, #1A54C4 100%);
        padding: 48px 24px 52px;
        position: relative;
        height: 350px;
        overflow: hidden;
    }
    .oui-hero-modern::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .oui-hero-modern::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .oui-hero-inner-modern {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    .oui-hero-label-modern {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.85);
        margin-bottom: 12px;
    }
    .oui-hero-title-modern {
        font-size: 38px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.8px;
        line-height: 1.1;
        margin-bottom: 16px;
    }
    .oui-hero-desc-modern {
        font-size: 16px;
        color: rgba(255,255,255,0.9);
        line-height: 1.6;
        max-width: 580px;
    }

    /* Feature cards in hero */
    .oui-hero-features {
        display: flex;
        gap: 16px;
        margin-top: 28px;
        flex-wrap: wrap;
    }
    .oui-hero-feature {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
    }
    .oui-hero-feature svg {
        width: 16px; height: 16px;
        flex-shrink: 0;
    }

    /* Section container */
    .oui-events-wrap {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .oui-page {
        background: #F2F3F5;
    }

    /* Search bar floating */
    .oui-search-float {
        background: #fff;
        border-radius: 20px;
        padding: 20px 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
        margin: -32px auto 32px;
        max-width: 700px;
        position: relative;
        top: -30px;
        z-index: 10;
    }
    .oui-search-float .oui-search-field {
        height: 54px;
        border-radius: 14px;
    }
    .oui-search-float .oui-search-btn {
        height: 54px;
        padding: 0 28px;
    }

    /* Events grid */
    .oui-events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 40px;
    }

    /* Event card - horizontal layout */
    .oui-event-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: row;
        align-items: stretch;
    }
    .oui-event-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1), 0 12px 32px rgba(0,0,0,0.06);
    }

    .oui-event-image {
        width: 180px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #EBF2FF 0%, #E0E8FF 100%);
        position: relative;
        overflow: hidden;
    }
    .oui-event-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
    }
    .oui-event-image-ph {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .oui-event-image-ph svg {
        width: 48px;
        height: 48px;
        color: #3478F6;
        opacity: 0.5;
    }

    .oui-event-content {
        padding: 20px 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .oui-event-title {
        font-size: 16px;
        font-weight: 700;
        color: #1C1C1E;
        line-height: 1.35;
        margin-bottom: 8px;
    }

    .oui-event-details {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }
    .oui-event-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #8E8E93;
    }
    .oui-event-detail svg {
        width: 14px; height: 14px;
        flex-shrink: 0;
        color: #3478F6;
    }

    .oui-event-footer {
        margin-top: auto;
        padding-top: 12px;
    }
    .oui-claim-btn-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        background: #3478F6;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 12px;
        transition: background 0.15s, transform 0.1s;
    }
    .oui-claim-btn-card:hover {
        background: #2563EB;
        color: #fff;
    }
    .oui-claim-btn-card:active {
        transform: scale(0.98);
    }

    /* No results */
    .oui-no-results {
        grid-column: 1 / -1;
        padding: 48px 24px;
        text-align: center;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .oui-no-results strong {
        color: #1C1C1E;
    }

    /* How it works section */
    .oui-how-section {
        background: #fff;
        border-radius: 24px;
        padding: 36px 32px;
        margin-bottom: 40px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .oui-how-title {
        font-size: 22px;
        font-weight: 700;
        color: #1C1C1E;
        text-align: center;
        margin-bottom: 32px;
    }
    .oui-how-steps {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }
    .oui-how-step {
        text-align: center;
    }
    .oui-how-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #EBF2FF 0%, #E0E8FF 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .oui-how-icon svg {
        width: 28px; height: 28px;
        color: #3478F6;
    }
    .oui-how-step h4 {
        font-size: 15px;
        font-weight: 700;
        color: #1C1C1E;
        margin-bottom: 8px;
    }
    .oui-how-step p {
        font-size: 13px;
        color: #8E8E93;
        line-height: 1.5;
    }

    /* Quick actions */
    .oui-quick-actions {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }
    .oui-quick-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 24px;
        background: #fff;
        color: #3478F6;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 50px;
        border: 1.5px solid #E5E5EA;
        transition: all 0.15s;
    }
    .oui-quick-action:hover {
        background: #EBF2FF;
        border-color: #3478F6;
        color: #3478F6;
    }
    .oui-quick-action svg {
        width: 16px; height: 16px;
    }

    /* Pagination */
    .oui-pagination-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-top: 32px;
    }

    @media (max-width: 900px) {
        .oui-events-grid { grid-template-columns: repeat(2, 1fr); }
        .oui-how-steps { grid-template-columns: 1fr; gap: 24px; }
        .oui-hero-title-modern { font-size: 30px; }
    }
    @media (max-width: 600px) {
        .oui-events-grid { grid-template-columns: 1fr; }
        .oui-event-card { flex-direction: column; }
        .oui-event-image { width: 100%; height: 180px; }
        .oui-claim-btn-card { width: 100%; justify-content: center; }
        .oui-hero-modern { padding: 36px 16px 40px; }
        .oui-hero-title-modern { font-size: 26px; }
        .oui-hero-desc-modern { font-size: 14px; }
        .oui-search-float { margin: -20px 12px 24px; padding: 14px; top: -20px; }
        .oui-search-float .oui-search-wrap { flex-direction: column; gap: 10px; }
        .oui-search-float .oui-search-field { height: 48px; width: 100%; }
        .oui-search-float .oui-search-btn { height: 44px; padding: 0 20px; width: 100%; }
        .oui-how-section { padding: 28px 20px; }
        .oui-quick-actions { flex-direction: column; }
        .oui-quick-action { width: 100%; justify-content: center; }
    }
    @media (max-width: 400px) {
        .oui-search-float { margin: -16px 8px 20px; padding: 12px; }
        .oui-hero-title-modern { font-size: 22px; }
        .oui-hero-features { flex-direction: column; gap: 10px; }
        .oui-hero-feature { font-size: 12px; padding: 8px 12px; }
    }

    /* Dark mode overrides */
    [data-theme="dark"] .oui-page {
        background: #1C1C1E;
    }
    [data-theme="dark"] .oui-hero-modern {
        background: linear-gradient(135deg, #1A54C4 0%, #0D3A8A 100%);
    }
    [data-theme="dark"] .oui-hero-feature {
        background: rgba(0,0,0,0.2);
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-hero-feature svg {
        color: #6FCF97;
    }
    [data-theme="dark"] .oui-event-card {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-event-image {
        background: linear-gradient(135deg, #3A3A3C 0%, #2C2C2E 100%);
    }
    [data-theme="dark"] .oui-event-title {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-event-detail {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-event-footer {
        border-top-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-search-float {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-search-field {
        background: #3A3A3C;
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-search-field:focus {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-search-field input::placeholder {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-search-btn {
        background: #3478F6;
    }
    [data-theme="dark"] .oui-count-pill {
        background: #2C2C2E;
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-count-dot {
        background: #3478F6;
    }
    [data-theme="dark"] .oui-how-section {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-how-title {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-how-step h4 {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-how-step p {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-how-icon {
        background: linear-gradient(135deg, #3A3A3C 0%, #2C2C2E 100%);
    }
    [data-theme="dark"] .oui-quick-action {
        background: #2C2C2E;
        color: #3478F6;
        border-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-quick-action:hover {
        background: #3A3A3C;
    }
    [data-theme="dark"] .oui-no-results {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-no-results strong {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-empty-icon {
        background: #3A3A3C;
    }
    [data-theme="dark"] .oui-empty-icon svg {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-empty-title {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-empty-desc {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-pagination a {
        background: #2C2C2E;
        color: #3478F6;
    }
    [data-theme="dark"] .oui-pagination a:hover {
        background: #3A3A3C;
    }
    [data-theme="dark"] .oui-pagination span.oui-page-active {
        background: #3478F6;
        color: #fff;
    }
    [data-theme="dark"] .oui-pagination span.oui-page-disabled {
        background: #3A3A3C;
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-pagination-info {
        color: #8E8E93;
    }
</style>
@endpush

@section('content')
<div class="oui-page">

    <!-- Modern Hero -->
    <div class="oui-hero-modern">
        <div class="oui-hero-inner-modern">
            <p class="oui-hero-label-modern">Certificate Claim System</p>
            <h1 class="oui-hero-title-modern">Claim Your Event Certificate</h1>
            <p class="oui-hero-desc-modern">Select your event, complete the claim form, and receive your certificate via email after approval.</p>
            <div class="oui-hero-features">
                <span class="oui-hero-feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Simple Process
                </span>
                <span class="oui-hero-feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Verified Certificates
                </span>
                <span class="oui-hero-feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Email Delivery
                </span>
            </div>
        </div>
    </div>

    <div class="oui-section oui-events-wrap">

        <!-- Floating Search -->
        <div class="oui-search-float">
            <form method="GET" action="{{ route('certificate.index') }}">
                <div class="oui-search-wrap">
                    <label class="oui-search-field">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" id="eventSearch" placeholder="Search events...">
                    </label>
                    <button type="submit" class="oui-search-btn">Search</button>
                </div>
            </form>
        </div>

        @if(session('error'))
            <div class="oui-alert oui-alert-error" style="margin-bottom:20px">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Count pill -->
        @if($events->total() > 0)
        <div class="oui-count-pill" style="margin-bottom:20px">
            <span class="oui-count-dot"></span>
            <span id="searchCount">{{ $events->total() }}</span> {{ Str::plural('event', $events->total()) }} available
        </div>
        @endif

        <!-- Events Grid -->
        <div class="oui-events-grid" id="eventsGrid">

            @if($events->total() === 0)
                <div class="oui-no-results">
                    <div class="oui-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div class="oui-empty-title">No active events</div>
                    <div class="oui-empty-desc">Please check back later or contact the administrator.</div>
                </div>

            @else
                @foreach($events as $event)
                <article class="oui-event-card" data-title="{{ strtolower($event->name) }}">

                    <div class="oui-event-image">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="">
                        @else
                            <div class="oui-event-image-ph">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="oui-event-content">
                        <h3 class="oui-event-title">{{ $event->name }}</h3>
                        <div class="oui-event-details">
                            @if($event->date)
                            <div class="oui-event-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $event->date->format('d M Y') }}
                            </div>
                            @endif
                            @if($event->location)
                            <div class="oui-event-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $event->location }}
                            </div>
                            @endif
                            @if($event->certificates_count > 0)
                            <div class="oui-event-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                {{ $event->certificates_count }} {{ Str::plural('claim', $event->certificates_count) }}
                            </div>
                            @endif
                        </div>
                        <div class="oui-event-footer">
                            <a href="{{ route('certificate.claim-form', $event->slug) }}" class="oui-claim-btn-card">
                                Claim
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </article>
                @endforeach

                <div class="oui-no-results" id="noResults" style="display:none">
                    No events match "<strong id="noResultsTerm"></strong>"
                </div>
            @endif

        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="oui-pagination-wrap">
            <div class="oui-pagination">
                @if($events->onFirstPage())
                    <span class="oui-page-disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $events->previousPageUrl() }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($events->getUrlRange(max(1, $events->currentPage()-2), min($events->lastPage(), $events->currentPage()+2)) as $page => $url)
                    @if($page == $events->currentPage())
                        <span class="oui-page-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($events->hasMorePages())
                    <a href="{{ $events->nextPageUrl() }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="oui-page-disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
            <p class="oui-pagination-info">
                Showing {{ $events->firstItem() }}–{{ $events->lastItem() }} of {{ $events->total() }} events
            </p>
        </div>
        @endif

        <!-- How It Works -->
        <div class="oui-how-section">
            <h2 class="oui-how-title">How It Works</h2>
            <div class="oui-how-steps">
                <div class="oui-how-step">
                    <div class="oui-how-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h4>Select Event</h4>
                    <p>Choose the event you participated in from the list above.</p>
                </div>
                <div class="oui-how-step">
                    <div class="oui-how-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                    <h4>Complete Form</h4>
                    <p>Fill in your details and submit the claim form.</p>
                </div>
                <div class="oui-how-step">
                    <div class="oui-how-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <h4>Receive Certificate</h4>
                    <p>Get your certificate via email after approval.</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="oui-quick-actions">
            <a href="{{ route('certificate.track') }}" class="oui-quick-action">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Track Claim Status
            </a>
            <a href="{{ route('certificate.participant-dashboard') }}" class="oui-quick-action">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                </svg>
                My Certificates
            </a>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('eventSearch');
    const cards       = document.querySelectorAll('.oui-event-card');
    const countEl     = document.getElementById('searchCount');
    const countPill   = countEl?.closest('.oui-count-pill');
    const noResults   = document.getElementById('noResults');
    const termEl      = document.getElementById('noResultsTerm');
    const grid        = document.getElementById('eventsGrid');

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
        if (countPill) countPill.innerHTML = `<span class="oui-count-dot"></span><span id="searchCount">${visible}</span> ${visible === 1 ? 'event' : 'events'} available`;

        if (noResults && termEl) {
            noResults.style.display = (visible === 0 && q !== '') ? 'block' : 'none';
            termEl.textContent = this.value.trim();
        }
    });
</script>
@endpush
@endsection
