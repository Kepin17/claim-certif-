<?php

namespace App\Jobs;

use App\Mail\CertificateApproved;
use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateCertificate implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public int $certificateId
    ) {}

    public function handle(): void
    {
        $certificate = Certificate::with([
            'eventRelation',
            'certificateType'
        ])->find($this->certificateId);

        if (!$certificate) {
            Log::warning('Certificate not found', [
                'id' => $this->certificateId
            ]);
            return;
        }

        if (!in_array($certificate->status, ['approved', 'generated'])) {
            Log::warning('GenerateCertificate job skipped', [
                'id' => $certificate->id,
                'status' => $certificate->status,
            ]);
            return;
        }

        try {
            $service = app(CertificateService::class);

            $pdfPath = $service->generateCertificate($certificate);
            $qrCode = $service->generateQRCode($certificate);

            $certificate->update([
                'status'   => 'generated',
                'pdf_path' => $pdfPath,
                'qr_code'  => $qrCode,
            ]);

            Mail::to($certificate->email)
                ->send(new CertificateApproved($certificate));

            $certificate->update([
                'status' => 'sent'
            ]);

            \App\Http\Controllers\Admin\CertificateAdminController::clearDashboardCache();

            Log::info('GenerateCertificate job completed', [
                'id' => $certificate->id,
            ]);

        } catch (\Throwable $e) {
            Log::error('GenerateCertificate job failed', [
                'id' => $certificate->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('GenerateCertificate job permanently failed', [
            'id' => $this->certificateId,
            'message' => $exception->getMessage(),
        ]);
    }
}