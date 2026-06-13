<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\CertificateAdminController;
use App\Http\Controllers\Admin\UserController;

// User Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Admin\AuthController::class, 'showUserProfile'])->name('user.profile');
    Route::put('/profile', [\App\Http\Controllers\Admin\AuthController::class, 'updateUserProfile'])->name('user.profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\AuthController::class, 'updateUserPassword'])->name('user.password.update');
    Route::post('/profile/verify-email', [\App\Http\Controllers\Admin\AuthController::class, 'verifyEmailChange'])->name('user.profile.verify-email');
});

// User Routes
Route::get('/', [CertificateController::class, 'index'])->name('certificate.index');
Route::get('/track-certificate', [CertificateController::class, 'track'])->name('certificate.track');
Route::post('/track-certificate', [CertificateController::class, 'track'])->name('certificate.track.submit')->middleware('throttle:10,1');
Route::get('/certificate-status/{uniqueKey}', [CertificateController::class, 'status'])->name('certificate.status')->middleware('throttle:30,1');

// Protected User Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/claim-certificate/{slug}', [CertificateController::class, 'showClaimForm'])->name('certificate.claim-form');
    Route::post('/claim-certificate', [CertificateController::class, 'store'])->name('certificate.store')->middleware('throttle:5,1');
    Route::get('/my-certificates', [CertificateController::class, 'participantDashboard'])->name('certificate.participant-dashboard');
});
Route::get('/download-certificate', [CertificateController::class, 'download'])->name('certificate.download')->middleware('throttle:20,1');
Route::get('/download-certificate/{certificateNumber}', function($certificateNumber) {
    return redirect()->route('certificate.download', ['number' => $certificateNumber]);
})->where('certificateNumber', '.*')->name('certificate.download.legacy');
Route::get('/verify', [CertificateController::class, 'verify'])->name('certificate.verify')->middleware('throttle:30,1');
Route::get('/verify/{certificateNumber}', function($certificateNumber) {
    return redirect()->route('certificate.verify', ['number' => $certificateNumber]);
})->where('certificateNumber', '.*')->name('certificate.verify.legacy');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/dashboard', [CertificateAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending', [CertificateAdminController::class, 'pending'])->name('pending');
    Route::get('/pending/event/{eventId}', [CertificateAdminController::class, 'pendingByEvent'])->name('pending.by-event');
    Route::get('/rejected', [CertificateAdminController::class, 'rejected'])->name('rejected');
    Route::get('/rejected/event/{eventId}', [CertificateAdminController::class, 'rejectedByEvent'])->name('rejected.by-event');
    Route::get('/generated', [CertificateAdminController::class, 'generated'])->name('generated');
    Route::get('/generated/event/{eventId}', [CertificateAdminController::class, 'generatedByEvent'])->name('generated.by-event');
    Route::get('/certificate/{id}', [CertificateAdminController::class, 'show'])->name('show');
    Route::post('/certificate/{id}/approve', [CertificateAdminController::class, 'approve'])->name('approve');
    Route::post('/certificate/{id}/reject', [CertificateAdminController::class, 'reject'])->name('reject');
    Route::get('/certificate/{id}/preview', [CertificateAdminController::class, 'preview'])->name('preview');
    Route::post('/certificate/{id}/regenerate', [CertificateAdminController::class, 'regenerate'])->name('regenerate');
    Route::post('/certificate/{id}/resend-email', [CertificateAdminController::class, 'resendEmail'])->name('resend-email');
    Route::delete('/certificate/{id}', [CertificateAdminController::class, 'destroy'])->name('destroy');
    Route::post('/certificate/{id}/reset-to-pending', [CertificateAdminController::class, 'resetToPending'])->name('reset-to-pending');
    Route::post('/bulk-approve', [CertificateAdminController::class, 'bulkApprove'])->name('bulk-approve');
    Route::post('/bulk-reject', [CertificateAdminController::class, 'bulkReject'])->name('bulk-reject');
    Route::get('/export/{eventId}', [CertificateAdminController::class, 'exportCsv'])->name('export');
    Route::get('/activity-log', [CertificateAdminController::class, 'activityLog'])->name('activity-log');
    Route::get('/search', [CertificateAdminController::class, 'search'])->name('search');
    Route::get('/manual-create', [CertificateAdminController::class, 'createManual'])->name('manual-create');
    Route::post('/manual-create', [CertificateAdminController::class, 'storeManual'])->name('manual-create.store');
    Route::post('/certificate/{id}/send-manual', [CertificateAdminController::class, 'sendManual'])->name('send-manual');

    // User Management Routes (superadmin only)
    Route::prefix('users')->name('users.')->middleware('superadmin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle-active');
    });

    // Event Management Routes
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\EventController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\EventController::class, 'store'])->name('store');
        Route::get('/{event}', [\App\Http\Controllers\Admin\EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [\App\Http\Controllers\Admin\EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [\App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/toggle', [\App\Http\Controllers\Admin\EventController::class, 'toggleStatus'])->name('toggle');
    });
});

// Shared Login Route (for both admin and regular users)
Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/check-email', [\App\Http\Controllers\Admin\AuthController::class, 'checkEmail'])->name('check.email');
Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// OTP Verification Routes (for admin users)
Route::get('/otp/verify', [\App\Http\Controllers\Admin\AuthController::class, 'showOTPVerify'])->name('otp.verify');
Route::post('/otp/verify', [\App\Http\Controllers\Admin\AuthController::class, 'verifyOTP'])->name('otp.verify.post');
Route::get('/otp/resend', [\App\Http\Controllers\Admin\AuthController::class, 'resendOTP'])->name('otp.resend');
