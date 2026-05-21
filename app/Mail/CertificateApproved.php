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
        
        if (!file_exists($certificatePath)) {
            // If file doesn't exist, send email without attachment
            return $this->subject('Your Certificate Has Been Generated!')
                ->view('emails.certificate-approved', [
                    'name' => $this->certificate->name,
                    'event' => $this->certificate->event,
                    'certificateNumber' => $this->certificate->certificate_number,
                    'downloadUrl' => route('certificate.download', $this->certificate->certificate_number),
                ]);
        }
        
        return $this->subject('Your Certificate Has Been Generated!')
            ->view('emails.certificate-approved', [
                'name' => $this->certificate->name,
                'event' => $this->certificate->event,
                'certificateNumber' => $this->certificate->certificate_number,
                'downloadUrl' => route('certificate.download', $this->certificate->certificate_number),
            ])
            ->attach($certificatePath, [
                'as' => 'certificate-' . $this->certificate->certificate_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
