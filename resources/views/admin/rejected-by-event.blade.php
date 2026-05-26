@extends('layouts.admin-layout')

@section('title', 'Rejected Claims - ' . $event->name)

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
        border: 1px solid rgba(140,44,26,0.15);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .event-info-icon {
        width: 48px; height: 48px;
        background: var(--danger-lt);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .event-info-icon svg { color: var(--danger); }

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
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(140,44,26,0.1);
    }

    /* Export Toolbar */
    .toolbar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-bottom: 16px;
    }

    .export-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: var(--radius-sm);
        font-size: 13px; font-weight: 500;
        background: var(--card); color: var(--ink-mid);
        border: 1px solid rgba(0,0,0,0.1);
        text-decoration: none; font-family: 'Geist', sans-serif;
        transition: background 0.2s;
    }
    .export-btn:hover { background: var(--surface); }

    /* Card Grid */
    .cards-grid {
        display: grid;
        gap: 20px;
    }

    .card {
        background: var(--card);
        border: 1px solid rgba(140,44,26,0.12);
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
        word-break: break-all;
    }

    /* Rejection Reason */
    .rejection-box {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.15);
        border-left: 3px solid var(--danger);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    .rejection-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--danger);
        margin-bottom: 6px;
    }

    .rejection-text {
        font-size: 14px;
        color: var(--danger);
        margin: 0;
        line-height: 1.6;
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
        .action-btn { width: 100%; justify-content: center; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Rejected Claims</h1>
        <a href="{{ route('admin.rejected') }}" class="back-link">Back to Events</a>
    </div>

    <div class="event-info">
        <div class="event-info-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="event-info-content">
            <h2>{{ $event->name }}</h2>
            <p>{{ $certificates->total() }} rejected claims</p>
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
            <div class="empty-state">No rejected claims for this event.</div>
        </div>
    @else
        <div class="toolbar">
            <a href="{{ route('admin.export', $event->id) }}?status=rejected" class="export-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </a>
        </div>
        <div class="cards-grid">
            @foreach($certificates as $certificate)
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">{{ $certificate->name }}</h3>
                            <p class="card-email">{{ $certificate->email }}</p>
                            @if($certificate->certificate_type_name)
                                <span style="display:inline-block;margin-top:4px;font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:2px 8px;border-radius:100px;background:rgba(59,130,246,0.1);color:#2563EB;">{{ $certificate->certificate_type_name }}</span>
                            @endif
                        </div>
                        <span class="status-badge">REJECTED</span>
                    </div>
                    <div class="card-meta">
                        <div class="meta-item">
                            Submitted At
                            <div class="meta-value">{{ $certificate->created_at->format('d F Y, H:i') }}</div>
                        </div>
                        @if($certificate->approved_at)
                        <div class="meta-item">
                            Rejected At
                            <div class="meta-value">{{ $certificate->approved_at->format('d F Y, H:i') }}</div>
                        </div>
                        @endif
                        @if($certificate->approved_by)
                        <div class="meta-item">
                            Rejected By
                            <div class="meta-value">{{ $certificate->approved_by }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="rejection-box">
                        <p class="rejection-label">Rejection Reason</p>
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

</div>

@push('scripts')
<script>
document.getElementById('certSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        const title = card.querySelector('.card-title');
        const email = card.querySelector('.card-email');
        if (!title) return;
        if (title.textContent.toLowerCase().includes(searchTerm) || email.textContent.toLowerCase().includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection
