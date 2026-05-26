@extends('layouts.user-layout')

@section('title', 'Claim Your Certificate')

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
            radial-gradient(ellipse 55% 70% at 10% 70%, rgba(201,168,76,0.14) 0%, transparent 55%),
            radial-gradient(ellipse 45% 60% at 90% 25%, rgba(92,122,56,0.22) 0%, transparent 50%);
        z-index: 0;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        max-width: 1100px;
        margin: 0 auto;
        padding: 56px 40px 48px;
    }

    .breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: rgba(255,255,255,0.4);
        text-decoration: none;
        margin-bottom: 28px;
        transition: color 0.15s;
    }

    .breadcrumb:hover { color: rgba(255,255,255,0.75); }
    .breadcrumb svg { flex-shrink: 0; opacity: 0.6; }

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
        max-width: 480px;
    }

    /* ── MAIN LAYOUT ── */
    .page-body {
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 40px 80px;
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 32px;
        align-items: start;
    }

    /* ── FORM CARD ── */
    .form-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .form-card-header {
        padding: 28px 32px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        background: var(--parchment);
    }

    .form-card-header h2 {
        font-family: 'Fraunces', serif;
        font-size: 22px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }

    .form-card-header p {
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.5;
    }

    .form-card-body {
        padding: 32px;
    }

    /* Alerts */
    .alert {
        padding: 14px 16px;
        border-radius: var(--r-md);
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 14px;
    }

    .alert-success {
        background: var(--accent-lt);
        border: 1px solid rgba(45,80,22,0.15);
    }

    .alert-error {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.15);
    }

    .alert-icon { flex-shrink: 0; width: 18px; height: 18px; margin-top: 1px; }
    .alert-success .alert-icon { color: var(--accent); }
    .alert-error .alert-icon { color: var(--danger); }
    .alert-success .alert-text { color: var(--accent); }
    .alert-error .alert-text { color: var(--danger); }

    .alert-list {
        margin-top: 8px;
        padding-left: 18px;
        font-size: 13px;
    }

    .alert-list li { margin-bottom: 3px; color: var(--danger); }

    /* Form sections */
    .form-section {
        margin-bottom: 28px;
    }

    .form-section:last-of-type { margin-bottom: 0; }

    .section-label {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .section-num {
        width: 26px;
        height: 26px;
        background: var(--moss);
        color: #FFFFFF;
        border-radius: 50%;
        font-size: 11px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        letter-spacing: 0.02em;
    }

    .section-title-wrap h3 {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
        line-height: 1.2;
    }

    .section-title-wrap p {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-grid.single { grid-template-columns: 1fr; }

    .form-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-field.full { grid-column: 1 / -1; }

    .form-label {
        font-size: 12.5px;
        font-weight: 500;
        color: var(--ink-mid);
        letter-spacing: 0.01em;
    }

    .form-label .req { color: var(--danger); margin-left: 2px; }

    .form-hint {
        font-size: 11.5px;
        color: var(--ink-faint);
        margin-top: -2px;
    }

    .form-input {
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        color: var(--ink);
        background: #FFFFFF;
        border: 1px solid rgba(0,0,0,0.10);
        border-radius: var(--r-sm);
        padding: 11px 14px;
        transition: border-color 0.15s, box-shadow 0.15s;
        width: 100%;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--olive);
        box-shadow: 0 0 0 3px rgba(92,122,56,0.12);
    }

    .form-input::placeholder { color: var(--ink-faint); }

    textarea.form-input {
        resize: vertical;
        min-height: 96px;
        line-height: 1.55;
    }

    /* Event panel (in sidebar) */
    .event-panel {
        background: var(--moss);
        border-radius: var(--r-md);
        padding: 20px;
        color: #FFFFFF;
        margin-bottom: 20px;
    }

    .event-panel-label {
        font-size: 9px;
        font-weight: 500;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--gold);
        opacity: 0.85;
        margin-bottom: 10px;
    }

    .event-panel-name {
        font-family: 'Fraunces', serif;
        font-size: 18px;
        font-weight: 300;
        line-height: 1.25;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }

    .event-panel-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: rgba(255,255,255,0.5);
    }

    .event-panel-date svg { opacity: 0.6; flex-shrink: 0; }

    /* Submit area */
    .form-actions {
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .submit-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--moss);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 13px 24px;
        border-radius: var(--r-sm);
        border: none;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .submit-btn:hover { background: var(--moss-mid); }
    .submit-btn:active { transform: scale(0.99); }
    .submit-btn svg { flex-shrink: 0; }

    .track-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 13px;
        color: var(--ink-muted);
    }

    .track-note a {
        color: var(--olive);
        font-weight: 500;
        text-decoration: none;
    }

    .track-note a:hover { text-decoration: underline; }

    /* ── SIDEBAR ── */
    .sidebar { position: sticky; top: 88px; }

    .steps-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--r-lg);
        padding: 24px;
        margin-bottom: 20px;
    }

    .steps-card h4 {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 18px;
    }

    .step-item {
        display: flex;
        gap: 12px;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .step-item:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: none;
    }

    .step-icon {
        width: 32px;
        height: 32px;
        background: var(--accent-lt);
        border-radius: var(--r-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .step-icon svg { color: var(--accent); }

    .step-content h5 {
        font-size: 13px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 3px;
    }

    .step-content p {
        font-size: 12px;
        color: var(--ink-muted);
        line-height: 1.45;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        background: var(--sand);
        border-radius: var(--r-md);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .info-item svg {
        flex-shrink: 0;
        color: var(--olive);
        margin-top: 1px;
    }

    .info-item-text strong {
        display: block;
        font-size: 12.5px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 2px;
    }

    .info-item-text span {
        font-size: 11.5px;
        color: var(--ink-muted);
        line-height: 1.4;
    }

    @media (max-width: 900px) {
        .page-body {
            grid-template-columns: 1fr;
            padding: 32px 24px 60px;
        }

        .sidebar { position: static; order: -1; }
        .event-panel { margin-bottom: 0; }
        .steps-card { margin-bottom: 16px; }
    }

    @media (max-width: 600px) {
        .hero-inner { padding: 40px 20px 36px; }
        .form-card-header,
        .form-card-body { padding: 20px; }
        .form-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- Hero -->
<div class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">
            <span class="eyebrow-line"></span>
            <span class="eyebrow-text">Certificate Claim</span>
        </div>

        <h1 class="hero-title">Claim your <em>certificate</em></h1>
        <p class="hero-desc">Complete the form below. Your certificate will be reviewed and delivered to your email once approved.</p>
    </div>
</div>

<!-- Main -->
<div class="page-body">

    <!-- Form column -->
    <div class="form-card">
        <div class="form-card-header">
            <h2>Claim Form</h2>
            <p>Enter your details and optional feedback. All fields marked * are required.</p>
        </div>

        <div class="form-card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span class="alert-text">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span class="alert-text">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <div>
                        <span class="alert-text">Please fix the following errors:</span>
                        <ul class="alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('certificate.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Section 1: Personal -->
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-num">1</span>
                        <div class="section-title-wrap">
                            <h3>Participant Details</h3>
                            <p>Name and email for certificate delivery</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="name" class="form-label">Full Name<span class="req">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" placeholder="e.g. John Smith" required>
                        </div>
                        <div class="form-field">
                            <label for="email" class="form-label">Email Address<span class="req">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" placeholder="you@email.com" required>
                            <span class="form-hint">Your certificate will be sent to this email</span>
                        </div>
                    </div>
                </div>

                @if(isset($event))
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                @endif

                @if(isset($certificateTypes) && $certificateTypes->count() > 0)
                <!-- Section 2: Certificate Type -->
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-num">2</span>
                        <div class="section-title-wrap">
                            <h3>Participation Role <span style="color:var(--danger)">*</span></h3>
                            <p>Select the role you participated as in this event</p>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        @foreach($certificateTypes as $type)
                        <label style="display:flex;align-items:center;gap:14px;padding:14px 16px;background:var(--surface);border:1.5px solid {{ old('certificate_type_id') == $type->id ? 'var(--olive)' : 'rgba(0,0,0,0.08)' }};border-radius:var(--r-sm);cursor:pointer;transition:border-color .15s;" class="type-label">
                            <input type="radio" name="certificate_type_id" value="{{ $type->id }}" {{ old('certificate_type_id') == $type->id ? 'checked' : '' }} required style="accent-color:var(--olive);width:16px;height:16px;flex-shrink:0;">
                            <div>
                                <div style="font-weight:600;font-size:14px;color:var(--ink);">{{ $type->name }}</div>
                                @if($type->role_text && $type->role_text !== $type->name)
                                    <div style="font-size:12px;color:var(--ink-muted);">Certificate will show: <em>{{ $type->role_text }}</em></div>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Feedback Section -->
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-num">{{ isset($certificateTypes) && $certificateTypes->count() > 0 ? '3' : '2' }}</span>
                        <div class="section-title-wrap">
                            <h3>Feedback</h3>
                            <p>Optional — helps us improve future events</p>
                        </div>
                    </div>

                    <div class="form-grid single">
                        <div class="form-field full">
                            <label for="message" class="form-label">Message & Impressions</label>
                            <textarea name="message" id="message" rows="4" class="form-input" placeholder="Share your experience from this event...">{{ old('message') }}</textarea>
                        </div>
                        <div class="form-field full">
                            <label for="next_event" class="form-label">Preferred Next Event</label>
                            <input type="text" name="next_event" id="next_event" value="{{ old('next_event') }}" class="form-input" placeholder="Topics or types of events you'd like to attend">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Submit Certificate Claim
                    </button>
                    <p class="track-note">
                        Already submitted?
                        <a href="{{ route('certificate.track') }}">Track claim status</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">

        @if(isset($event))
            <div class="event-panel">
                <div class="event-panel-label">Selected Event</div>
                <div class="event-panel-name">{{ $event->name }}</div>
                @if($event->date)
                    <div class="event-panel-date">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $event->date->format('d F Y') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="steps-card">
            <h4>Process</h4>
            <div class="step-item">
                <div class="step-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="step-content">
                    <h5>Submit form</h5>
                    <p>Enter your details and submit your claim</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="step-content">
                    <h5>Admin review</h5>
                    <p>Verified within 24–48 hours</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </div>
                <div class="step-content">
                    <h5>Receive certificate</h5>
                    <p>PDF delivered to your email once approved</p>
                </div>
            </div>
        </div>

       

    </aside>

</div>
@endsection
