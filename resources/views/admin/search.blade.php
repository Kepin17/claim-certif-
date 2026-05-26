@extends('layouts.admin-layout')

@section('title', 'Search' . ($query ? ' — ' . $query : ''))

@section('content')
<style>
    .main-content { max-width: 1200px; margin: 0 auto; padding: 48px 40px 80px; }

    .page-title { font-family: 'Fraunces', serif; font-size: 32px; font-weight: 300; color: var(--ink); letter-spacing: -0.01em; margin-bottom: 24px; }

    .search-bar {
        display: flex; gap: 10px; margin-bottom: 32px;
    }

    .search-input {
        flex: 1; padding: 14px 20px;
        font-family: 'Geist', sans-serif; font-size: 15px;
        color: var(--ink); background: var(--card);
        border: 1px solid rgba(0,0,0,0.1); border-radius: var(--radius-sm);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(45,80,22,0.1); }

    .search-btn {
        padding: 14px 24px; background: var(--ink); color: #fff;
        border: none; border-radius: var(--radius-sm);
        font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 500;
        cursor: pointer; transition: background 0.2s;
    }
    .search-btn:hover { background: #2A2821; }

    .results-info { font-size: 13px; color: var(--ink-muted); margin-bottom: 20px; }

    /* Table */
    .results-table-wrap {
        background: var(--card); border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg); overflow: hidden;
    }

    .results-table { width: 100%; border-collapse: collapse; }

    .results-table th {
        font-size: 11px; font-weight: 500; letter-spacing: 0.08em;
        text-transform: uppercase; color: var(--ink-muted);
        padding: 14px 20px; text-align: left;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        background: var(--surface);
    }

    .results-table td {
        padding: 14px 20px; font-size: 14px; color: var(--ink-mid);
        border-bottom: 1px solid rgba(0,0,0,0.04); vertical-align: middle;
    }

    .results-table tr:last-child td { border-bottom: none; }
    .results-table tr:hover td { background: var(--surface); }

    .status-badge {
        display: inline-block; font-size: 10px; font-weight: 600;
        letter-spacing: 0.08em; text-transform: uppercase;
        padding: 3px 8px; border-radius: 100px;
    }
    .status-badge.pending { background: rgba(251,191,36,0.15); color: #92400E; }
    .status-badge.generated, .status-badge.sent { background: var(--accent-lt); color: var(--accent); }
    .status-badge.rejected { background: var(--danger-lt); color: var(--danger); }

    .view-link { color: var(--accent); text-decoration: none; font-weight: 500; font-size: 13px; }
    .view-link:hover { text-decoration: underline; }

    .empty-state { text-align: center; padding: 64px 40px; color: var(--ink-muted); font-size: 15px; }
    .empty-state p { margin-top: 8px; font-size: 13px; }

    @media (max-width: 768px) {
        .main-content { padding: 32px 20px 60px; }
        .results-table th:nth-child(3),
        .results-table td:nth-child(3) { display: none; }
    }
</style>

<div class="main-content">

    <h1 class="page-title">Search Claims</h1>

    <form method="GET" action="{{ route('admin.search') }}" class="search-bar">
        <input type="text" name="q" value="{{ $query }}" placeholder="Search by name, email, certificate number, or event…" class="search-input" autofocus>
        <button type="submit" class="search-btn">Search</button>
    </form>

    @if(strlen($query) > 0 && strlen($query) < 2)
        <div class="empty-state">Please enter at least 2 characters.</div>
    @elseif(strlen($query) >= 2)
        @if($results instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <p class="results-info">
                Found <strong>{{ $results->total() }}</strong> result(s) for "<strong>{{ $query }}</strong>"
            </p>
            @if($results->count() === 0)
                <div class="empty-state">
                    No claims matched your search.
                    <p>Try searching by a different name, email, or certificate number.</p>
                </div>
            @else
                <div class="results-table-wrap">
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Event</th>
                                <th>Certificate #</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $cert)
                            <tr>
                                <td style="font-weight:500;color:var(--ink);">{{ $cert->name }}</td>
                                <td>{{ $cert->email }}</td>
                                <td>{{ $cert->event }}</td>
                                <td style="font-family:monospace;font-size:13px;">{{ $cert->certificate_number ?? '—' }}</td>
                                <td>
                                    <span class="status-badge {{ $cert->status }}">{{ $cert->status }}</span>
                                </td>
                                <td style="font-size:13px;white-space:nowrap;">{{ $cert->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.show', $cert->id) }}" class="view-link">View →</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="padding:16px 20px;">
                        {{ $results->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        @endif
    @else
        <div class="empty-state">
            Enter a search term above to find certificate claims.
            <p>You can search by participant name, email, certificate number, or event name.</p>
        </div>
    @endif

</div>
@endsection
