@extends('layouts.user-layout')

@section('title', 'Certificate Status')

@push('scripts')
@include('certificates.partials.oui-shared')
<style>
    /* Modern Hero */
    .oui-hero-status {
        background: linear-gradient(135deg, #3478F6 0%, #1A54C4 100%);
        padding: 48px 24px 52px;
        position: relative;
        overflow: hidden;
    }
    .oui-hero-status::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .oui-hero-status::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .oui-hero-inner-status {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        text-align: center;
    }
    .oui-hero-label-status {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.85);
        margin-bottom: 12px;
    }
    .oui-hero-title-status {
        font-size: 34px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.7px;
        line-height: 1.15;
        margin-bottom: 8px;
    }
    .oui-hero-desc-status {
        font-size: 15px;
        color: rgba(255,255,255,0.85);
        line-height: 1.5;
    }

    /* Status card */
    .oui-status-wrap {
        max-width: 540px;
        margin: -32px auto 0;
        position: relative;
        z-index: 10;
    }
    .oui-status-card {
        background: #fff;
        border-radius: 24px;
        padding: 32px 28px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
    }

    /* Status header */
    .oui-status-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #F2F3F5;
    }
    .oui-status-label {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #8E8E93;
    }
    .oui-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .oui-status-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .badge-pending   { background: #FFF3E0; color: #C45C00; }
    .badge-pending   .oui-status-badge-dot { background: #FF9F0A; }
    .badge-approved  { background: #EBF2FF; color: #1A54C4; }
    .badge-approved  .oui-status-badge-dot { background: #3478F6; }
    .badge-generated { background: #F5EEFF; color: #7C29B8; }
    .badge-generated .oui-status-badge-dot { background: #AF52DE; }
    .badge-sent      { background: #E6FAF0; color: #1A7A40; }
    .badge-sent      .oui-status-badge-dot { background: #30D158; }
    .badge-rejected  { background: #FFEEED; color: #B02020; }
    .badge-rejected  .oui-status-badge-dot { background: #FF3B30; }

    /* Details grid */
    .oui-details-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin-bottom: 24px;
    }
    .oui-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 12px 0;
        border-bottom: 1px solid #F2F3F5;
    }
    .oui-detail-row:last-child {
        border-bottom: none;
    }
    .oui-detail-label {
        font-size: 12.5px;
        font-weight: 500;
        color: #8E8E93;
    }
    .oui-detail-value {
        font-size: 14px;
        font-weight: 600;
        color: #1C1C1E;
        text-align: right;
        max-width: 60%;
    }
    .oui-detail-value.full {
        grid-column: 1 / -1;
        text-align: left;
        max-width: 100%;
    }

    /* Rejection alert */
    .oui-reject-alert {
        background: #FFEEED;
        border-radius: 16px;
        padding: 16px 18px;
        margin-bottom: 20px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .oui-reject-alert svg {
        width: 20px;
        height: 20px;
        color: #FF3B30;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .oui-reject-alert-title {
        font-size: 13px;
        font-weight: 700;
        color: #B02020;
        margin-bottom: 4px;
    }
    .oui-reject-alert-text {
        font-size: 13px;
        color: #B02020;
        line-height: 1.45;
    }

    /* Buttons */
    .oui-btn-download {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px 24px;
        background: #3478F6;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 16px;
        transition: background 0.15s, transform 0.1s;
        box-shadow: 0 2px 10px rgba(52,120,246,0.28);
        margin-bottom: 16px;
    }
    .oui-btn-download:hover {
        background: #2563EB;
        color: #fff;
    }
    .oui-btn-download:active {
        transform: scale(0.98);
    }
    .oui-btn-download svg {
        width: 18px;
        height: 18px;
    }

    .oui-btn-resubmit {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        background: #FF9F0A;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 14px;
        transition: background 0.15s, transform 0.1s;
        margin-bottom: 16px;
    }
    .oui-btn-resubmit:hover {
        background: #F59E0B;
        color: #fff;
    }
    .oui-btn-resubmit:active {
        transform: scale(0.98);
    }
    .oui-btn-resubmit svg {
        width: 16px;
        height: 16px;
    }

    /* LinkedIn share button */
    .oui-btn-linkedin {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        background: #0077B5;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 14px;
        transition: background 0.15s, transform 0.1s;
        margin-bottom: 16px;
    }
    .oui-btn-linkedin:hover {
        background: #006097;
        color: #fff;
    }
    .oui-btn-linkedin:active {
        transform: scale(0.98);
    }
    .oui-btn-linkedin svg {
        width: 16px;
        height: 16px;
    }

    /* Footer */
    .oui-status-footer {
        text-align: center;
        padding-top: 16px;
        border-top: 1px solid #F2F3F5;
    }
    .oui-footer-info {
        font-size: 12.5px;
        color: #8E8E93;
        margin-bottom: 12px;
    }
    .oui-footer-link a {
        font-size: 13px;
        font-weight: 600;
        color: #3478F6;
        text-decoration: none;
    }
    .oui-footer-link a:hover {
        text-decoration: underline;
    }

    .oui-page {
        background: #F2F3F5;
    }

    @media (max-width: 540px) {
        .oui-hero-status { padding: 36px 16px 40px; }
        .oui-hero-title-status { font-size: 26px; }
        .oui-status-wrap { margin: -24px 16px 0; }
        .oui-status-card { padding: 24px 20px; border-radius: 20px; }
        .oui-detail-value { max-width: 50%; }
    }

    /* Dark mode overrides */
    [data-theme="dark"] .oui-page {
        background: #1C1C1E;
    }
    [data-theme="dark"] .oui-hero-status {
        background: linear-gradient(135deg, #1A54C4 0%, #0D3A8A 100%);
    }
    [data-theme="dark"] .oui-status-card {
        background: #2C2C2E;
    }
    [data-theme="dark"] .oui-status-header {
        border-bottom-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-detail-row {
        border-bottom-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-detail-label {
        color: #8E8E93;
    }
    [data-theme="dark"] .oui-detail-value {
        color: #F5F2EC;
    }
    [data-theme="dark"] .oui-status-footer {
        border-top-color: #3A3A3C;
    }
    [data-theme="dark"] .oui-footer-info {
        color: #8E8E93;
    }
</style>
@endpush

@section('content')
<div class="oui-page">

    <!-- Modern Hero -->
    <div class="oui-hero-status">
        <div class="oui-hero-inner-status">
            <p class="oui-hero-label-status">Certificate Status</p>
            <h1 class="oui-hero-title-status">Claim Status</h1>
            <p class="oui-hero-desc-status">Track your certificate claim progress</p>
        </div>
    </div>

    <!-- Status Card -->
    <div class="oui-status-wrap">
        <div class="oui-status-card">

            <!-- Status Header -->
            <div class="oui-status-header">
                <span class="oui-status-label">Current Status</span>
                @php
                    $badgeClass = match($certificate->status) {
                        'pending'   => 'badge-pending',
                        'approved'  => 'badge-approved',
                        'generated' => 'badge-generated',
                        'sent'      => 'badge-sent',
                        default     => 'badge-rejected',
                    };
                    $statusLabel = match($certificate->status) {
                        'pending'   => 'Pending',
                        'approved'  => 'Approved',
                        'generated' => 'Generated',
                        'sent'      => 'Sent',
                        'rejected'  => 'Rejected',
                        default     => ucfirst($certificate->status),
                    };
                @endphp
                <span class="oui-status-badge {{ $badgeClass }}">
                    <span class="oui-status-badge-dot"></span>
                    {{ $statusLabel }}
                </span>
            </div>

            <!-- Details -->
            <div class="oui-details-grid">
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Name</span>
                    <span class="oui-detail-value">{{ $certificate->name }}</span>
                </div>
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Email</span>
                    <span class="oui-detail-value">{{ $certificate->email }}</span>
                </div>
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Event</span>
                    <span class="oui-detail-value">{{ $certificate->event }}</span>
                </div>
                @if($certificate->certificate_type_name)
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Role / Type</span>
                    <span class="oui-detail-value">{{ $certificate->certificate_type_name }}</span>
                </div>
                @endif
                @if($certificate->certificate_number)
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Certificate No.</span>
                    <span class="oui-detail-value">{{ $certificate->certificate_number }}</span>
                </div>
                @endif
                @if($certificate->message)
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Message</span>
                    <span class="oui-detail-value full">{{ $certificate->message }}</span>
                </div>
                @endif
                @if($certificate->next_event)
                <div class="oui-detail-row">
                    <span class="oui-detail-label">Preferred Next Event</span>
                    <span class="oui-detail-value">{{ $certificate->next_event }}</span>
                </div>
                @endif
            </div>

            <!-- Rejection Alert -->
            @if($certificate->status === 'rejected')
            <div class="oui-reject-alert">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <div class="oui-reject-alert-title">Rejection Reason</div>
                    <div class="oui-reject-alert-text">{{ $certificate->rejection_reason }}</div>
                </div>
            </div>
            @endif

            <!-- Download Button -->
            @if($certificate->status === 'generated' || $certificate->status === 'sent')
            <a href="{{ route('certificate.download') }}?key={{ $certificate->unique_key }}" class="oui-btn-download">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download Certificate
            </a>

            <!-- LinkedIn Share Button -->
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('certificate.status', $certificate->unique_key)) }}" target="_blank" rel="noopener noreferrer" class="oui-btn-linkedin">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                Share on LinkedIn
            </a>
            @endif

            <!-- Re-submit Button -->
            @if($certificate->status === 'rejected' && $certificate->eventRelation?->isClaimOpen())
            <a href="{{ route('certificate.claim-form', $certificate->eventRelation->slug) }}" class="oui-btn-resubmit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/>
                </svg>
                Re-submit Claim
            </a>
            @endif

            <!-- Footer -->
            <div class="oui-status-footer">
                <p class="oui-footer-info">Submitted on {{ $certificate->created_at->format('d M Y, H:i') }}</p>
                <div class="oui-footer-link">
                    <a href="{{ route('certificate.index') }}">Submit another claim</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
