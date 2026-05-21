@extends('layouts.admin-layout')

@section('title', 'Rejected Claims')

@section('content')
<style>
    .main {
        max-width: 1100px;
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

    /* Card Grid */
    .cards-grid {
        display: grid;
        gap: 20px;
    }

    .card {
        background: var(--card);
        border: 1px solid rgba(140,44,26,0.15);
        border-radius: var(--radius-lg);
        padding: 24px;
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink);
    }

    .card-email {
        font-size: 13px;
        color: var(--ink-muted);
        margin-top: 4px;
    }

    .status-badge {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
        background: var(--danger-lt);
        color: var(--danger);
        border: 1px solid rgba(140,44,26,0.15);
    }

    .card-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
        padding-top: 16px;
        border-top: 1px solid rgba(0,0,0,0.06);
    }

    .meta-item {
        font-size: 12px;
        color: var(--ink-muted);
    }

    .meta-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink-mid);
        margin-top: 4px;
    }

    /* Rejection Reason */
    .rejection-box {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.15);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    .rejection-label {
        font-size: 12px;
        color: var(--danger);
        font-weight: 500;
        margin-bottom: 6px;
    }

    .rejection-text {
        font-size: 14px;
        color: var(--danger);
        margin: 0;
    }

    /* Action Button */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .action-btn:hover {
        background: #2A2821;
    }

    .action-btn:active {
        transform: scale(0.98);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 64px 40px;
        color: var(--ink-muted);
        font-size: 14px;
    }

    /* Pagination */
    .pagination {
        padding: 16px 24px;
        margin-top: 20px;
    }

    @media (max-width: 640px) {
        .main { padding: 32px 20px 60px; }
        .page-title { font-size: 26px; }
        .card-meta { grid-template-columns: 1fr; }
    }
</style>

<main class="main">

    <div class="page-header">
        <h1 class="page-title">Rejected Claims</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Back to Dashboard</a>
    </div>

    @if($certificates->count() === 0)
        <div class="card">
            <div class="empty-state">No rejected claims.</div>
        </div>
    @else
        <div class="cards-grid">
            @foreach($certificates as $certificate)
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">{{ $certificate->name }}</h3>
                            <p class="card-email">{{ $certificate->email }}</p>
                        </div>
                        <span class="status-badge">REJECTED</span>
                    </div>
                    <div class="card-meta">
                        <div class="meta-item">
                            Participant Number
                            <div class="meta-value">{{ $certificate->participant_number }}</div>
                        </div>
                        <div class="meta-item">
                            Event
                            <div class="meta-value">{{ $certificate->event }}</div>
                        </div>
                    </div>
                    <div class="rejection-box">
                        <p class="rejection-label">Rejection Reason:</p>
                        <p class="rejection-text">{{ $certificate->rejection_reason }}</p>
                    </div>
                    <a href="{{ route('admin.show', $certificate->id) }}" class="action-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        View Details
                    </a>
                </div>
            @endforeach
        </div>
        <div class="pagination">
            {{ $certificates->links() }}
        </div>
    @endif

</main>
@endsection
