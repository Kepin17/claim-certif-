<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Certificate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CertificateAdminController extends Controller
{
    public function dashboard()
    {
        $stats = Cache::remember('admin.dashboard.stats', 300, function () {
            return [
                'pendingCount'   => Certificate::pending()->count(),
                'generatedCount' => Certificate::whereIn('status', ['generated', 'sent'])->count(),
                'rejectedCount'  => Certificate::rejected()->count(),
                'eventsCount'    => Event::count(),
                'totalClaims'    => Certificate::count(),
            ];
        });

        $recentPending = Certificate::pending()
            ->with('event')
            ->whereDate('created_at', today())
            ->latest()
            ->limit(5)
            ->get();

        $recentLogs = AdminActivityLog::whereDate('created_at', today())
            ->latest()
            ->limit(10)
            ->get();
            
        $allEvents = Event::latest()->get();

        return view('admin.dashboard', array_merge($stats, compact('recentPending', 'recentLogs', 'allEvents')));
    }

    public static function clearDashboardCache(): void
    {
        Cache::forget('admin.dashboard.stats');
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

    private function generateCertificateNumber(Certificate $certificate): string
    {
        $event = $certificate->eventRelation ?? \App\Models\Event::find($certificate->event_id);

        // Type-level prefix takes priority
        $prefix = $certificate->certificateType?->certificate_number_prefix
            ?? $event?->certificate_number_prefix;

        if (!empty($prefix)) {
            $year     = date('Y');
            $sequence = Certificate::whereYear('created_at', $year)
                ->whereNotNull('certificate_number')
                ->count() + 1;
            return sprintf('%s-%s-%04d', $prefix, $year, $sequence);
        }

        $eventCode = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $certificate->event), 0, 3)) ?: 'CRT';
        $year      = date('Y');
        $sequence  = Certificate::whereYear('created_at', $year)
            ->whereNotNull('certificate_number')
            ->count() + 1;
        return sprintf('%s-%s-%04d', $eventCode, $year, $sequence);
    }

    public function approve(Request $request, $id)
    {
        $certificate = Certificate::with(['eventRelation', 'certificateType'])->lockForUpdate()->findOrFail($id);

        $certificateNumber = $this->generateCertificateNumber($certificate);

        $certificate->update([
            'status'             => 'approved',
            'certificate_number' => $certificateNumber,
            'approved_by'        => Auth::user()->name,
            'approved_at'        => now(),
        ]);

        \App\Jobs\GenerateCertificate::dispatch($certificate->id);

        AdminActivityLog::record('approved', $certificate);

        return redirect()->route('admin.pending')
            ->with('success', 'Certificate approved — generation queued for ' . $certificate->email . '.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $certificate = Certificate::lockForUpdate()->findOrFail($id);
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

        $certificate->update(['status' => 'approved']);
        \App\Jobs\GenerateCertificate::dispatch($certificate->id);

        return back()->with('success', 'Certificate queued for regeneration — email will be resent to ' . $certificate->email);
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

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);

        if (!in_array($certificate->status, ['generated', 'sent'])) {
            return back()->with('error', 'Only generated certificates can be deleted.');
        }

        // Delete PDF file if exists
        if ($certificate->pdf_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($certificate->pdf_path);
        }

        // Delete attendance photo if exists
        if ($certificate->attendance_photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($certificate->attendance_photo);
        }

        // Delete proof file if exists
        if ($certificate->proof_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($certificate->proof_file);
        }

        $email = $certificate->email;
        $eventName = $certificate->event;

        AdminActivityLog::record('deleted_generated', $certificate);
        $certificate->delete();

        return back()->with('success', "Certificate for {$email} has been deleted. User can now re-claim with the same email for event: {$eventName}");
    }

    public function bulkApprove(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:certificates,id']);

        $certificates = Certificate::with(['eventRelation', 'certificateType'])
            ->whereIn('id', $request->ids)
            ->where('status', 'pending')
            ->get();

        $count = 0;
        foreach ($certificates as $certificate) {
            $locked = Certificate::lockForUpdate()->find($certificate->id);
            if (!$locked) continue;
            $certificateNumber = $this->generateCertificateNumber($locked);
            $locked->update([
                'status'             => 'approved',
                'certificate_number' => $certificateNumber,
                'approved_by'        => Auth::user()->name,
                'approved_at'        => now(),
            ]);
            \App\Jobs\GenerateCertificate::dispatch($locked->fresh());
            AdminActivityLog::record('bulk_approved', $locked);
            $count++;
        }

        return redirect()->back()
            ->with('success', $count . ' certificate(s) approved — generation queued.');
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
            $locked = Certificate::lockForUpdate()->find($certificate->id);
            if (!$locked) continue;
            $locked->update([
                'status'           => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'approved_by'      => Auth::user()->name,
                'approved_at'      => now(),
            ]);
            try {
                Mail::to($locked->email)->send(new \App\Mail\CertificateRejected($locked));
            } catch (\Exception $e) {
                Log::error('Bulk reject email failed: ' . $e->getMessage());
            }
            AdminActivityLog::record('bulk_rejected', $locked, $request->rejection_reason);
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
            ->paginate(15);

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

    public function quickGenerate(Request $request, $eventId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'certificate_type_id' => 'nullable|exists:certificate_types,id',
        ]);

        $event = Event::findOrFail($eventId);

        $certificate = Certificate::create([
            'event_id' => $eventId,
            'name' => $request->name,
            'email' => $request->email,
            'event' => $event->name,
            'certificate_type_id' => $request->certificate_type_id,
            'status' => 'approved',
            'certificate_number' => $this->generateCertificateNumber(new Certificate(['event_id' => $eventId, 'event' => $event->name])),
            'approved_by' => Auth::user()->name,
            'approved_at' => now(),
        ]);

        // Generate PDF immediately (sync)
        \App\Jobs\GenerateCertificate::dispatchSync($certificate->id);

        // Send email immediately
        try {
            Mail::to($certificate->email)->send(new \App\Mail\CertificateApproved($certificate));
            $certificate->update(['status' => 'sent']);
        } catch (\Exception $e) {
            Log::error('Quick generate email failed: ' . $e->getMessage());
        }

        AdminActivityLog::record('quick_generated', $certificate);

        return back()->with('success', 'Certificate generated and sent to ' . $request->email);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_sertifikat.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['email', 'nama lengkap']);
            fputcsv($file, ['peserta@example.com', 'Budi Santoso']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'file' => 'required|file|max:10240',
        ]);

        $event = Event::findOrFail($request->event_id);
        $file = $request->file('file');
        
        $path = $file->getRealPath();
        
        // Read CSV
        $content = file_get_contents($path);
        $lines = explode(PHP_EOL, $content);
        $data = array_filter(array_map('str_getcsv', $lines));
        
        if (empty($data)) {
            return back()->with('error', 'File kosong atau tidak dapat dibaca.');
        }

        // Remove header
        $header = array_shift($data);
        
        $emailIdx = array_search('email', array_map('strtolower', $header));
        $nameIdx = array_search('nama lengkap', array_map('strtolower', $header));

        if ($emailIdx === false) $emailIdx = 0;
        if ($nameIdx === false) $nameIdx = 1;
        
        $count = 0;
        foreach ($data as $row) {
            if (count($row) < 2) continue;
            
            $email = trim($row[$emailIdx] ?? '');
            $name = trim($row[$nameIdx] ?? '');
            
            if (empty($email) || empty($name)) continue;
            
            $certificate = Certificate::create([
                'event_id' => $event->id,
                'name' => $name,
                'email' => $email,
                'event' => $event->name,
                'status' => 'approved',
                'certificate_number' => $this->generateCertificateNumber(new Certificate(['event_id' => $event->id, 'event' => $event->name])),
                'approved_by' => Auth::user()->name,
                'approved_at' => now(),
            ]);

            \App\Jobs\GenerateCertificate::dispatch($certificate->id);
            AdminActivityLog::record('quick_generated', $certificate);
            $count++;
        }

        return back()->with('success', $count . ' Sertifikat berhasil diimpor dan sedang diproses.');
    }
}
