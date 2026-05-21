@extends('layouts.user-layout')

@section('title', 'Certificate Status')

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

    /* Main */
    .main {
        max-width: 500px;
        margin: 0 auto;
        padding: 48px 40px 80px;
    }

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

    /* Status Badge */
    .status-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .status-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-muted);
    }

    .status-badge {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
    }

    .status-pending { background: rgba(251,191,36,0.15); color: #D97706; border: 1px solid rgba(251,191,36,0.2); }
    .status-under_review { background: rgba(59,130,246,0.15); color: #2563EB; border: 1px solid rgba(59,130,246,0.2); }
    .status-approved { background: var(--accent-lt); color: var(--accent); border: 1px solid rgba(45,80,22,0.15); }
    .status-rejected { background: var(--danger-lt); color: var(--danger); border: 1px solid rgba(140,44,26,0.15); }
    .status-generated { background: rgba(139,92,246,0.15); color: #7C3AED; border: 1px solid rgba(139,92,246,0.2); }
    .status-sent { background: var(--accent-lt); color: var(--accent); border: 1px solid rgba(45,80,22,0.15); }

    /* Details */
    .details {
        background: rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: var(--radius-md);
        padding: 20px;
        margin-bottom: 24px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 13px;
        color: var(--ink-muted);
    }

    .detail-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink-mid);
        text-align: right;
    }

    .detail-col {
        flex-direction: column;
        gap: 4px;
    }

    /* Alert */
    .alert-error {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.2);
        border-left: 3px solid var(--danger);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        margin-bottom: 24px;
    }

    .alert-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--danger);
        margin-bottom: 4px;
    }

    .alert-text {
        font-size: 13px;
        color: var(--danger);
    }

    /* Download Button */
    .download-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--accent);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 14px 24px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
        margin-bottom: 24px;
    }

    .download-btn:hover {
        background: var(--accent-mid);
    }

    .download-btn:active {
        transform: scale(0.98);
    }

    .download-btn svg { flex-shrink: 0; }

    .footer-info {
        text-align: center;
        font-size: 13px;
        color: var(--ink-muted);
        margin-bottom: 16px;
    }

    .footer-link {
        text-align: center;
        font-size: 13px;
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
            <span class="hero-eyebrow-text">Status Check</span>
        </div>
        <h1 class="hero-title">Certificate<br><em>status</em></h1>
    </div>
</div>

<!-- Main Content -->
<main class="main">

    <div class="card">
        <div class="card-accent"></div>
        <div class="card-body">
            <h2 class="card-title">Certificate Status</h2>

            <div class="status-header">
                <span class="status-label">Status:</span>
                <span class="status-badge status-{{ $certificate->status }}">
                    {{ strtoupper($certificate->status) }}
                </span>
            </div>

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Name</span>
                    <span class="detail-value">{{ $certificate->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $certificate->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Event</span>
                    <span class="detail-value">{{ $certificate->event }}</span>
                </div>
                @if($certificate->message)
                    <div class="detail-row detail-col">
                        <span class="detail-label">Pesan dan Kesan</span>
                        <span class="detail-value">{{ $certificate->message }}</span>
                    </div>
                @endif
                @if($certificate->next_event)
                    <div class="detail-row">
                        <span class="detail-label">Event Selanjutnya</span>
                        <span class="detail-value">{{ $certificate->next_event }}</span>
                    </div>
                @endif
                @if($certificate->certificate_number)
                    <div class="detail-row">
                        <span class="detail-label">Certificate Number</span>
                        <span class="detail-value">{{ $certificate->certificate_number }}</span>
                    </div>
                @endif
            </div>

            @if($certificate->status === 'rejected')
                <div class="alert-error">
                    <div class="alert-title">Rejection Reason</div>
                    <div class="alert-text">{{ $certificate->rejection_reason }}</div>
                </div>
            @endif

            @if($certificate->status === 'generated' || $certificate->status === 'sent')
                <a href="{{ route('certificate.download') }}?number={{ urlencode($certificate->certificate_number) }}" class="download-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Download Certificate
                </a>
            @endif

            <div class="footer-info">
                Submitted on: {{ $certificate->created_at->format('d F Y, H:i') }}
            </div>

            <div class="footer-link">
                <a href="{{ route('certificate.index') }}">Submit another claim</a>
            </div>
        </div>
    </div>

</main>
@endsection
