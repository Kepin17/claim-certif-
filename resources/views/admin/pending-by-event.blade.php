@extends('layouts.admin-layout')

@section('title', 'Pending Claims - ' . $event->name)

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

    /* Event Info */
    .event-info {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .event-info-icon {
        width: 48px; height: 48px;
        background: rgba(251,191,36,0.15);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .event-info-icon svg { color: #D97706; }

    .event-info-content h2 {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .event-info-content p {
        font-size: 13px;
        color: var(--ink-muted);
    }

    /* Search Bar */
    .search-bar {
        margin-bottom: 24px;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: var(--ink-faint);
    }

    .search-input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        color: var(--ink);
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: var(--radius-sm);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: #D97706;
        box-shadow: 0 0 0 3px rgba(217,119,6,0.1);
    }

    /* Card Grid */
    .cards-grid {
        display: grid;
        gap: 20px;
    }

    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
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
        background: rgba(251,191,36,0.15);
        color: #D97706;
        border: 1px solid rgba(251,191,36,0.2);
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
        word-break: break-all;
    }

    .card-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

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
        .main-content { padding: 32px 20px 60px; }
        .page-title { font-size: 26px; }
        .event-info { flex-direction: column; text-align: center; }
        .card-meta { grid-template-columns: 1fr; }
        .card-actions { flex-direction: column; }
        .action-btn { width: 100%; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Pending Claims</h1>
        <a href="{{ route('admin.pending') }}" class="back-link">Back to Events</a>
    </div>

    <div class="event-info">
        <div class="event-info-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="event-info-content">
            <h2>{{ $event->name }}</h2>
            <p>{{ $certificates->total() }} pending claims</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-input-wrapper">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="certSearch" placeholder="Search by name or email..." class="search-input">
        </div>
    </div>

    @if($certificates->count() === 0)
        <div class="card">
            <div class="empty-state">No pending claims for this event.</div>
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
                        <span class="status-badge">
                            PENDING
                        </span>
                    </div>
                    <div class="card-meta">
                        <div class="meta-item">
                            Submitted At
                            <div class="meta-value">{{ $certificate->created_at->format('d F Y, H:i') }}</div>
                        </div>
                        @if($certificate->message)
                        <div class="meta-item">
                            Message
                            <div class="meta-value">{{ $certificate->message }}</div>
                        </div>
                        @endif
                        @if($certificate->next_event)
                        <div class="meta-item">
                            Next Event Request
                            <div class="meta-value">{{ $certificate->next_event }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('admin.show', $certificate->id) }}" class="action-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            Review Claim
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination">
            {{ $certificates->links() }}
        </div>
    @endif

</div>

@push('scripts')
<script>
document.getElementById('certSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const email = card.querySelector('.card-email').textContent.toLowerCase();
        if (title.includes(searchTerm) || email.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection
