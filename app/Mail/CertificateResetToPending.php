<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateResetToPending extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Your Certificate Claim Has Been Re-opened',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.certificate-reset',
            with: [
                'name' => $this->certificate->name,
                'event' => $this->certificate->event,
                'trackUrl' => config('app.url') . '/track-certificate',
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
