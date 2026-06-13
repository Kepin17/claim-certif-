@extends('layouts.user-layout')

@section('title', 'Claim Your Certificate')

@push('scripts')
@include('certificates.partials.oui-shared')
@endpush

@section('content')
@php
    $feedbackStep = (isset($certificateTypes) && $certificateTypes->count() > 0) ? 3 : 2;
    $hasCertificateTypes = isset($certificateTypes) && $certificateTypes->count() > 0;
    $attendanceStep = $hasCertificateTypes ? 3 : 2;
    $feedbackStep = isset($event) && $event->requires_attendance_proof ? $attendanceStep + 1 : $attendanceStep;
@endphp
<div class="oui-page">

    <div class="oui-hero">
        <div class="oui-hero-inner wide">
            <a href="{{ route('certificate.index') }}" class="oui-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Back to events
            </a>
            <p class="oui-page-label">Certificate Claim</p>
            <h1 class="oui-page-title">Claim your certificate</h1>
            <p class="oui-page-desc">Complete the form below. Your certificate will be reviewed and delivered to your email once approved.</p>

            @if(isset($event))
            <div class="oui-event-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                {{ $event->name }}
                @if($event->date)
                    · {{ $event->date->format('d M Y') }}
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="oui-section">
        <div class="oui-layout">

            <div class="oui-main-col">
                <div class="oui-card">
                    <div class="oui-card-title">Claim form</div>
                    <p class="oui-card-sub">Enter your details and optional feedback. Fields marked * are required.</p>

                    @if (session('success'))
                        <div class="oui-alert oui-alert-success">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="oui-alert oui-alert-error">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="oui-alert oui-alert-error">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                            <div>
                                <span>Please fix the following errors:</span>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('certificate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(isset($event))
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                        @endif

                        <div class="oui-form-block">
                            <div class="oui-section-head">
                                <span class="oui-section-num">1</span>
                                <div>
                                    <h3>Participant details</h3>
                                    <p>Name and email for certificate delivery</p>
                                </div>
                            </div>
                            <div class="oui-grid-2">
                                <div class="oui-field">
                                    <label for="name" class="oui-label">Full name<span class="req">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="oui-input" placeholder="e.g. John Smith" required>
                                </div>
                                <div class="oui-field">
                                    <label for="email" class="oui-label">Email address<span class="req">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="oui-input" placeholder="you@email.com" required>
                                    <p class="oui-hint">Your certificate will be sent to this email</p>
                                </div>
                            </div>
                        </div>

                        @if(isset($certificateTypes) && $certificateTypes->count() > 0)
                        <div class="oui-form-block">
                            <div class="oui-section-head">
                                <span class="oui-section-num">2</span>
                                <div>
                                    <h3>Participation role<span class="req">*</span></h3>
                                    <p>Select the role you participated as in this event</p>
                                </div>
                            </div>
                            <div class="oui-radio-list">
                                @foreach($certificateTypes as $type)
                                <label class="oui-radio-option">
                                    <input type="radio" name="certificate_type_id" value="{{ $type->id }}" {{ old('certificate_type_id') == $type->id ? 'checked' : '' }} required>
                                    <div>
                                        <div class="oui-radio-title">{{ $type->name }}</div>
                                        @if($type->role_text && $type->role_text !== $type->name)
                                            <div class="oui-radio-sub">Certificate will show: <em>{{ $type->role_text }}</em></div>
                                        @endif
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($event) && $event->requires_attendance_proof)
                        <div class="oui-form-block">
                            <div class="oui-section-head">
                                <span class="oui-section-num">{{ $attendanceStep }}</span>
                                <div>
                                    <h3>Attendance Proof<span class="req">*</span></h3>
                                    <p>Capture your photo as proof of attendance</p>
                                </div>
                            </div>
                            <div class="oui-field">
                                <div id="camera-container" style="text-align:center;">
                                    <div id="camera-preview-container" style="position:relative; max-width:100%; margin-bottom:12px;">
                                        <video id="camera-video" autoplay playsinline style="width:100%; max-width:400px; border-radius:8px; display:none;"></video>
                                        <canvas id="camera-canvas" style="width:100%; max-width:400px; border-radius:8px; display:none;"></canvas>
                                        <img id="camera-photo" src="" alt="Captured photo" style="width:100%; max-width:400px; border-radius:8px; display:none;" />
                                    </div>
                                    <div id="camera-controls" style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                                        <button type="button" id="btn-start-camera" class="oui-btn-primary" style="display:inline-flex;align-items:center;gap:8px;padding:12px 20px;font-size:14px;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>
                                            </svg>
                                            Open Camera
                                        </button>
                                        <button type="button" id="btn-capture" class="oui-btn-primary" style="display:none;align-items:center;gap:8px;padding:12px 20px;font-size:14px;background:#8B5CF6;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            Capture Photo
                                        </button>
                                        <button type="button" id="btn-retake" class="oui-btn-primary" style="display:none;align-items:center;gap:8px;padding:12px 20px;font-size:14px;background:#6B7280;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>
                                            </svg>
                                            Retake
                                        </button>
                                    </div>
                                    <p id="camera-error" class="oui-hint" style="color:var(--danger);display:none;margin-top:12px;"></p>
                                    <p class="oui-hint" style="margin-top:8px;">Please allow camera access when prompted. Your photo will be used as proof of attendance.</p>
                                    <input type="hidden" name="attendance_photo" id="attendance_photo_input" required>
                                </div>
                            </div>
                        </div>

                        <script>
                        (function() {
                            const video = document.getElementById('camera-video');
                            const canvas = document.getElementById('camera-canvas');
                            const photo = document.getElementById('camera-photo');
                            const btnStart = document.getElementById('btn-start-camera');
                            const btnCapture = document.getElementById('btn-capture');
                            const btnRetake = document.getElementById('btn-retake');
                            const input = document.getElementById('attendance_photo_input');
                            const errorEl = document.getElementById('camera-error');
                            let stream = null;

                            function showError(msg) {
                                errorEl.textContent = msg;
                                errorEl.style.display = 'block';
                            }

                            function clearError() {
                                errorEl.style.display = 'none';
                            }

                            btnStart.addEventListener('click', async function() {
                                clearError();
                                try {
                                    stream = await navigator.mediaDevices.getUserMedia({
                                        video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } },
                                        audio: false
                                    });
                                    video.srcObject = stream;
                                    video.style.display = 'block';
                                    photo.style.display = 'none';
                                    btnStart.style.display = 'none';
                                    btnCapture.style.display = 'inline-flex';
                                    btnRetake.style.display = 'none';
                                } catch (err) {
                                    showError('Could not access camera. Please ensure you have granted camera permissions.');
                                    console.error('Camera error:', err);
                                }
                            });

                            btnCapture.addEventListener('click', function() {
                                if (!stream) return;
                                const ctx = canvas.getContext('2d');
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                                const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                                input.value = dataUrl;
                                photo.src = dataUrl;
                                video.style.display = 'none';
                                photo.style.display = 'block';
                                btnCapture.style.display = 'none';
                                btnRetake.style.display = 'inline-flex';
                                // Stop the camera stream
                                stream.getTracks().forEach(track => track.stop());
                                stream = null;
                            });

                            btnRetake.addEventListener('click', async function() {
                                clearError();
                                input.value = '';
                                photo.style.display = 'none';
                                try {
                                    stream = await navigator.mediaDevices.getUserMedia({
                                        video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } },
                                        audio: false
                                    });
                                    video.srcObject = stream;
                                    video.style.display = 'block';
                                    btnCapture.style.display = 'inline-flex';
                                    btnRetake.style.display = 'none';
                                } catch (err) {
                                    showError('Could not access camera. Please ensure you have granted camera permissions.');
                                    btnStart.style.display = 'inline-flex';
                                }
                            });
                        })();
                        </script>
                        @endif

                        <div class="oui-form-block">
                            <div class="oui-section-head">
                                <span class="oui-section-num">{{ $feedbackStep }}</span>
                                <div>
                                    <h3>Feedback</h3>
                                    <p>Optional — helps us improve future events</p>
                                </div>
                            </div>
                            <div class="oui-field">
                                <label for="message" class="oui-label">Message & impressions</label>
                                <textarea name="message" id="message" rows="4" class="oui-textarea" placeholder="Share your experience from this event...">{{ old('message') }}</textarea>
                            </div>
                            <div class="oui-field" style="margin-top:14px">
                                <label for="next_event" class="oui-label">Preferred next event</label>
                                <input type="text" name="next_event" id="next_event" value="{{ old('next_event') }}" class="oui-input" placeholder="Topics or types of events you'd like to attend">
                            </div>
                        </div>

                        <div class="oui-actions">
                            <button type="submit" class="oui-btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                                Submit certificate claim
                            </button>
                            <p class="oui-note">
                                Already submitted?
                                <a href="{{ route('certificate.track') }}">Track claim status</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="oui-side-col">
                <div class="oui-card oui-side-card">
                    <div class="oui-side-title">How it works</div>
                    <div class="oui-step">
                        <span class="oui-step-num">1</span>
                        <div>
                            <h5>Submit form</h5>
                            <p>Enter your details and submit your claim</p>
                        </div>
                    </div>
                    <div class="oui-step">
                        <span class="oui-step-num">2</span>
                        <div>
                            <h5>Admin review</h5>
                            <p>Verified within 24–48 hours</p>
                        </div>
                    </div>
                    <div class="oui-step">
                        <span class="oui-step-num">3</span>
                        <div>
                            <h5>Receive certificate</h5>
                            <p>PDF delivered to your email once approved</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('certificate.participant-dashboard') }}" class="oui-link-card">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                    </svg>
                    My certificates
                </a>
            </aside>

        </div>
    </div>
</div>
@endsection
