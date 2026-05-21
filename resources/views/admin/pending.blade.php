@extends('layouts.admin-layout')

@section('title', 'Pending Claims')

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

    .name-cell {
        font-weight: 500;
        color: var(--ink);
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
        padding: 8px 16px;
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
        <h1 class="page-title">Pending Claims</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Back to Dashboard</a>
    </div>

    @if($certificates->count() === 0)
        <div class="table-container">
            <div class="empty-state">No pending claims to review.</div>
        </div>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Event</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $certificate)
                        <tr>
                            <td class="name-cell">{{ $certificate->name }}</td>
                            <td>{{ $certificate->email }}</td>
                            <td>{{ $certificate->event }}</td>
                            <td>{{ $certificate->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.show', $certificate->id) }}" class="action-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                    </svg>
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{ $certificates->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
