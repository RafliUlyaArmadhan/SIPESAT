<?php

namespace App\Mail;

use App\Models\LaporanSampah;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public LaporanSampah $laporan;

    /**
     * Create a new message instance.
     */
    public function __construct(LaporanSampah $laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Sampah Telah Selesai Ditangani',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.laporan-selesai',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}