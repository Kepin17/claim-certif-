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
    public string $awardType;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
        $this->awardType   = $certificate->getAwardType();
    }

    public function build()
    {
        $certificatePath = storage_path('app/public/' . $this->certificate->pdf_path);

        // Sanitize name for filename
        $sanitizedName = preg_replace('/[^a-zA-Z0-9-]/', '-', $this->certificate->name);
        $attachmentFilename = $this->certificate->certificate_number . '-' . $sanitizedName . '.pdf';

        // Dynamic subject based on award type
        $subject = match($this->awardType) {
            'juara1' => '🥇 Selamat! Anda Meraih Juara 1 – ' . $this->certificate->event,
            'juara2' => '🥈 Selamat! Anda Meraih Juara 2 – ' . $this->certificate->event,
            'juara3' => '🥉 Selamat! Anda Meraih Juara 3 – ' . $this->certificate->event,
            default  => '📜 Sertifikat Partisipasi Anda Telah Diterbitkan – ' . $this->certificate->event,
        };

        $viewData = [
            'name'              => $this->certificate->name,
            'event'             => $this->certificate->event,
            'certificateNumber' => $this->certificate->certificate_number,
            'downloadUrl'       => config('app.url') . '/download-certificate?key=' . $this->certificate->unique_key,
            'awardType'         => $this->awardType,
            'customMessage'     => $this->certificate->custom_email_message,
            'certificateType'   => $this->certificate->certificate_type_name,
        ];

        if (!file_exists($certificatePath)) {
            return $this->subject($subject)->view('emails.certificate-approved', $viewData);
        }

        return $this->subject($subject)
            ->view('emails.certificate-approved', $viewData)
            ->attach($certificatePath, [
                'as'   => $attachmentFilename,
                'mime' => 'application/pdf',
            ]);
    }
}
