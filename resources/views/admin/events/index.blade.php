@extends('layouts.admin-layout')

@section('title', 'Manage Events')

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

    /* Alert */
    .alert-success {
        background: var(--accent-lt);
        border: 1px solid rgba(45,80,22,0.2);
        border-left: 3px solid var(--accent);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success p { font-size: 14px; color: var(--accent); }

    /* Create Button */
    .create-btn {
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
        margin-bottom: 24px;
    }

    .create-btn:hover {
        background: #2A2821;
    }

    .create-btn:active {
        transform: scale(0.98);
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

    .event-name {
        font-weight: 500;
        color: var(--ink);
    }

    .event-desc {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 4px;
    }

    /* Event Poster */
    .event-poster {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(0,0,0,0.12);
    }

    .event-poster-placeholder {
        width: 80px;
        height: 60px;
        background: rgba(0,0,0,0.04);
        border-radius: var(--radius-sm);
        border: 1px solid rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: var(--ink-muted);
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
    }

    .status-active {
        background: var(--accent-lt);
        color: var(--accent);
        border: 1px solid rgba(45,80,22,0.15);
    }

    .status-inactive {
        background: var(--danger-lt);
        color: var(--danger);
        border: 1px solid rgba(140,44,26,0.15);
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 8px;
    }

    .action-link {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        transition: background 0.2s;
        text-decoration: none;
    }

    .action-link svg {
        width: 14px;
        height: 14px;
    }

    .action-link:hover {
        background: rgba(0,0,0,0.06);
    }

    .action-link.view svg { color: var(--ink-muted); }
    .action-link.edit svg { color: var(--ink-muted); }
    .action-link.toggle svg { color: #D97706; }
    .action-link.delete svg { color: var(--danger); }

    .action-form {
        display: inline;
    }

    .action-form button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
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
        <h1 class="page-title">Manage Events</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-link">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div style="display: flex; gap: 12px; margin-bottom: 24px;">
        <a href="{{ route('admin.events.create') }}" class="create-btn" style="margin-bottom: 0;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Create New Event
        </a>
        <a href="#" class="create-btn" style="margin-bottom: 0; background: #10B981;" onclick="openImportModal(event)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Import Excel
        </a>
        <a href="#" class="create-btn" style="margin-bottom: 0; background: #3B82F6;" onclick="openManualModal(event)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Kirim Manual
        </a>
    </div>

    @if($events->count() === 0)
        <div class="table-container">
            <div class="empty-state">No events found.</div>
        </div>
    @else
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Poster</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Claims</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                @if($event->poster)
                                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}" class="event-poster">
                                @else
                                    <div class="event-poster-placeholder">No Poster</div>
                                @endif
                            </td>
                            <td>
                                <div class="event-name">{{ $event->name }}</div>
                                @if($event->description)
                                    <div class="event-desc">{{ Str::limit($event->description, 50) }}</div>
                                @endif
                            </td>
                            <td>{{ $event->date ? $event->date->format('d F Y') : 'N/A' }}</td>
                            <td>{{ $event->location ?? 'N/A' }}</td>
                            <td>
                                @if($event->is_active)
                                    <span class="status-badge status-active">Active</span>
                                @else
                                    <span class="status-badge status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $event->certificates->count() }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.events.show', $event) }}" class="action-link view" title="View">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="action-link edit" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.events.toggle', $event) }}" method="POST" class="action-form">
                                        @csrf
                                        <button type="submit" class="action-link toggle" title="Toggle Status">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="action-form" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-link delete" title="Delete">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {{ $events->links() }}
            </div>
        </div>
    @endif

</div>

{{-- ── Import Excel Modal ── --}}
<div id="importModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div class="modal-content" style="background:var(--card); width:100%; max-width:500px; border-radius:var(--radius-lg); padding:30px; box-shadow:0 15px 50px rgba(0,0,0,0.1);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 style="margin:0; font-family:'Fraunces', serif; font-weight:300; font-size:24px;">Import Excel (CSV)</h3>
            <button onclick="closeImportModal()" style="background:none; border:none; cursor:pointer; color:var(--ink-muted);"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        
        <form action="{{ route('admin.import-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:500; margin-bottom:8px;">Pilih Event</label>
                <select name="event_id" required style="width:100%; padding:10px 14px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px; outline:none; background:var(--surface);">
                    <option value="">-- Pilih Event --</option>
                    @foreach($allEvents as $ev)
                        <option value="{{ $ev->id }}">{{ $ev->name }} {{ $ev->is_active ? '' : '(Inactive)' }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:500; margin-bottom:8px;">Sebagai Apa (Role)</label>
                <select name="role" id="role_select" onchange="handleRoleChange()" style="width:100%; padding:10px 14px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px; outline:none; background:var(--surface);">
                    <option value="">-- Tidak ada role khusus --</option>
                    <option value="Peserta">Peserta</option>
                    <option value="Pemateri">Pemateri</option>
                    <option value="Panitia">Panitia</option>
                    <option value="manual">Lainnya (Input Manual)...</option>
                </select>
                <input type="text" name="role_manual" id="role_manual" placeholder="Ketik role di sini..." style="display:none; width:100%; margin-top:8px; padding:10px 14px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:500; margin-bottom:8px;">Upload File CSV</label>
                <input type="file" name="file" accept=".csv" required style="width:100%; padding:8px 10px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
                <div style="margin-top:8px; font-size:12px; color:var(--ink-muted);">
                    Silakan gunakan format CSV. <a href="{{ route('admin.download-template') }}" style="color:var(--accent); font-weight:500; text-decoration:none;">Download Template</a>
                </div>
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:30px;">
                <button type="button" onclick="closeImportModal()" style="padding:10px 20px; border:1px solid rgba(0,0,0,0.1); background:transparent; border-radius:8px; cursor:pointer; font-weight:500;">Batal</button>
                <button type="submit" style="padding:10px 20px; border:none; background:var(--accent); color:white; border-radius:8px; cursor:pointer; font-weight:500;">Import & Generate</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Manual Send Modal ── --}}
<div id="manualModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; overflow-y:auto; padding:20px;">
    <div class="modal-content" style="background:var(--card); width:100%; max-width:600px; border-radius:var(--radius-lg); padding:30px; box-shadow:0 15px 50px rgba(0,0,0,0.1); margin:auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 style="margin:0; font-family:'Fraunces', serif; font-weight:300; font-size:24px;">Kirim Sertifikat Manual</h3>
            <button onclick="closeManualModal()" style="background:none; border:none; cursor:pointer; color:var(--ink-muted);"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        
        <form action="{{ route('admin.manual-send') }}" method="POST">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:500; margin-bottom:8px;">Pilih Event</label>
                <select name="event_id" required style="width:100%; padding:10px 14px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px; outline:none; background:var(--surface);">
                    <option value="">-- Pilih Event --</option>
                    @foreach($allEvents as $ev)
                        <option value="{{ $ev->id }}">{{ $ev->name }} {{ $ev->is_active ? '' : '(Inactive)' }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:500; margin-bottom:8px;">Sebagai Apa (Role)</label>
                <select name="role" id="role_select_manual" onchange="handleRoleChangeManual()" style="width:100%; padding:10px 14px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px; outline:none; background:var(--surface);">
                    <option value="">-- Tidak ada role khusus --</option>
                    <option value="Peserta">Peserta</option>
                    <option value="Pemateri">Pemateri</option>
                    <option value="Panitia">Panitia</option>
                    <option value="manual">Lainnya (Input Manual)...</option>
                </select>
                <input type="text" name="role_manual" id="role_manual_input" placeholder="Ketik role di sini..." style="display:none; width:100%; margin-top:8px; padding:10px 14px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:500; margin-bottom:8px;">Daftar Peserta</label>
                <div id="participants-container">
                    <div class="participant-row" style="display:flex; gap:10px; margin-bottom:10px;">
                        <input type="text" name="participants[0][name]" placeholder="Nama Lengkap" required style="flex:1; padding:8px 10px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
                        <input type="email" name="participants[0][email]" placeholder="Email" required style="flex:1; padding:8px 10px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
                        <button type="button" onclick="removeRow(this)" style="padding:8px 12px; background:var(--danger-lt); color:var(--danger); border:1px solid rgba(140,44,26,0.15); border-radius:8px; cursor:pointer;" title="Hapus"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
                    </div>
                </div>
                <button type="button" onclick="addParticipantRow()" style="margin-top:10px; padding:8px 16px; background:var(--surface); border:1px dashed rgba(0,0,0,0.2); border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; width:100%; transition:background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.03)'" onmouseout="this.style.background='var(--surface)'">+ Tambah Baris Peserta</button>
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:30px;">
                <button type="button" onclick="closeManualModal()" style="padding:10px 20px; border:1px solid rgba(0,0,0,0.1); background:transparent; border-radius:8px; cursor:pointer; font-weight:500;">Batal</button>
                <button type="submit" style="padding:10px 20px; border:none; background:var(--accent); color:white; border-radius:8px; cursor:pointer; font-weight:500;">Kirim Sertifikat</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openImportModal(e) {
    e.preventDefault();
    document.getElementById('importModal').style.display = 'flex';
}
function closeImportModal() {
    document.getElementById('importModal').style.display = 'none';
}
function handleRoleChange() {
    var select = document.getElementById('role_select');
    var manualInput = document.getElementById('role_manual');
    if (select.value === 'manual') {
        manualInput.style.display = 'block';
        manualInput.required = true;
    } else {
        manualInput.style.display = 'none';
        manualInput.required = false;
        manualInput.value = '';
    }
}

let pIndex = 1;
function addParticipantRow() {
    const container = document.getElementById('participants-container');
    const div = document.createElement('div');
    div.className = 'participant-row';
    div.style.display = 'flex';
    div.style.gap = '10px';
    div.style.marginBottom = '10px';
    div.innerHTML = `
        <input type="text" name="participants[${pIndex}][name]" placeholder="Nama Lengkap" required style="flex:1; padding:8px 10px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
        <input type="email" name="participants[${pIndex}][email]" placeholder="Email" required style="flex:1; padding:8px 10px; border:1px solid rgba(0,0,0,0.1); border-radius:8px; font-size:14px;">
        <button type="button" onclick="removeRow(this)" style="padding:8px 12px; background:var(--danger-lt); color:var(--danger); border:1px solid rgba(140,44,26,0.15); border-radius:8px; cursor:pointer;" title="Hapus"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    `;
    container.appendChild(div);
    pIndex++;
}

function removeRow(btn) {
    if (document.querySelectorAll('.participant-row').length > 1) {
        btn.parentElement.remove();
    } else {
        alert("Minimal harus ada 1 baris peserta.");
    }
}

function openManualModal(e) {
    e.preventDefault();
    document.getElementById('manualModal').style.display = 'flex';
}
function closeManualModal() {
    document.getElementById('manualModal').style.display = 'none';
}

function handleRoleChangeManual() {
    var select = document.getElementById('role_select_manual');
    var manualInput = document.getElementById('role_manual_input');
    if (select.value === 'manual') {
        manualInput.style.display = 'block';
        manualInput.required = true;
    } else {
        manualInput.style.display = 'none';
        manualInput.required = false;
        manualInput.value = '';
    }
}
</script>
@endpush
@endsection
