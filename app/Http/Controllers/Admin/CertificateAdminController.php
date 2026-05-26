<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
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
        $pendingCount   = Certificate::pending()->count();
        $generatedCount = Certificate::whereIn('status', ['generated', 'sent'])->count();
        $rejectedCount  = Certificate::rejected()->count();
        $eventsCount    = Event::count();
        $totalClaims    = Certificate::count();

        $recentPending = Certificate::pending()
            ->with('event')
            ->latest()
            ->limit(5)
            ->get();

        $recentLogs = AdminActivityLog::latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'pendingCount', 'generatedCount', 'rejectedCount',
            'eventsCount', 'totalClaims', 'recentPending', 'recentLogs'
        ));
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

            AdminActivityLog::record('approved', $certificate);

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

        AdminActivityLog::record('rejected', $certificate, $request->rejection_reason);

        return redirect()->route('admin.pending')
            ->with('success', 'Certificate rejected.');
    }

    public function resetToPending(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        if ($certificate->status !== 'rejected') {
            return redirect()->back()->with('error', 'Only rejected claims can be reset.');
        }

        $certificate->update([
            'status' => 'pending',
            'rejection_reason' => null,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        try {
            Mail::to($certificate->email)->send(new \App\Mail\CertificateResetToPending($certificate));
        } catch (\Exception $e) {
            Log::error('Reset to pending email failed: ' . $e->getMessage());
        }

        AdminActivityLog::record('reset_to_pending', $certificate);

        return redirect()->route('admin.pending')
            ->with('success', 'Claim has been re-opened and user has been notified via email.');
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
            AdminActivityLog::record('resent_email', $certificate);
            return back()->with('success', 'Email resent to ' . $certificate->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Email resend failed: ' . $e->getMessage());
        }
    }

    public function bulkApprove(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:certificates,id']);

        $certificates = Certificate::whereIn('id', $request->ids)->where('status', 'pending')->get();
        $success = 0;
        $errors = [];

        foreach ($certificates as $certificate) {
            try {
                $service = new CertificateService();
                $pdfPath = $service->generateCertificate($certificate);
                $qrCode  = $service->generateQRCode($certificate);
                $certificate->update([
                    'status'      => 'generated',
                    'pdf_path'    => $pdfPath,
                    'qr_code'     => $qrCode,
                    'approved_by' => Auth::user()->name,
                    'approved_at' => now(),
                ]);
                $certificate->refresh();
                Mail::to($certificate->email)->send(new \App\Mail\CertificateApproved($certificate));
                $certificate->update(['status' => 'sent']);
                AdminActivityLog::record('bulk_approved', $certificate);
                $success++;
            } catch (\Exception $e) {
                $errors[] = $certificate->name . ': ' . $e->getMessage();
                Log::error('Bulk approve failed for ' . $certificate->id . ': ' . $e->getMessage());
            }
        }

        $msg = $success . ' certificate(s) approved and sent.';
        if ($errors) $msg .= ' ' . count($errors) . ' failed.';

        return redirect()->back()->with('success', $msg);
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids'              => 'required|array',
            'ids.*'            => 'integer|exists:certificates,id',
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $certificates = Certificate::whereIn('id', $request->ids)->where('status', 'pending')->get();
        $count = 0;

        foreach ($certificates as $certificate) {
            $certificate->update([
                'status'           => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'approved_by'      => Auth::user()->name,
                'approved_at'      => now(),
            ]);
            try {
                Mail::to($certificate->email)->send(new \App\Mail\CertificateRejected($certificate));
            } catch (\Exception $e) {
                Log::error('Bulk reject email failed: ' . $e->getMessage());
            }
            AdminActivityLog::record('bulk_rejected', $certificate, $request->rejection_reason);
            $count++;
        }

        return redirect()->back()->with('success', $count . ' claim(s) rejected.');
    }

    public function exportCsv(Request $request, $eventId)
    {
        $event  = Event::findOrFail($eventId);
        $status = $request->query('status', 'generated');

        $query = Certificate::where('event_id', $eventId);
        if ($status === 'generated') {
            $query->whereIn('status', ['generated', 'sent']);
        } else {
            $query->where('status', $status);
        }
        $certificates = $query->latest()->get();

        $filename = strtolower(str_replace(' ', '-', $event->name)) . '-' . $status . '-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = ['Name', 'Email', 'Certificate Number', 'Status', 'Submitted At', 'Processed At', 'Processed By', 'Rejection Reason'];

        $callback = function () use ($certificates, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($certificates as $cert) {
                fputcsv($file, [
                    $cert->name,
                    $cert->email,
                    $cert->certificate_number ?? '-',
                    $cert->status,
                    $cert->created_at->format('Y-m-d H:i'),
                    $cert->approved_at ? $cert->approved_at->format('Y-m-d H:i') : '-',
                    $cert->approved_by ?? '-',
                    $cert->rejection_reason ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function activityLog(Request $request)
    {
        $logs = AdminActivityLog::with('certificate')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('admin_name', 'like', '%' . $request->search . '%')
                      ->orWhere('certificate_name', 'like', '%' . $request->search . '%')
                      ->orWhere('event_name', 'like', '%' . $request->search . '%')
                      ->orWhere('action', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->latest()
            ->paginate(30);

        return view('admin.activity-log', compact('logs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return view('admin.search', ['results' => collect(), 'query' => $query]);
        }

        $results = Certificate::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%')
                  ->orWhere('certificate_number', 'like', '%' . $query . '%')
                  ->orWhere('event', 'like', '%' . $query . '%');
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.search', compact('results', 'query'));
    }
}
