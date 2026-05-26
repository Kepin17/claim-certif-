@extends('layouts.user-layout')

@section('title', 'My Certificates')

@push('scripts')
<style>
    /* ── ONE UI 8.5 – My Certificates ── */
    .oui-page {
        min-height: calc(100vh - 64px);
        background: #F2F3F5;
        padding: 0 0 48px;
    }

    /* Hero header */
    .oui-hero {
        background: #ffffff;
        padding: 36px 24px 28px;
        border-bottom: none;
    }
    .oui-hero-inner {
        max-width: 680px;
        margin: 0 auto;
    }
    .oui-page-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #3478F6;
        margin-bottom: 6px;
    }
    .oui-page-title {
        font-size: 30px;
        font-weight: 700;
        color: #1C1C1E;
        letter-spacing: -0.5px;
        line-height: 1.15;
        margin-bottom: 22px;
    }

    /* Search bar */
    .oui-search-wrap {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .oui-search-field {
        flex: 1;
        display: flex;
        align-items: center;
        background: #F2F3F5;
        border: 1.5px solid transparent;
        border-radius: 16px;
        padding: 0 16px;
        gap: 10px;
        height: 52px;
        transition: border-color 0.18s, background 0.18s;
    }
    .oui-search-field:focus-within {
        background: #fff;
        border-color: #3478F6;
    }
    .oui-search-field svg {
        width: 17px;
        height: 17px;
        color: #8E8E93;
        flex-shrink: 0;
    }
    .oui-search-field input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 15px;
        color: #1C1C1E;
        outline: none;
        font-family: inherit;
    }
    .oui-search-field input::placeholder { color: #AEAEB2; }
    .oui-search-btn {
        height: 52px;
        padding: 0 22px;
        background: #3478F6;
        color: #fff;
        border: none;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
        font-family: inherit;
        flex-shrink: 0;
    }
    .oui-search-btn:hover  { background: #2563EB; }
    .oui-search-btn:active { transform: scale(0.97); }

    /* Results section */
    .oui-section {
        max-width: 680px;
        margin: 24px auto 0;
        padding: 0 24px;
    }

    /* Summary pill */
    .oui-count-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        border: 1.5px solid #E5E5EA;
        border-radius: 50px;
        padding: 5px 14px 5px 10px;
        font-size: 13px;
        font-weight: 500;
        color: #3C3C43;
        margin-bottom: 16px;
    }
    .oui-count-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #3478F6;
        flex-shrink: 0;
    }

    /* Certificate card */
    .oui-card {
        background: #ffffff;
        border-radius: 22px;
        padding: 20px 20px 18px;
        margin-bottom: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
        transition: transform 0.18s, box-shadow 0.18s;
        position: relative;
        overflow: hidden;
    }
    .oui-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 22px 22px 0 0;
    }
    .oui-card.status-pending::before   { background: #FF9F0A; }
    .oui-card.status-approved::before  { background: #3478F6; }
    .oui-card.status-generated::before { background: #AF52DE; }
    .oui-card.status-sent::before      { background: #30D158; }
    .oui-card.status-rejected::before  { background: #FF3B30; }

    .oui-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.09), 0 1px 4px rgba(0,0,0,0.05);
    }

    /* Card header row */
    .oui-card-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
    }
    .oui-card-name {
        font-size: 16px;
        font-weight: 700;
        color: #1C1C1E;
        line-height: 1.3;
        margin-bottom: 2px;
    }
    .oui-card-email {
        font-size: 12.5px;
        color: #8E8E93;
        font-weight: 400;
    }

    /* Status badges */
    .oui-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 50px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.02em;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .oui-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .badge-pending   { background: #FFF3E0; color: #C45C00; }
    .badge-pending   .oui-badge-dot { background: #FF9F0A; }
    .badge-approved  { background: #EBF2FF; color: #1A54C4; }
    .badge-approved  .oui-badge-dot { background: #3478F6; }
    .badge-generated { background: #F5EEFF; color: #7C29B8; }
    .badge-generated .oui-badge-dot { background: #AF52DE; }
    .badge-sent      { background: #E6FAF0; color: #1A7A40; }
    .badge-sent      .oui-badge-dot { background: #30D158; }
    .badge-rejected  { background: #FFEEED; color: #B02020; }
    .badge-rejected  .oui-badge-dot { background: #FF3B30; }

    /* Info rows */
    .oui-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 16px;
        margin-bottom: 16px;
    }
    .oui-info-item {}
    .oui-info-label {
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #AEAEB2;
        margin-bottom: 2px;
    }
    .oui-info-value {
        font-size: 13.5px;
        font-weight: 500;
        color: #3C3C43;
        line-height: 1.35;
    }
    .oui-info-value.full-col { grid-column: 1 / -1; }

    /* Rejection notice */
    .oui-reject-notice {
        background: #FFEEED;
        border-radius: 12px;
        padding: 10px 14px;
        margin-bottom: 14px;
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }
    .oui-reject-notice svg {
        width: 15px;
        height: 15px;
        color: #FF3B30;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .oui-reject-notice span {
        font-size: 12.5px;
        color: #B02020;
        line-height: 1.45;
        font-weight: 400;
    }

    /* Divider */
    .oui-card-divider {
        height: 1px;
        background: #F2F3F5;
        margin: 0 -20px 14px;
    }

    /* Details link */
    .oui-details-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 600;
        color: #3478F6;
        text-decoration: none;
        padding: 8px 0;
        transition: opacity 0.15s;
    }
    .oui-details-link:hover { opacity: 0.72; }
    .oui-details-link svg {
        width: 14px;
        height: 14px;
    }

    /* Empty state */
    .oui-empty {
        background: #fff;
        border-radius: 22px;
        padding: 48px 24px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .oui-empty-icon {
        width: 64px;
        height: 64px;
        background: #F2F3F5;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .oui-empty-icon svg {
        width: 28px;
        height: 28px;
        color: #AEAEB2;
    }
    .oui-empty-title {
        font-size: 17px;
        font-weight: 700;
        color: #1C1C1E;
        margin-bottom: 6px;
    }
    .oui-empty-desc {
        font-size: 13.5px;
        color: #8E8E93;
        line-height: 1.5;
    }

    /* Re-submit chip */
    .oui-resubmit-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        font-weight: 600;
        color: #FF9F0A;
        text-decoration: none;
        background: #FFF3E0;
        border-radius: 50px;
        padding: 5px 12px;
        transition: background 0.15s;
        margin-left: 8px;
    }
    .oui-resubmit-link:hover { background: #FFE4B5; }
    .oui-resubmit-link svg { width: 12px; height: 12px; }

    @media (max-width: 540px) {
        .oui-page-title { font-size: 24px; }
        .oui-hero { padding: 28px 16px 22px; }
        .oui-section { padding: 0 16px; }
        .oui-info-grid { grid-template-columns: 1fr; }
        .oui-search-btn { padding: 0 16px; }
    }
</style>
@endpush

@section('content')
<div class="oui-page">

    {{-- Hero / Search --}}
    <div class="oui-hero">
        <div class="oui-hero-inner">
            <p class="oui-page-label">Certificates</p>
            <h1 class="oui-page-title">My Certificates</h1>

            <form method="GET" action="{{ route('certificate.participant-dashboard') }}">
                <div class="oui-search-wrap">
                    <label class="oui-search-field">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="email" name="email" placeholder="Enter your email address"
                               value="{{ old('email', $email) }}" required>
                    </label>
                    <button type="submit" class="oui-search-btn">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Results --}}
    <div class="oui-section">

        @if($certificates->isNotEmpty())
        <div class="oui-count-pill">
            <span class="oui-count-dot"></span>
            {{ $certificates->count() }} {{ $certificates->count() === 1 ? 'certificate' : 'certificates' }} found
        </div>

        @foreach($certificates as $cert)
        @php
            $statusClass = match($cert->status) {
                'pending'   => 'status-pending',
                'approved'  => 'status-approved',
                'generated' => 'status-generated',
                'sent'      => 'status-sent',
                default     => 'status-rejected',
            };
            $badgeClass = match($cert->status) {
                'pending'   => 'badge-pending',
                'approved'  => 'badge-approved',
                'generated' => 'badge-generated',
                'sent'      => 'badge-sent',
                default     => 'badge-rejected',
            };
            $statusLabel = match($cert->status) {
                'pending'   => 'Pending',
                'approved'  => 'Approved',
                'generated' => 'Generated',
                'sent'      => 'Sent',
                'rejected'  => 'Rejected',
                default     => ucfirst($cert->status),
            };
        @endphp

        <div class="oui-card {{ $statusClass }}">
            {{-- Header --}}
            <div class="oui-card-head">
                <div>
                    <div class="oui-card-name">{{ $cert->name }}</div>
                    <div class="oui-card-email">{{ $cert->email }}</div>
                </div>
                <span class="oui-badge {{ $badgeClass }}">
                    <span class="oui-badge-dot"></span>
                    {{ $statusLabel }}
                </span>
            </div>

            {{-- Info grid --}}
            <div class="oui-info-grid">
                <div class="oui-info-item" style="grid-column: 1 / -1">
                    <div class="oui-info-label">Event</div>
                    <div class="oui-info-value">{{ $cert->event }}</div>
                </div>

                @if($cert->certificate_type_name)
                <div class="oui-info-item">
                    <div class="oui-info-label">Role</div>
                    <div class="oui-info-value">{{ $cert->certificate_type_name }}</div>
                </div>
                @endif

                @if($cert->certificate_number)
                <div class="oui-info-item">
                    <div class="oui-info-label">Certificate No.</div>
                    <div class="oui-info-value">{{ $cert->certificate_number }}</div>
                </div>
                @endif

                <div class="oui-info-item">
                    <div class="oui-info-label">Submitted</div>
                    <div class="oui-info-value">{{ $cert->created_at->format('d M Y') }}</div>
                </div>

                @if($cert->approved_at)
                <div class="oui-info-item">
                    <div class="oui-info-label">Processed</div>
                    <div class="oui-info-value">{{ $cert->approved_at->format('d M Y') }}</div>
                </div>
                @endif
            </div>

            {{-- Rejection notice --}}
            @if($cert->rejection_reason)
            <div class="oui-reject-notice">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ $cert->rejection_reason }}</span>
            </div>
            @endif

            <div class="oui-card-divider"></div>

            {{-- Footer actions --}}
            <div style="display:flex; align-items:center; flex-wrap:wrap; gap:4px;">
                <a href="{{ route('certificate.status', $cert->unique_key) }}" class="oui-details-link">
                    View details
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>

                @if($cert->status === 'rejected' && $cert->eventRelation?->isClaimOpen())
                <a href="{{ route('certificate.claim-form', $cert->eventRelation->slug) }}" class="oui-resubmit-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/>
                    </svg>
                    Re-submit
                </a>
                @endif
            </div>
        </div>
        @endforeach

        @elseif($email)
        <div class="oui-empty">
            <div class="oui-empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="oui-empty-title">No certificates found</div>
            <div class="oui-empty-desc">No certificate claims are associated with<br><strong>{{ $email }}</strong></div>
        </div>
        @endif

    </div>
</div>
@endsection
