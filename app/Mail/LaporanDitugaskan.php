<?php

namespace App\Mail;

use App\Models\LaporanSampah;
use App\Models\Penugasan;
use App\Models\Petugas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanDitugaskan extends Mailable
{
    use Queueable, SerializesModels;

    public $laporan;
    public $penugasan;
    public $petugas;

    /**
     * Membuat instance email baru.
     */
    public function __construct(
        LaporanSampah $laporan,
        Penugasan $penugasan,
        Petugas $petugas
    ) {
        $this->laporan = $laporan;
        $this->penugasan = $penugasan;
        $this->petugas = $petugas;

        // Memastikan relasi yang dibutuhkan oleh template email tersedia.
        $this->laporan->loadMissing([
            'kategoriSampah',
            'kecamatan',
            'desa',
            'user',
        ]);

        // Memastikan relasi user milik petugas tersedia.
        $this->petugas->loadMissing([
            'user',
        ]);
    }

    /**
     * Subject email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Penugasan Laporan Baru - SIPESAT'
        );
    }

    /**
     * View yang digunakan untuk isi email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'petugas.notiftugas'
        );
    }

    /**
     * Attachment email.
     */
    public function attachments(): array
    {
        return [];
    }
}

