@extends('layouts.admin-layout')

@section('title', 'Create Event')

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

    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 40px;
    }

    /* Form */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-mid);
        margin-bottom: 8px;
        display: block;
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
        width: 100%;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(45,80,22,0.1);
    }

    textarea.form-input {
        resize: none;
        min-height: 100px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-group input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-group label {
        font-size: 14px;
        color: var(--ink-mid);
        cursor: pointer;
    }

    /* File Upload */
    .file-upload {
        border: 2px dashed rgba(0,0,0,0.12);
        border-radius: var(--radius-md);
        padding: 24px;
        text-align: center;
        transition: border-color 0.2s, background 0.2s;
    }

    .file-upload:hover {
        border-color: var(--accent);
        background: var(--accent-lt);
    }

    .file-upload input {
        width: 100%;
    }

    .file-upload-desc {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 8px;
    }

    /* Submit Button */
    .submit-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--ink);
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
        background: #2A2821;
    }

    .submit-btn:active {
        transform: scale(0.98);
    }

    /* Error Alert */
    .alert-error {
        background: var(--danger-lt);
        border: 1px solid rgba(140,44,26,0.2);
        border-left: 3px solid var(--danger);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        margin-bottom: 24px;
    }

    .error-list {
        margin: 0;
        padding-left: 20px;
    }

    .error-list li {
        font-size: 13px;
        color: var(--danger);
        margin-bottom: 4px;
    }

    @media (max-width: 640px) {
        .main-content { padding: 32px 20px 60px; }
        .card { padding: 24px; }
        .page-title { font-size: 26px; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Create New Event</h1>
        <a href="{{ route('admin.events.index') }}" class="back-link">Back to Events</a>
    </div>

    <div class="card">

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert-error">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name" class="form-label">Event Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-input">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="date" class="form-label">Event Date</label>
                <input type="date" name="date" id="date" value="{{ old('date') }}" class="form-input">
            </div>

            <div class="form-group">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-input">
            </div>

            <div class="form-group">
                <label for="poster" class="form-label">Event Poster</label>
                <div class="file-upload">
                    <input type="file" name="poster" id="poster" accept="image/png,image/jpg,image/jpeg">
                    <p class="file-upload-desc">Upload PNG/JPG poster image. (Max 5MB)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1" class="form-input">
            </div>

            <div class="form-group">
                <label for="certificate_number_prefix" class="form-label">Certificate Number Prefix (Optional)</label>
                <input type="text" name="certificate_number_prefix" id="certificate_number_prefix" value="{{ old('certificate_number_prefix') }}" class="form-input" placeholder="Leave empty for auto-generated format (e.g., EVT-2026-0001)">
                <p style="font-size: 12px; color: var(--ink-muted); margin-top: 4px;">If set, all certificates for this event will use this fixed prefix. Leave empty to use auto-generated format.</p>
            </div>

            <div class="form-group">
                <label for="claim_deadline" class="form-label">Claim Deadline (Optional)</label>
                <input type="datetime-local" name="claim_deadline" id="claim_deadline" value="{{ old('claim_deadline') }}" class="form-input">
                <p style="font-size: 12px; color: var(--ink-muted); margin-top: 4px;">After this date and time, the claim form for this event will be automatically closed. Leave empty for no deadline.</p>
            </div>

            {{-- Certificate Types --}}
            <div style="margin-top:28px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                    <div>
                        <h3 style="font-family:'Fraunces',serif;font-size:17px;font-weight:300;color:var(--ink);">Certificate Types</h3>
                        <p style="font-size:12px;color:var(--ink-muted);margin-top:3px;">Add participant roles (e.g. Peserta, Panitia, Pembicara). If none added, users claim a single certificate.</p>
                    </div>
                    <button type="button" id="addTypeBtn" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--ink);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Geist',sans-serif;font-size:13px;cursor:pointer;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Add Type
                    </button>
                </div>
                <div id="typesContainer" style="display:flex;flex-direction:column;gap:10px;"></div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_active" id="is_active" checked>
                    <label for="is_active">Active Event (visible to users)</label>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="requires_attendance_proof" id="requires_attendance_proof">
                    <label for="requires_attendance_proof">Require attendance proof photo (users must capture photo with camera when claiming)</label>
                </div>
            </div>

            <div class="form-group">
                <label for="certificate_template" class="form-label">Certificate Template Image</label>
                <div class="file-upload">
                    <input type="file" name="certificate_template" id="certificate_template" accept="image/png,image/jpg,image/jpeg">
                    <p class="file-upload-desc">Upload PNG/JPG template image. Nama peserta, event, dan nomor sertifikat akan ditulis di atasnya. (Max 5MB)</p>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                Create Event
            </button>
        </form>

    </div>

</div>
@push('scripts')
<script>
let typeCount = 0;

function typeRow(i) {
    return `<div class="type-row" id="type-${i}" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:10px;align-items:center;background:var(--surface);border:1px solid rgba(0,0,0,0.07);border-radius:var(--radius-sm);padding:12px 14px;">
        <div>
            <label style="font-size:11px;font-weight:500;color:var(--ink-muted);letter-spacing:.05em;text-transform:uppercase;display:block;margin-bottom:4px;">Type Name *</label>
            <input type="text" name="certificate_types[${i}][name]" placeholder="e.g. Peserta" required
                   style="width:100%;padding:8px 10px;font-family:'Geist',sans-serif;font-size:13px;border:1px solid rgba(0,0,0,0.1);border-radius:6px;background:var(--card);color:var(--ink);box-sizing:border-box;">
        </div>
        <div>
            <label style="font-size:11px;font-weight:500;color:var(--ink-muted);letter-spacing:.05em;text-transform:uppercase;display:block;margin-bottom:4px;">Role Text on Cert</label>
            <input type="text" name="certificate_types[${i}][role_text]" placeholder="e.g. PESERTA"
                   style="width:100%;padding:8px 10px;font-family:'Geist',sans-serif;font-size:13px;border:1px solid rgba(0,0,0,0.1);border-radius:6px;background:var(--card);color:var(--ink);box-sizing:border-box;">
        </div>
        <div>
            <label style="font-size:11px;font-weight:500;color:var(--ink-muted);letter-spacing:.05em;text-transform:uppercase;display:block;margin-bottom:4px;">Number Prefix</label>
            <input type="text" name="certificate_types[${i}][certificate_number_prefix]" placeholder="e.g. PESERTA/2026"
                   style="width:100%;padding:8px 10px;font-family:'Geist',sans-serif;font-size:13px;border:1px solid rgba(0,0,0,0.1);border-radius:6px;background:var(--card);color:var(--ink);box-sizing:border-box;">
        </div>
        <button type="button" onclick="document.getElementById('type-${i}').remove()"
                style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:var(--danger-lt);color:var(--danger);border:none;border-radius:6px;cursor:pointer;flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>`;
}

document.getElementById('addTypeBtn').addEventListener('click', () => {
    document.getElementById('typesContainer').insertAdjacentHTML('beforeend', typeRow(typeCount++));
});
</script>
@endpush
@endsection
