@extends('layouts.user-layout')

@section('title', 'Verify OTP')

@section('content')
<style>
    .otp-hero {
        background: linear-gradient(135deg, #3478F6 0%, #1A54C4 100%);
        padding: 56px 24px 88px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .otp-hero::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .otp-hero::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .otp-hero-inner {
        position: relative;
        z-index: 1;
    }
    .otp-hero-icon {
        width: 64px;
        height: 64px;
        border-radius: 20px;
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.4);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }
    .otp-hero-icon svg { width: 30px; height: 30px; color: #fff; }
    .otp-hero-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.75);
        margin-bottom: 6px;
    }
    .otp-hero-title {
        font-size: 32px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
    }
    .otp-hero-sub {
        font-size: 15px;
        color: rgba(255,255,255,0.85);
        max-width: 340px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .otp-wrap {
        max-width: 420px;
        margin: -40px auto 56px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .otp-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: 22px;
        padding: 32px 28px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    }

    /* Alerts */
    .ov-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 20px;
    }
    .ov-alert svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }
    .ov-alert.success { background: #E9FBF0; color: #16773A; }
    .ov-alert.error   { background: #FFF0F0; color: #C0392B; }
    .ov-alert.info    { background: #EEF4FF; color: #1A54C4; }

    /* OTP input */
    .otp-input-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 10px;
    }
    .otp-digits-input {
        width: 100%;
        text-align: center;
        font-size: 32px;
        letter-spacing: 14px;
        font-weight: 800;
        font-family: 'Geist', sans-serif;
        color: var(--ink);
        background: var(--surface);
        border: 2px solid transparent;
        border-radius: 16px;
        padding: 20px 14px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        caret-color: #3478F6;
    }
    .otp-digits-input:focus {
        background: var(--card);
        border-color: #3478F6;
        box-shadow: 0 0 0 4px rgba(52,120,246,0.14);
    }
    .otp-digits-input::placeholder {
        color: rgba(0,0,0,0.15);
        letter-spacing: 10px;
    }

    /* Timer */
    .otp-timer {
        text-align: center;
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: 10px;
    }
    .otp-timer span { color: #3478F6; font-weight: 600; }

    /* Submit */
    .otp-btn {
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
        margin-top: 18px;
    }
    .otp-btn:hover { background: #2563EB; }
    .otp-btn:active { transform: scale(0.98); }
    .otp-btn svg { width: 18px; height: 18px; }

    /* Resend */
    .otp-resend {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    .otp-resend p { font-size: 13px; color: var(--ink-muted); margin-bottom: 8px; }
    .otp-resend a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #3478F6;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 10px;
        background: rgba(52,120,246,0.08);
        transition: background 0.15s;
    }
    .otp-resend a:hover { background: rgba(52,120,246,0.15); }
    .otp-resend a svg { width: 14px; height: 14px; }

    @media (max-width: 480px) {
        .otp-hero { padding: 44px 20px 72px; }
        .otp-hero-title { font-size: 26px; }
        .otp-wrap { margin-top: -32px; }
        .otp-card { padding: 26px 20px; }
        .otp-digits-input { font-size: 26px; letter-spacing: 10px; }
    }
</style>

<!-- Hero -->
<div class="otp-hero">
    <div class="otp-hero-inner">
        <div class="otp-hero-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
        </div>
        <p class="otp-hero-label">Security Verification</p>
        <h1 class="otp-hero-title">Check Your Email</h1>
        <p class="otp-hero-sub">We've sent a 6-digit verification code to your email address</p>
    </div>
</div>

<div class="otp-wrap">
    <div class="otp-card">

        @if(session('info'))
        <div class="ov-alert info">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="ov-alert error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="ov-alert error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul style="margin:0; padding:0; list-style:none;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('otp.verify.post') }}" method="POST">
            @csrf

            <label for="otp" class="otp-input-label">Verification Code</label>
            <input
                type="text"
                name="otp"
                id="otp"
                class="otp-digits-input"
                placeholder="••••••"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                autocomplete="one-time-code"
                required
                autofocus
            >
            <p class="otp-timer">Code expires in <span id="countdown">10:00</span></p>

            <button type="submit" class="otp-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                Verify & Continue
            </button>
        </form>

        <div class="otp-resend">
            <p>Didn't receive the code?</p>
            <a href="{{ route('otp.resend') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                </svg>
                Resend Code
            </a>
        </div>

    </div>
</div>

<script>
    // Auto format OTP input (digits only)
    document.getElementById('otp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });

    // Countdown timer 10 minutes
    let seconds = 600;
    const el = document.getElementById('countdown');
    const timer = setInterval(() => {
        seconds--;
        if (seconds <= 0) {
            clearInterval(timer);
            el.textContent = 'Expired';
            el.style.color = '#C0392B';
            return;
        }
        const m = Math.floor(seconds / 60).toString().padStart(2, '0');
        const s = (seconds % 60).toString().padStart(2, '0');
        el.textContent = `${m}:${s}`;
        if (seconds <= 60) el.style.color = '#E53935';
    }, 1000);
</script>
@endsection
