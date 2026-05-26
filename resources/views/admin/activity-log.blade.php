@extends('layouts.admin-layout')

@section('title', 'Activity Log')

@section('content')
<style>
    .main-content { max-width: 1200px; margin: 0 auto; padding: 48px 40px 80px; }

    .page-header { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 32px; }

    .page-title { font-family: 'Fraunces', serif; font-size: 32px; font-weight: 300; color: var(--ink); letter-spacing: -0.01em; }

    .back-link { font-size: 13px; color: var(--accent); text-decoration: none; font-weight: 500; }
    .back-link:hover { text-decoration: underline; }

    /* Filters */
    .filters {
        display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;
    }

    .filter-input {
        flex: 1; min-width: 200px;
        padding: 10px 16px; font-family: 'Geist', sans-serif; font-size: 14px;
        color: var(--ink); background: var(--card);
        border: 1px solid rgba(0,0,0,0.1); border-radius: var(--radius-sm);
    }

    .filter-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(45,80,22,0.1); }

    .filter-select {
        padding: 10px 16px; font-family: 'Geist', sans-serif; font-size: 14px;
        color: var(--ink); background: var(--card);
        border: 1px solid rgba(0,0,0,0.1); border-radius: var(--radius-sm);
        cursor: pointer;
    }

    .filter-btn {
        padding: 10px 20px; background: var(--ink); color: #fff;
        border: none; border-radius: var(--radius-sm);
        font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 500;
        cursor: pointer;
    }

    /* Log Table */
    .log-table-wrap {
        background: var(--card); border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg); overflow: hidden;
    }

    .log-table { width: 100%; border-collapse: collapse; }

    .log-table th {
        font-size: 11px; font-weight: 500; letter-spacing: 0.08em;
        text-transform: uppercase; color: var(--ink-muted);
        padding: 14px 20px; text-align: left;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        background: var(--surface);
    }

    .log-table td {
        padding: 14px 20px; font-size: 14px; color: var(--ink-mid);
        border-bottom: 1px solid rgba(0,0,0,0.04);
        vertical-align: middle;
    }

    .log-table tr:last-child td { border-bottom: none; }
    .log-table tr:hover td { background: var(--surface); }

    .action-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 500; letter-spacing: 0.05em;
        text-transform: uppercase; padding: 4px 10px;
        border-radius: 100px;
    }

    .action-badge.green { background: var(--accent-lt); color: var(--accent); border: 1px solid rgba(45,80,22,0.15); }
    .action-badge.red { background: var(--danger-lt); color: var(--danger); border: 1px solid rgba(140,44,26,0.15); }
    .action-badge.amber { background: rgba(251,191,36,0.15); color: #92400E; border: 1px solid rgba(217,119,6,0.2); }
    .action-badge.gray { background: rgba(0,0,0,0.05); color: var(--ink-mid); border: 1px solid rgba(0,0,0,0.08); }

    .cert-link { color: var(--accent); text-decoration: none; font-weight: 500; }
    .cert-link:hover { text-decoration: underline; }

    .empty-state { text-align: center; padding: 64px 40px; color: var(--ink-muted); font-size: 14px; }

    @media (max-width: 768px) {
        .main-content { padding: 32px 20px 60px; }
        .page-title { font-size: 26px; }
        .log-table th:nth-child(4),
        .log-table td:nth-child(4) { display: none; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Activity Log</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Back to Dashboard</a>
    </div>

    <form method="GET" action="{{ route('admin.activity-log') }}" class="filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search admin, name, event..." class="filter-input">
        <select name="action" class="filter-select">
            <option value="">All Actions</option>
            <option value="approved" {{ request('action') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('action') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="reset_to_pending" {{ request('action') === 'reset_to_pending' ? 'selected' : '' }}>Reset to Pending</option>
            <option value="bulk_approved" {{ request('action') === 'bulk_approved' ? 'selected' : '' }}>Bulk Approved</option>
            <option value="bulk_rejected" {{ request('action') === 'bulk_rejected' ? 'selected' : '' }}>Bulk Rejected</option>
            <option value="regenerated" {{ request('action') === 'regenerated' ? 'selected' : '' }}>Regenerated</option>
            <option value="resent_email" {{ request('action') === 'resent_email' ? 'selected' : '' }}>Resent Email</option>
        </select>
        <button type="submit" class="filter-btn">Filter</button>
        @if(request('search') || request('action'))
            <a href="{{ route('admin.activity-log') }}" style="padding:10px 16px;font-size:14px;color:var(--ink-muted);text-decoration:none;">Clear</a>
        @endif
    </form>

    <div class="log-table-wrap">
        @if($logs->count() === 0)
            <div class="empty-state">No activity logs found.</div>
        @else
            <table class="log-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Admin</th>
                        <th>Participant</th>
                        <th>Event</th>
                        <th>Notes</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>
                            <span class="action-badge {{ $log->action_color }}">
                                {{ $log->action_label }}
                            </span>
                        </td>
                        <td style="font-weight:500;color:var(--ink);">{{ $log->admin_name }}</td>
                        <td>
                            @if($log->certificate_id)
                                <a href="{{ route('admin.show', $log->certificate_id) }}" class="cert-link">{{ $log->certificate_name }}</a>
                            @else
                                <span style="color:var(--ink-faint);">—</span>
                            @endif
                        </td>
                        <td>{{ $log->event_name ?? '—' }}</td>
                        <td style="max-width:220px;">
                            @if($log->notes)
                                <span style="font-size:13px;color:var(--ink-muted);" title="{{ $log->notes }}">
                                    {{ Str::limit($log->notes, 60) }}
                                </span>
                            @else
                                <span style="color:var(--ink-faint);">—</span>
                            @endif
                        </td>
                        <td style="font-size:13px;white-space:nowrap;">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 16px 20px;">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
