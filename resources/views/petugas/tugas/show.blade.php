@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')

<style>
    .detail-page {
        font-size: 13px;
    }

    .detail-header {
        margin-bottom: 14px;
    }

    .detail-header h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
        margin-bottom: 14px;
        overflow: hidden;
    }

    .detail-card-header {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        font-size: 11px;
        font-weight: 700;
    }

    .detail-card-body {
        padding: 12px;
    }

    .info-row {
        display: flex;
        gap: 10px;
        padding: 6px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 120px;
        min-width: 120px;
        color: #777;
        font-size: 9px;
    }

    .info-value {
        flex: 1;
        color: #333;
        font-size: 9px;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 4px;
        font-size: 7px;
        font-weight: 700;
        color: white;
    }

    .status-baru {
        background: #0d9fe8;
    }

    .status-proses {
        background: #198754;
    }

    .status-validasi {
        background: #6c757d;
    }

    .status-selesai {
        background: #198754;
    }

    .form-label-small {
        display: block;
        font-size: 9px;
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }

    .form-control-small {
        font-size: 9px;
        padding: 7px 8px;
    }

    .btn-action {
        width: 100%;
        border: none;
        border-radius: 4px;
        padding: 8px;
        color: #fff;
        font-size: 9px;
        font-weight: 600;
    }

    .btn-action:hover {
        opacity: .9;
    }

    .btn-mulai {
        background: #198754;
    }

    .btn-selesai {
        background: #198754;
    }

    .btn-back {
        font-size: 9px;
        padding: 5px 8px;
        border: 1px solid #aaa;
        border-radius: 4px;
        text-decoration: none;
        color: #555;
        background: #fff;
    }

    .btn-back:hover {
        background: #f5f5f5;
    }

    .map-container {
        width: 100%;
        height: 190px;
        margin-top: 8px;
        border-radius: 5px;
        overflow: hidden;
    }

    .google-map-btn {
        display: inline-block;
        margin-top: 6px;
        padding: 4px 7px;
        font-size: 8px;
        border: 1px solid #0d6efd;
        color: #0d6efd;
        text-decoration: none;
        border-radius: 4px;
    }

    .google-map-btn:hover {
        background: #0d6efd;
        color: #fff;
    }

    .admin-note {
        margin-top: 9px;
        font-size: 8px;
    }

    .admin-note strong {
        color: #555;
    }

    .documentation-box {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
        padding: 12px;
    }

    .documentation-title {
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .foto-box {
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 8px;
        min-height: 70px;
        background: #fafafa;
    }

    .foto-title {
        font-size: 8px;
        font-weight: 600;
        color: #555;
    }

    .foto-empty {
        font-size: 8px;
        color: #999;
        margin-top: 6px;
    }

    .foto-box img {
        width: 100%;
        max-height: 130px;
        object-fit: cover;
        border-radius: 4px;
        margin-top: 6px;
    }

    .info-alert {
        background: #d9f4ff;
        border: 1px solid #bcecff;
        color: #31758b;
        border-radius: 4px;
        padding: 9px;
        font-size: 9px;
        line-height: 1.5;
    }

    .muted-small {
        color: #999;
        font-size: 8px;
    }
</style>

@php
    $laporan = $penugasan->laporanSampah;
    $status = $laporan->status ?? '';

    $latitude = $laporan->latitude ?? -7.6531;
    $longitude = $laporan->longitude ?? 111.3284;

    $dokumentasi = $laporan->dokumentasiPenanganan ?? null;

    $statusLabel = match ($status) {
        'diverifikasi' => 'DIVERIFIKASI',
        'sedang_ditangani' => 'SEDANG DITANGANI',
        'menunggu_validasi_akhir' => 'MENUNGGU VALIDASI',
        'selesai' => 'SELESAI',
        default => strtoupper(str_replace('_', ' ', $status))
    };
@endphp

<div class="detail-page">

    {{-- HEADER --}}
    <div class="detail-header d-flex justify-content-between align-items-center">

        <h5>
            Detail Tugas -
            {{ $laporan->kode_laporan ?? '-' }}
        </h5>

        <a href="{{ route('petugas.tugas.index') }}"
           class="btn-back">
            ← Kembali
        </a>

    </div>

    <div class="row g-3">

        {{-- =========================
             KOLOM KIRI
        ========================== --}}
        <div class="col-lg-8">

            {{-- INFORMASI LAPORAN --}}
            <div class="detail-card">

                <div class="detail-card-header d-flex justify-content-between align-items-center">

                    <span>Informasi Laporan</span>

                    @if($status == 'diverifikasi')
                        <span class="status-badge status-baru">
                            {{ $statusLabel }}
                        </span>

                    @elseif($status == 'sedang_ditangani')
                        <span class="status-badge status-proses">
                            {{ $statusLabel }}
                        </span>

                    @elseif($status == 'menunggu_validasi_akhir')
                        <span class="status-badge status-validasi">
                            {{ $statusLabel }}
                        </span>

                    @elseif($status == 'selesai')
                        <span class="status-badge status-selesai">
                            {{ $statusLabel }}
                        </span>
                    @endif

                </div>

                <div class="detail-card-body">

                    {{-- KATEGORI --}}
                    <div class="info-row">
                        <div class="info-label">Kategori</div>

                        <div class="info-value">
                            {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="info-row">
                        <div class="info-label">Deskripsi Laporan</div>

                        <div class="info-value">
                            {{ $laporan->deskripsi ?? '-' }}
                        </div>
                    </div>

                    {{-- LOKASI --}}
                    <div class="info-row">
                        <div class="info-label">Lokasi</div>

                        <div class="info-value">

                            {{ $laporan->alamat ?? '-' }}

                            <div class="muted-small">
                                {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}
                                -
                                {{ $laporan->desa->nama_desa ?? '-' }}
                            </div>

                        </div>
                    </div>

                    {{-- MAP --}}
                    <div class="map-container">
                        <div id="detailMap"
                             style="width:100%;height:100%;">
                        </div>
                    </div>

                    {{-- GOOGLE MAPS --}}
                    <a href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}"
                       target="_blank"
                       class="google-map-btn">
                        Buka Rute di Google Maps
                    </a>

                    {{-- CATATAN ADMIN --}}
                    <div class="admin-note">
                        <strong>Catatan Admin Penugas</strong>

                        <div class="mt-1">
                            {{ $penugasan->catatan ?? '-' }}
                        </div>
                    </div>

                    {{-- TANGGAL --}}
                    <div class="admin-note">
                        <strong>Tenggat Waktu</strong>

                        <div class="text-warning mt-1">
                            {{ $penugasan->created_at
                                ? $penugasan->created_at->format('d M Y H:i')
                                : '-' }}
                        </div>
                    </div>

                </div>

            </div>


            {{-- DOKUMENTASI SAYA --}}
            <div class="documentation-box">

                <div class="documentation-title">
                    Dokumentasi Saya
                </div>

                <div class="row g-3">

                    {{-- FOTO SEBELUM --}}
                    <div class="col-md-6">

                        <div class="foto-box">

                            <div class="foto-title">
                                Foto Sebelum
                            </div>

                            @if($dokumentasi && !empty($dokumentasi->foto_sebelum))

                                @foreach((array) $dokumentasi->foto_sebelum as $foto)

                                    <img src="{{ asset('uploads/' . $foto) }}"
                                         alt="Foto Sebelum">

                                @endforeach

                            @else

                                <div class="foto-empty">
                                    Belum diunggah
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- FOTO SESUDAH --}}
                    <div class="col-md-6">

                        <div class="foto-box">

                            <div class="foto-title">
                                Foto Sesudah
                            </div>

                            @if($dokumentasi && !empty($dokumentasi->foto_sesudah))

                                @foreach((array) $dokumentasi->foto_sesudah as $foto)

                                    <img src="{{ asset('uploads/' . $foto) }}"
                                         alt="Foto Sesudah">

                                @endforeach

                            @else

                                <div class="foto-empty">
                                    Belum diunggah
                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- CATATAN PEKERJAAN --}}
                <div class="mt-3">

                    <div class="foto-title">
                        Catatan Pekerjaan
                    </div>

                    <div class="muted-small mt-1">
                        {{ $dokumentasi->catatan_pekerjaan ?? 'Belum ada catatan.' }}
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             KOLOM KANAN
        ========================== --}}
        <div class="col-lg-4">

            <div class="detail-card">

                <div class="detail-card-header">
                    Update Pekerjaan
                </div>

                <div class="detail-card-body">

                    {{-- DIVERIFIKASI --}}
                    @if($status == 'diverifikasi')

                        <form action="{{ route('petugas.tugas.update-status', $penugasan->id) }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf

                            <input type="hidden"
                                   name="action"
                                   value="mulai">

                            <div class="mb-3">

                                <label class="form-label-small">
                                    Foto Kondisi Sebelum (Opsional/Wajib)
                                </label>

                                <input type="file"
                                       name="foto_sebelum[]"
                                       class="form-control form-control-small"
                                       accept="image/*"
                                       multiple>

                            </div>

                            <button type="submit"
                                    class="btn-action btn-mulai">
                                ▶ Mulai Kerjakan
                            </button>

                        </form>


                    {{-- SEDANG DITANGANI --}}
                    @elseif($status == 'sedang_ditangani')

                        <form action="{{ route('petugas.tugas.update-status', $penugasan->id) }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf

                            <input type="hidden"
                                   name="action"
                                   value="selesai">

                            <div class="mb-3">

                                <label class="form-label-small">
                                    Foto Kondisi Sesudah
                                </label>

                                <input type="file"
                                       name="foto_sesudah[]"
                                       class="form-control form-control-small"
                                       accept="image/*"
                                       multiple>

                            </div>

                            <div class="mb-3">

                                <label class="form-label-small">
                                    Catatan Pekerjaan
                                </label>

                                <textarea name="catatan_pekerjaan"
                                          class="form-control form-control-small"
                                          rows="4"
                                          placeholder="Deskripsikan pekerjaan yang telah dilakukan..."></textarea>

                            </div>

                            <button type="submit"
                                    class="btn-action btn-selesai">
                                ✓ Selesaikan Pekerjaan
                            </button>

                        </form>


                    {{-- MENUNGGU VALIDASI --}}
                    @elseif($status == 'menunggu_validasi_akhir')

                        <div class="info-alert">
                            Pekerjaan telah selesai dan sedang
                            divalidasi oleh Admin.
                        </div>


                    {{-- SUDAH SELESAI --}}
                    @elseif($status == 'selesai')

                        <div class="info-alert">
                            Pekerjaan telah selesai dan sudah
                            divalidasi oleh Admin.
                        </div>


                    {{-- STATUS LAIN --}}
                    @else

                        <div class="info-alert">
                            Tidak ada tindakan yang dapat dilakukan
                            untuk status tugas ini.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


{{-- LEAFLET --}}
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

    const latitude = {{ $latitude }};
    const longitude = {{ $longitude }};

    const map = L.map('detailMap')
        .setView([latitude, longitude], 15);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);

    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup('Lokasi Laporan')
        .openPopup();

</script>

@endsection