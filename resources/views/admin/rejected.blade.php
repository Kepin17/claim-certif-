@extends('layouts.admin-layout')

@section('title', 'Rejected Claims')

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

    /* Event Grid */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .event-card {
        background: var(--card);
        border: 1px solid rgba(140,44,26,0.12);
        border-radius: var(--radius-lg);
        padding: 24px;
        display: flex;
        flex-direction: column;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }

    .event-card:hover {
        border-color: rgba(140,44,26,0.25);
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        transform: translateY(-3px);
    }

    .event-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .event-icon {
        width: 40px; height: 40px;
        background: var(--danger-lt);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-icon svg { color: var(--danger); }

    .event-count {
        font-size: 12px;
        font-weight: 500;
        color: var(--danger);
        background: var(--danger-lt);
        padding: 4px 10px;
        border-radius: 100px;
        border: 1px solid rgba(140,44,26,0.15);
    }

    .event-name {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 8px;
    }

    .event-date {
        font-size: 13px;
        color: var(--ink-muted);
        margin-bottom: 20px;
    }

    .event-cta {
        margin-top: auto;
    }

    .view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--danger);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 12px 24px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
    }

    .view-btn:hover {
        background: #6D2213;
    }

    .view-btn:active {
        transform: scale(0.98);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 64px 40px;
        color: var(--ink-muted);
        font-size: 14px;
    }

    .empty-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
    }

    @media (max-width: 640px) {
        .main-content { padding: 32px 20px 60px; }
        .page-title { font-size: 26px; }
        .events-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Rejected Claims</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Back to Dashboard</a>
    </div>

    @if($events->count() === 0)
        <div class="empty-card">
            <div class="empty-state">No rejected claims found.</div>
        </div>
    @else
        <div class="events-grid">
            @foreach($events as $event)
                <div class="event-card">
                    <div class="event-card-header">
                        <div class="event-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <span class="event-count">{{ $event->certificates_count }} rejected</span>
                    </div>
                    <h3 class="event-name">{{ $event->name }}</h3>
                    @if($event->date)
                        <p class="event-date">{{ $event->date->format('d F Y') }}</p>
                    @else
                        <p class="event-date">Date not set</p>
                    @endif
                    <div class="event-cta">
                        <a href="{{ route('admin.rejected.by-event', $event->id) }}" class="view-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            View Rejected
                        </a>
                    </div>
                </div>
            @endforeach
            {{ $events->links() }}
        </div>
    @endif

</div>
@endsection
