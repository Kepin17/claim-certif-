@extends('layouts.admin-layout')

@section('title', 'Edit Event')

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

    /* Template Info */
    .template-info {
        background: rgba(45,80,22,0.05);
        border: 1px solid rgba(45,80,22,0.15);
        border-radius: var(--radius-md);
        padding: 12px 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .template-info-icon {
        color: var(--accent);
    }

    .template-info-text {
        font-size: 13px;
        color: var(--accent);
        font-weight: 500;
    }

    .template-info-link {
        font-size: 12px;
        color: #2563EB;
        text-decoration: none;
    }

    .template-info-link:hover {
        text-decoration: underline;
    }

    /* Overlay Editor */
    .overlay-editor {
        background: rgba(139,92,246,0.05);
        border: 1px solid rgba(139,92,246,0.15);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
    }

    .overlay-editor-title {
        font-size: 16px;
        font-weight: 500;
        color: #7C3AED;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Preview */
    .preview-container {
        position: relative;
        width: 100%;
        border: 1px solid rgba(0,0,0,0.12);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: rgba(0,0,0,0.04);
        margin-bottom: 20px;
        aspect-ratio: 1.414;
    }

    .preview-container img {
        width: 100%;
        height: 100%;
        object-fit: fill;
    }

    .preview-text {
        position: absolute;
        pointer-events: none;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Overlay Grid */
    .overlay-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .overlay-panel {
        background: var(--card);
        border: 1px solid rgba(139,92,246,0.1);
        border-radius: var(--radius-md);
        padding: 16px;
    }

    .overlay-panel-title {
        font-size: 13px;
        font-weight: 500;
        color: #7C3AED;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .overlay-field {
        margin-bottom: 12px;
    }

    .overlay-field-label {
        font-size: 11px;
        color: var(--ink-muted);
        margin-bottom: 6px;
        display: block;
    }

    .overlay-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .overlay-range {
        flex: 1;
    }

    .overlay-number {
        width: 50px;
        text-align: center;
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
        .overlay-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Edit Event</h1>
        <a href="{{ route('admin.events.index') }}" class="back-link">Back to Events</a>
    </div>

    <div class="card">

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-input">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="date" class="form-label">Event Date</label>
                <input type="date" name="date" id="date" value="{{ old('date', $event->date ? $event->date->format('Y-m-d') : '') }}" class="form-input">
            </div>

            <div class="form-group">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" class="form-input">
            </div>

            <div class="form-group">
                <label for="poster" class="form-label">Event Poster</label>
                @if($event->poster)
                    <div class="template-info">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="template-info-icon">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <div>
                            <p class="template-info-text">Poster sudah ada</p>
                            <a href="{{ asset('storage/' . $event->poster) }}" target="_blank" class="template-info-link">Lihat poster saat ini</a>
                        </div>
                    </div>
                @endif
                <div class="file-upload">
                    <input type="file" name="poster" id="poster" accept="image/png,image/jpg,image/jpeg">
                    <p class="file-upload-desc">Upload PNG/JPG poster image. (Max 5MB)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="1" class="form-input">
            </div>

            <div class="form-group">
                <label for="certificate_number_prefix" class="form-label">Certificate Number Prefix (Optional)</label>
                <input type="text" name="certificate_number_prefix" id="certificate_number_prefix" value="{{ old('certificate_number_prefix', $event->certificate_number_prefix) }}" class="form-input" placeholder="Leave empty for auto-generated format (e.g., EVT-2026-0001)">
                <p style="font-size: 12px; color: var(--ink-muted); margin-top: 4px;">If set, all certificates for this event will use this fixed prefix. Leave empty to use auto-generated format.</p>
            </div>

            <div class="form-group">
                <label for="claim_deadline" class="form-label">Claim Deadline (Optional)</label>
                <input type="datetime-local" name="claim_deadline" id="claim_deadline" value="{{ old('claim_deadline', $event->claim_deadline ? $event->claim_deadline->format('Y-m-d\TH:i') : '') }}" class="form-input">
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
                <div id="typesContainer" style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($event->certificateTypes as $i => $ct)
                    <div class="type-row" id="type-existing-{{ $ct->id }}" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:10px;align-items:center;background:var(--surface);border:1px solid rgba(0,0,0,0.07);border-radius:var(--radius-sm);padding:12px 14px;">
                        <input type="hidden" name="certificate_types[{{ $i }}][id]" value="{{ $ct->id }}">
                        <div>
                            <label style="font-size:11px;font-weight:500;color:var(--ink-muted);letter-spacing:.05em;text-transform:uppercase;display:block;margin-bottom:4px;">Type Name *</label>
                            <input type="text" name="certificate_types[{{ $i }}][name]" value="{{ old('certificate_types.'.$i.'.name', $ct->name) }}" required
                                   style="width:100%;padding:8px 10px;font-family:'Geist',sans-serif;font-size:13px;border:1px solid rgba(0,0,0,0.1);border-radius:6px;background:var(--card);color:var(--ink);box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:500;color:var(--ink-muted);letter-spacing:.05em;text-transform:uppercase;display:block;margin-bottom:4px;">Role Text on Cert</label>
                            <input type="text" name="certificate_types[{{ $i }}][role_text]" value="{{ old('certificate_types.'.$i.'.role_text', $ct->role_text) }}"
                                   style="width:100%;padding:8px 10px;font-family:'Geist',sans-serif;font-size:13px;border:1px solid rgba(0,0,0,0.1);border-radius:6px;background:var(--card);color:var(--ink);box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:500;color:var(--ink-muted);letter-spacing:.05em;text-transform:uppercase;display:block;margin-bottom:4px;">Number Prefix</label>
                            <input type="text" name="certificate_types[{{ $i }}][certificate_number_prefix]" value="{{ old('certificate_types.'.$i.'.certificate_number_prefix', $ct->certificate_number_prefix) }}"
                                   style="width:100%;padding:8px 10px;font-family:'Geist',sans-serif;font-size:13px;border:1px solid rgba(0,0,0,0.1);border-radius:6px;background:var(--card);color:var(--ink);box-sizing:border-box;">
                        </div>
                        <button type="button" onclick="this.closest('.type-row').remove()"
                                style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:var(--danger-lt);color:var(--danger);border:none;border-radius:6px;cursor:pointer;flex-shrink:0;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_active" id="is_active" {{ $event->is_active ? 'checked' : '' }}>
                    <label for="is_active">Active Event (visible to users)</label>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="requires_attendance_proof" id="requires_attendance_proof" {{ $event->requires_attendance_proof ? 'checked' : '' }}>
                    <label for="requires_attendance_proof">Require attendance proof photo (users must capture photo with camera when claiming)</label>
                </div>
            </div>

            <!-- Certificate Template Upload -->
            <div class="form-group">
                <label for="certificate_template" class="form-label">Certificate Template Image</label>
                @if($event->certificate_template)
                    <div class="template-info">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="template-info-icon">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <div>
                            <p class="template-info-text">Template sudah ada</p>
                            <a href="{{ asset('storage/' . $event->certificate_template) }}" target="_blank" class="template-info-link">Lihat template saat ini</a>
                        </div>
                    </div>
                @endif
                <div class="file-upload">
                    <input type="file" name="certificate_template" id="certificate_template" accept="image/png,image/jpg,image/jpeg" onchange="previewTemplate(this)">
                    <p class="file-upload-desc">Upload PNG/JPG. (Max 5MB)</p>
                </div>
            </div>

            <!-- Overlay Position Editor -->
            <div class="overlay-editor">
                <h3 class="overlay-editor-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/>
                    </svg>
                    Posisi Teks pada Sertifikat
                </h3>

                <!-- Live Preview -->
                @if($event->certificate_template)
                <div>
                    <p style="font-size: 13px; font-weight: 500; color: var(--ink-mid); margin-bottom: 8px;">Live Preview</p>
                    <div id="preview-container" class="preview-container">
                        <img id="preview-img" src="{{ asset('storage/' . $event->certificate_template) }}" />
                        <div id="preview-name" class="preview-text">Nama Peserta</div>
                        <div id="preview-role" class="preview-text">Peserta</div>
                    </div>
                </div>
                @else
                <div id="preview-container" class="preview-container hidden" style="display: none;">
                    <img id="preview-img" />
                    <div id="preview-name" class="preview-text">Nama Peserta</div>
                    <div id="preview-role" class="preview-text">Peserta</div>
                </div>
                @endif

                <div class="overlay-grid">
                    <!-- Nama Peserta Settings -->
                    <div class="overlay-panel">
                        <p class="overlay-panel-title">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            Nama Peserta
                        </p>
                        <div class="overlay-field">
                            <label class="overlay-field-label">Posisi Atas (%)</label>
                            <div class="overlay-row">
                                <input type="range" name="overlay_name_top" id="name_top" min="0" max="100" step="0.5" value="{{ $event->overlay_name_top ?? 40 }}" oninput="updatePreview(); document.getElementById('name_top_val').value=this.value" class="overlay-range">
                                <input type="number" id="name_top_val" value="{{ $event->overlay_name_top ?? 40 }}" min="0" max="100" step="0.5" oninput="document.getElementById('name_top').value=this.value; updatePreview()" class="form-input overlay-number">
                            </div>
                        </div>
                        <input type="hidden" name="overlay_name_left" id="name_left" value="{{ $event->overlay_name_left ?? 50 }}">
                        <div class="overlay-field">
                            <label class="overlay-field-label">Ukuran Font (px)</label>
                            <div class="overlay-row">
                                <input type="range" name="overlay_name_size" id="name_size" min="10" max="60" step="1" value="{{ $event->overlay_name_size ?? 26 }}" oninput="updatePreview(); document.getElementById('name_size_val').value=this.value" class="overlay-range">
                                <input type="number" id="name_size_val" value="{{ $event->overlay_name_size ?? 26 }}" min="10" max="60" oninput="document.getElementById('name_size').value=this.value; updatePreview()" class="form-input overlay-number">
                            </div>
                        </div>
                        <div class="overlay-field">
                            <label class="overlay-field-label">Warna Teks</label>
                            <div class="overlay-row">
                                <input type="color" name="overlay_name_color" id="name_color" value="{{ $event->overlay_name_color ?? '#1a2e6e' }}" oninput="updatePreview" style="height: 36px; width: 50px; border-radius: var(--radius-sm); border: 1px solid rgba(0,0,0,0.12); cursor: pointer;">
                                <span id="name_color_hex" style="font-size: 12px; color: var(--ink-muted);">{{ $event->overlay_name_color ?? '#1a2e6e' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Role / Sebagai Settings -->
                    <div class="overlay-panel">
                        <p class="overlay-panel-title">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="16" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            Label "Sebagai"
                        </p>
                        <div class="overlay-field">
                            <label class="overlay-field-label">Teks Label</label>
                            <input type="text" name="overlay_role_text" id="role_text" value="{{ $event->overlay_role_text ?? 'Peserta' }}" oninput="updatePreview()" class="form-input">
                        </div>
                        <div class="overlay-field">
                            <label class="overlay-field-label">Posisi Atas (%)</label>
                            <div class="overlay-row">
                                <input type="range" name="overlay_role_top" id="role_top" min="0" max="100" step="0.5" value="{{ $event->overlay_role_top ?? 52 }}" oninput="updatePreview(); document.getElementById('role_top_val').value=this.value" class="overlay-range">
                                <input type="number" id="role_top_val" value="{{ $event->overlay_role_top ?? 52 }}" min="0" max="100" step="0.5" oninput="document.getElementById('role_top').value=this.value; updatePreview()" class="form-input overlay-number">
                            </div>
                        </div>
                        <input type="hidden" name="overlay_role_left" id="role_left" value="{{ $event->overlay_role_left ?? 50 }}">
                        <div class="overlay-field">
                            <label class="overlay-field-label">Ukuran Font (px)</label>
                            <div class="overlay-row">
                                <input type="range" name="overlay_role_size" id="role_size" min="10" max="60" step="1" value="{{ $event->overlay_role_size ?? 20 }}" oninput="updatePreview(); document.getElementById('role_size_val').value=this.value" class="overlay-range">
                                <input type="number" id="role_size_val" value="{{ $event->overlay_role_size ?? 20 }}" min="10" max="60" oninput="document.getElementById('role_size').value=this.value; updatePreview()" class="form-input overlay-number">
                            </div>
                        </div>
                        <div class="overlay-field">
                            <label class="overlay-field-label">Warna Teks</label>
                            <div class="overlay-row">
                                <input type="color" name="overlay_role_color" id="role_color" value="{{ $event->overlay_role_color ?? '#1a2e6e' }}" oninput="updatePreview" style="height: 36px; width: 50px; border-radius: var(--radius-sm); border: 1px solid rgba(0,0,0,0.12); cursor: pointer;">
                                <span id="role_color_hex" style="font-size: 12px; color: var(--ink-muted);">{{ $event->overlay_role_color ?? '#1a2e6e' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                Update Event
            </button>
        </form>

    </div>

</div>

@push('scripts')
<script>
function updatePreview() {
    const container = document.getElementById('preview-container');
    if (!container) return;

    const nameEl = document.getElementById('preview-name');
    const roleEl = document.getElementById('preview-role');

    const nameTop   = document.getElementById('name_top').value;
    const nameLeft  = document.getElementById('name_left').value;
    const nameSize  = document.getElementById('name_size').value;
    const nameColor = document.getElementById('name_color').value;
    const roleTop   = document.getElementById('role_top').value;
    const roleLeft  = document.getElementById('role_left').value;
    const roleSize  = document.getElementById('role_size').value;
    const roleColor = document.getElementById('role_color').value;
    const roleText  = document.getElementById('role_text').value || 'Peserta';

    const scale = container.offsetWidth / 1122;

    nameEl.style.top       = nameTop + '%';
    nameEl.style.left      = '0';
    nameEl.style.width     = '100%';
    nameEl.style.textAlign = 'center';
    nameEl.style.transform = 'none';
    nameEl.style.fontSize  = (parseFloat(nameSize) * scale) + 'px';
    nameEl.style.color     = nameColor;

    roleEl.style.top       = roleTop + '%';
    roleEl.style.left      = '0';
    roleEl.style.width     = '100%';
    roleEl.style.textAlign = 'center';
    roleEl.style.transform = 'none';
    roleEl.style.fontSize  = (parseFloat(roleSize) * scale) + 'px';
    roleEl.style.color     = roleColor;
    roleEl.textContent     = roleText;

    document.getElementById('name_color_hex').textContent = nameColor;
    document.getElementById('role_color_hex').textContent = roleColor;
}

function previewTemplate(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('preview-img');
            const container = document.getElementById('preview-container');
            img.src = e.target.result;
            container.style.display = 'block';
            container.classList.remove('hidden');
            updatePreview();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

window.addEventListener('load', function() {
    updatePreview();
    window.addEventListener('resize', updatePreview);
});

let typeCount = {{ $event->certificateTypes->count() }};

function typeRow(i) {
    return `<div class="type-row" id="type-new-${i}" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:10px;align-items:center;background:var(--surface);border:1px solid rgba(0,0,0,0.07);border-radius:var(--radius-sm);padding:12px 14px;">
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
        <button type="button" onclick="document.getElementById('type-new-${i}').remove()"
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
