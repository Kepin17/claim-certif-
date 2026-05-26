@extends('layouts.user-layout')

@section('title', 'Track Certificate')

@push('scripts')
@include('certificates.partials.oui-shared')
<style>
    .oui-track-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 16px;
        align-items: start;
    }

    .oui-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 20px;
    }

    .oui-info-card {
        background: #fff;
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .oui-info-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .oui-info-card-icon.blue { background: #EBF2FF; color: #3478F6; }
    .oui-info-card-icon.green { background: #E6FAF0; color: #30D158; }
    .oui-info-card-icon.orange { background: #FFF3E0; color: #FF9F0A; }

    .oui-info-card h3 {
        font-size: 14px;
        font-weight: 700;
        color: #1C1C1E;
        margin-bottom: 6px;
    }
    .oui-info-card p {
        font-size: 12.5px;
        color: #8E8E93;
        line-height: 1.5;
    }

    .oui-status-list { display: flex; flex-direction: column; gap: 10px; }
    .oui-status-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        background: #F2F3F5;
        border-radius: 12px;
    }
    .oui-status-row .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }
    .oui-status-row strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1C1C1E;
        margin-bottom: 2px;
    }
    .oui-status-row span {
        font-size: 12px;
        color: #8E8E93;
        line-height: 1.4;
    }

    .oui-tip-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .oui-tip-list li {
        display: flex;
        gap: 10px;
        font-size: 13px;
        color: #3C3C43;
        line-height: 1.45;
    }
    .oui-tip-list li svg {
        width: 16px;
        height: 16px;
        color: #3478F6;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .oui-events-preview {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #F2F3F5;
    }
    .oui-events-preview-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #8E8E93;
        margin-bottom: 10px;
    }
    .oui-event-mini {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 12px;
        background: #F2F3F5;
        border-radius: 12px;
        margin-bottom: 8px;
        text-decoration: none;
        transition: background 0.15s;
    }
    .oui-event-mini:last-child { margin-bottom: 0; }
    .oui-event-mini:hover { background: #EBF2FF; }
    .oui-event-mini-name {
        font-size: 13px;
        font-weight: 600;
        color: #1C1C1E;
        line-height: 1.3;
    }
    .oui-event-mini-date {
        font-size: 11px;
        color: #8E8E93;
        margin-top: 2px;
    }
    .oui-event-mini svg { color: #3478F6; flex-shrink: 0; }

    @media (max-width: 900px) {
        .oui-track-layout { grid-template-columns: 1fr; }
        .oui-side-col { display: none; }
        .oui-info-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .oui-info-grid { display: none; }
        .oui-mobile-tips { display: block; }
        .oui-mobile-links { display: block; }
    }

    /* Dark mode overrides */
    [data-theme="dark"] .oui-page {
        background: #1C1C1E;
    }
    [data-theme="dark"] .oui-hero {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-page-title {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-page-desc {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-info-card {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-info-card h3 {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-status-row {
        background: #3A3A3C;
    }
    [data-theme="dark"] .oui-status-row strong {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-card {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-card-title {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-card-sub {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-field .oui-label {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-input {
        background: #3A3A3C;
        color: #F5F2EC;
        border-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-input:focus {
        background: #2C2C2E;
        border-color: #3478F6;
    }
    [data-theme="dark"] .oui-select {
        background: #3A3A3C;
        color: #F5F2EC;
        border-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-side-card {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-side-title {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-events-preview-title {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-event-mini {
        background: #3A3A3C;
    }
    [data-theme="dark"] .oui-event-mini:hover {
        background: #48484A;
    }
    [data-theme="dark"] .oui-event-mini-name {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-link-card {
        background: #2C2C2E;
        color: #3478F6;
        border-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-link-card:hover {
        background: #3A3A3C;
    }
    [data-theme="dark"] .oui-link-secondary {
        color: #3478F6;
    }
    [data-theme="dark"] .oui-mobile-tips .oui-card {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-mobile-tips div {
        color: #F5F2EC;
    }
</style>
@endpush

@section('content')
<div class="oui-page">

    <div class="oui-hero">
        <div class="oui-hero-inner wide">
            <p class="oui-page-label">Status Check</p>
            <h1 class="oui-page-title">Track your certificate</h1>
            <p class="oui-page-desc">Look up a single claim by email and event, or view every certificate linked to your email in one place.</p>
        </div>
    </div>

    <div class="oui-section">
        <div class="oui-track-layout">

            <!-- Mobile: Show simplified tips below form -->
            <div class="oui-mobile-tips" style="display:none;margin-top:20px">
                <div class="oui-card" style="padding:16px">
                    <div style="font-size:13px;font-weight:600;color:#1C1C1E;margin-bottom:10px">Quick tips</div>
                    <ul class="oui-tip-list">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Double-check your email spelling
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Pick the exact event you claimed
                        </li>
                    </ul>
                </div>
            </div>

            <div>
                @if(session('error'))
                    <div class="oui-alert oui-alert-error" style="margin-bottom:16px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="oui-card">
                    <div class="oui-card-title">Look up your claim</div>
                    <p class="oui-card-sub">Use the same email you submitted when claiming. We'll redirect you to the full status page if a match is found.</p>

                    <form action="{{ route('certificate.track') }}" method="POST">
                        @csrf

                        <div class="oui-field">
                            <label for="email" class="oui-label">Email address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="oui-input"
                                placeholder="you@email.com"
                                required>
                            <p class="oui-hint">Must match the email on your original claim form</p>
                        </div>

                        <div class="oui-field" style="margin-top:14px">
                            <label for="event_id" class="oui-label">Event attended</label>
                            <select name="event_id" id="event_id" class="oui-select" required>
                                <option value="">Select event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                        {{ $event->name }}
                                        @if($event->date)
                                            ({{ $event->date->format('d M Y') }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="oui-actions">
                            <button type="submit" class="oui-btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                                Check status
                            </button>
                        </div>
                    </form>
                </div>

                <div class="oui-info-grid">
                    <div class="oui-info-card">
                        <div class="oui-info-card-icon blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <h3>Review time</h3>
                        <p>Most claims are reviewed within 24–48 hours on business days after submission.</p>
                    </div>
                    <div class="oui-info-card">
                        <div class="oui-info-card-icon green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <h3>Email delivery</h3>
                        <p>Once approved, your certificate PDF is sent to the email address on your claim.</p>
                    </div>
                    <div class="oui-info-card">
                        <div class="oui-info-card-icon orange">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </div>
                        <h3>Verified PDF</h3>
                        <p>Every certificate includes a QR code for quick authenticity verification.</p>
                    </div>
                </div>
            </div>

            <!-- Desktop sidebar -->
            <aside class="oui-side-col">
                <div class="oui-card oui-side-card">
                    <div class="oui-side-title">Status guide</div>
                    <div class="oui-status-list">
                        <div class="oui-status-row">
                            <span class="dot" style="background:#FF9F0A"></span>
                            <div>
                                <strong>Pending</strong>
                                <span>Your claim is in the queue waiting for admin review.</span>
                            </div>
                        </div>
                        <div class="oui-status-row">
                            <span class="dot" style="background:#3478F6"></span>
                            <div>
                                <strong>Approved</strong>
                                <span>Verified — certificate generation is in progress.</span>
                            </div>
                        </div>
                        <div class="oui-status-row">
                            <span class="dot" style="background:#AF52DE"></span>
                            <div>
                                <strong>Generated / Sent</strong>
                                <span>Ready or already delivered to your inbox.</span>
                            </div>
                        </div>
                        <div class="oui-status-row">
                            <span class="dot" style="background:#FF3B30"></span>
                            <div>
                                <strong>Rejected</strong>
                                <span>See the reason on the status page; you may re-submit if the event is still open.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="oui-card oui-side-card" style="margin-top:14px">
                    <div class="oui-side-title">Before you search</div>
                    <ul class="oui-tip-list">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Double-check your email spelling — no extra spaces.
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Pick the exact event you claimed under.
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Check spam/junk if status is sent but you don't see the email.
                        </li>
                    </ul>

                    @if($events->count() > 0)
                    <div class="oui-events-preview">
                        <div class="oui-events-preview-title">Active events</div>
                        @foreach($events->take(4) as $event)
                        <a href="{{ route('certificate.claim-form', $event->slug) }}" class="oui-event-mini">
                            <div>
                                <div class="oui-event-mini-name">{{ Str::limit($event->name, 32) }}</div>
                                @if($event->date)
                                    <div class="oui-event-mini-date">{{ $event->date->format('d M Y') }}</div>
                                @endif
                            </div>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                        @endforeach
                        @if($events->count() > 4)
                            <p class="oui-hint" style="margin-top:8px;text-align:center">
                                +{{ $events->count() - 4 }} more on <a href="{{ route('certificate.index') }}" style="color:#3478F6;font-weight:600">Events</a>
                            </p>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="oui-side-links" style="display:flex;flex-direction:column;gap:10px;margin-top:14px">
                    <a href="{{ route('certificate.participant-dashboard') }}" class="oui-link-card" style="margin-top:0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                        </svg>
                        View all my certificates
                    </a>
                    <a href="{{ route('certificate.index') }}" class="oui-link-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Browse events to claim
                    </a>
                </div>
            </aside>

            <!-- Mobile bottom links -->
            <div class="oui-mobile-links" style="display:none;margin-top:20px">
                <a href="{{ route('certificate.participant-dashboard') }}" class="oui-link-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                    </svg>
                    View all my certificates
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
