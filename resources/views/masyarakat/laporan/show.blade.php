@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')

<style>
    .detail-page {
        max-width: 850px;
        margin: 0 auto;
        font-size: 12px;
    }

    .back-link {
        display: inline-block;
        color: #777;
        text-decoration: none;
        font-size: 9px;
        margin-bottom: 7px;
    }

    .back-link:hover {
        color: #1f6e43;
    }

    .detail-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .detail-top h4 {
        font-size: 15px;
        font-weight: 700;
        margin: 0;
        color: #1f2a24;
    }

    .status-badge {
        font-size: 8px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-menunggu {
        background: #ffc107;
        color: #222;
    }

    .status-diverifikasi {
        background: #0dcaf0;
        color: #222;
    }

    .status-proses {
        background: #198754;
        color: #fff;
    }

    .status-validasi {
        background: #f0ad4e;
        color: #fff;
    }

    .status-selesai {
        background: #198754;
        color: #fff;
    }

    .status-ditolak {
        background: #dc3545;
        color: #fff;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 215px;
        gap: 12px;
        align-items: start;
    }

    .detail-card,
    .history-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 7px;
        box-shadow: 0 2px 5px rgba(0,0,0,.07);
    }

    .detail-card {
        padding: 14px;
    }

    .history-card {
        padding: 13px;
    }

    .laporan-title {
        font-size: 14px;
        font-weight: 700;
        color: #1f6e43;
        margin-bottom: 3px;
    }

    .laporan-meta {
        font-size: 7px;
        color: #777;
        margin-bottom: 14px;
    }

    .label {
        font-size: 8px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
    }

    .value {
        font-size: 8px;
        line-height: 1.45;
        color: #333;
        margin-bottom: 11px;
    }

    .kategori {
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
    }

    .kategori-icon {
        color: #1f6e43;
        font-size: 8px;
    }

    .foto-laporan {
        width: 143px;
        height: 82px;
        object-fit: cover;
        border-radius: 4px;
        display: block;
        border: 1px solid #ddd;
    }

    .foto-empty {
        width: 143px;
        height: 82px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f7f7f7;
        color: #888;
        font-size: 8px;
    }

    .map-wrapper {
        height: 155px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .history-title {
        font-size: 9px;
        font-weight: 700;
        color: #333;
        margin-bottom: 11px;
    }

    .history-item {
        position: relative;
        padding-left: 14px;
        padding-bottom: 15px;
        margin-left: 2px;
        border-left: 1px solid #ddd;
    }

    .history-item:last-child {
        border-left: none;
        padding-bottom: 0;
    }

    .history-dot {
        position: absolute;
        left: -4px;
        top: 0;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #198754;
    }

    .history-dot.inactive {
        background: #fff;
        border: 1px solid #d0d0d0;
    }

    .history-status {
        font-size: 8px;
        font-weight: 700;
        color: #333;
        margin-bottom: 2px;
    }

    .history-date {
        font-size: 7px;
        color: #777;
        line-height: 1.35;
    }

    .history-note {
        font-size: 7px;
        color: #999;
        margin-top: 2px;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="detail-page">

    {{-- KEMBALI --}}
    <a href="{{ route('masyarakat.dashboard') }}" class="back-link">
        ← Kembali ke Dashboard
    </a>


    {{-- JUDUL HALAMAN + STATUS --}}
    <div class="detail-top">

        <h4>
            Detail Laporan
        </h4>

        @php
            $status = $laporan->status ?? 'menunggu_verifikasi';

            $statusLabel = match ($status) {
                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                'diverifikasi' => 'Diverifikasi',
                'sedang_ditangani' => 'Sedang Ditangani',
                'menunggu_validasi_akhir' => 'Menunggu Validasi',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
                default => ucfirst(str_replace('_', ' ', $status)),
            };

            $statusClass = match ($status) {
                'menunggu_verifikasi' => 'status-menunggu',
                'diverifikasi' => 'status-diverifikasi',
                'sedang_ditangani' => 'status-proses',
                'menunggu_validasi_akhir' => 'status-validasi',
                'selesai' => 'status-selesai',
                'ditolak' => 'status-ditolak',
                default => 'status-menunggu',
            };
        @endphp

        <span class="status-badge {{ $statusClass }}">
            ● {{ $statusLabel }}
        </span>

    </div>


    <div class="detail-grid">

        {{-- =========================
             KIRI
        ========================== --}}
        <div class="detail-card">

            {{-- JUDUL LAPORAN --}}
            <div class="laporan-title">
                {{ $laporan->judul_laporan ?? '-' }}
            </div>

            {{-- KODE + TANGGAL --}}
            <div class="laporan-meta">
                # {{ $laporan->kode_laporan ?? '-' }}
                &nbsp; • &nbsp;
                Dibuat pada
                {{ $laporan->created_at
                    ? $laporan->created_at->format('d M Y, H:i')
                    : '-' }}
            </div>


            {{-- KATEGORI --}}
            <div class="label">
                Kategori Sampah
            </div>

            <div class="value kategori">
                <span class="kategori-icon">●</span>

                {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
            </div>


            {{-- DESKRIPSI --}}
            <div class="label">
                Deskripsi
            </div>

            <div class="value">
                {{ $laporan->deskripsi ?? '-' }}
            </div>


            {{-- ALAMAT --}}
            <div class="label">
                Alamat Lengkap
            </div>

            <div class="value">
                {{ $laporan->alamat_lengkap ?? '-' }}
            </div>


            {{-- FOTO --}}
            <div class="label">
                Foto Laporan
            </div>

            @php
                $foto = $laporan->foto_laporan ?? [];

                if (!is_array($foto)) {
                    $foto = [$foto];
                }

                $fotoPertama = $foto[0] ?? null;
            @endphp

            @if($fotoPertama)

                <img
                    src="{{ asset('uploads/' . $fotoPertama) }}"
                    alt="Foto Laporan"
                    class="foto-laporan"
                >

            @else

                <div class="foto-empty">
                    Tidak ada foto laporan
                </div>

            @endif


            {{-- LOKASI PETA --}}
            <div class="label" style="margin-top: 13px;">
                Lokasi Peta
            </div>

            <div class="map-wrapper">

                <div id="map"></div>

            </div>

        </div>


        {{-- =========================
             KANAN: RIWAYAT STATUS
        ========================== --}}
        <div class="history-card">

            <div class="history-title">
                Riwayat Status
            </div>

            {{-- STATUS AKTIF --}}
            <div class="history-item">

                <span class="history-dot"></span>

                <div class="history-status">
                    Menunggu Verifikasi
                </div>

                <div class="history-date">
                    {{ $laporan->created_at
                        ? $laporan->created_at->format('d M Y, H:i')
                        : '-' }}
                    • oleh Sistem
                </div>

            </div>


            {{-- STATUS SELESAI --}}
            <div class="history-item">

                <span class="history-dot inactive"></span>

                <div class="history-status">
                    Selesai
                </div>

                <div class="history-note">
                    Menunggu penanganan selesai
                </div>

            </div>

        </div>

    </div>

</div>


{{-- LEAFLET --}}
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const latitude = {{ $laporan->latitude }};
        const longitude = {{ $laporan->longitude }};

        const map = L.map('map').setView(
            [latitude, longitude],
            15
        );

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);

        const marker = L.marker([
            latitude,
            longitude
        ]).addTo(map);

        marker.bindPopup(`
            <div style="font-size:8px;">
                <strong>Lokasi Laporan</strong><br>
                {{ $laporan->alamat_lengkap ?? '-' }}
            </div>
        `).openPopup();

    });
</script>

@endsection