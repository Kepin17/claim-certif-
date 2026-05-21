@extends('layouts.user-layout')

@section('title', 'Claim Your Certificate')

@section('content')
<style>
    /* Hero */
    .hero {
        background: var(--ink);
        padding: 72px 40px 60px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(74,128,34,0.18) 0%, transparent 55%),
            radial-gradient(circle at 80% 20%, rgba(74,128,34,0.10) 0%, transparent 45%);
    }

    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 100px;
        padding: 5px 14px 5px 10px;
        margin-bottom: 28px;
    }

    .hero-eyebrow-dot {
        width: 6px; height: 6px;
        background: #6FCF97;
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.8); }
    }

    .hero-eyebrow-text {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.6);
    }

    .hero-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(36px, 6vw, 52px);
        font-weight: 300;
        color: #FFFFFF;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin-bottom: 16px;
        text-align: center;
    }

    .hero-title em {
        font-style: italic;
        color: #A8D88A;
        letter-spacing: -0.01em;
    }

    .hero-desc {
        font-size: 15px;
        color: rgba(255,255,255,0.5);
        line-height: 1.7;
        max-width: 520px;
        margin: 0 auto;
    }

    /* Main */
    .main {
        max-width: 700px;
        margin: 0 auto;
        padding: 48px 40px 80px;
    }

    /* Card */
    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 40px;
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 24px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.01em;
        margin-bottom: 32px;
        text-align: center;
    }

    /* Alerts */
    .alert {
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: var(--accent-lt);
        border: 1px solid rgba(45,80,22,0.2);
        border-left: 3px solid var(--accent);
    }

    .alert-error {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.2);
        border-left: 3px solid var(--danger);
    }

    .alert-icon {
        flex-shrink: 0;
        width: 20px; height: 20px;
    }

    .alert-success .alert-icon { color: var(--accent); }
    .alert-error .alert-icon { color: var(--danger); }

    .alert-text {
        font-size: 14px;
    }

    .alert-success .alert-text { color: var(--accent); }
    .alert-error .alert-text { color: var(--danger); }

    .alert-list {
        margin-top: 8px;
        padding-left: 20px;
    }

    .alert-list li {
        font-size: 13px;
        color: var(--danger);
        margin-bottom: 4px;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .section-icon {
        width: 32px; height: 32px;
        background: var(--accent-lt);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-icon svg { color: var(--accent); }

    .section-title {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink);
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    /* Form Field */
    .form-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-mid);
    }

    .form-label .required {
        color: var(--danger);
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
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(45,80,22,0.1);
    }

    .form-input::placeholder {
        color: var(--ink-faint);
    }

    textarea.form-input {
        resize: none;
        min-height: 100px;
    }

    /* Event Badge */
    .event-badge {
        background: var(--accent-lt);
        border: 1px solid rgba(45,80,22,0.15);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }

    .event-badge-icon {
        width: 40px; height: 40px;
        background: var(--accent);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .event-badge-icon svg { color: #FFFFFF; }

    .event-badge-content h3 {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .event-badge-content p {
        font-size: 13px;
        color: var(--ink-muted);
    }

    /* File Upload */
    .file-upload {
        border: 2px dashed rgba(0,0,0,0.12);
        border-radius: var(--radius-md);
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .file-upload:hover {
        border-color: var(--accent);
        background: var(--accent-lt);
    }

    .file-upload.dragover {
        border-color: var(--accent);
        background: var(--accent-lt);
    }

    .file-upload-icon {
        width: 48px; height: 48px;
        background: rgba(0,0,0,0.04);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .file-upload-icon svg { color: var(--ink-muted); }

    .file-upload-title {
        font-size: 14px;
        color: var(--ink-mid);
        margin-bottom: 4px;
    }

    .file-upload-desc {
        font-size: 12px;
        color: var(--ink-muted);
    }

    .file-upload input { display: none; }

    /* Submit Button */
    .submit-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--accent);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 15px;
        font-weight: 500;
        padding: 14px 24px;
        border-radius: var(--radius-sm);
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
        margin-top: 32px;
    }

    .submit-btn:hover {
        background: var(--accent-mid);
    }

    .submit-btn:active {
        transform: scale(0.98);
    }

    .submit-btn svg { flex-shrink: 0; }

    /* Track Link */
    .track-link {
        text-align: center;
        padding-top: 24px;
        border-top: 1px solid rgba(0,0,0,0.06);
        margin-top: 32px;
    }

    .track-link p {
        font-size: 13px;
        color: var(--ink-muted);
        margin-bottom: 8px;
    }

    .track-link a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .track-link a:hover {
        text-decoration: underline;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 32px;
    }

    .info-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 24px;
        text-align: center;
    }

    .info-icon {
        width: 40px; height: 40px;
        background: var(--accent-lt);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }

    .info-icon svg { color: var(--accent); }

    .info-title {
        font-size: 15px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 6px;
    }

    .info-desc {
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.5;
    }

    @media (max-width: 640px) {
        .hero { padding: 48px 20px 40px; }
        .main { padding: 32px 20px 60px; }
        .card { padding: 24px; }
        .form-grid { grid-template-columns: 1fr; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- Hero -->
<div class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-dot"></span>
            <span class="hero-eyebrow-text">Certificate Claim</span>
        </div>
        <h1 class="hero-title">Claim your<br><em>certificate</em></h1>
        <p class="hero-desc">Submit your participation details to receive your official certificate</p>
    </div>
</div>

<!-- Main Content -->
<main class="main">

    <div class="card">

        <h2 class="card-title">Submit Your Claim</h2>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="alert-text">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-error">
                <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span class="alert-text">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-error">
                <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <div>
                    <span class="alert-text">Please fix the following errors:</span>
                    <ul class="alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('certificate.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Personal Information Section -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <span class="section-title">Personal Information</span>
                </div>

                <div class="form-grid">
                    <div class="form-field">
                        <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-field">
                        <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" placeholder="your@email.com" required>
                    </div>
                </div>
            </div>

            <!-- Event Information Section -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span class="section-title">Event Information</span>
                </div>

                @if(isset($event))
                    <div class="event-badge">
                        <div class="event-badge-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                            </svg>
                        </div>
                        <div class="event-badge-content">
                            <h3>{{ $event->name }}</h3>
                            @if($event->date)
                                <p>{{ $event->date->format('d F Y') }}</p>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                @endif
            </div>

            <!-- Feedback Section -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <span class="section-title">Feedback & Suggestions</span>
                </div>

                <div class="form-field" style="margin-bottom: 20px;">
                    <label for="message" class="form-label">Pesan dan Kesan</label>
                    <textarea name="message" id="message" rows="4" class="form-input" placeholder="Bagikan pengalaman dan kesan Anda selama mengikuti event ini...">{{ old('message') }}</textarea>
                </div>

                <div class="form-field">
                    <label for="next_event" class="form-label">Event Selanjutnya yang Anda Inginkan</label>
                    <input type="text" name="next_event" id="next_event" value="{{ old('next_event') }}" class="form-input" placeholder="Event apa yang ingin Anda ikuti selanjutnya?">
                </div>
            </div>

            <!-- Proof Upload Section -->
            <!-- <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                        </svg>
                    </div>
                    <span class="section-title">Supporting Documents</span>
                </div>

                <div class="file-upload" id="drop-zone">
                    <input type="file" name="proof_file" id="proof_file" accept=".pdf,.jpg,.jpeg,.png">
                    <label for="proof_file" style="cursor: pointer;">
                        <div class="file-upload-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <p class="file-upload-title">Drag and drop your proof file here, or click to browse</p>
                        <p class="file-upload-desc">Accepted formats: PDF, JPG, PNG (Max 5MB)</p>
                    </label>
                </div> -->
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
                Submit Certificate Claim
            </button>

            <!-- Track Status Link -->
            <div class="track-link">
                <p>Already submitted a claim?</p>
                <a href="{{ route('certificate.track') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Track your claim status
                </a>
            </div>

        </form>

    </div>

    <!-- Info Cards -->
    <div class="info-grid">
        <div class="info-card">
            <div class="info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <h3 class="info-title">Fast Processing</h3>
            <p class="info-desc">Your claim will be reviewed within 24-48 hours</p>
        </div>
        <div class="info-card">
            <div class="info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <h3 class="info-title">Secure & Verified</h3>
            <p class="info-desc">All certificates are verified with QR codes</p>
        </div>
        <div class="info-card">
            <div class="info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
            </div>
            <h3 class="info-title">Easy Download</h3>
            <p class="info-desc">Download your certificate instantly after approval</p>
        </div>
    </div>

</main>

@push('scripts')
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('proof_file');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length) {
            fileInput.files = files;
            updateFileName(files[0].name);
        }
    });

    fileInput.addEventListener('change', (e) => {
        if (fileInput.files.length) {
            updateFileName(fileInput.files[0].name);
        }
    });

    function updateFileName(name) {
        const label = dropZone.querySelector('.file-upload-title');
        label.textContent = `Selected: ${name}`;
        label.style.color = 'var(--accent)';
        label.style.fontWeight = '500';
    }
</script>
@endpush
@endsection
