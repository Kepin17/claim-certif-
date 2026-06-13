@extends('layouts.user-layout')

@section('title', 'Reset Password')

@section('content')
<style>
    .auth-hero {
        background: linear-gradient(135deg, #3478F6 0%, #1A54C4 100%);
        padding: 56px 24px 88px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .auth-hero::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .auth-hero-inner { position: relative; z-index: 1; }
    .auth-hero-icon {
        width: 60px; height: 60px;
        border-radius: 18px;
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.4);
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 18px;
    }
    .auth-hero-icon svg { width: 28px; height: 28px; color: #fff; }
    .auth-hero-label { font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 6px; }
    .auth-hero-title { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 8px; }
    .auth-hero-sub { font-size: 15px; color: rgba(255,255,255,0.85); }

    .auth-wrap { max-width: 440px; margin: -40px auto 56px; padding: 0 20px; position: relative; z-index: 2; }
    .auth-card { background: var(--card); border: 1px solid rgba(0,0,0,0.07); border-radius: 22px; padding: 32px 28px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

    .a-field { margin-bottom: 16px; }
    .a-label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 7px; }
    .a-input { width: 100%; font-family: 'Geist', sans-serif; font-size: 15px; color: var(--ink); background: var(--surface); border: 1.5px solid transparent; border-radius: 12px; padding: 13px 14px; outline: none; box-sizing: border-box; transition: border-color 0.18s, background 0.18s, box-shadow 0.18s; }
    .a-input:focus { background: var(--card); border-color: #3478F6; box-shadow: 0 0 0 3px rgba(52,120,246,0.12); }
    .a-input::placeholder { color: #AEAEB2; }
    .a-input.with-toggle { padding-right: 46px; }

    .a-input-wrap { position: relative; }
    .a-pw-toggle { position: absolute; right: 13px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--ink-muted); padding: 4px; line-height: 0; transition: color 0.18s; display: flex; align-items: center; }
    .a-pw-toggle:hover { color: #3478F6; }
    .a-pw-toggle svg { width: 18px; height: 18px; display: block; }

    .a-btn { width: 100%; height: 50px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #3478F6; color: #fff; border: none; border-radius: 14px; font-size: 15px; font-weight: 700; font-family: inherit; cursor: pointer; transition: background 0.15s; box-shadow: 0 3px 14px rgba(52,120,246,0.35); margin-top: 8px; }
    .a-btn:hover { background: #2563EB; }

    .a-alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 18px; }
    .a-alert svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }
    .a-alert.error { background: #FFF0F0; color: #C0392B; }
    .a-hint { font-size: 12px; color: var(--ink-muted); margin-top: 5px; }

    @media (max-width: 480px) {
        .auth-hero { padding: 44px 20px 72px; }
        .auth-hero-title { font-size: 26px; }
        .auth-wrap { margin-top: -32px; }
        .auth-card { padding: 26px 20px; }
    }
</style>

<div class="auth-hero">
    <div class="auth-hero-inner">
        <div class="auth-hero-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
        <p class="auth-hero-label">Account Recovery</p>
        <h1 class="auth-hero-title">Set New Password</h1>
        <p class="auth-hero-sub">Choose a strong password for your account</p>
    </div>
</div>

<div class="auth-wrap">
    <div class="auth-card">

        @if($errors->any())
        <div class="a-alert error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="a-field">
                <label for="email" class="a-label">Email Address</label>
                <input type="email" name="email" id="email" class="a-input" placeholder="you@email.com" value="{{ old('email', $email) }}" required>
            </div>

            <div class="a-field">
                <label for="password" class="a-label">New Password</label>
                <div class="a-input-wrap">
                    <input type="password" name="password" id="password" class="a-input with-toggle" placeholder="Min. 8 characters" required minlength="8">
                    <button type="button" class="a-pw-toggle" id="togglePw" tabindex="-1">
                        <svg id="eyeIcon1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="a-field">
                <label for="password_confirmation" class="a-label">Confirm Password</label>
                <div class="a-input-wrap">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="a-input with-toggle" placeholder="Re-enter your password" required>
                    <button type="button" class="a-pw-toggle" id="togglePwConfirm" tabindex="-1">
                        <svg id="eyeIcon2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <p id="matchHint" class="a-hint" style="display:none;color:#C0392B;">Passwords do not match.</p>
            </div>

            <button type="submit" class="a-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                Reset Password
            </button>
        </form>

    </div>
</div>

<script>
    function setupToggle(btnId, inputId, iconId) {
        document.getElementById(btnId).addEventListener('click', function () {
            const input = document.getElementById(inputId);
            const hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            document.getElementById(iconId).innerHTML = hidden
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        });
    }
    setupToggle('togglePw', 'password', 'eyeIcon1');
    setupToggle('togglePwConfirm', 'password_confirmation', 'eyeIcon2');

    document.getElementById('resetForm').addEventListener('submit', function (e) {
        const pw  = document.getElementById('password').value;
        const cpw = document.getElementById('password_confirmation').value;
        const hint = document.getElementById('matchHint');
        if (pw !== cpw) {
            e.preventDefault();
            hint.style.display = 'block';
            document.getElementById('password_confirmation').focus();
        } else {
            hint.style.display = 'none';
        }
    });
</script>
@endsection
