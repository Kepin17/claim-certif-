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

    /* Toolbar */
    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .toolbar-left { display: flex; align-items: center; gap: 10px; }
    .toolbar-right { display: flex; align-items: center; gap: 10px; }

    .select-all-wrap {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--ink-muted); cursor: pointer;
    }

    /* Bulk Action Bar */
    .bulk-bar {
        display: none;
        position: sticky;
        bottom: 24px;
        background: var(--ink);
        color: #fff;
        border-radius: var(--radius-lg);
        padding: 14px 20px;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        z-index: 100;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    .bulk-bar.visible { display: flex; }

    .bulk-count { font-size: 14px; font-weight: 500; }

    .bulk-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .bulk-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-size: 13px; font-weight: 500; cursor: pointer;
        border: none; font-family: 'Geist', sans-serif;
        transition: background 0.2s;
    }

    .bulk-btn.approve { background: var(--accent); color: #fff; }
    .bulk-btn.approve:hover { background: var(--accent-mid); }
    .bulk-btn.reject-open { background: var(--danger); color: #fff; }
    .bulk-btn.reject-open:hover { background: #6D2213; }
    .bulk-btn.cancel { background: rgba(255,255,255,0.1); color: #fff; }
    .bulk-btn.cancel:hover { background: rgba(255,255,255,0.2); }

    /* Checkbox */
    .card-checkbox {
        width: 18px; height: 18px; accent-color: var(--accent); cursor: pointer;
    }

    /* Export btn */
    .export-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: var(--radius-sm);
        font-size: 13px; font-weight: 500; cursor: pointer;
        background: var(--card); color: var(--ink-mid);
        border: 1px solid rgba(0,0,0,0.1);
        text-decoration: none; font-family: 'Geist', sans-serif;
        transition: background 0.2s;
    }
    .export-btn:hover { background: var(--surface); }

    /* Bulk reject modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 200;
        align-items: center; justify-content: center;
    }
    .modal-overlay.visible { display: flex; }
    .modal {
        background: var(--card); border-radius: var(--radius-lg);
        padding: 28px; width: 100%; max-width: 480px; margin: 20px;
    }
    .modal-title {
        font-family: 'Fraunces', serif; font-size: 20px;
        font-weight: 300; color: var(--ink); margin-bottom: 16px;
    }
    .modal-actions { display: flex; gap: 10px; margin-top: 16px;
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
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="toolbar-left">
                <label class="select-all-wrap">
                    <input type="checkbox" id="selectAll" class="card-checkbox">
                    Select all on this page
                </label>
                <span id="selectedCount" style="font-size:13px;color:var(--ink-muted);"></span>
            </div>
            <div class="toolbar-right">
                <a href="{{ route('admin.export', $event->id) }}?status=pending" class="export-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export CSV
                </a>
            </div>
        </div>

        <div class="cards-grid">
            @foreach($certificates as $certificate)
                <div class="card" data-id="{{ $certificate->id }}">
                    <div class="card-header">
                        <div style="display:flex;align-items:flex-start;gap:12px;">
                            <input type="checkbox" class="card-checkbox cert-checkbox" value="{{ $certificate->id }}" style="margin-top:3px;">
                            <div>
                                <h3 class="card-title">{{ $certificate->name }}</h3>
                                <p class="card-email">{{ $certificate->email }}</p>
                                @if($certificate->certificate_type_name)
                                    <span style="display:inline-block;margin-top:4px;font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:2px 8px;border-radius:100px;background:rgba(59,130,246,0.1);color:#2563EB;">{{ $certificate->certificate_type_name }}</span>
                                @endif
                            </div>
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

        <!-- Bulk action sticky bar -->
        <form id="bulkApproveForm" action="{{ route('admin.bulk-approve') }}" method="POST" style="display:none;">
            @csrf
            <div id="bulkApproveIds"></div>
        </form>
        <div id="bulkRejectModal" class="modal-overlay">
            <div class="modal">
                <h3 class="modal-title">Bulk Reject Claims</h3>
                <form action="{{ route('admin.bulk-reject') }}" method="POST" id="bulkRejectForm">
                    @csrf
                    <div id="bulkRejectIds"></div>
                    <label style="font-size:13px;font-weight:500;color:var(--ink-mid);display:block;margin-bottom:8px;">Rejection Reason</label>
                    <button type="button" onclick="document.getElementById('bulkReason').value='Data not found in attendance records or not present at the event'" style="font-size:12px;color:var(--accent);background:none;border:none;cursor:pointer;margin-bottom:8px;padding:0;">+ Quick add: Not found in attendance / not present</button>
                    <textarea name="rejection_reason" id="bulkReason" rows="4" required style="width:100%;padding:10px 14px;font-family:'Geist',sans-serif;font-size:14px;border:1px solid rgba(0,0,0,0.12);border-radius:6px;resize:none;"></textarea>
                    <div class="modal-actions">
                        <button type="submit" class="bulk-btn reject-open">Confirm Reject</button>
                        <button type="button" onclick="document.getElementById('bulkRejectModal').classList.remove('visible')" class="bulk-btn cancel" style="background:rgba(0,0,0,0.08);color:var(--ink);">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="bulkBar" class="bulk-bar">
            <span class="bulk-count" id="bulkCountLabel">0 selected</span>
            <div class="bulk-actions">
                <button class="bulk-btn approve" onclick="submitBulkApprove()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                    Approve Selected
                </button>
                <button class="bulk-btn reject-open" onclick="openBulkReject()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reject Selected
                </button>
                <button class="bulk-btn cancel" onclick="clearSelection()">Clear</button>
            </div>
        </div>
    @endif

</div>


@push('scripts')
<script>
document.getElementById('certSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.card').forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const email = card.querySelector('.card-email').textContent.toLowerCase();
        card.style.display = (title.includes(searchTerm) || email.includes(searchTerm)) ? 'block' : 'none';
    });
});

function getSelected() {
    return [...document.querySelectorAll('.cert-checkbox:checked')].map(c => c.value);
}

function updateBulkBar() {
    const ids = getSelected();
    const bar = document.getElementById('bulkBar');
    bar.classList.toggle('visible', ids.length > 0);
    document.getElementById('bulkCountLabel').textContent = ids.length + ' selected';
    document.getElementById('selectedCount').textContent = ids.length > 0 ? ids.length + ' selected' : '';
}

document.querySelectorAll('.cert-checkbox').forEach(cb => cb.addEventListener('change', updateBulkBar));

document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.cert-checkbox').forEach(cb => cb.checked = this.checked);
    updateBulkBar();
});

function clearSelection() {
    document.querySelectorAll('.cert-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('selectAll').checked = false;
    updateBulkBar();
}

function submitBulkApprove() {
    const ids = getSelected();
    if (!ids.length) return;
    if (!confirm('Approve ' + ids.length + ' claim(s)? This will generate and send certificates.')) return;
    const container = document.getElementById('bulkApproveIds');
    container.innerHTML = '';
    ids.forEach(id => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = id;
        container.appendChild(inp);
    });
    document.getElementById('bulkApproveForm').submit();
}

function openBulkReject() {
    const ids = getSelected();
    if (!ids.length) return;
    const container = document.getElementById('bulkRejectIds');
    container.innerHTML = '';
    ids.forEach(id => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = id;
        container.appendChild(inp);
    });
    document.getElementById('bulkRejectModal').classList.add('visible');
}
</script>
@endpush
@endsection
