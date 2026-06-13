@extends('layouts.user-layout')

@section('title', 'Events')

@push('scripts')
@include('certificates.partials.oui-shared')
<style>
    /* ─── Base ─────────────────────────────────── */
    .ev-page { background: var(--surface); min-height: 100vh; }

    /* ─── Hero ──────────────────────────────────── */
    .ev-hero {
        background: linear-gradient(135deg, #3478F6 0%, #1A54C4 100%);
        padding: 60px 24px 100px;
        position: relative;
        overflow: hidden;
    }
    .ev-hero::before {
        content: '';
        position: absolute;
        top: -40%; right: -15%;
        width: 700px; height: 700px;
        background: radial-gradient(circle, rgba(255,255,255,0.09) 0%, transparent 65%);
        border-radius: 50%;
        pointer-events: none;
    }
    .ev-hero::after {
        content: '';
        position: absolute;
        bottom: -40%; left: -10%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 65%);
        border-radius: 50%;
        pointer-events: none;
    }
    .ev-hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    .ev-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.8);
        background: rgba(255,255,255,0.12);
        padding: 5px 12px;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.2);
        margin-bottom: 20px;
    }
    .ev-hero-label svg { width: 13px; height: 13px; }
    .ev-hero-title {
        font-size: 46px;
        font-weight: 900;
        color: #fff;
        letter-spacing: -1.2px;
        line-height: 1.05;
        margin-bottom: 16px;
        max-width: 660px;
    }
    .ev-hero-desc {
        font-size: 17px;
        color: rgba(255,255,255,0.88);
        line-height: 1.65;
        max-width: 540px;
        margin-bottom: 32px;
    }
    .ev-hero-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .ev-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 16px;
        background: rgba(255,255,255,0.18);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.28);
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
    }
    .ev-hero-badge svg { width: 15px; height: 15px; }

    /* ─── Main wrap ─────────────────────────────── */
    .ev-main {
        max-width: 1200px;
        margin: -52px auto 0;
        padding: 0 24px 60px;
        position: relative;
        z-index: 2;
    }

    /* ─── Search bar ────────────────────────────── */
    .ev-search-card {
        background: var(--card);
        border-radius: 20px;
        padding: 16px 18px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 32px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .ev-search-input-wrap {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface);
        border-radius: 13px;
        padding: 0 16px;
        height: 50px;
    }
    .ev-search-input-wrap svg {
        width: 18px; height: 18px;
        color: #AEAEB2;
        flex-shrink: 0;
    }
    .ev-search-input-wrap input {
        flex: 1;
        border: none;
        background: transparent;
        font-family: 'Geist', sans-serif;
        font-size: 15px;
        color: var(--ink);
        outline: none;
    }
    .ev-search-input-wrap input::placeholder { color: #AEAEB2; }
    .ev-search-btn {
        height: 50px;
        padding: 0 22px;
        background: #3478F6;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        font-family: inherit;
        border: none;
        border-radius: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
        box-shadow: 0 2px 10px rgba(52,120,246,0.3);
    }
    .ev-search-btn:hover { background: #2563EB; }
    .ev-search-btn:active { transform: scale(0.97); }
    .ev-search-btn svg { width: 16px; height: 16px; }
    .ev-search-btn .btn-text { display: block; }
    .ev-search-btn .btn-icon { display: none; }

    /* ─── Section header ────────────────────────── */
    .ev-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
    }
    .ev-section-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.3px;
    }
    .ev-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(52,120,246,0.1);
        color: #3478F6;
        font-size: 13px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
    }
    .ev-count-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #3478F6;
    }

    /* ─── Events grid ───────────────────────────── */
    .ev-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 36px;
    }

    /* ─── Event card (vertical) ─────────────────── */
    .ev-card {
        background: var(--card);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .ev-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.1);
    }
    .ev-card-image {
        width: 100%;
        aspect-ratio: 16/9;
        background: linear-gradient(135deg, #EBF2FF 0%, #D8E8FF 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .ev-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .ev-card-image-ph svg {
        width: 48px; height: 48px;
        color: #3478F6;
        opacity: 0.4;
    }
    .ev-card-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .ev-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.35;
        margin-bottom: 10px;
    }
    .ev-card-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 16px;
    }
    .ev-card-meta-row {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12.5px;
        color: var(--ink-muted);
    }
    .ev-card-meta-row svg {
        width: 13px; height: 13px;
        flex-shrink: 0;
        color: #3478F6;
    }
    .ev-card-footer { margin-top: auto; }
    .ev-claim-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 20px;
        background: #3478F6;
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        border-radius: 12px;
        transition: background 0.15s, transform 0.1s;
        box-shadow: 0 2px 8px rgba(52,120,246,0.25);
    }
    .ev-claim-btn:hover { background: #2563EB; color: #fff; }
    .ev-claim-btn:active { transform: scale(0.98); }
    .ev-claim-btn svg { width: 15px; height: 15px; }

    /* ─── Empty state ───────────────────────────── */
    .ev-empty {
        grid-column: 1 / -1;
        padding: 56px 24px;
        text-align: center;
        background: var(--card);
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .ev-empty-icon {
        width: 72px; height: 72px;
        background: var(--surface);
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
    }
    .ev-empty-icon svg { width: 32px; height: 32px; color: #AEAEB2; }
    .ev-empty-title { font-size: 17px; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
    .ev-empty-desc { font-size: 14px; color: var(--ink-muted); }

    /* ─── Pagination ────────────────────────────── */
    .ev-pagination-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-bottom: 40px;
    }

    /* ─── Divider section ───────────────────────── */
    .ev-divider {
        height: 1px;
        background: rgba(0,0,0,0.06);
        margin: 40px 0;
    }

    /* ─── How It Works ──────────────────────────── */
    .ev-how {
        background: var(--card);
        border-radius: 24px;
        padding: 40px 36px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 24px;
    }
    .ev-how-head {
        text-align: center;
        margin-bottom: 36px;
    }
    .ev-how-head h2 {
        font-size: 24px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.3px;
        margin-bottom: 6px;
    }
    .ev-how-head p {
        font-size: 14px;
        color: var(--ink-muted);
    }
    .ev-how-steps {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        position: relative;
    }
    .ev-how-step {
        text-align: center;
        padding: 28px 20px;
        background: var(--surface);
        border-radius: 18px;
        position: relative;
    }
    .ev-how-num {
        position: absolute;
        top: 16px;
        left: 20px;
        font-size: 11px;
        font-weight: 800;
        color: #3478F6;
        background: rgba(52,120,246,0.1);
        width: 24px;
        height: 24px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ev-how-icon {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, rgba(52,120,246,0.12) 0%, rgba(52,120,246,0.06) 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .ev-how-icon svg { width: 26px; height: 26px; color: #3478F6; }
    .ev-how-step h4 {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 6px;
    }
    .ev-how-step p {
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.5;
    }

    /* ─── Quick Actions ─────────────────────────── */
    .ev-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 8px;
    }
    .ev-action {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 20px;
        background: var(--card);
        border: 1.5px solid rgba(0,0,0,0.06);
        border-radius: 18px;
        text-decoration: none;
        transition: all 0.16s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .ev-action:hover {
        border-color: #3478F6;
        box-shadow: 0 4px 16px rgba(52,120,246,0.12);
        transform: translateY(-2px);
    }
    .ev-action-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        background: rgba(52,120,246,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .ev-action-icon svg { width: 20px; height: 20px; color: #3478F6; }
    .ev-action-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 2px;
    }
    .ev-action-desc {
        font-size: 12px;
        color: var(--ink-muted);
    }
    .ev-action-arrow {
        margin-left: auto;
        width: 20px; height: 20px;
        color: #AEAEB2;
        flex-shrink: 0;
    }

    /* ─── Alert ─────────────────────────────────── */
    .ev-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 20px;
    }
    .ev-alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
    .ev-alert.error { background: #FFF0F0; color: #C0392B; }

    /* ─── Responsive ────────────────────────────── */
    @media (max-width: 960px) {
        .ev-grid { grid-template-columns: repeat(2, 1fr); }
        .ev-hero-title { font-size: 36px; }
    }
    @media (max-width: 640px) {
        .ev-hero { padding: 44px 20px 84px; }
        .ev-hero-title { font-size: 28px; }
        .ev-hero-desc { font-size: 15px; }
        .ev-main { padding: 0 14px 48px; }
        .ev-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .ev-card-body { padding: 14px 14px 16px; }
        .ev-card-title { font-size: 13px; }
        .ev-card-meta-row { font-size: 11.5px; }
        .ev-search-btn .btn-text { display: none; }
        .ev-search-btn .btn-icon { display: block; }
        .ev-search-btn { width: 50px; padding: 0; justify-content: center; }
        .ev-how { padding: 28px 20px; }
        .ev-how-steps { grid-template-columns: 1fr; }
        .ev-actions { grid-template-columns: 1fr; }
    }
    @media (max-width: 400px) {
        .ev-grid { grid-template-columns: 1fr; }
        .ev-hero-title { font-size: 24px; }
    }

    /* ─── Dark mode ─────────────────────────────── */
    [data-theme="dark"] .ev-hero { background: linear-gradient(135deg, #1A54C4 0%, #0D3A8A 100%); }
    [data-theme="dark"] .ev-card { background: #2C2C2E; border-color: rgba(255,255,255,0.06); }
    [data-theme="dark"] .ev-card-image { background: linear-gradient(135deg, #3A3A3C 0%, #2C2C2E 100%); }
    [data-theme="dark"] .ev-card-title { color: #F5F2EC; }
    [data-theme="dark"] .ev-empty { background: #2C2C2E; }
    [data-theme="dark"] .ev-empty-icon { background: #3A3A3C; }
    [data-theme="dark"] .ev-empty-title { color: #F5F2EC; }
    [data-theme="dark"] .ev-how { background: #2C2C2E; border-color: rgba(255,255,255,0.06); }
    [data-theme="dark"] .ev-how-step { background: #3A3A3C; }
    [data-theme="dark"] .ev-how-step h4 { color: #F5F2EC; }
    [data-theme="dark"] .ev-action { background: #2C2C2E; border-color: rgba(255,255,255,0.06); }
    [data-theme="dark"] .ev-action-title { color: #F5F2EC; }
    [data-theme="dark"] .ev-search-card { background: #2C2C2E; }
    [data-theme="dark"] .ev-search-input-wrap { background: #3A3A3C; }
    [data-theme="dark"] .ev-search-input-wrap input { color: #F5F2EC; }
    [data-theme="dark"] .oui-pagination a { background: #2C2C2E; color: #3478F6; }
    [data-theme="dark"] .oui-pagination a:hover { background: #3A3A3C; }
    [data-theme="dark"] .oui-pagination span.oui-page-active { background: #3478F6; color: #fff; }
    [data-theme="dark"] .oui-pagination span.oui-page-disabled { background: #3A3A3C; color: #8E8E93; }
    [data-theme="dark"] .oui-pagination-info { color: #8E8E93; }
</style>
@endpush

@section('content')
<div class="ev-page">

    <!-- Hero -->
    <div class="ev-hero">
        <div class="ev-hero-inner">
            <div class="ev-hero-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
                Certificate Claim System
            </div>
            <h1 class="ev-hero-title">Claim Your Event Certificate</h1>
            <p class="ev-hero-desc">Select your event, complete the claim form, and receive your verified certificate via email after approval.</p>
            <div class="ev-hero-badges">
                <span class="ev-hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Simple Process
                </span>
                <span class="ev-hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Verified Certificates
                </span>
                <span class="ev-hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Email Delivery
                </span>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="ev-main">

        <!-- Search -->
        <div class="ev-search-card">
            <form method="GET" action="{{ route('certificate.index') }}" style="display:contents;">
                <div class="ev-search-input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="eventSearch" placeholder="Search events by name…">
                </div>
                <button type="submit" class="ev-search-btn">
                    <span class="btn-text">Search</span>
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </button>
            </form>
        </div>

        @if(session('error'))
        <div class="ev-alert error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Events header -->
        @if($events->total() > 0)
        <div class="ev-section-head">
            <h2 class="ev-section-title">Active Events</h2>
            <div class="ev-count-badge">
                <span class="ev-count-dot"></span>
                <span id="searchCount">{{ $events->total() }}</span> {{ Str::plural('event', $events->total()) }}
            </div>
        </div>
        @endif

        <!-- Events Grid -->
        <div class="ev-grid" id="eventsGrid">

            @if($events->total() === 0)
            <div class="ev-empty">
                <div class="ev-empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="ev-empty-title">No active events</div>
                <div class="ev-empty-desc">Please check back later or contact the administrator.</div>
            </div>

            @else
                @foreach($events as $event)
                <article class="ev-card" data-title="{{ strtolower($event->name) }}">

                    <div class="ev-card-image">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}">
                        @else
                            <div class="ev-card-image-ph">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="ev-card-body">
                        <h3 class="ev-card-title">{{ $event->name }}</h3>

                        <div class="ev-card-meta">
                            @if($event->date)
                            <div class="ev-card-meta-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $event->date->format('d M Y') }}
                            </div>
                            @endif
                            @if($event->location)
                            <div class="ev-card-meta-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $event->location }}
                            </div>
                            @endif
                            @if($event->certificates_count > 0)
                            <div class="ev-card-meta-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                {{ $event->certificates_count }} {{ Str::plural('claim', $event->certificates_count) }}
                            </div>
                            @endif
                        </div>

                        <div class="ev-card-footer">
                            <a href="{{ route('certificate.claim-form', $event->slug) }}" class="ev-claim-btn">
                                Claim Certificate
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </article>
                @endforeach

                <div class="ev-empty" id="noResults" style="display:none;">
                    No events match "<strong id="noResultsTerm"></strong>"
                </div>
            @endif

        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="ev-pagination-wrap oui-pagination-wrap">
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

        <div class="ev-divider"></div>

        <!-- How It Works -->
        <div class="ev-how">
            <div class="ev-how-head">
                <h2>How It Works</h2>
                <p>Three simple steps to get your certificate</p>
            </div>
            <div class="ev-how-steps">
                <div class="ev-how-step">
                    <div class="ev-how-num">1</div>
                    <div class="ev-how-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                    <h4>Find Your Event</h4>
                    <p>Browse or search the list of available events you participated in.</p>
                </div>
                <div class="ev-how-step">
                    <div class="ev-how-num">2</div>
                    <div class="ev-how-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                    <h4>Fill the Form</h4>
                    <p>Complete your details and submit the claim request with required attachments.</p>
                </div>
                <div class="ev-how-step">
                    <div class="ev-how-num">3</div>
                    <div class="ev-how-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <h4>Get Your Certificate</h4>
                    <p>Receive your verified certificate via email after admin approval.</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="ev-actions">
            <a href="{{ route('certificate.track') }}" class="ev-action">
                <div class="ev-action-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <div>
                    <div class="ev-action-title">Track Claim Status</div>
                    <div class="ev-action-desc">Check the status of your certificate claim</div>
                </div>
                <svg class="ev-action-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
            <a href="{{ route('certificate.participant-dashboard') }}" class="ev-action">
                <div class="ev-action-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div>
                    <div class="ev-action-title">My Certificates</div>
                    <div class="ev-action-desc">View all certificates linked to your account</div>
                </div>
                <svg class="ev-action-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('eventSearch');
    const cards       = document.querySelectorAll('.ev-card');
    const countEl     = document.getElementById('searchCount');
    const noResults   = document.getElementById('noResults');
    const termEl      = document.getElementById('noResultsTerm');

    searchInput?.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(card => {
            const title = card.dataset.title || '';
            const show  = !q || title.includes(q);
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
