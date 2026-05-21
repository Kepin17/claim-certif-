@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    /* Main Content */
    .main-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 48px 40px 80px;
    }

    /* Page Header */
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

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 24px;
        text-decoration: none;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
        display: block;
    }

    .stat-card:hover {
        border-color: rgba(0,0,0,0.14);
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        transform: translateY(-3px);
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.pending { background: rgba(251,191,36,0.15); }
    .stat-icon.pending svg { color: #D97706; }

    .stat-icon.approved { background: var(--accent-lt); }
    .stat-icon.approved svg { color: var(--accent); }

    .stat-icon.generated { background: rgba(59,130,246,0.15); }
    .stat-icon.generated svg { color: #2563EB; }

    .stat-icon.events { background: rgba(139,92,246,0.15); }
    .stat-icon.events svg { color: #7C3AED; }

    .stat-icon svg { width: 20px; height: 20px; }

    .stat-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--ink-muted);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .stat-num {
        font-family: 'Fraunces', serif;
        font-size: 36px;
        font-weight: 500;
        color: var(--ink);
        line-height: 1;
    }

    /* Quick Actions */
    .quick-actions {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 32px;
    }

    .section-title {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.01em;
        margin-bottom: 24px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        font-weight: 500;
        padding: 14px 24px;
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

    .action-btn svg { flex-shrink: 0; }

    @media (max-width: 640px) {
        .main-content { padding: 32px 20px 60px; }
        .stats-grid { grid-template-columns: 1fr; }
        .page-title { font-size: 26px; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Admin Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <a href="{{ route('admin.pending') }}" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon pending">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <span class="stat-label">Pending</span>
            </div>
            <div class="stat-num">{{ $pendingCount }}</div>
        </a>

        <a href="{{ route('admin.approved') }}" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon approved">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <span class="stat-label">Approved</span>
            </div>
            <div class="stat-num">{{ $approvedCount }}</div>
        </a>

        <a href="{{ route('admin.generated') }}" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon generated">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <span class="stat-label">Generated</span>
            </div>
            <div class="stat-num">{{ $generatedCount }}</div>
        </a>

        <a href="{{ route('admin.events.index') }}" class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon events">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="stat-label">Events</span>
            </div>
            <div class="stat-num">{{ $eventsCount ?? 0 }}</div>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">Quick Actions</h2>
        <div class="actions-grid">
            <a href="{{ route('admin.pending') }}" class="action-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Review Pending
            </a>
            <a href="{{ route('admin.generated') }}" class="action-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                </svg>
                View Generated
            </a>
        </div>
    </div>

</div>
@endsection
