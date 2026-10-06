<?php

namespace App\Mail;

use App\Models\LaporanSampah;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanSelesai extends Mailable
{
    use Queueable, SerializesModels;

    public $laporan;

    public function __construct(LaporanSampah $laporan)
    {
        $this->laporan = $laporan;

        $this->laporan->loadMissing([
            'user',
            'kategoriSampah',
            'kecamatan',
            'desa',
            'dokumentasiPenanganan',
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Anda Telah Selesai - SIPESAT'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'masyarakat.notiflaporanselesai'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}