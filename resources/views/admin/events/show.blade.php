@extends('layouts.admin-layout')

@section('title', 'Event Details')

@section('content')
<style>
    .main-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 48px 40px 80px;
    }

    .page-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-title {
        font-family: 'Fraunces', serif;
        font-size: 32px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.01em;
    }

    .back-link {
        font-size: 13px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 40px;
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 12px;
        color: var(--ink-muted);
        margin-bottom: 6px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink);
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
    }

    .status-active {
        background: var(--accent-lt);
        color: var(--accent);
        border: 1px solid rgba(45,80,22,0.15);
    }

    .status-inactive {
        background: var(--danger-lt);
        color: var(--danger);
        border: 1px solid rgba(140,44,26,0.15);
    }

    /* Description */
    .description-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid rgba(0,0,0,0.07);
    }

    .description-text {
        font-size: 14px;
        color: var(--ink-mid);
        line-height: 1.6;
    }

    /* Claims Section */
    .claims-section {
        margin-bottom: 32px;
    }

    .claims-title {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 20px;
    }

    .claim-item {
        background: rgba(0,0,0,0.02);
        border-radius: var(--radius-md);
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .claim-info {
        flex: 1;
    }

    .claim-name {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
    }

    .claim-email {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 2px;
    }

    .claim-status {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 100px;
    }

    .claim-status.approved, .claim-status.generated {
        background: var(--accent-lt);
        color: var(--accent);
    }

    .claim-status.rejected {
        background: var(--danger-lt);
        color: var(--danger);
    }

    .claim-status.pending {
        background: rgba(234,179,8,0.1);
        color: #854D0E;
    }

    .view-all-link {
        font-size: 13px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        margin-top: 16px;
        display: inline-block;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        background: #2A2821;
    }

    .action-btn:active {
        transform: scale(0.98);
    }

    .action-btn.secondary {
        background: #D97706;
    }

    .action-btn.secondary:hover {
        background: #B45309;
    }

    .action-form {
        display: inline;
    }

    @media (max-width: 640px) {
        .main-content { padding: 32px 20px 60px; }
        .card { padding: 24px; }
        .page-title { font-size: 26px; }
        .details-grid { grid-template-columns: 1fr; }
        .actions { flex-direction: column; }
        .action-btn { width: 100%; justify-content: center; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Event Details</h1>
        <a href="{{ route('admin.events.index') }}" class="back-link">Back to Events</a>
    </div>

    <div class="card">

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">Event Name</span>
                <span class="detail-value">{{ $event->name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                @if($event->is_active)
                    <span class="status-badge status-active">Active</span>
                @else
                    <span class="status-badge status-inactive">Inactive</span>
                @endif
            </div>
            <div class="detail-item">
                <span class="detail-label">Date</span>
                <span class="detail-value">{{ $event->date ? $event->date->format('d F Y') : 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Location</span>
                <span class="detail-value">{{ $event->location ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Max Participants</span>
                <span class="detail-value">{{ $event->max_participants ?? 'Unlimited' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Claims</span>
                <span class="detail-value">{{ $event->certificates->count() }}</span>
            </div>
        </div>

        @if($event->description)
            <div class="description-section">
                <span class="detail-label">Description</span>
                <p class="description-text">{{ $event->description }}</p>
            </div>
        @endif

        <div class="claims-section">
            <h2 class="claims-title">Recent Claims</h2>
            @if($event->certificates->count() === 0)
                <p style="font-size: 14px; color: var(--ink-muted);">No claims for this event yet.</p>
            @else
                @foreach($event->certificates->take(5) as $certificate)
                    <div class="claim-item">
                        <div class="claim-info">
                            <p class="claim-name">{{ $certificate->name }}</p>
                            <p class="claim-email">{{ $certificate->email }}</p>
                        </div>
                        <span class="claim-status {{ $certificate->status }}">
                            {{ strtoupper($certificate->status) }}
                        </span>
                    </div>
                @endforeach
                @if($event->certificates->count() > 5)
                    <a href="{{ route('admin.pending') }}" class="view-all-link">View all claims</a>
                @endif
            @endif
        </div>

        <div class="actions">
            <a href="{{ route('admin.events.edit', $event) }}" class="action-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Event
            </a>
            <form action="{{ route('admin.events.toggle', $event) }}" method="POST" class="action-form">
                @csrf
                <button type="submit" class="action-btn secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/>
                    </svg>
                    {{ $event->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
