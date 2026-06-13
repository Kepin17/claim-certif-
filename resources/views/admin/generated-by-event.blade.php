@extends('layouts.admin-layout')

@section('title', 'Generated Certificates - ' . $event->name)

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
        background: var(--accent-lt);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .event-info-icon svg { color: var(--accent); }

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
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(45,80,22,0.1);
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
        background: rgba(139,92,246,0.15);
        color: #7C3AED;
        border: 1px solid rgba(139,92,246,0.2);
    }

    .status-sent {
        background: var(--accent-lt);
        color: var(--accent);
        border: 1px solid rgba(45,80,22,0.15);
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

    .action-form {
        display: inline;
    }

    .action-form button {
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .action-form button:hover {
        background: #2A2821;
    }

    .action-form button:active {
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
        .action-btn, .action-form button { width: 100%; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Generated Certificates</h1>
        <a href="{{ route('admin.generated') }}" class="back-link">Back to Events</a>
    </div>

    <div class="event-info">
        <div class="event-info-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="event-info-content">
            <h2>{{ $event->name }}</h2>
            <p>{{ $certificates->total() }} generated certificates</p>
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

    <!-- Quick Generate Form -->
    <div style="background: var(--card); border: 1px solid rgba(0,0,0,0.07); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 24px;">
        <h3 style="font-family: 'Fraunces', serif; font-size: 18px; font-weight: 300; color: var(--ink); margin-bottom: 16px;">Quick Generate Certificate</h3>
        <form action="{{ route('admin.quick-generate', $event->id) }}" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; align-items: end;">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 6px;">Name</label>
                <input type="text" name="name" placeholder="Participant name" required style="width: 100%; padding: 12px 14px; font-family: 'Geist', sans-serif; font-size: 14px; color: var(--ink); background: var(--surface); border: 1px solid rgba(0,0,0,0.12); border-radius: var(--radius-sm);">
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 6px;">Email</label>
                <input type="email" name="email" placeholder="participant@email.com" required style="width: 100%; padding: 12px 14px; font-family: 'Geist', sans-serif; font-size: 14px; color: var(--ink); background: var(--surface); border: 1px solid rgba(0,0,0,0.12); border-radius: var(--radius-sm);">
            </div>
            <button type="submit" style="height: 44px; background: #3478F6; color: #fff; font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 600; border: none; border-radius: var(--radius-sm); cursor: pointer; transition: background 0.15s;">
                Generate & Send
            </button>
        </form>
        <p style="font-size: 12px; color: var(--ink-muted); margin-top: 10px;">Certificate will be generated and sent immediately without admin validation.</p>
    </div>

    @if($certificates->count() === 0)
        <div class="card">
            <div class="empty-state">No generated certificates for this event.</div>
        </div>
    @else
        <div class="toolbar">
            <a href="{{ route('admin.export', $event->id) }}?status=generated" class="export-btn">
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
                        <span class="status-badge {{ $certificate->status === 'sent' ? 'status-sent' : '' }}">
                            {{ strtoupper($certificate->status) }}
                        </span>
                    </div>
                    <div class="card-meta">
                        <div class="meta-item">
                            Certificate Number
                            <div class="meta-value">{{ $certificate->certificate_number }}</div>
                        </div>
                        <div class="meta-item">
                            Generated At
                            <div class="meta-value">{{ $certificate->updated_at ? $certificate->updated_at->format('d F Y, H:i') : 'N/A' }}</div>
                        </div>
                        <div class="meta-item">
                            PDF Path
                            <div class="meta-value">{{ $certificate->pdf_path }}</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('admin.show', $certificate->id) }}" class="action-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            View Details
                        </a>
                        <form action="{{ route('admin.regenerate', $certificate->id) }}" method="POST" class="action-form">
                            @csrf
                            <button type="submit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke_linejoin="round" style="vertical-align: middle; margin-right: 6px;">
                                    <path d="M23 4v6h-6"/><path d="M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                                </svg>
                                Regenerate
                            </button>
                        </form>
                        <form action="{{ route('admin.resend-email', $certificate->id) }}" method="POST" class="action-form">
                            @csrf
                            <button type="submit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke_linejoin="round" style="vertical-align: middle; margin-right: 6px;">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                </svg>
                                Resend Email
                            </button>
                        </form>
                        <form action="{{ route('admin.destroy', $certificate->id) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure you want to delete this certificate? This will allow the user to re-claim with the same email.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: var(--danger); color: #fff;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke_linejoin="round" style="vertical-align: middle; margin-right: 6px;">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                                Delete
                            </button>
                        </form>
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
