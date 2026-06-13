@extends('layouts.admin-layout')

@section('title', 'Manual Certificate Creation')

@section('content')
<style>
    .mc-page {
        max-width: 640px;
        margin: 40px auto;
        padding: 0 24px;
    }
    .mc-card {
        background: #FDFCFA;
        border: 1px solid rgba(0,0,0,0.07);
        border-radius: 20px;
        padding: 32px 28px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .mc-header {
        margin-bottom: 28px;
    }
    .mc-title {
        font-family: 'Fraunces', serif;
        font-size: 24px;
        font-weight: 500;
        color: #131210;
        margin-bottom: 8px;
    }
    .mc-desc {
        font-size: 14px;
        color: #8A877F;
    }
    .mc-field {
        margin-bottom: 20px;
    }
    .mc-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #8A877F;
        margin-bottom: 8px;
    }
    .mc-input {
        width: 100%;
        font-family: 'Geist', sans-serif;
        font-size: 15px;
        color: #131210;
        background: #F5F2EC;
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 14px 16px;
        outline: none;
        transition: border-color 0.18s, background 0.18s;
    }
    .mc-input:focus {
        background: #FDFCFA;
        border-color: #3478F6;
        box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
    }
    .mc-input::placeholder { color: #AEAEB2; }
    .mc-btn {
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
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        box-shadow: 0 3px 12px rgba(52,120,246,0.28);
        margin-top: 8px;
    }
    .mc-btn:hover { background: #2563EB; }
    .mc-btn:active { transform: scale(0.98); }
    .mc-btn svg { width: 18px; height: 18px; }
    .mc-alert {
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .mc-alert-success { background: #E9FBF0; color: #16773A; }
    .mc-alert-error { background: #FFF0F0; color: #C0392B; }
    .mc-alert svg { width: 18px; height: 18px; flex-shrink: 0; }
    .mc-hint {
        font-size: 12px;
        color: #8A877F;
        margin-top: 6px;
    }
    @media (max-width: 640px) {
        .mc-page { margin: 24px auto; padding: 0 16px; }
        .mc-card { padding: 24px 20px; }
    }
</style>

<div class="mc-page">
    <div class="mc-card">
        <div class="mc-header">
            <h1 class="mc-title">Create Certificate Manually</h1>
            <p class="mc-desc">Generate a certificate for a participant without requiring them to submit a claim form.</p>
        </div>

        @if(session('success'))
        <div class="mc-alert mc-alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mc-alert mc-alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mc-alert mc-alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul style="margin:0; padding:0; list-style:none;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.manual-create.store') }}">
            @csrf

            <div class="mc-field">
                <label for="event_id" class="mc-label">Event</label>
                <select name="event_id" id="event_id" class="mc-input" required>
                    <option value="">Select an event...</option>
                    @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mc-field">
                <label for="name" class="mc-label">Participant Name</label>
                <input type="text" name="name" id="name" class="mc-input" placeholder="e.g. John Smith" required value="{{ old('name') }}">
            </div>

            <div class="mc-field">
                <label for="email" class="mc-label">Participant Email</label>
                <input type="email" name="email" id="email" class="mc-input" placeholder="participant@email.com" required value="{{ old('email') }}">
                <p class="mc-hint">Certificate will be sent to this email after generation.</p>
            </div>

            @if(isset($certificateTypes))
            <div class="mc-field">
                <label for="certificate_type_id" class="mc-label">Certificate Type (Optional)</label>
                <select name="certificate_type_id" id="certificate_type_id" class="mc-input">
                    <option value="">Default</option>
                    @foreach($certificateTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <button type="submit" class="mc-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14m-7-7h14"/>
                </svg>
                Create & Generate Certificate
            </button>
        </form>

        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.06);">
            <a href="{{ route('admin.generated') }}" style="font-size: 13px; color: #8A877F; text-decoration: none;">
                ← Back to Generated Certificates
            </a>
        </div>
    </div>
</div>
@endsection
