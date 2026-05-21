<?php

namespace App\Services;

use App\Models\Certificate;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public function generateCertificate(Certificate $certificate)
    {
        // Check if the event has a custom template image
        $event = $certificate->eventRelation ?? \App\Models\Event::find($certificate->event_id);
        if ($event && $event->certificate_template) {
            $templatePath = storage_path('app/public/' . $event->certificate_template);
            if (file_exists($templatePath)) {
                return $this->generateFromTemplate($certificate, $event, $templatePath);
            }
        }

        // Fall back to built-in HTML/PDF template
        $html = '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body { margin: 0; padding: 0; font-family: Georgia, serif; background: #fff; }
  .page { width: 297mm; height: 210mm; padding: 15mm; box-sizing: border-box;
          border: 12px solid #1a365d; position: relative; background: #fafafa; }
  .inner-border { position: absolute; top: 8mm; left: 8mm; right: 8mm; bottom: 8mm;
                  border: 2px solid #d4af37; pointer-events: none; }
  .header { text-align: center; margin-bottom: 8mm; }
  .header h1 { font-size: 38px; color: #1a365d; margin: 0; letter-spacing: 4px; text-transform: uppercase; }
  .header p { font-size: 14px; color: #666; margin: 4px 0 0; }
  .divider { width: 60%; margin: 5mm auto; border: none; border-top: 2px solid #d4af37; }
  .body { text-align: center; margin: 5mm 0; }
  .body .presented { font-size: 14px; color: #555; margin-bottom: 4mm; }
  .body .name { font-size: 36px; color: #1a365d; font-weight: bold; letter-spacing: 2px;
                border-bottom: 2px solid #d4af37; display: inline-block; padding-bottom: 2mm;
                margin-bottom: 5mm; }
  .body .description { font-size: 14px; color: #555; margin-bottom: 3mm; }
  .body .event-name { font-size: 20px; color: #2d3748; font-style: italic; margin-bottom: 3mm; }
  .body .date-text { font-size: 13px; color: #666; }
  .footer { position: absolute; bottom: 15mm; left: 15mm; right: 15mm;
            display: flex; justify-content: space-between; align-items: flex-end; }
  .cert-number { font-size: 11px; color: #888; font-family: monospace; }
  .signature { text-align: center; }
  .sig-line { width: 50mm; border-top: 1px solid #333; margin-bottom: 3px; }
  .sig-label { font-size: 12px; color: #555; }
</style>
</head>
<body>
<div class="page">
  <div class="inner-border"></div>
  <div class="header">
    <h1>Certificate of Completion</h1>
    <p>This certificate is proudly presented to</p>
  </div>
  <hr class="divider">
  <div class="body">
    <div class="presented">This is to certify that</div>
    <div class="name">' . htmlspecialchars($certificate->name) . '</div>
    <div class="description">has successfully participated in</div>
    <div class="event-name">' . htmlspecialchars($certificate->event) . '</div>
    <div class="date-text">on ' . $certificate->created_at->format('d F Y') . '</div>
  </div>
  <div class="footer">
    <div class="cert-number">Certificate No: ' . htmlspecialchars($certificate->certificate_number) . '</div>
    <div class="signature">
      <div class="sig-line"></div>
      <div class="sig-label">Event Organizer</div>
    </div>
  </div>
</div>
</body>
</html>';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'certificate-' . $certificate->certificate_number . '.pdf';
        $path = 'certificates/' . $filename;

        Storage::disk('public')->put($path, $dompdf->output());

        return $path;
    }

    private function generateFromTemplate(Certificate $certificate, \App\Models\Event $event, string $templatePath): string
    {
        // Embed the template image as base64 in HTML, overlay text using absolute positioning
        $imageData = base64_encode(file_get_contents($templatePath));
        $mimeType = mime_content_type($templatePath);

        // Convert top% to mm so DOMPDF doesn't miscalculate % inside nested absolute containers
        // A4 landscape height = 210mm
        $nameTopMm  = round(($event->overlay_name_top ?? 40) / 100 * 210, 2);
        $roleTopMm  = round(($event->overlay_role_top ?? 52) / 100 * 210, 2);
        // Font size stored as CSS px; DOMPDF at 96dpi treats them correctly
        $nameSizePx = $event->overlay_name_size ?? 26;
        $roleSizePx = $event->overlay_role_size ?? 20;

        $html = '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; }
  body { margin: 0; padding: 0; width: 297mm; height: 210mm; }
  .wrap { position: relative; width: 297mm; height: 210mm; }
  /* DOMPDF does not support object-fit — use absolute fill instead */
  .bg-img { position: absolute; top: 0; left: 0; width: 297mm; height: 210mm; }
  .overlay { position: absolute; top: 0; left: 0; width: 297mm; height: 210mm; }
  .name {
    position: absolute;
    top: ' . $nameTopMm . 'mm;
    left: 0;
    width: 297mm;
    text-align: center;
    font-family: Arial, sans-serif;
    font-size: ' . $nameSizePx . 'px;
    font-weight: bold;
    color: ' . htmlspecialchars($event->overlay_name_color ?? '#1a2e6e') . ';
    letter-spacing: 1px;
  }
  .role {
    position: absolute;
    top: ' . $roleTopMm . 'mm;
    left: 0;
    width: 297mm;
    text-align: center;
    font-family: Arial, sans-serif;
    font-size: ' . $roleSizePx . 'px;
    font-weight: bold;
    color: ' . htmlspecialchars($event->overlay_role_color ?? '#1a2e6e') . ';
  }
  .cert-number {
    position: absolute;
    bottom: 22%;
    left: 5%;
    font-family: monospace;
    font-size: 10px;
    color: #555;
  }
</style>
</head>
<body>
<div class="wrap">
  <img class="bg-img" src="data:' . $mimeType . ';base64,' . $imageData . '" />
  <div class="overlay">
    <div class="name">' . htmlspecialchars($certificate->name) . '</div>
    <div class="role">' . htmlspecialchars($event->overlay_role_text ?? 'Peserta') . '</div>
    <div class="cert-number">No: ' . htmlspecialchars($certificate->certificate_number) . '</div>
  </div>
</div>
</body>
</html>';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'certificate-' . $certificate->certificate_number . '.pdf';
        $path = 'certificates/' . $filename;

        Storage::disk('public')->put($path, $dompdf->output());

        return $path;
    }

    public function generateQRCode(Certificate $certificate)
    {
        // Generate QR code URL for verification
        $verificationUrl = route('certificate.verify', $certificate->certificate_number);
        
        // Generate QR code using Google Charts API (simple approach)
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($verificationUrl);
        
        return $qrCodeUrl;
    }

    public function getCertificatePath(Certificate $certificate)
    {
        return storage_path('app/public/' . $certificate->pdf_path);
    }

    public function getCertificateMimeType(Certificate $certificate)
    {
        return 'application/pdf';
    }

    public function deleteCertificate(Certificate $certificate)
    {
        if ($certificate->pdf_path) {
            Storage::disk('public')->delete($certificate->pdf_path);
        }
    }
}
