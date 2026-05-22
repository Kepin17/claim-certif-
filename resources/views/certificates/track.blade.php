@extends('layouts.user-layout')

@section('title', 'Track Certificate')

@section('content')
<style>
    /* Hero */
    .hero {
        background: var(--ink);
        padding: 72px 40px 60px;
        position: relative;
        overflow: hidden;
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
        text-align: center;
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
        font-size: clamp(32px, 5vw, 48px);
        font-weight: 300;
        color: #FFFFFF;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 14px;
    }

    .hero-title em {
        font-style: italic;
        color: #A8D88A;
    }

    .hero-desc {
        font-size: 15px;
        color: rgba(255,255,255,0.45);
        line-height: 1.6;
        max-width: 480px;
        margin: 0 auto;
    }

    /* Main */
    .main {
        max-width: 500px;
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

    /* Card */
    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .card-accent {
        height: 3px;
        background: linear-gradient(90deg, var(--accent) 0%, var(--accent-mid) 100%);
    }

    .card-body {
        padding: 32px;
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 24px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.01em;
        margin-bottom: 28px;
        text-align: center;
    }

    /* Form */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-mid);
        margin-bottom: 8px;
        letter-spacing: 0.01em;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        color: var(--ink);
        background: #FFFFFF;
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: var(--radius-sm);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(45,80,22,0.1);
    }

    .form-input::placeholder {
        color: var(--ink-faint);
    }

    .btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 14px 24px;
        border: none;
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .btn:hover {
        background: #2A2821;
    }

    .btn:active {
        transform: scale(0.98);
    }

    .btn svg { flex-shrink: 0; }

    .footer-link {
        text-align: center;
        margin-top: 24px;
        font-size: 13px;
        color: var(--ink-muted);
    }

    .footer-link a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .footer-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 640px) {
        .hero { padding: 48px 20px 40px; }
        .main { padding: 32px 20px 60px; }
        .card-body { padding: 24px; }
        .card-title { font-size: 20px; }
    }
</style>

<!-- Hero -->
<div class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-dot"></span>
            <span class="hero-eyebrow-text">Check Status</span>
        </div>
        <h1 class="hero-title">Track your<br><em>certificate</em></h1>
        <p class="hero-desc">Enter your email and select an event to check the status of your certificate claim.</p>
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

    <div class="card">
        <div class="card-accent"></div>
        <div class="card-body">
            <h2 class="card-title">Track Certificate</h2>

            <form action="{{ route('certificate.track') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="form-input"
                        placeholder="your@email.com"
                        required>
                </div>

                <div class="form-group">
                    <label for="event_id" class="form-label">Event Attended</label>
                    <select name="event_id" id="event_id"
                        class="form-input"
                        required>
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

                <button type="submit" class="btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Search
                </button>
            </form>

            <div class="footer-link">
                Want to claim a certificate? <a href="{{ route('certificate.index') }}">Submit a claim</a>
            </div>
        </div>
    </div>

</main>
@endsection
