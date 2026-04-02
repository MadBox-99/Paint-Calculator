<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CalculationFormSendToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public $pdfPath;

    public $pdfFilename;

    public function __construct(array $data, string $pdfPath, string $pdfFilename = 'calculation.pdf')
    {
        $this->data = $data;
        $this->pdfPath = $pdfPath;
        $this->pdfFilename = $pdfFilename;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Festék kalkulácíó Form',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.calculation-form-send-to-admin', with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath(path: $this->pdfPath)
                ->as($this->pdfFilename)
                ->withMime('application/pdf'),
        ];
    }
}
