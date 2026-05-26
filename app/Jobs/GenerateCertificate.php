<?php

namespace App\Jobs;

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

    public function __construct(public Certificate $certificate) {}

    public function handle(): void
    {
        $certificate = $this->certificate->fresh(['eventRelation', 'certificateType']);

        if (!$certificate || !in_array($certificate->status, ['approved', 'generated'])) {
            Log::warning('GenerateCertificate job skipped', ['id' => $this->certificate->id, 'status' => $certificate?->status]);
            return;
        }

        try {
            $service = new CertificateService();
            $pdfPath = $service->generateCertificate($certificate);
            $qrCode  = $service->generateQRCode($certificate);

            $certificate->update([
                'status'   => 'generated',
                'pdf_path' => $pdfPath,
                'qr_code'  => $qrCode,
            ]);

            $certificate->refresh();

            Mail::to($certificate->email)->send(new \App\Mail\CertificateApproved($certificate));

            $certificate->update(['status' => 'sent']);

            \App\Http\Controllers\Admin\CertificateAdminController::clearDashboardCache();

            Log::info('GenerateCertificate job completed', ['id' => $certificate->id]);

        } catch (\Exception $e) {
            Log::error('GenerateCertificate job failed', [
                'id'    => $certificate->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('GenerateCertificate job permanently failed', [
            'id'    => $this->certificate->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
