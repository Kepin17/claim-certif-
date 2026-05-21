@extends('layouts.admin-layout')

@section('title', 'Manage Events')

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

    /* Alert */
    .alert-success {
        background: var(--accent-lt);
        border: 1px solid rgba(45,80,22,0.2);
        border-left: 3px solid var(--accent);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success p { font-size: 14px; color: var(--accent); }

    /* Create Button */
    .create-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 12px 24px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
        margin-bottom: 24px;
    }

    .create-btn:hover {
        background: #2A2821;
    }

    .create-btn:active {
        transform: scale(0.98);
    }

    /* Table */
    .table-container {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: rgba(0,0,0,0.02);
        border-bottom: 1px solid rgba(0,0,0,0.07);
    }

    th {
        font-family: 'Geist', sans-serif;
        font-size: 11px;
        font-weight: 500;
        color: var(--ink-muted);
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-align: left;
        padding: 14px 24px;
    }

    tbody tr {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: background 0.2s;
    }

    tbody tr:hover {
        background: rgba(0,0,0,0.02);
    }

    tbody tr:last-child {
        border-bottom: none;
    }

    td {
        font-size: 14px;
        color: var(--ink-mid);
        padding: 16px 24px;
    }

    .event-name {
        font-weight: 500;
        color: var(--ink);
    }

    .event-desc {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 4px;
    }

    /* Event Poster */
    .event-poster {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(0,0,0,0.12);
    }

    .event-poster-placeholder {
        width: 80px;
        height: 60px;
        background: rgba(0,0,0,0.04);
        border-radius: var(--radius-sm);
        border: 1px solid rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: var(--ink-muted);
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

    /* Actions */
    .actions {
        display: flex;
        gap: 8px;
    }

    .action-link {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        transition: background 0.2s;
        text-decoration: none;
    }

    .action-link svg {
        width: 14px;
        height: 14px;
    }

    .action-link:hover {
        background: rgba(0,0,0,0.06);
    }

    .action-link.view svg { color: var(--ink-muted); }
    .action-link.edit svg { color: var(--ink-muted); }
    .action-link.toggle svg { color: #D97706; }
    .action-link.delete svg { color: var(--danger); }

    .action-form {
        display: inline;
    }

    .action-form button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
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
        border-top: 1px solid rgba(0,0,0,0.07);
    }

    @media (max-width: 640px) {
        .main-content { padding: 32px 20px 60px; }
        .page-title { font-size: 26px; }
        .table-container { overflow-x: auto; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Manage Events</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <a href="{{ route('admin.events.create') }}" class="create-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Create New Event
    </a>

    @if($events->count() === 0)
        <div class="table-container">
            <div class="empty-state">No events found.</div>
        </div>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Poster</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Claims</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                @if($event->poster)
                                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}" class="event-poster">
                                @else
                                    <div class="event-poster-placeholder">No Poster</div>
                                @endif
                            </td>
                            <td>
                                <div class="event-name">{{ $event->name }}</div>
                                @if($event->description)
                                    <div class="event-desc">{{ Str::limit($event->description, 50) }}</div>
                                @endif
                            </td>
                            <td>{{ $event->date ? $event->date->format('d F Y') : 'N/A' }}</td>
                            <td>{{ $event->location ?? 'N/A' }}</td>
                            <td>
                                @if($event->is_active)
                                    <span class="status-badge status-active">Active</span>
                                @else
                                    <span class="status-badge status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $event->certificates->count() }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.events.show', $event) }}" class="action-link view" title="View">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="action-link edit" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.events.toggle', $event) }}" method="POST" class="action-form">
                                        @csrf
                                        <button type="submit" class="action-link toggle" title="Toggle Status">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-link delete" title="Delete">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{ $events->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
