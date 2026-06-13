@extends('layouts.user-layout')

@section('title', 'My Profile')

@section('content')
<style>
    /* Hero */
    .p-hero {
        background: linear-gradient(135deg, #3478F6 0%, #1A54C4 100%);
        padding: 52px 24px 80px;
        position: relative;
        overflow: hidden;
    }
    .p-hero::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .p-hero::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .p-hero-inner {
        max-width: 640px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .p-hero-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        border: 2.5px solid rgba(255,255,255,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .p-hero-avatar svg {
        width: 34px;
        height: 34px;
        color: #fff;
    }
    .p-hero-info {
        flex: 1;
    }
    .p-hero-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.75);
        margin-bottom: 4px;
    }
    .p-hero-name {
        font-size: 26px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.3px;
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .p-hero-email {
        font-size: 14px;
        color: rgba(255,255,255,0.8);
    }

    /* Layout */
    .p-wrap {
        max-width: 640px;
        margin: -32px auto 56px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Section card */
    .p-section {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    .p-section-header {
        padding: 18px 22px 14px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .p-section-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .p-section-icon svg {
        width: 18px;
        height: 18px;
    }
    .p-section-icon.blue { background: rgba(52,120,246,0.12); color: #3478F6; }
    .p-section-icon.dark { background: rgba(0,0,0,0.06); color: var(--ink); }
    .p-section-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--ink);
    }
    .p-section-desc {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 1px;
    }
    .p-section-body {
        padding: 20px 22px;
    }

    /* Fields */
    .p-field {
        margin-bottom: 18px;
    }
    .p-field:last-of-type {
        margin-bottom: 0;
    }
    .p-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 7px;
    }
    .p-input {
        width: 100%;
        font-family: 'Geist', sans-serif;
        font-size: 15px;
        color: var(--ink);
        background: var(--surface);
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 13px 14px;
        outline: none;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        box-sizing: border-box;
    }
    .p-input:focus {
        background: var(--card);
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
    }
    .p-input::placeholder { color: #AEAEB2; }
    .p-input.pw-input { padding-right: 46px; }
    .p-hint {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 5px;
        line-height: 1.4;
    }
    .p-hint.info { color: #3478F6; }

    /* Password toggle */
    .p-pw-wrap {
        position: relative;
    }
    .p-pw-toggle {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--ink-muted);
        padding: 4px;
        line-height: 0;
        transition: color 0.18s;
    }
    .p-pw-toggle:hover { color: var(--accent); }
    .p-pw-toggle svg { width: 18px; height: 18px; }

    /* Submit button */
    .p-btn {
        width: 100%;
        height: 48px;
        margin-top: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
    }
    .p-btn:active { transform: scale(0.98); }
    .p-btn.blue {
        background: #3478F6;
        color: #fff;
        box-shadow: 0 3px 12px rgba(52,120,246,0.32);
    }
    .p-btn.blue:hover { background: #2563EB; }
    .p-btn.dark {
        background: var(--ink);
        color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.18);
    }
    .p-btn.dark:hover { opacity: 0.88; }
    .p-btn svg { width: 18px; height: 18px; }

    /* Alerts */
    .p-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 16px;
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 16px;
    }
    .p-alert svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }
    .p-alert.success { background: #E9FBF0; color: #16773A; }
    .p-alert.error   { background: #FFF0F0; color: #C0392B; }
    .p-alert.info    { background: #EEF4FF; color: #1A54C4; }
    .p-alert ul      { margin: 0; padding: 0; list-style: none; }

    /* OTP verify box */
    .p-otp-card {
        background: #EEF4FF;
        border: 1.5px solid rgba(52,120,246,0.2);
        border-radius: 16px;
        padding: 20px;
    }
    .p-otp-title {
        font-size: 14px;
        font-weight: 700;
        color: #1A54C4;
        margin-bottom: 4px;
    }
    .p-otp-sub {
        font-size: 13px;
        color: #3478F6;
        margin-bottom: 14px;
    }
    .p-otp-input {
        width: 100%;
        text-align: center;
        font-size: 24px;
        letter-spacing: 10px;
        font-weight: 700;
        font-family: 'Geist', sans-serif;
        color: var(--ink);
        background: var(--card);
        border: 2px solid rgba(52,120,246,0.3);
        border-radius: 12px;
        padding: 14px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.18s, box-shadow 0.18s;
    }
    .p-otp-input:focus {
        border-color: #3478F6;
        box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
    }

    @media (max-width: 520px) {
        .p-hero { padding: 40px 20px 72px; }
        .p-hero-avatar { width: 56px; height: 56px; }
        .p-hero-name { font-size: 20px; }
        .p-wrap { margin-top: -28px; padding: 0 14px; }
    }
</style>

<!-- Hero -->
<div class="p-hero">
    <div class="p-hero-inner">
        <div class="p-hero-avatar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div class="p-hero-info">
            <p class="p-hero-label">My Account</p>
            <h1 class="p-hero-name">{{ $user->name }}</h1>
            <p class="p-hero-email">{{ $user->email }}</p>
        </div>
    </div>
</div>

<div class="p-wrap">

    {{-- Alerts --}}
    @if(session('success'))
    <div class="p-alert success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('info'))
    <div class="p-alert info">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>
        <span>{{ session('info') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="p-alert error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- Personal Info Section --}}
    <div class="p-section">
        <div class="p-section-header">
            <div class="p-section-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div>
                <p class="p-section-title">Personal Information</p>
                <p class="p-section-desc">Update your name and email address</p>
            </div>
        </div>
        <div class="p-section-body">
            <form method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="p-field">
                    <label for="name" class="p-label">Full Name</label>
                    <input type="text" name="name" id="name" class="p-input" value="{{ old('name', $user->name) }}" placeholder="e.g. John Smith" required>
                    <p class="p-hint">This name will appear on your certificates</p>
                </div>

                <div class="p-field">
                    <label for="email" class="p-label">Email Address</label>
                    <input type="email" name="email" id="email" class="p-input" value="{{ old('email', $user->email) }}" required>
                    @if(session('email_changed'))
                        <p class="p-hint info">OTP sent to your new email. Please verify below to complete the change.</p>
                    @else
                        <p class="p-hint">Changing your email requires OTP verification</p>
                    @endif
                </div>

                <button type="submit" class="p-btn blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Save Changes
                </button>
            </form>

            {{-- Email OTP Verify --}}
            @if(session('email_changed'))
            <div class="p-otp-card" style="margin-top: 20px;">
                <p class="p-otp-title">Verify New Email</p>
                <p class="p-otp-sub">Enter the 6-digit code sent to <strong>{{ session('pending_email') }}</strong></p>
                <form method="POST" action="{{ route('user.profile.verify-email') }}">
                    @csrf
                    <input type="text" name="otp" class="p-otp-input" placeholder="000000" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required>
                    <button type="submit" class="p-btn blue" style="margin-top: 12px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Verify Email
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    {{-- Change Password Section --}}
    <div class="p-section">
        <div class="p-section-header">
            <div class="p-section-icon dark">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <div>
                <p class="p-section-title">Change Password</p>
                <p class="p-section-desc">Keep your account secure with a strong password</p>
            </div>
        </div>
        <div class="p-section-body">
            <form method="POST" action="{{ route('user.password.update') }}">
                @csrf
                @method('PUT')

                <div class="p-field">
                    <label for="current_password" class="p-label">Current Password</label>
                    <div class="p-pw-wrap">
                        <input type="password" name="current_password" id="current_password" class="p-input pw-input" placeholder="Enter current password" required>
                        <button type="button" class="p-pw-toggle" onclick="togglePw('current_password', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-field">
                    <label for="new_password" class="p-label">New Password</label>
                    <div class="p-pw-wrap">
                        <input type="password" name="new_password" id="new_password" class="p-input pw-input" placeholder="Min. 8 characters" required minlength="8">
                        <button type="button" class="p-pw-toggle" onclick="togglePw('new_password', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-field">
                    <label for="new_password_confirmation" class="p-label">Confirm New Password</label>
                    <div class="p-pw-wrap">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="p-input pw-input" placeholder="Re-enter new password" required>
                        <button type="button" class="p-pw-toggle" onclick="togglePw('new_password_confirmation', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="p-btn dark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Update Password
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.querySelector('svg').innerHTML = isHidden
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}
</script>
@endsection
