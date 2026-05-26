@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .dash {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 40px 80px;
    }

    /* ─── Header ─── */
    .dash-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 36px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dash-greeting {
        font-family: 'Fraunces', serif;
        font-size: 30px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .dash-greeting span { color: var(--accent); }

    .dash-meta {
        font-size: 13px;
        color: var(--ink-muted);
        margin-top: 4px;
    }

    .dash-date {
        font-size: 13px;
        color: var(--ink-muted);
        text-align: right;
    }

    /* ─── Stat Cards ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 22px 20px 20px;
        text-decoration: none;
        display: block;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
        border-color: rgba(0,0,0,0.12);
    }

    .stat-card:hover::after { opacity: 1; }

    .stat-card.pending::after  { background: #D97706; }
    .stat-card.generated::after{ background: #2563EB; }
    .stat-card.rejected::after { background: var(--danger); }
    .stat-card.events::after   { background: #7C3AED; }
    .stat-card.total::after    { background: var(--accent); }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg { width: 18px; height: 18px; }

    .stat-icon.pending   { background: rgba(251,191,36,0.15); color: #D97706; }
    .stat-icon.generated { background: rgba(59,130,246,0.12); color: #2563EB; }
    .stat-icon.rejected  { background: var(--danger-lt); color: var(--danger); }
    .stat-icon.events    { background: rgba(139,92,246,0.12); color: #7C3AED; }
    .stat-icon.total     { background: var(--accent-lt); color: var(--accent); }

    .stat-arrow {
        color: var(--ink-faint);
        transition: color 0.2s, transform 0.2s;
    }

    .stat-card:hover .stat-arrow {
        color: var(--ink-muted);
        transform: translateX(3px);
    }

    .stat-num {
        font-family: 'Fraunces', serif;
        font-size: 38px;
        font-weight: 500;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--ink-muted);
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* ─── Progress Bar ─── */
    .overview-bar {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 24px 28px;
        margin-bottom: 32px;
    }

    .overview-bar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .overview-title {
        font-family: 'Fraunces', serif;
        font-size: 16px;
        font-weight: 300;
        color: var(--ink);
    }

    .overview-legend {
        display: flex; gap: 20px; flex-wrap: wrap;
    }

    .legend-item {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--ink-muted);
    }

    .legend-dot {
        width: 8px; height: 8px; border-radius: 50%;
    }

    .bar-track {
        height: 8px;
        background: var(--surface);
        border-radius: 100px;
        overflow: hidden;
        display: flex;
    }

    .bar-seg {
        height: 100%;
        transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
    }

    /* ─── Bottom Grid ─── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .panel {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .panel-title {
        font-family: 'Fraunces', serif;
        font-size: 16px;
        font-weight: 300;
        color: var(--ink);
    }

    .panel-link {
        font-size: 12px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .panel-link:hover { text-decoration: underline; }

    /* ─── Recent Pending ─── */
    .pending-list { list-style: none; }

    .pending-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        transition: background 0.15s;
    }

    .pending-item:last-child { border-bottom: none; }
    .pending-item:hover { background: var(--surface); }

    .pending-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--accent-lt);
        color: var(--accent);
        font-size: 13px;
        font-weight: 600;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .pending-info { flex: 1; min-width: 0; }

    .pending-name {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pending-event {
        font-size: 12px;
        color: var(--ink-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pending-time {
        font-size: 12px;
        color: var(--ink-faint);
        white-space: nowrap;
    }

    .pending-review {
        font-size: 12px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        padding: 5px 12px;
        border: 1px solid rgba(45,80,22,0.2);
        border-radius: 6px;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .pending-review:hover { background: var(--accent-lt); }

    /* ─── Activity Log ─── */
    .log-list { list-style: none; }

    .log-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px 24px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        transition: background 0.15s;
    }

    .log-item:last-child { border-bottom: none; }
    .log-item:hover { background: var(--surface); }

    .log-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    .log-dot.green  { background: var(--accent); }
    .log-dot.red    { background: var(--danger); }
    .log-dot.amber  { background: #D97706; }
    .log-dot.gray   { background: var(--ink-faint); }

    .log-body { flex: 1; min-width: 0; }

    .log-text {
        font-size: 13px;
        color: var(--ink-mid);
        line-height: 1.5;
    }

    .log-text strong { color: var(--ink); }

    .log-time {
        font-size: 11px;
        color: var(--ink-faint);
        margin-top: 2px;
    }

    /* ─── Quick Actions (bottom strip) ─── */
    .quick-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        margin-top: 24px;
    }

    .qa-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 18px 20px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }

    .qa-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(0,0,0,0.09);
        border-color: rgba(0,0,0,0.12);
    }

    .qa-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .qa-icon svg { width: 18px; height: 18px; }

    .qa-label {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
    }

    .qa-sub {
        font-size: 12px;
        color: var(--ink-muted);
    }

    /* ─── Empty state ─── */
    .empty-panel {
        padding: 40px 24px;
        text-align: center;
        color: var(--ink-muted);
        font-size: 13px;
    }

    /* ─── Responsive ─── */
    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .dash { padding: 28px 20px 60px; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .bottom-grid { grid-template-columns: 1fr; }
        .dash-greeting { font-size: 24px; }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .stat-num { font-size: 30px; }
    }
</style>

<div class="dash">

    {{-- ── Header ── --}}
    <div class="dash-header">
        <div>
            <div class="dash-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }},
                <span>{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
            <div class="dash-meta">Here's what's happening with your certificates today.</div>
        </div>
        <div class="dash-date">
            <div style="font-weight:500;color:var(--ink);">{{ now()->format('l') }}</div>
            <div>{{ now()->format('d F Y') }}</div>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="stats-grid">
        <a href="{{ route('admin.pending') }}" class="stat-card pending">
            <div class="stat-top">
                <div class="stat-icon pending">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <svg class="stat-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
            <div class="stat-num" data-target="{{ $pendingCount }}">0</div>
            <div class="stat-label">Pending</div>
        </a>

        <a href="{{ route('admin.generated') }}" class="stat-card generated">
            <div class="stat-top">
                <div class="stat-icon generated">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <svg class="stat-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
            <div class="stat-num" data-target="{{ $generatedCount }}">0</div>
            <div class="stat-label">Generated</div>
        </a>

        <a href="{{ route('admin.rejected') }}" class="stat-card rejected">
            <div class="stat-top">
                <div class="stat-icon rejected">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <svg class="stat-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
            <div class="stat-num" data-target="{{ $rejectedCount }}">0</div>
            <div class="stat-label">Rejected</div>
        </a>

        <a href="{{ route('admin.events.index') }}" class="stat-card events">
            <div class="stat-top">
                <div class="stat-icon events">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <svg class="stat-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
            <div class="stat-num" data-target="{{ $eventsCount }}">0</div>
            <div class="stat-label">Events</div>
        </a>

        <a href="{{ route('admin.search') }}" class="stat-card total">
            <div class="stat-top">
                <div class="stat-icon total">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <svg class="stat-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </div>
            <div class="stat-num" data-target="{{ $totalClaims }}">0</div>
            <div class="stat-label">Total Claims</div>
        </a>
    </div>

    {{-- ── Overview Bar ── --}}
    @if($totalClaims > 0)
    <div class="overview-bar">
        <div class="overview-bar-header">
            <span class="overview-title">Claims Overview</span>
            <div class="overview-legend">
                <span class="legend-item"><span class="legend-dot" style="background:#2563EB;"></span>Generated ({{ $generatedCount }})</span>
                <span class="legend-item"><span class="legend-dot" style="background:#D97706;"></span>Pending ({{ $pendingCount }})</span>
                <span class="legend-item"><span class="legend-dot" style="background:var(--danger);"></span>Rejected ({{ $rejectedCount }})</span>
            </div>
        </div>
        <div class="bar-track">
            <div class="bar-seg" style="background:#2563EB; width: 0%;"
                 data-width="{{ round($generatedCount / $totalClaims * 100, 1) }}%"></div>
            <div class="bar-seg" style="background:#D97706; width: 0%;"
                 data-width="{{ round($pendingCount / $totalClaims * 100, 1) }}%"></div>
            <div class="bar-seg" style="background:var(--danger); width: 0%;"
                 data-width="{{ round($rejectedCount / $totalClaims * 100, 1) }}%"></div>
        </div>
    </div>
    @endif

    {{-- ── Bottom Grid ── --}}
    <div class="bottom-grid">

        {{-- Recent Pending --}}
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">Recent Pending Claims</span>
                <a href="{{ route('admin.pending') }}" class="panel-link">View all →</a>
            </div>
            @if($recentPending->count())
                <ul class="pending-list">
                    @foreach($recentPending as $cert)
                    <li class="pending-item">
                        <div class="pending-avatar">{{ mb_substr($cert->name, 0, 1) }}</div>
                        <div class="pending-info">
                            <div class="pending-name">{{ $cert->name }}</div>
                            <div class="pending-event">{{ Str::limit($cert->event, 38) }}</div>
                        </div>
                        <div class="pending-time">{{ $cert->created_at->diffForHumans() }}</div>
                        <a href="{{ route('admin.show', $cert->id) }}" class="pending-review">Review</a>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-panel">No pending claims right now.</div>
            @endif
        </div>

        {{-- Activity Log --}}
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">Recent Activity</span>
                <a href="{{ route('admin.activity-log') }}" class="panel-link">Full log →</a>
            </div>
            @if($recentLogs->count())
                <ul class="log-list">
                    @foreach($recentLogs as $log)
                    <li class="log-item">
                        <div class="log-dot {{ $log->action_color }}"></div>
                        <div class="log-body">
                            <div class="log-text">
                                <strong>{{ $log->admin_name }}</strong>
                                {{ match($log->action) {
                                    'approved'         => 'approved',
                                    'rejected'         => 'rejected',
                                    'reset_to_pending' => 'reset to pending',
                                    'bulk_approved'    => 'bulk approved',
                                    'bulk_rejected'    => 'bulk rejected',
                                    'regenerated'      => 'regenerated',
                                    'resent_email'     => 'resent email for',
                                    default            => $log->action,
                                } }}
                                @if($log->certificate_id)
                                    <a href="{{ route('admin.show', $log->certificate_id) }}" style="color:var(--accent);text-decoration:none;font-weight:500;">{{ Str::limit($log->certificate_name, 28) }}</a>
                                @endif
                                @if($log->event_name)
                                    <span style="color:var(--ink-muted);"> · {{ Str::limit($log->event_name, 24) }}</span>
                                @endif
                            </div>
                            <div class="log-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-panel">No activity recorded yet.</div>
            @endif
        </div>

    </div>

    {{-- ── Quick Actions ── --}}
    <div class="quick-strip">
        <a href="{{ route('admin.pending') }}" class="qa-card">
            <div class="qa-icon" style="background:rgba(251,191,36,0.15);color:#D97706;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="qa-label">Review Pending</div>
                <div class="qa-sub">{{ $pendingCount }} awaiting review</div>
            </div>
        </a>
        <a href="{{ route('admin.generated') }}" class="qa-card">
            <div class="qa-icon" style="background:rgba(59,130,246,0.12);color:#2563EB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div class="qa-label">Generated</div>
                <div class="qa-sub">{{ $generatedCount }} certificates</div>
            </div>
        </a>
        <a href="{{ route('admin.rejected') }}" class="qa-card">
            <div class="qa-icon" style="background:var(--danger-lt);color:var(--danger);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <div class="qa-label">View Rejected</div>
                <div class="qa-sub">{{ $rejectedCount }} rejected</div>
            </div>
        </a>
        <a href="{{ route('admin.activity-log') }}" class="qa-card">
            <div class="qa-icon" style="background:rgba(45,80,22,0.1);color:var(--accent);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="12" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div>
                <div class="qa-label">Activity Log</div>
                <div class="qa-sub">Audit trail</div>
            </div>
        </a>
        <a href="{{ route('admin.events.create') }}" class="qa-card">
            <div class="qa-icon" style="background:rgba(139,92,246,0.12);color:#7C3AED;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </div>
            <div>
                <div class="qa-label">New Event</div>
                <div class="qa-sub">Create & configure</div>
            </div>
        </a>
        <a href="{{ route('admin.search') }}" class="qa-card">
            <div class="qa-icon" style="background:rgba(0,0,0,0.05);color:var(--ink-mid);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <div>
                <div class="qa-label">Search Claims</div>
                <div class="qa-sub">Find any claim</div>
            </div>
        </a>
    </div>

</div>

@push('scripts')
<script>
/* ── Count-up animation ── */
document.querySelectorAll('.stat-num[data-target]').forEach(el => {
    const target = parseInt(el.dataset.target, 10);
    if (target === 0) { el.textContent = '0'; return; }
    const duration = 900;
    const step = Math.ceil(duration / target);
    let current = 0;
    const timer = setInterval(() => {
        current += Math.max(1, Math.ceil(target / 60));
        if (current >= target) { el.textContent = target.toLocaleString(); clearInterval(timer); }
        else { el.textContent = current.toLocaleString(); }
    }, step > 16 ? step : 16);
});

/* ── Progress bar animation ── */
window.addEventListener('load', () => {
    document.querySelectorAll('.bar-seg').forEach(seg => {
        seg.style.width = seg.dataset.width;
    });
});
</script>
@endpush

@endsection
