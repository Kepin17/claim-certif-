@extends('layouts.admin-layout')

@section('title', 'Event Details – ' . $event->name)

@section('content')
<style>
    .main-content {
        max-width: 1100px;
        margin: 0 auto;
        padding: 48px 40px 100px;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 36px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title {
        font-family: 'Fraunces', serif;
        font-size: 30px;
        font-weight: 300;
        color: var(--ink);
        letter-spacing: -0.01em;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .back-link {
        font-size: 13px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .back-link:hover { text-decoration: underline; }

    /* ─── Alert Banner ─── */
    .alert {
        padding: 14px 18px;
        border-radius: var(--radius-md);
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .alert-success { background: var(--accent-lt); color: var(--accent); border: 1px solid rgba(45,80,22,0.15); }
    .alert-error   { background: var(--danger-lt); color: var(--danger); border: 1px solid rgba(140,44,26,0.15); }

    /* ─── Card ─── */
    .card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 36px 40px;
        margin-bottom: 24px;
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 300;
        color: var(--ink);
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(0,0,0,0.07);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ─── Details Grid ─── */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 24px;
    }

    .detail-item { display: flex; flex-direction: column; }
    .detail-label {
        font-size: 11px;
        color: var(--ink-muted);
        margin-bottom: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: var(--ink);
    }

    /* ─── Status Badge ─── */
    .status-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
    }
    .status-active   { background: var(--accent-lt); color: var(--accent); border: 1px solid rgba(45,80,22,0.15); }
    .status-inactive { background: var(--danger-lt); color: var(--danger); border: 1px solid rgba(140,44,26,0.15); }

    /* ─── Action buttons ─── */
    .actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 28px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--ink);
        color: #FFFFFF;
        font-family: 'Geist', sans-serif;
        font-size: 13px;
        font-weight: 500;
        padding: 9px 18px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.01em;
        border: none;
        cursor: pointer;
    }
    .action-btn:hover   { background: #2A2821; }
    .action-btn:active  { transform: scale(0.97); }
    .action-btn.warning { background: #D97706; }
    .action-btn.warning:hover { background: #B45309; }
    .action-btn.danger  { background: var(--danger); }
    .action-btn.danger:hover  { background: #6B1F10; }

    /* ─── Form Elements ─── */
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 8px;
        letter-spacing: 0.01em;
    }
    .form-label .badge-optional {
        font-size: 10px;
        font-weight: 500;
        background: rgba(0,0,0,0.06);
        color: var(--ink-muted);
        padding: 2px 8px;
        border-radius: 100px;
        margin-left: 6px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .form-hint {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 6px;
        line-height: 1.5;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        background: var(--surface);
        border: 1px solid rgba(0,0,0,0.13);
        border-radius: var(--radius-sm);
        font-family: 'Geist', sans-serif;
        font-size: 14px;
        color: var(--ink);
        padding: 10px 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(45,80,22,0.1);
    }
    .form-textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    /* ─── Award Type Pills ─── */
    .award-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 0;
    }
    .award-pill input[type="radio"] { display: none; }
    .award-pill label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 100px;
        border: 1.5px solid rgba(0,0,0,0.12);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
        user-select: none;
        background: var(--surface);
        color: var(--ink-mid);
    }
    .award-pill input[type="radio"]:checked + label {
        border-color: var(--accent);
        background: var(--accent-lt);
        color: var(--accent);
        font-weight: 600;
    }
    .award-pill label:hover { border-color: var(--accent); }

    /* ─── Custom Message Textarea special styling ─── */
    .message-box-wrapper {
        position: relative;
    }
    .message-preview-badge {
        position: absolute;
        top: -10px;
        right: 14px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: #FFFBEB;
        color: #92400E;
        border: 1px solid #FCD34D;
        padding: 2px 10px;
        border-radius: 100px;
    }
    .message-textarea {
        background: #FFFDF5;
        border-color: #FCD34D;
    }
    .message-textarea:focus {
        border-color: #F59E0B;
        box-shadow: 0 0 0 3px rgba(245,158,11,0.12);
    }

    /* ─── File Upload ─── */
    .file-drop {
        border: 2px dashed rgba(0,0,0,0.15);
        border-radius: var(--radius-md);
        padding: 28px 24px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        position: relative;
    }
    .file-drop:hover, .file-drop.drag-over {
        border-color: var(--accent);
        background: var(--accent-lt);
    }
    .file-drop input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .file-drop-icon { font-size: 28px; margin-bottom: 8px; }
    .file-drop-text { font-size: 14px; font-weight: 500; color: var(--ink-mid); }
    .file-drop-sub  { font-size: 12px; color: var(--ink-muted); margin-top: 4px; }
    .file-name-display {
        font-size: 13px;
        font-weight: 600;
        color: var(--accent);
        margin-top: 8px;
        display: none;
    }

    /* ─── Participants input rows ─── */
    .participant-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
    .remove-row-btn {
        background: var(--danger-lt);
        color: var(--danger);
        border: none;
        border-radius: 8px;
        width: 34px; height: 34px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.15s;
        flex-shrink: 0;
    }
    .remove-row-btn:hover { background: rgba(140,44,26,0.18); }

    .add-row-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: none;
        border: 1.5px dashed rgba(0,0,0,0.2);
        color: var(--ink-mid);
        font-size: 13px;
        font-weight: 500;
        padding: 9px 16px;
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
        width: 100%;
        justify-content: center;
    }
    .add-row-btn:hover { border-color: var(--accent); color: var(--accent); }

    /* ─── Tabs ─── */
    .tab-bar {
        display: flex;
        gap: 4px;
        background: rgba(0,0,0,0.04);
        border-radius: var(--radius-sm);
        padding: 4px;
        margin-bottom: 28px;
    }
    .tab-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 500;
        padding: 9px 14px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
        background: transparent;
        color: var(--ink-muted);
    }
    .tab-btn.active {
        background: var(--card);
        color: var(--ink);
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ─── Info Note ─── */
    .info-note {
        background: var(--accent-lt);
        border: 1px solid rgba(45,80,22,0.18);
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 13px;
        color: var(--accent);
        line-height: 1.6;
        margin-bottom: 22px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    /* ─── Claims list ─── */
    .claim-item {
        background: rgba(0,0,0,0.02);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .claim-name  { font-size: 14px; font-weight: 500; color: var(--ink); }
    .claim-email { font-size: 12px; color: var(--ink-muted); margin-top: 2px; }
    .claim-status {
        font-size: 11px; font-weight: 600; letter-spacing: 0.05em;
        text-transform: uppercase; padding: 4px 10px; border-radius: 100px;
        white-space: nowrap;
    }
    .claim-status.approved, .claim-status.generated, .claim-status.sent {
        background: var(--accent-lt); color: var(--accent);
    }
    .claim-status.rejected { background: var(--danger-lt); color: var(--danger); }
    .claim-status.pending  { background: rgba(234,179,8,0.1); color: #854D0E; }

    @media (max-width: 640px) {
        .main-content { padding: 28px 18px 70px; }
        .card { padding: 24px 20px; }
        .participant-row { grid-template-columns: 1fr; }
        .award-pills { flex-direction: column; }
        .tab-btn { font-size: 12px; padding: 8px 10px; }
    }
</style>

<div class="main-content">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <a href="{{ route('admin.events.index') }}" class="back-link" style="margin-bottom:10px;display:inline-flex;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Events
            </a>
            <h1 class="page-title">{{ $event->name }}</h1>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a href="{{ route('admin.events.edit', $event) }}" class="action-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Event
            </a>
            <form action="{{ route('admin.events.toggle', $event) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="action-btn warning">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                    {{ $event->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
        <ul style="margin:0;padding-left:16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ── Event Info ── --}}
    <div class="card">
        <div class="card-title">
            <span class="card-icon" style="background:rgba(45,80,22,0.1);color:var(--accent);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </span>
            Informasi Event
        </div>
        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">Nama Event</span>
                <span class="detail-value">{{ $event->name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="status-badge {{ $event->is_active ? 'status-active' : 'status-inactive' }}">
                    {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tanggal</span>
                <span class="detail-value">{{ $event->date ? $event->date->format('d F Y') : 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Lokasi</span>
                <span class="detail-value">{{ $event->location ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Maks Peserta</span>
                <span class="detail-value">{{ $event->max_participants ?? 'Tidak Terbatas' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Klaim</span>
                <span class="detail-value">{{ $event->certificates->count() }}</span>
            </div>
        </div>
        @if($event->description)
        <p style="margin:24px 0 0;font-size:14px;color:var(--ink-mid);line-height:1.65;padding-top:20px;border-top:1px solid rgba(0,0,0,0.07);">
            {{ $event->description }}
        </p>
        @endif
    </div>

    {{-- ── Kirim Sertifikat ── --}}
    <div class="card">
        <div class="card-title">
            <span class="card-icon" style="background:rgba(52,120,246,0.1);color:#3478F6;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
            </span>
            Kirim Sertifikat
        </div>

        {{-- Tabs --}}
        <div class="tab-bar" role="tablist">
            <button class="tab-btn active" id="tab-import" onclick="switchTab('import')" type="button" role="tab">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Import Excel / CSV
            </button>
            <button class="tab-btn" id="tab-manual" onclick="switchTab('manual')" type="button" role="tab">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Input Manual
            </button>
        </div>

        {{-- ── TAB 1: Import Excel ── --}}
        <div class="tab-panel active" id="panel-import">

            <div class="info-note">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span>Upload file CSV dengan kolom <strong>email</strong> dan <strong>nama lengkap</strong>. 
                    <a href="{{ route('admin.download-template') }}" style="color:var(--accent);font-weight:600;">Download template ↗</a>
                </span>
            </div>

            <form action="{{ route('admin.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">

                {{-- Award / Role Category --}}
                <div class="form-group">
                    <label class="form-label">
                        Kategori Penghargaan
                        <span class="badge-optional">Optional</span>
                    </label>
                    <div class="award-pills" id="import-award-pills">
                        <div class="award-pill">
                            <input type="radio" id="import-role-peserta" name="role" value="Peserta" checked>
                            <label for="import-role-peserta">🎓 Peserta</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="import-role-juara1" name="role" value="Juara 1">
                            <label for="import-role-juara1">🥇 Juara 1</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="import-role-juara2" name="role" value="Juara 2">
                            <label for="import-role-juara2">🥈 Juara 2</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="import-role-juara3" name="role" value="Juara 3">
                            <label for="import-role-juara3">🥉 Juara 3</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="import-role-custom" name="role" value="manual" onchange="toggleImportRoleManual(this)">
                            <label for="import-role-custom">✏️ Lainnya…</label>
                        </div>
                    </div>
                    <div id="import-role-manual-wrap" style="display:none;margin-top:12px;">
                        <input type="text" name="role_manual" class="form-input" placeholder="Contoh: Panitia, Juri, Pembicara…" style="max-width:320px;">
                    </div>
                    <p class="form-hint">Kategori ini menentukan tampilan dan judul email yang diterima peserta.</p>
                </div>

                {{-- Custom Message --}}
                <div class="form-group">
                    <label class="form-label" for="import-custom-msg">
                        Pesan Khusus ke Email
                        <span class="badge-optional">Optional</span>
                    </label>
                    <div class="message-box-wrapper">
                        <span class="message-preview-badge">✉️ Ditampilkan di email</span>
                        <textarea id="import-custom-msg" name="custom_email_message"
                                  class="form-textarea message-textarea"
                                  placeholder="Contoh: Selamat atas pencapaian luar biasa Anda! Kami sangat bangga dengan dedikasi dan kerja keras yang Anda tunjukkan selama lomba. Semoga prestasi ini menjadi awal dari banyak pencapaian besar berikutnya. Sampai jumpa di event selanjutnya! 🎉"
                                  rows="4" maxlength="2000">{{ old('custom_email_message') }}</textarea>
                    </div>
                    <p class="form-hint">Pesan ini akan muncul sebagai kotak "Pesan dari Panitia" di dalam email sertifikat. Kosongkan jika tidak ada pesan tambahan.</p>
                </div>

                {{-- File Upload --}}
                <div class="form-group">
                    <label class="form-label" for="import-file">File CSV / Excel</label>
                    <div class="file-drop" id="file-drop-zone">
                        <input type="file" id="import-file" name="file" accept=".csv,.xlsx,.xls"
                               onchange="handleFileSelect(this)" required>
                        <div class="file-drop-icon">📂</div>
                        <div class="file-drop-text">Klik untuk memilih file atau seret ke sini</div>
                        <div class="file-drop-sub">Mendukung .csv, .xlsx, .xls (maks. 10 MB)</div>
                        <div class="file-name-display" id="file-name-display"></div>
                    </div>
                </div>

                <button type="submit" class="action-btn" style="background:var(--accent);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import & Kirim Sertifikat
                </button>
            </form>
        </div>

        {{-- ── TAB 2: Manual Input ── --}}
        <div class="tab-panel" id="panel-manual">

            <form action="{{ route('admin.manual-send') }}" method="POST" id="manual-send-form">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">

                {{-- Award / Role Category --}}
                <div class="form-group">
                    <label class="form-label">
                        Kategori Penghargaan
                        <span class="badge-optional">Optional</span>
                    </label>
                    <div class="award-pills" id="manual-award-pills">
                        <div class="award-pill">
                            <input type="radio" id="manual-role-peserta" name="role" value="Peserta" checked>
                            <label for="manual-role-peserta">🎓 Peserta</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="manual-role-juara1" name="role" value="Juara 1">
                            <label for="manual-role-juara1">🥇 Juara 1</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="manual-role-juara2" name="role" value="Juara 2">
                            <label for="manual-role-juara2">🥈 Juara 2</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="manual-role-juara3" name="role" value="Juara 3">
                            <label for="manual-role-juara3">🥉 Juara 3</label>
                        </div>
                        <div class="award-pill">
                            <input type="radio" id="manual-role-custom" name="role" value="manual" onchange="toggleManualRoleManual(this)">
                            <label for="manual-role-custom">✏️ Lainnya…</label>
                        </div>
                    </div>
                    <div id="manual-role-manual-wrap" style="display:none;margin-top:12px;">
                        <input type="text" name="role_manual" class="form-input" placeholder="Contoh: Panitia, Juri, Pembicara…" style="max-width:320px;">
                    </div>
                    <p class="form-hint">Kategori ini menentukan tampilan dan judul email yang diterima peserta.</p>
                </div>

                {{-- Custom Message --}}
                <div class="form-group">
                    <label class="form-label" for="manual-custom-msg">
                        Pesan Khusus ke Email
                        <span class="badge-optional">Optional</span>
                    </label>
                    <div class="message-box-wrapper">
                        <span class="message-preview-badge">✉️ Ditampilkan di email</span>
                        <textarea id="manual-custom-msg" name="custom_email_message"
                                  class="form-textarea message-textarea"
                                  placeholder="Contoh: Selamat atas pencapaian luar biasa Anda! Kami sangat bangga…"
                                  rows="4" maxlength="2000">{{ old('custom_email_message') }}</textarea>
                    </div>
                    <p class="form-hint">Pesan ini akan muncul sebagai kotak "Pesan dari Panitia" di email. Kosongkan jika tidak ada pesan tambahan.</p>
                </div>

                {{-- Participants --}}
                <div class="form-group">
                    <label class="form-label">Daftar Peserta</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;padding:0 2px;">
                        <span style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-muted);">Nama Lengkap</span>
                        <span style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-muted);">Alamat Email</span>
                        <span style="width:34px;"></span>
                    </div>
                    <div id="participants-container">
                        <div class="participant-row">
                            <input type="text" name="participants[0][name]" class="form-input" placeholder="Budi Santoso" required>
                            <input type="email" name="participants[0][email]" class="form-input" placeholder="budi@example.com" required>
                            <button type="button" class="remove-row-btn" onclick="removeRow(this)" title="Hapus baris">×</button>
                        </div>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addParticipantRow()" style="margin-top:10px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Peserta
                    </button>
                </div>

                <button type="submit" class="action-btn" style="background:var(--accent);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
                    Kirim Sertifikat
                </button>
            </form>
        </div>
    </div>

    {{-- ── Klaim Terbaru ── --}}
    <div class="card">
        <div class="card-title">
            <span class="card-icon" style="background:rgba(234,179,8,0.12);color:#92400E;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </span>
            Klaim Terbaru
        </div>
        @if($event->certificates->count() === 0)
            <p style="font-size:14px;color:var(--ink-muted);text-align:center;padding:24px 0;">
                Belum ada klaim untuk event ini.
            </p>
        @else
            @foreach($event->certificates->sortByDesc('created_at')->take(8) as $certificate)
            <div class="claim-item">
                <div style="flex:1;min-width:0;">
                    <p class="claim-name">{{ $certificate->name }}</p>
                    <p class="claim-email">{{ $certificate->email }}
                        @if($certificate->certificate_type_name)
                            · <span style="color:var(--ink-muted);">{{ $certificate->certificate_type_name }}</span>
                        @endif
                    </p>
                </div>
                <span class="claim-status {{ $certificate->status }}">{{ strtoupper($certificate->status) }}</span>
                <a href="{{ route('admin.show', $certificate->id) }}"
                   style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:500;white-space:nowrap;margin-left:12px;">
                   Lihat →
                </a>
            </div>
            @endforeach
            @if($event->certificates->count() > 8)
            <a href="{{ route('admin.pending') }}" style="font-size:13px;color:var(--accent);text-decoration:none;font-weight:500;display:inline-block;margin-top:8px;">
                Lihat semua {{ $event->certificates->count() }} klaim →
            </a>
            @endif
        @endif
    </div>

</div>

@push('scripts')
<script>
/* ── Tab Switching ── */
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('panel-' + tab).classList.add('active');
}

/* ── Role Manual Toggle ── */
function toggleImportRoleManual(el) {
    document.getElementById('import-role-manual-wrap').style.display = el.checked ? 'block' : 'none';
}
function toggleManualRoleManual(el) {
    document.getElementById('manual-role-manual-wrap').style.display = el.checked ? 'block' : 'none';
}

/* ── File Drop ── */
function handleFileSelect(input) {
    const display = document.getElementById('file-name-display');
    if (input.files.length > 0) {
        display.textContent = '📄 ' + input.files[0].name;
        display.style.display = 'block';
    }
}
const dropZone = document.getElementById('file-drop-zone');
if (dropZone) {
    dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
    dropZone.addEventListener('dragleave', ()=> dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const fileInput = document.getElementById('import-file');
        fileInput.files = e.dataTransfer.files;
        handleFileSelect(fileInput);
    });
}

/* ── Participants Rows ── */
let rowCount = 1;
function addParticipantRow() {
    const container = document.getElementById('participants-container');
    const div = document.createElement('div');
    div.className = 'participant-row';
    div.innerHTML = `
        <input type="text"  name="participants[${rowCount}][name]"  class="form-input" placeholder="Nama Lengkap" required>
        <input type="email" name="participants[${rowCount}][email]" class="form-input" placeholder="email@example.com" required>
        <button type="button" class="remove-row-btn" onclick="removeRow(this)" title="Hapus">×</button>
    `;
    container.appendChild(div);
    rowCount++;
}
function removeRow(btn) {
    const container = document.getElementById('participants-container');
    if (container.children.length <= 1) return;
    btn.closest('.participant-row').remove();
}
</script>
@endpush

@endsection
