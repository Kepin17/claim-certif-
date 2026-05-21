<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function build()
    {
        $certificatePath = storage_path('app/public/' . $this->certificate->pdf_path);

        // Sanitize name for filename
        $sanitizedName = preg_replace('/[^a-zA-Z0-9-]/', '-', $this->certificate->name);
        $attachmentFilename = $this->certificate->certificate_number . '-' . $sanitizedName . '.pdf';

        if (!file_exists($certificatePath)) {
            // If file doesn't exist, send email without attachment
            return $this->subject('Your Certificate Has Been Generated!')
                ->view('emails.certificate-approved', [
                    'name' => $this->certificate->name,
                    'event' => $this->certificate->event,
                    'certificateNumber' => $this->certificate->certificate_number,
                    'downloadUrl' => config('app.url') . route('certificate.download', urlencode($this->certificate->certificate_number), false),
                ]);
        }

        return $this->subject('Your Certificate Has Been Generated!')
            ->view('emails.certificate-approved', [
                'name' => $this->certificate->name,
                'event' => $this->certificate->event,
                'certificateNumber' => $this->certificate->certificate_number,
                'downloadUrl' => config('app.url') . route('certificate.download', urlencode($this->certificate->certificate_number), false),
            ])
            ->attach($certificatePath, [
                'as' => $attachmentFilename,
                'mime' => 'application/pdf',
            ]);
    }
}
