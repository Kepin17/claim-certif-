<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::active()->get();
        return view('certificates.events', compact('events'));
    }

    public function showClaimForm($slug)
    {
        $event = \App\Models\Event::where('slug', $slug)->firstOrFail();
        if (!$event->is_active) {
            return redirect()->route('certificate.index')
                ->with('error', 'This event is not currently accepting claims.');
        }
        return view('certificates.claim', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'event_id' => 'required|exists:events,id',
            'message' => 'nullable|string|max:1000',
            'next_event' => 'nullable|string|max:255',
            'proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $event = \App\Models\Event::findOrFail($validated['event_id']);

        // Check for duplicate claims (by email and event)
        $existing = Certificate::where('email', $validated['email'])
            ->where('event_id', $validated['event_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'A claim with this email already exists for this event.');
        }

        // Handle file upload
        $proofPath = null;
        if ($request->hasFile('proof_file')) {
            $proofPath = $request->file('proof_file')->store('proofs', 'public');
        }

        // Create certificate claim
        $certificate = Certificate::create([
            'event_id' => $validated['event_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'event' => $event->name,
            'message' => $validated['message'],
            'next_event' => $validated['next_event'],
            'proof_file' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('certificate.status', $certificate->unique_key)
            ->with('success', 'Certificate claim submitted successfully.');
    }

    public function status($uniqueKey)
    {
        $certificate = Certificate::byUniqueKey($uniqueKey)->firstOrFail();
        return view('certificates.status', compact('certificate'));
    }

    public function track(Request $request)
    {
        $certificate = null;
        $events = \App\Models\Event::active()->get();
        
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'event_id' => 'required|exists:events,id',
            ]);

            $certificate = Certificate::where('email', $request->email)
                ->where('event_id', $request->event_id)
                ->first();

            if ($certificate) {
                return redirect()->route('certificate.status', $certificate->unique_key);
            } else {
                return back()->with('error', 'No certificate claim found for this email and event.');
            }
        }

        return view('certificates.track', compact('certificate', 'events'));
    }

    public function download($certificateNumber)
    {
        // URL-decode the certificate number to handle slashes
        $certificateNumber = urldecode($certificateNumber);

        $certificate = Certificate::where('certificate_number', $certificateNumber)
            ->whereIn('status', ['generated', 'sent'])
            ->firstOrFail();

        $filePath = storage_path('app/public/' . $certificate->pdf_path);

        if (!file_exists($filePath)) {
            abort(404, 'Certificate file not found');
        }

        return response()->download($filePath, 'certificate-' . $certificate->certificate_number . '.pdf');
    }

    public function verify($certificateNumber)
    {
        // URL-decode the certificate number to handle slashes
        $certificateNumber = urldecode($certificateNumber);

        $certificate = Certificate::where('certificate_number', $certificateNumber)
            ->whereIn('status', ['generated', 'sent'])
            ->firstOrFail();

        return view('certificates.verify', compact('certificate'));
    }
}
