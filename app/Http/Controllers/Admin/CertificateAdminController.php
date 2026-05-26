<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Event;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CertificateAdminController extends Controller
{
    public function dashboard()
    {
        $pendingCount = Certificate::pending()->count();
        $generatedCount = Certificate::whereIn('status', ['generated', 'sent'])->count();
        $rejectedCount = Certificate::rejected()->count();
        $eventsCount = Event::count();
        
        return view('admin.dashboard', compact('pendingCount', 'generatedCount', 'rejectedCount', 'eventsCount'));
    }

    public function pending()
    {
        // Get events that have pending certificates
        $events = Event::whereHas('certificates', function($query) {
            $query->where('status', 'pending');
        })->withCount(['certificates' => function($query) {
            $query->where('status', 'pending');
        }])->latest()->paginate(10);
        return view('admin.pending', compact('events'));
    }

    public function pendingByEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $certificates = Certificate::where('event_id', $eventId)
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);
        return view('admin.pending-by-event', compact('event', 'certificates'));
    }

    public function rejected()
    {
        $events = Event::whereHas('certificates', function($query) {
            $query->where('status', 'rejected');
        })->withCount(['certificates' => function($query) {
            $query->where('status', 'rejected');
        }])->latest()->paginate(10);
        return view('admin.rejected', compact('events'));
    }

    public function rejectedByEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $certificates = Certificate::where('event_id', $eventId)
            ->where('status', 'rejected')
            ->latest()
            ->paginate(20);
        return view('admin.rejected-by-event', compact('event', 'certificates'));
    }

    public function generated()
    {
        // Get events that have generated/sent certificates
        $events = Event::whereHas('certificates', function($query) {
            $query->whereIn('status', ['generated', 'sent']);
        })->withCount(['certificates' => function($query) {
            $query->whereIn('status', ['generated', 'sent']);
        }])->latest()->paginate(10);

        return view('admin.generated', compact('events'));
    }

    public function generatedByEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $certificates = Certificate::where('event_id', $eventId)
            ->whereIn('status', ['generated', 'sent'])
            ->latest()
            ->paginate(20);

        return view('admin.generated-by-event', compact('event', 'certificates'));
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.show', compact('certificate'));
    }

    public function approve(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        // Generate certificate number
        $event = $certificate->eventRelation;
        if (!empty($event->certificate_number_prefix)) {
            // Use fixed prefix from event
            $certificateNumber = $event->certificate_number_prefix;
        } else {
            // Use auto-generated format
            $eventCode = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $certificate->event), 0, 3)) ?: 'CRT';
            $year = date('Y');
            $sequence = Certificate::whereYear('created_at', $year)->count() + 1;
            $certificateNumber = sprintf('%s-%s-%04d', $eventCode, $year, $sequence);
        }

        $certificate->update([
            'status' => 'approved',
            'certificate_number' => $certificateNumber,
            'approved_by' => Auth::user()->name,
            'approved_at' => now(),
        ]);

        $certificate->refresh();

        // Generate certificate and send email synchronously
        try {
            $service = new CertificateService();

            Log::info('Generating certificate for', ['certificate_id' => $certificate->id, 'certificate_number' => $certificateNumber]);

            $pdfPath = $service->generateCertificate($certificate);
            $qrCode = $service->generateQRCode($certificate);

            Log::info('Certificate generated successfully', ['pdf_path' => $pdfPath, 'qr_code' => $qrCode]);

            $certificate->update([
                'status' => 'generated',
                'pdf_path' => $pdfPath,
                'qr_code' => $qrCode,
            ]);

            $certificate->refresh();

            Mail::to($certificate->email)->send(new \App\Mail\CertificateApproved($certificate));

            Log::info('Email sent successfully', ['email' => $certificate->email]);

            $certificate->update(['status' => 'sent']);

            return redirect()->route('admin.generated')
                ->with('success', 'Certificate approved, generated, and sent to ' . $certificate->email . '!');

        } catch (\Exception $e) {
            Log::error('Certificate generation failed', [
                'certificate_id' => $certificate->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.generated')
                ->with('warning', 'Certificate approved but generation failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $certificate = Certificate::findOrFail($id);
        $certificate->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => Auth::user()->name,
            'approved_at' => now(),
        ]);

        // Send rejection email
        try {
            Mail::to($certificate->email)->send(new \App\Mail\CertificateRejected($certificate));
        } catch (\Exception $e) {
            Log::error('Rejection email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.pending')
            ->with('success', 'Certificate rejected.');
    }

    public function preview($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.preview', compact('certificate'));
    }

    public function regenerate($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        if (!in_array($certificate->status, ['generated', 'sent'])) {
            return back()->with('error', 'Only generated certificates can be regenerated.');
        }

        try {
            $service = new CertificateService();
            $pdfPath = $service->generateCertificate($certificate);
            $qrCode = $service->generateQRCode($certificate);
            $certificate->update(['pdf_path' => $pdfPath, 'qr_code' => $qrCode]);
            $certificate->refresh();
            Mail::to($certificate->email)->send(new \App\Mail\CertificateApproved($certificate));
            return back()->with('success', 'Certificate regenerated and resent to ' . $certificate->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Regeneration failed: ' . $e->getMessage());
        }
    }

    public function resendEmail($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        if (!in_array($certificate->status, ['generated', 'sent'])) {
            return back()->with('error', 'Only generated certificates can have emails resent.');
        }

        try {
            Mail::to($certificate->email)->send(new \App\Mail\CertificateApproved($certificate));
            return back()->with('success', 'Email resent to ' . $certificate->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Email resend failed: ' . $e->getMessage());
        }
    }
}
