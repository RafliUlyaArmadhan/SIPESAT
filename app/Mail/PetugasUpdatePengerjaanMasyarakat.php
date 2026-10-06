<?php

namespace App\Mail;

use App\Models\DokumentasiPenanganan;
use App\Models\LaporanSampah;
use App\Models\Petugas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PetugasUpdatePengerjaanMasyarakat extends Mailable
{
    use Queueable, SerializesModels;

    public LaporanSampah $laporan;
    public Petugas $petugas;
    public string $tahap;
    public ?DokumentasiPenanganan $dokumentasi;

    public function __construct(
        LaporanSampah $laporan,
        Petugas $petugas,
        string $tahap,
        ?DokumentasiPenanganan $dokumentasi = null
    ) {
        $this->laporan = $laporan;
        $this->petugas = $petugas;
        $this->tahap = $tahap;
        $this->dokumentasi = $dokumentasi;

        $this->laporan->loadMissing([
            'user',
            'kategoriSampah',
            'kecamatan',
            'desa',
        ]);

        $this->petugas->loadMissing('user');
    }

    public function envelope(): Envelope
    {
        $subject = $this->tahap === 'selesai'
            ? 'Laporan ' . $this->laporan->kode_laporan . ' Telah Selesai Ditangani - SIPESAT'
            : 'Laporan ' . $this->laporan->kode_laporan . ' Mulai Ditangani - SIPESAT';

        return new Envelope(
            subject: $subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'masyarakat.notifpengerjaan'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
