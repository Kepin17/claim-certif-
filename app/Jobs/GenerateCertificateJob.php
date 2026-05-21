<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateApproved;

class GenerateCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function handle(CertificateService $certificateService)
    {
        try {
            // Generate PDF
            $pdfPath = $certificateService->generateCertificate($this->certificate);

            // Generate QR code
            $qrCode = $certificateService->generateQRCode($this->certificate);

            // Update certificate
            $this->certificate->update([
                'status' => 'generated',
                'pdf_path' => $pdfPath,
                'qr_code' => $qrCode,
            ]);

            // Send email
            Mail::to($this->certificate->email)->send(new CertificateApproved($this->certificate));

            // Update status to sent
            $this->certificate->update(['status' => 'sent']);

        } catch (\Exception $e) {
            \Log::error('Certificate generation failed: ' . $e->getMessage());
            $this->certificate->update(['status' => 'approved']); // Revert to approved if failed
            throw $e;
        }
    }
}
