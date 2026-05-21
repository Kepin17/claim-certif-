@extends('layouts.admin-layout')

@section('title', 'Preview Certificate')

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

    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 40px;
    }

    /* Certificate Preview */
    .cert-preview {
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: var(--radius-lg);
        padding: 48px;
        margin-bottom: 24px;
        text-align: center;
        background: #FFFFFF;
    }

    .cert-title {
        font-family: 'Fraunces', serif;
        font-size: 32px;
        font-weight: 300;
        color: #1e3a8a;
        margin-bottom: 16px;
        letter-spacing: 0.05em;
    }

    .cert-subtitle {
        font-size: 16px;
        color: var(--ink-muted);
        margin-bottom: 32px;
    }

    .cert-name {
        font-family: 'Fraunces', serif;
        font-size: 48px;
        font-weight: 400;
        color: var(--ink);
        margin-bottom: 24px;
        letter-spacing: -0.02em;
    }

    .cert-completed {
        font-size: 20px;
        color: var(--ink-mid);
        margin-bottom: 8px;
    }

    .cert-event {
        font-family: 'Fraunces', serif;
        font-size: 28px;
        font-weight: 300;
        font-style: italic;
        color: var(--ink);
        margin-bottom: 32px;
    }

    .cert-number {
        font-size: 14px;
        color: var(--ink-muted);
    }

    /* Note */
    .note-box {
        background: rgba(234,179,8,0.1);
        border: 1px solid rgba(234,179,8,0.2);
        border-radius: var(--radius-md);
        padding: 16px 20px;
    }

    .note-box p {
        font-size: 13px;
        color: #854D0E;
        margin: 0;
    }

    .note-box strong {
        font-weight: 500;
    }

    @media (max-width: 640px) {
        .main { padding: 32px 20px 60px; }
        .card { padding: 24px; }
        .page-title { font-size: 26px; }
        .cert-preview { padding: 32px 20px; }
        .cert-title { font-size: 24px; }
        .cert-name { font-size: 32px; }
        .cert-event { font-size: 20px; }
    }
</style>

<main class="main">

    <div class="page-header">
        <h1 class="page-title">Certificate Preview</h1>
        <a href="{{ route('admin.show', $certificate->id) }}" class="back-link">Back to Review</a>
    </div>

    <div class="card">

        <div class="cert-preview">
            <h1 class="cert-title">CERTIFICATE OF COMPLETION</h1>
            <p class="cert-subtitle">This certificate is proudly presented to</p>

            <h2 class="cert-name">{{ $certificate->name }}</h2>

            <p class="cert-completed">has successfully completed</p>
            <p class="cert-event">{{ $certificate->event }}</p>

            <p class="cert-number">Participant Number: {{ $certificate->participant_number }}</p>

            @if($certificate->certificate_number)
                <p class="cert-number" style="margin-top: 16px;">Certificate Number: {{ $certificate->certificate_number }}</p>
            @endif
        </div>

        <div class="note-box">
            <p><strong>Note:</strong> This is a preview. The actual certificate will be generated as a PDF with proper formatting and styling.</p>
        </div>

    </div>

</main>
@endsection
