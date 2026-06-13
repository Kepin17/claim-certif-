@extends('layouts.user-layout')

@section('title', 'Sign In')

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
    .auth-hero::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .auth-hero-inner {
        position: relative;
        z-index: 1;
    }
    .auth-hero-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.4);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }
    .auth-hero-icon svg { width: 28px; height: 28px; color: #fff; }
    .auth-hero-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.75);
        margin-bottom: 6px;
    }
    .auth-hero-title {
        font-size: 32px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
    }
    .auth-hero-sub {
        font-size: 15px;
        color: rgba(255,255,255,0.85);
    }

    .auth-wrap {
        max-width: 440px;
        margin: -40px auto 56px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .auth-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: 22px;
        padding: 32px 28px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    }

    /* Field */
    .a-field { margin-bottom: 16px; }
    .a-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 7px;
    }
    .a-input {
        width: 100%;
        font-family: 'Geist', sans-serif;
        font-size: 15px;
        color: var(--ink);
        background: var(--surface);
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 13px 14px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
    }
    .a-input:focus {
        background: var(--card);
        border-color: #3478F6;
        box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
    }
    .a-input::placeholder { color: #AEAEB2; }
    .a-input.with-toggle { padding-right: 46px; }

    /* Password toggle */
    .a-input-wrap {
        position: relative;
    }
    .a-pw-toggle {
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
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .a-pw-toggle:hover { color: #3478F6; }
    .a-pw-toggle svg { width: 18px; height: 18px; display: block; }

    /* Status text */
    .a-status {
        font-size: 12px;
        margin-top: 5px;
        min-height: 16px;
        line-height: 1.4;
        transition: color 0.2s;
    }
    .a-hint {
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 5px;
        line-height: 1.4;
    }

    /* Submit button */
    .a-btn {
        width: 100%;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #3478F6;
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        box-shadow: 0 3px 14px rgba(52,120,246,0.35);
        margin-top: 8px;
    }
    .a-btn:hover { background: #2563EB; }
    .a-btn:active { transform: scale(0.98); }
    .a-btn svg { width: 18px; height: 18px; }

    /* Alert */
    .a-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 18px;
    }
    .a-alert svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }
    .a-alert.error { background: #FFF0F0; color: #C0392B; }
    .a-alert.info  { background: #EEF4FF; color: #1A54C4; }

    /* Info box */
    .a-info-box {
        background: rgba(52,120,246,0.06);
        border-radius: 12px;
        padding: 12px 14px;
        margin-top: 18px;
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.5;
    }
    .a-info-box strong { color: var(--ink); }

    /* New user badge */
    .a-new-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(52,120,246,0.1);
        color: #3478F6;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 14px;
    }

    @media (max-width: 480px) {
        .auth-hero { padding: 44px 20px 72px; }
        .auth-hero-title { font-size: 26px; }
        .auth-wrap { margin-top: -32px; }
        .auth-card { padding: 26px 20px; }
    }
</style>

<!-- Hero -->
<div class="auth-hero">
    <div class="auth-hero-inner">
        <div class="auth-hero-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10,17 15,12 10,7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
        </div>
        <p class="auth-hero-label">Certificate Portal</p>
        <h1 class="auth-hero-title">Welcome Back</h1>
        <p class="auth-hero-sub">Sign in to your account or create a new one</p>
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

        @if(session('info'))
        <div class="a-alert info">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            {{-- Name field: hidden by default, shown for new users --}}
            <div class="a-field" id="nameField" style="display: none;">
                <div class="a-new-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14m-7-7h14"/></svg>
                    New Account
                </div>
                <label for="name" class="a-label">Full Name</label>
                <input type="text" name="name" id="name" class="a-input" placeholder="e.g. John Smith" value="{{ old('name') }}">
                <p class="a-hint" id="newUserHint" style="display:none; color: #3478F6;">Enter your name to create your account automatically.</p>
            </div>

            <div class="a-field">
                <label for="email" class="a-label">Email Address</label>
                <input type="email" name="email" id="email" class="a-input" placeholder="you@email.com" value="{{ old('email') }}" required autofocus>
                <p id="emailStatus" class="a-status"></p>
            </div>

            <div class="a-field" id="passwordField">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">
                    <label for="password" class="a-label" style="margin-bottom:0;">Password</label>
                    <a href="{{ route('password.request') }}" style="font-size:12px;color:#3478F6;text-decoration:none;font-weight:500;">Forgot password?</a>
                </div>
                <div class="a-input-wrap">
                    <input type="password" name="password" id="password" class="a-input with-toggle" placeholder="Min. 8 characters" required minlength="8">
                    <button type="button" class="a-pw-toggle" id="togglePassword" tabindex="-1">
                        <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="a-field" id="confirmPasswordField" @if(!session('show_name_field')) style="display:none;" @endif>
                <label for="password_confirmation" class="a-label">Confirm Password</label>
                <div class="a-input-wrap">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="a-input with-toggle" placeholder="Re-enter your password" @if(session('show_name_field')) required @endif>
                    <button type="button" class="a-pw-toggle" id="toggleConfirmPassword" tabindex="-1">
                        <svg id="eyeIconConfirm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="a-btn" id="submitBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10,17 15,12 10,7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                <span id="btnText">Continue</span>
            </button>
        </form>

        <div class="a-info-box">
            💡 <strong>First time here?</strong> Just enter your email — we'll detect if you're new and set up your account automatically after verification.
        </div>

    </div>
</div>

<script>
    const emailInput      = document.getElementById('email');
    const nameField       = document.getElementById('nameField');
    const nameInput       = document.getElementById('name');
    const emailStatus     = document.getElementById('emailStatus');
    const newUserHint     = document.getElementById('newUserHint');
    const btnText         = document.getElementById('btnText');
    const confirmField    = document.getElementById('confirmPasswordField');
    const passwordInput   = document.getElementById('password');
    const confirmInput    = document.getElementById('password_confirmation');

    // Password toggles
    function setupToggle(btnId, inputId, iconId) {
        document.getElementById(btnId).addEventListener('click', function() {
            const input = document.getElementById(inputId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            document.getElementById(iconId).innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        });
    }
    setupToggle('togglePassword', 'password', 'eyeIcon');
    setupToggle('toggleConfirmPassword', 'password_confirmation', 'eyeIconConfirm');

    // ── Email auto-detect ──────────────────────────────────
    let emailChecked = false;
    let emailExists  = null;
    let abortCtrl    = null;

    function applyResult(exists) {
        emailChecked = true;
        emailExists  = exists;
        if (exists) {
            emailStatus.textContent    = '✓ Account found — enter your password';
            emailStatus.style.color    = '#34C759';
            nameField.style.display    = 'none';
            nameInput.removeAttribute('required');
            newUserHint.style.display  = 'none';
            confirmField.style.display = 'none';
            confirmInput.removeAttribute('required');
            btnText.textContent        = 'Sign In';
        } else {
            emailStatus.textContent    = 'New account — fill in your name below';
            emailStatus.style.color    = '#3478F6';
            nameField.style.display    = 'block';
            nameInput.setAttribute('required', 'required');
            newUserHint.style.display  = 'block';
            confirmField.style.display = 'block';
            confirmInput.setAttribute('required', 'required');
            btnText.textContent        = 'Create Account';
            nameInput.focus();
        }
    }

    function runCheck(email, callback) {
        if (abortCtrl) abortCtrl.abort();
        abortCtrl = new AbortController();
        emailStatus.textContent = 'Checking…';
        emailStatus.style.color = '#8E8E93';

        fetch('/check-email?email=' + encodeURIComponent(email), {
            method: 'GET',
            signal: abortCtrl.signal,
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            applyResult(!!data.exists);
            if (callback) callback(!!data.exists);
        })
        .catch(err => {
            if (err.name === 'AbortError') return;
            emailStatus.textContent = '';
            emailChecked = false;
            if (callback) callback(null);
        });
    }

    emailInput.addEventListener('blur', function () {
        const email = this.value.trim();
        if (!email || !this.validity.valid) { emailStatus.textContent = ''; return; }
        if (emailChecked) return;
        runCheck(email, null);
    });

    emailInput.addEventListener('input', function () {
        emailChecked = false;
        emailExists  = null;
        emailStatus.textContent    = '';
        nameField.style.display    = 'none';
        nameInput.removeAttribute('required');
        confirmField.style.display = 'none';
        confirmInput.removeAttribute('required');
        btnText.textContent        = 'Continue';
    });

    // ── Form submit ─────────────────────────────────────────
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        const email = emailInput.value.trim();
        const form  = this;

        // Email not checked yet → run check first, then decide
        if (!emailChecked && email) {
            e.preventDefault();
            runCheck(email, function (exists) {
                if (exists === true) {
                    // existing user, just submit
                    form.submit();
                }
                // new user: fields are now shown, user must fill name — don't auto-submit
                // check failed (null): let form submit and let server handle it
                else if (exists === null) {
                    form.submit();
                }
            });
            return;
        }

        // New user fields visible but name empty
        if (nameField.style.display === 'block' && !nameInput.value.trim()) {
            e.preventDefault();
            nameInput.focus();
            return;
        }

        // Password confirmation mismatch
        if (confirmField.style.display === 'block') {
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                confirmInput.style.border = '1.5px solid #C0392B';
                confirmInput.focus();
                return;
            }
        }
    });
</script>
@endsection
