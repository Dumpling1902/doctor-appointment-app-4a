<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReporteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointments;
    public $title;

    public function __construct($appointments, $title = 'Reporte Diario de Citas')
    {
        $this->appointments = $appointments;
        $this->title = $title;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
