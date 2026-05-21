@extends('layouts.admin-layout')

@section('title', 'Review Claim')

@section('content')
<style>
    .main {
        max-width: 900px;
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

    /* Sections */
    .sections {
        display: grid;
        gap: 24px;
    }

    .section {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 24px;
    }

    .section-title {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 20px;
        letter-spacing: -0.01em;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 12px;
        color: var(--ink-muted);
        margin-bottom: 6px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
    }

    .status-value {
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .status-value.pending {
        color: #854D0E;
    }

    .status-value.other {
        color: var(--ink-mid);
    }

    /* Proof Link */
    .proof-link {
        font-size: 13px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        margin-top: 8px;
        display: inline-block;
    }

    .proof-link:hover {
        text-decoration: underline;
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .action-btn {
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
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        background: #2A2821;
    }

    .action-btn:active {
        transform: scale(0.98);
    }

    .action-btn.approve {
        background: var(--accent);
    }

    .action-btn.approve:hover {
        background: var(--accent-mid);
    }

    .action-btn.reject {
        background: var(--danger);
    }

    .action-btn.reject:hover {
        background: #6D2213;
    }

    /* Reject Form */
    .reject-form {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.15);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-top: 20px;
    }

    .reject-form-title {
        font-size: 16px;
        font-weight: 500;
        color: var(--danger);
        margin-bottom: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-mid);
        margin-bottom: 8px;
        display: block;
    }

    .form-input {
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        color: var(--ink);
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(140,44,26,0.1);
    }

    textarea.form-input {
        resize: none;
        min-height: 100px;
    }

    .action-form {
        display: inline;
    }

    @media (max-width: 640px) {
        .main { padding: 32px 20px 60px; }
        .section { padding: 20px; }
        .page-title { font-size: 26px; }
        .info-grid { grid-template-columns: 1fr; }
        .actions { flex-direction: column; }
        .action-btn { width: 100%; justify-content: center; }
    }
</style>

<main class="main">

    <div class="page-header">
        <h1 class="page-title">Review Claim</h1>
        <a href="{{ route('admin.pending') }}" class="back-link">Back to Pending</a>
    </div>

    <div class="sections">

        <div class="section">
            <h2 class="section-title">Personal Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ $certificate->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $certificate->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Event</span>
                    <span class="info-value">{{ $certificate->event }}</span>
                </div>
            </div>
        </div>

        @if($certificate->message || $certificate->next_event)
        <div class="section">
            <h2 class="section-title">Feedback & Suggestions</h2>
            @if($certificate->message)
            <div class="info-item" style="margin-bottom: 16px;">
                <span class="info-label">Pesan dan Kesan</span>
                <span class="info-value">{{ $certificate->message }}</span>
            </div>
            @endif
            @if($certificate->next_event)
            <div class="info-item">
                <span class="info-label">Event Selanjutnya yang Diinginkan</span>
                <span class="info-value">{{ $certificate->next_event }}</span>
            </div>
            @endif
        </div>
        @endif

        <div class="section">
            <h2 class="section-title">Claim Details</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Submitted</span>
                    <span class="info-value">{{ $certificate->created_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="status-value {{ $certificate->status === 'pending' ? 'pending' : 'other' }}">
                        {{ $certificate->status }}
                    </span>
                </div>
            </div>
            @if($certificate->proof_file)
                <div style="margin-top: 16px;">
                    <span class="info-label">Proof File</span>
                    <a href="{{ asset('storage/' . $certificate->proof_file) }}" target="_blank" class="proof-link">View Proof</a>
                </div>
            @endif
        </div>

        @if($certificate->status === 'pending')
            <div class="actions">
                <form action="{{ route('admin.approve', $certificate->id) }}" method="POST" class="action-form">
                    @csrf
                    <button type="submit" class="action-btn approve">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Approve
                    </button>
                </form>
                <button onclick="document.getElementById('rejectForm').classList.toggle('hidden')" class="action-btn reject">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    Reject
                </button>
            </div>

            <div id="rejectForm" class="reject-form hidden" style="display: none;">
                <h3 class="reject-form-title">Reject Claim</h3>
                <form action="{{ route('admin.reject', $certificate->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rejection_reason" class="form-label">Rejection Reason</label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" class="form-input" required></textarea>
                    </div>
                    <button type="submit" class="action-btn reject">
                        Confirm Rejection
                    </button>
                </form>
            </div>
        @endif

    </div>

</main>

@push('scripts')
<script>
document.getElementById('rejectForm').classList.add('hidden');
</script>
@endpush
@endsection
