@extends('layouts.user-layout')

@section('title', 'Register')

@section('content')
<style>
    .login-container {
        max-width: 420px;
        margin: 60px auto;
        padding: 0 24px;
    }

    .login-card {
        background: var(--card);
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: var(--radius-lg);
        padding: 40px 32px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
    }

    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-title {
        font-family: 'Fraunces', serif;
        font-size: 26px;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 8px;
    }

    .login-subtitle {
        font-size: 14px;
        color: var(--ink-muted);
    }

    .login-field {
        margin-bottom: 20px;
    }

    .login-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 8px;
    }

    .login-input {
        width: 100%;
        font-family: 'Geist', sans-serif;
        font-size: 15px;
        color: var(--ink);
        background: var(--surface);
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 14px 16px;
        outline: none;
        transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
    }

    .login-input:focus {
        background: var(--card);
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
    }

    .login-input::placeholder {
        color: #AEAEB2;
    }

    .login-btn-submit {
        width: 100%;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        box-shadow: 0 2px 10px rgba(52,120,246,0.28);
        margin-top: 8px;
    }

    .login-btn-submit:hover {
        background: #2563EB;
    }

    .login-btn-submit:active {
        transform: scale(0.98);
    }

    .login-alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .login-alert-error {
        background: #FFEEED;
        color: #B02020;
    }

    .login-alert svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .login-note {
        text-align: center;
        font-size: 13px;
        color: var(--ink-muted);
        margin-top: 24px;
        line-height: 1.5;
    }

    .login-link {
        color: var(--accent);
        font-weight: 500;
        text-decoration: none;
    }

    .login-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .login-container {
            margin: 32px auto;
        }
        .login-card {
            padding: 32px 24px;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1 class="login-title">Create account</h1>
            <p class="login-subtitle">Sign up to claim and manage your certificates</p>
        </div>

        @if ($errors->any())
            <div class="login-alert login-alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <ul style="margin:0; padding-left:0; list-style:none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.register.post') }}">
            @csrf

            <div class="login-field">
                <label for="name" class="login-label">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="login-input" placeholder="e.g. John Smith" required autofocus>
            </div>

            <div class="login-field">
                <label for="email" class="login-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="login-input" placeholder="you@email.com" required>
            </div>

            <div class="login-field">
                <label for="password" class="login-label">Password</label>
                <input type="password" name="password" id="password" class="login-input" placeholder="Min. 8 characters" required minlength="8">
            </div>

            <div class="login-field">
                <label for="password_confirmation" class="login-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="login-input" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="login-btn-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Create Account
            </button>
        </form>

        <p class="login-note">
            Already have an account? <a href="{{ route('login') }}" class="login-link">Sign in</a>
        </p>
    </div>
</div>
@endsection
