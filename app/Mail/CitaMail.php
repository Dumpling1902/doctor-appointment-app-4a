<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class CitaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Cita Médica',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cita',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.cita', ['appointment' => $this->appointment]);
        
        return [
            Attachment::fromData(fn () => $pdf->output(), 'Cita-' . $this->appointment->id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
