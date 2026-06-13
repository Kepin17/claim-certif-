<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::active()
            ->withCount('certificates')
            ->orderByDesc('date')
            ->paginate(20);

        return view('certificates.events', compact('events'));
    }

    public function showClaimForm($slug)
    {
        $event = \App\Models\Event::where('slug', $slug)
            ->with('activeCertificateTypes')
            ->firstOrFail();

        if (!$event->is_active) {
            return redirect()->route('certificate.index')
                ->with('error', 'This event is not currently accepting claims.');
        }
        if (!$event->isClaimOpen()) {
            return redirect()->route('certificate.index')
                ->with('error', 'The claim deadline for this event has passed.');
        }

        $certificateTypes = $event->activeCertificateTypes;
        $user = auth()->user();
        
        return view('certificates.claim', compact('event', 'certificateTypes', 'user'));
    }

    public function store(Request $request)
    {
        $event = \App\Models\Event::with('activeCertificateTypes')->findOrFail($request->input('event_id'));

        $rules = [
            'name'                  => 'required|string|max:255',
            'email'                 => 'nullable|email|max:255',
            'event_id'              => 'required|exists:events,id',
            'certificate_type_id'   => 'nullable|exists:certificate_types,id',
            'message'               => 'nullable|string|max:1000',
            'next_event'            => 'nullable|string|max:255',
            'proof_file'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'attendance_photo'      => 'nullable|string',
            'payment_proof'         => $event->requires_payment_proof ? 'required|file|mimes:pdf,jpg,jpeg,png|max:5120' : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        $validated = $request->validate($rules);

        $event = \App\Models\Event::with('activeCertificateTypes')->findOrFail($validated['event_id']);

        if (!$event->isClaimOpen()) {
            return back()->with('error', 'The claim deadline for this event has passed.');
        }

        // Validate type belongs to the event if provided
        $certType = null;
        if (!empty($validated['certificate_type_id'])) {
            $certType = $event->activeCertificateTypes->find($validated['certificate_type_id']);
            if (!$certType) {
                return back()->with('error', 'Invalid certificate type selected.')->withInput();
            }
        } elseif ($event->activeCertificateTypes->count() > 0) {
            return back()->with('error', 'Please select a certificate type.')->withInput();
        }

        // Block duplicate: only if active (non-rejected) claim exists for same email+event+type
        $existing = Certificate::where('email', $validated['email'])
            ->where('event_id', $validated['event_id'])
            ->when($certType, fn($q) => $q->where('certificate_type_id', $certType->id))
            ->whereNotIn('status', ['rejected'])
            ->first();

        if ($existing) {
            return back()->with('error', 'An active claim with this email already exists for this event.');
        }

        // Handle file upload
        $proofPath = null;
        if ($request->hasFile('proof_file')) {
            $proofPath = $request->file('proof_file')->store('proofs', 'public');
        }

        // Handle attendance photo from camera (base64)
        $attendancePhotoPath = null;
        if ($event->requires_attendance_proof && $request->filled('attendance_photo')) {
            $attendancePhotoPath = $this->saveBase64Image($request->input('attendance_photo'), 'attendance-photos');
        }

        // Handle payment proof file upload
        $paymentProofPath = null;
        if ($event->requires_payment_proof && $request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        // Get authenticated user's email
        $userEmail = auth()->user()->email;

        $certificate = Certificate::create([
            'event_id'              => $validated['event_id'],
            'certificate_type_id'   => $certType?->id,
            'certificate_type_name' => $certType?->name,
            'name'                  => $validated['name'],
            'email'                 => $userEmail,
            'event'                 => $event->name,
            'message'               => $validated['message'],
            'next_event'            => $validated['next_event'],
            'proof_file'            => $proofPath,
            'attendance_photo'      => $attendancePhotoPath,
            'payment_proof'         => $paymentProofPath,
            'status'                => 'pending',
        ]);

        return redirect()->route('certificate.status', $certificate->unique_key)
            ->with('success', 'Certificate claim submitted successfully.');
    }

    public function status($uniqueKey)
    {
        $certificate = Certificate::byUniqueKey($uniqueKey)
            ->with('eventRelation')
            ->firstOrFail();
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

    public function participantDashboard(Request $request)
    {
        $user = auth()->user();
        $email = $user->email;
        
        $certificates = Certificate::where('email', $email)
            ->with('eventRelation')
            ->latest()
            ->paginate(12);

        return view('certificates.participant-dashboard', compact('email', 'certificates'));
    }

    public function download(Request $request)
    {
        $uniqueKey = $request->query('key');

        if (!$uniqueKey) {
            abort(404, 'Certificate key is required');
        }

        // Handle double-encoded URLs (Gmail redirects)
        $uniqueKey = urldecode($uniqueKey);

        $certificate = Certificate::where('unique_key', $uniqueKey)
            ->whereIn('status', ['generated', 'sent'])
            ->firstOrFail();

        $filePath = storage_path('app/public/' . $certificate->pdf_path);

        if (!file_exists($filePath)) {
            abort(404, 'Certificate file not found');
        }

        return response()->download($filePath, 'certificate-' . str_replace(['/', '\\'], '-', $certificate->certificate_number) . '.pdf');
    }

    public function verify(Request $request)
    {
        $certificateNumber = $request->query('number');

        if (!$certificateNumber) {
            abort(404, 'Certificate number is required');
        }

        // Handle double-encoded URLs (Gmail redirects)
        $certificateNumber = urldecode($certificateNumber);

        $certificate = Certificate::where('certificate_number', $certificateNumber)
            ->whereIn('status', ['generated', 'sent'])
            ->firstOrFail();

        return view('certificates.verify', compact('certificate'));
    }

    private function saveBase64Image(string $base64Data, string $folder): string
    {
        // Extract the actual base64 content (remove data:image/xxx;base64, prefix)
        if (str_contains($base64Data, ',')) {
            $base64Data = explode(',', $base64Data)[1];
        }

        $imageData = base64_decode($base64Data);
        $filename = Str::random(20) . '.jpg';
        $path = $folder . '/' . $filename;

        Storage::disk('public')->put($path, $imageData);

        return $path;
    }
}
