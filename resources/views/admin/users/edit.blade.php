@extends('layouts.admin-layout')

@section('title', 'Edit User — ' . $user->name)

@section('content')
<style>
    .main-content { max-width: 680px; margin: 0 auto; padding: 48px 40px 80px; }

    .page-header { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 32px; }

    .page-title { font-family: 'Fraunces', serif; font-size: 28px; font-weight: 300; color: var(--ink); letter-spacing: -0.02em; }

    .back-link { font-size: 13px; color: var(--accent); text-decoration: none; font-weight: 500; }
    .back-link:hover { text-decoration: underline; }

    .user-meta {
        display: flex; align-items: center; gap: 12px;
        background: var(--surface); border: 1px solid rgba(0,0,0,0.06);
        border-radius: var(--radius-sm); padding: 14px 18px;
        margin-bottom: 24px;
    }
    .user-avatar-lg {
        width: 42px; height: 42px; border-radius: 50%;
        background: var(--accent-lt); color: var(--accent);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700; text-transform: uppercase; flex-shrink: 0;
    }
    .user-meta-info .meta-name { font-weight: 500; color: var(--ink); font-size: 15px; }
    .user-meta-info .meta-since { font-size: 12px; color: var(--ink-muted); }

    .form-card {
        background: var(--card); border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg); padding: 36px;
    }

    .form-group { margin-bottom: 22px; }

    .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--ink-mid); margin-bottom: 7px; }
    .form-label .req { color: var(--danger); margin-left: 2px; }

    .form-input {
        width: 100%; padding: 10px 14px;
        font-family: 'Geist', sans-serif; font-size: 14px; color: var(--ink);
        background: var(--surface); border: 1px solid rgba(0,0,0,0.1);
        border-radius: var(--radius-sm); box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(45,80,22,0.1); background: var(--card); }

    .form-hint { font-size: 12px; color: var(--ink-muted); margin-top: 5px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .toggle-wrap { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
    .toggle-label { font-size: 14px; color: var(--ink-mid); }

    .toggle-switch { position: relative; width: 40px; height: 22px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; cursor: pointer;
        background: rgba(0,0,0,0.15); border-radius: 100px; transition: background 0.2s;
    }
    .toggle-slider::before {
        content: ''; position: absolute;
        height: 16px; width: 16px; left: 3px; bottom: 3px;
        background: #fff; border-radius: 50%; transition: transform 0.2s;
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--accent); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }

    .divider { border: none; border-top: 1px solid rgba(0,0,0,0.06); margin: 26px 0; }

    .form-actions { display: flex; align-items: center; gap: 12px; margin-top: 28px; }

    .btn-submit {
        padding: 11px 28px; background: var(--ink); color: #fff;
        font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 500;
        border: none; border-radius: var(--radius-sm); cursor: pointer; transition: background 0.2s;
    }
    .btn-submit:hover { background: #2A2821; }

    .btn-cancel { font-size: 14px; color: var(--ink-muted); text-decoration: none; }
    .btn-cancel:hover { color: var(--ink); }

    .errors { background: var(--danger-lt); border: 1px solid rgba(140,44,26,0.15); border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 24px; }
    .errors li { font-size: 13px; color: var(--danger); margin-bottom: 4px; }
    .errors li:last-child { margin-bottom: 0; }

    .self-warning { font-size: 12px; color: #92400E; background: rgba(251,191,36,0.12); border: 1px solid rgba(217,119,6,0.2); border-radius: var(--radius-sm); padding: 8px 12px; margin-top: 6px; }

    @media (max-width: 600px) {
        .main-content { padding: 28px 20px 60px; }
        .form-card { padding: 24px; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="main-content">

    <div class="page-header">
        <h1 class="page-title">Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="back-link">← Back to Users</a>
    </div>

    <div class="user-meta">
        <div class="user-avatar-lg">{{ mb_substr($user->name, 0, 1) }}</div>
        <div class="user-meta-info">
            <div class="meta-name">{{ $user->name }} @if($user->id === auth()->id()) <span style="font-size:11px;background:rgba(251,191,36,0.15);color:#92400E;padding:2px 7px;border-radius:100px;font-weight:600;letter-spacing:0.05em;text-transform:uppercase;">You</span> @endif</div>
            <div class="meta-since">Member since {{ $user->created_at->format('d F Y') }}</div>
        </div>
    </div>

    <div class="form-card">

        @if($errors->any())
            <ul class="errors">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Full Name <span class="req">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address <span class="req">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
            </div>

            <hr class="divider">

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current">
                    <p class="form-hint">Minimum 8 characters. Leave blank to keep unchanged.</p>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
            </div>

            <hr class="divider">

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Role <span class="req">*</span></label>
                    <select name="role" class="form-input" required>
                        <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Account Status</label>
                    @if($user->id === auth()->id())
                        <div class="toggle-wrap">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" checked disabled>
                                <span class="toggle-slider"></span>
                            </label>
                            <input type="hidden" name="is_active" value="1">
                            <span class="toggle-label">Active</span>
                        </div>
                        <p class="self-warning">You cannot deactivate your own account.</p>
                    @else
                        <div class="toggle-wrap">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ? '1' : '') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">Active (can log in)</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Save Changes</button>
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Cancel</a>
            </div>

        </form>
    </div>

</div>
@endsection
