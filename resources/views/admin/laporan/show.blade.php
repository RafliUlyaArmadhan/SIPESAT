@extends('layouts.app')

@section('title', 'Detail Laporan - ' . $laporan->kode_laporan)

@section('content')

<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      crossorigin=""/>

<style>

    .detail-wrapper {
        padding-bottom: 30px;
    }

    .detail-card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        margin-bottom: 20px;
    }

    .detail-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eee;
        border-radius: 12px 12px 0 0;
        font-weight: 700;
    }

    .label-detail {
        color: #777;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .value-detail {
        font-size: 13px;
        color: #222;
        margin-bottom: 16px;
    }

    .foto-box {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .foto-thumb {
        width: 180px;
        height: 130px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: .2s;
    }

    .foto-thumb:hover {
        transform: scale(1.03);
        opacity: .9;
    }

    .foto-empty {
        padding: 25px;
        background: #f8f9fa;
        border: 1px dashed #ccc;
        border-radius: 8px;
        color: #888;
        font-size: 12px;
        text-align: center;
    }

    #mapDetailAdmin {
        width: 100%;
        height: 300px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .status-badge-custom {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .history-item {
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
    }

    .history-item:last-child {
        border-bottom: 0;
    }

    .history-status {
        font-size: 12px;
        font-weight: 700;
    }

    .history-info {
        font-size: 11px;
        color: #777;
    }

    .action-card {
        position: sticky;
        top: 20px;
    }

    .photo-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0,0,0,.88);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .photo-modal img {
        max-width: 92vw;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
    }

    .photo-modal-close {
        position: absolute;
        top: 15px;
        right: 25px;
        color: white;
        font-size: 40px;
        cursor: pointer;
        line-height: 1;
    }

    @media(max-width:768px) {

        .foto-thumb {
            width: 140px;
            height: 105px;
        }

        .action-card {
            position: static;
        }

    }

</style>


<div class="container-fluid detail-wrapper">

    <!-- ================= HEADER ================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Detail Laporan
            </h4>

            <div class="text-muted small">
                #{{ $laporan->kode_laporan }}
            </div>
        </div>

        @php

            $statusLabel = match($laporan->status) {

                'menunggu_verifikasi'
                    => 'Menunggu Verifikasi',

                'diverifikasi'
                    => 'Diverifikasi',

                'sedang_ditangani'
                    => 'Sedang Ditangani',

                'menunggu_validasi_akhir'
                    => 'Menunggu Validasi Akhir',

                'selesai'
                    => 'Selesai',

                'ditolak'
                    => 'Ditolak',

                default
                    => ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            $laporan->status
                        )
                    ),

            };

            $statusClass = match($laporan->status) {

                'menunggu_verifikasi'
                    => 'bg-warning text-dark',

                'diverifikasi'
                    => 'bg-primary',

                'sedang_ditangani'
                    => 'bg-primary',

                'menunggu_validasi_akhir'
                    => 'bg-warning text-dark',

                'selesai'
                    => 'bg-success',

                'ditolak'
                    => 'bg-danger',

                default
                    => 'bg-secondary',

            };

        @endphp

        <span class="status-badge-custom {{ $statusClass }}">
            {{ $statusLabel }}
        </span>

    </div>


    <!-- ================= GRID ================= -->

    <div class="row">

        <!-- ================= BAGIAN KIRI ================= -->

        <div class="col-lg-8">

            <!-- INFORMASI LAPORAN -->

            <div class="card detail-card">

                <div class="card-header">
                    <i class="fa-solid fa-file-lines me-2 text-primary"></i>
                    Informasi Laporan
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="label-detail">
                                Judul Laporan
                            </div>

                            <div class="value-detail fw-bold">
                                {{ $laporan->judul_laporan ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="label-detail">
                                Kode Laporan
                            </div>

                            <div class="value-detail">
                                {{ $laporan->kode_laporan ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="label-detail">
                                Pelapor
                            </div>

                            <div class="value-detail">
                                {{ $laporan->user?->name ?? 'Anonim' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="label-detail">
                                Tanggal Laporan
                            </div>

                            <div class="value-detail">

                                {{ $laporan->created_at
                                    ? $laporan->created_at->format('d M Y, H:i')
                                    : '-'
                                }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="label-detail">
                                Kategori Sampah
                            </div>

                            <div class="value-detail">
                                {{ $laporan->kategoriSampah?->nama_kategori ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="label-detail">
                                Kecamatan
                            </div>

                            <div class="value-detail">
                                {{ $laporan->kecamatan?->nama_kecamatan
                                    ?? $laporan->kecamatan?->nama
                                    ?? '-'
                                }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="label-detail">
                                Desa
                            </div>

                            <div class="value-detail">
                                {{ $laporan->desa?->nama_desa
                                    ?? $laporan->desa?->nama
                                    ?? '-'
                                }}
                            </div>

                        </div>

                    </div>


                    <div class="label-detail">
                        Alamat Lengkap
                    </div>

                    <div class="value-detail">
                        {{ $laporan->alamat_lengkap ?? '-' }}
                    </div>


                    <div class="label-detail">
                        Deskripsi
                    </div>

                    <div class="value-detail">
                        {{ $laporan->deskripsi ?? '-' }}
                    </div>

                </div>

            </div>


            <!-- ================= FOTO LAPORAN ================= -->

            <div class="card detail-card">

                <div class="card-header">

                    <i class="fa-solid fa-image me-2 text-primary"></i>

                    Foto Laporan

                </div>


                <div class="card-body">

                    @php

                        $fotoLaporan = $laporan->foto_laporan ?? [];

                        if (!is_array($fotoLaporan)) {
                            $fotoLaporan = [$fotoLaporan];
                        }

                    @endphp


                    @if(count($fotoLaporan) > 0)

                        <div class="foto-box">

                            @foreach($fotoLaporan as $foto)

                                @php

                                    $fotoUrl = asset(
                                        str_starts_with(
                                            $foto,
                                            'uploads/'
                                        )
                                        ? $foto
                                        : 'uploads/' . $foto
                                    );

                                @endphp

                                <img
                                    src="{{ $fotoUrl }}"
                                    class="foto-thumb"
                                    alt="Foto Laporan"
                                    onclick="bukaFoto('{{ $fotoUrl }}')"
                                    onerror="this.onerror=null;this.style.display='none';"
                                >

                            @endforeach

                        </div>

                        <div class="text-muted small mt-2">
                            Klik foto untuk melihat ukuran lebih besar.
                        </div>

                    @else

                        <div class="foto-empty">
                            Tidak ada foto laporan.
                        </div>

                    @endif

                </div>

            </div>


            <!-- ================= DOKUMENTASI PENANGANAN ================= -->

            <div class="card detail-card">

                <div class="card-header">

                    <i class="fa-solid fa-camera me-2 text-primary"></i>

                    Dokumentasi Penanganan

                </div>


                <div class="card-body">

                    @if($laporan->dokumentasiPenanganan)

                        <!-- FOTO SEBELUM -->

                        <div class="mb-4">

                            <div class="fw-bold small mb-2">
                                Foto Sebelum
                            </div>

                            @php

                                $fotoSebelum =
                                    $laporan->dokumentasiPenanganan->foto_sebelum
                                    ?? [];

                                if (!is_array($fotoSebelum)) {
                                    $fotoSebelum = [$fotoSebelum];
                                }

                            @endphp


                            @if(count($fotoSebelum) > 0)

                                <div class="foto-box">

                                    @foreach($fotoSebelum as $foto)

                                        @php

                                            $fotoUrl = asset(
                                                str_starts_with(
                                                    $foto,
                                                    'uploads/'
                                                )
                                                ? $foto
                                                : 'uploads/' . $foto
                                            );

                                        @endphp

                                        <img
                                            src="{{ $fotoUrl }}"
                                            class="foto-thumb"
                                            alt="Foto Sebelum"
                                            onclick="bukaFoto('{{ $fotoUrl }}')"
                                            onerror="this.onerror=null;this.style.display='none';"
                                        >

                                    @endforeach

                                </div>

                            @else

                                <div class="foto-empty">
                                    Belum ada Foto Sebelum.
                                </div>

                            @endif

                        </div>


                        <!-- FOTO SESUDAH -->

                        <div class="mb-4">

                            <div class="fw-bold small mb-2">
                                Foto Sesudah
                            </div>

                            @php

                                $fotoSesudah =
                                    $laporan->dokumentasiPenanganan->foto_sesudah
                                    ?? [];

                                if (!is_array($fotoSesudah)) {
                                    $fotoSesudah = [$fotoSesudah];
                                }

                            @endphp


                            @if(count($fotoSesudah) > 0)

                                <div class="foto-box">

                                    @foreach($fotoSesudah as $foto)

                                        @php

                                            $fotoUrl = asset(
                                                str_starts_with(
                                                    $foto,
                                                    'uploads/'
                                                )
                                                ? $foto
                                                : 'uploads/' . $foto
                                            );

                                        @endphp

                                        <img
                                            src="{{ $fotoUrl }}"
                                            class="foto-thumb"
                                            alt="Foto Sesudah"
                                            onclick="bukaFoto('{{ $fotoUrl }}')"
                                            onerror="this.onerror=null;this.style.display='none';"
                                        >

                                    @endforeach

                                </div>

                            @else

                                <div class="foto-empty">
                                    Belum ada Foto Sesudah.
                                </div>

                            @endif

                        </div>


                        <!-- CATATAN -->

                        @if(
                            $laporan->dokumentasiPenanganan->catatan_pekerjaan
                        )

                            <div>

                                <div class="fw-bold small mb-2">
                                    Catatan Pekerjaan
                                </div>

                                <div
                                    class="p-3 rounded"
                                    style="background:#f8f9fa;"
                                >
                                    {{ $laporan->dokumentasiPenanganan->catatan_pekerjaan }}
                                </div>

                            </div>

                        @endif


                    @else

                        <div class="foto-empty">
                            Belum ada dokumentasi penanganan dari petugas.
                        </div>

                    @endif

                </div>

            </div>


            <!-- ================= PETA ================= -->

            <div class="card detail-card">

                <div class="card-header">

                    <i class="fa-solid fa-location-dot me-2 text-danger"></i>

                    Lokasi Laporan

                </div>

                <div class="card-body">

                    <div class="small text-muted mb-2">

                        {{ $laporan->alamat_lengkap ?? '-' }}

                    </div>

                    <div id="mapDetailAdmin"></div>

                </div>

            </div>


            <!-- ================= RIWAYAT ================= -->

            <div class="card detail-card">

                <div class="card-header">

                    <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>

                    Riwayat Status

                </div>


                <div class="card-body p-0">

                    @forelse(
                        $laporan->laporanStatusHistories
                        as $history
                    )

                        <div class="history-item">

                            <div class="d-flex justify-content-between">

                                <div class="history-status">

                                    {{
                                        str_replace(
                                            '_',
                                            ' ',
                                            strtoupper(
                                                $history->status_baru
                                                ?? $history->status_sesudah
                                                ?? '-'
                                            )
                                        )
                                    }}

                                </div>


                                <div class="history-info">

                                    {{
                                        $history->created_at
                                        ? $history->created_at->format(
                                            'd M Y H:i'
                                        )
                                        : '-'
                                    }}

                                </div>

                            </div>


                            <div class="history-info mt-1">

                                {{ $history->keterangan ?? '-' }}

                            </div>


                            <div class="history-info mt-1">

                                <i class="fa-solid fa-user me-1"></i>

                                {{
                                    $history->user?->name
                                    ?? 'Sistem'
                                }}

                            </div>

                        </div>

                    @empty

                        <div class="p-4 text-muted small">
                            Belum ada riwayat status.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        <!-- ================= BAGIAN KANAN ================= -->

        <div class="col-lg-4">

            <div class="action-card">

                <!-- AKSI ADMIN -->

                <div class="card detail-card">

                    <div class="card-header">

                        <i class="fa-solid fa-screwdriver-wrench me-2"></i>

                        Aksi Admin

                    </div>


                    <div class="card-body">

                        <!-- VERIFIKASI -->

                        @if($laporan->status === 'menunggu_verifikasi')

                            <form
                                action="{{ route(
                                    'admin.laporan.verifikasi',
                                    $laporan->id
                                ) }}"
                                method="POST"
                                class="mb-2"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-info text-white w-100"
                                >
                                    <i class="fa-solid fa-check me-1"></i>

                                    Verifikasi Laporan

                                </button>

                            </form>


                            <button
                                type="button"
                                class="btn btn-outline-danger w-100 mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="#modalTolak"
                            >

                                <i class="fa-solid fa-xmark me-1"></i>

                                Tolak Laporan

                            </button>

                        @endif


                        <!-- TUGASKAN -->

                        @if(
                            in_array(
                                $laporan->status,
                                [
                                    'menunggu_verifikasi',
                                    'diverifikasi'
                                ]
                            )
                        )

                            <hr>

                            <form
                                action="{{ route(
                                    'admin.laporan.tugaskan',
                                    $laporan->id
                                ) }}"
                                method="POST"
                            >

                                @csrf

                                <div class="mb-3">

                                    <label class="form-label small fw-bold">
                                        Tugaskan Petugas
                                    </label>

                                    <select
                                        name="petugas_id"
                                        class="form-select"
                                        required
                                    >

                                        <option value="">
                                            -- Pilih Petugas --
                                        </option>

                                        @foreach(
                                            $petugasList
                                            as $petugas
                                        )

                                            <option
                                                value="{{ $petugas->id }}"
                                                {{
                                                    $laporan->penugasan
                                                    && $laporan->penugasan->petugas_id
                                                    == $petugas->id
                                                    ? 'selected'
                                                    : ''
                                                }}
                                            >

                                                {{
                                                    $petugas->user?->name
                                                    ?? 'Petugas'
                                                }}

                                                @if(
                                                    $petugas->penugasans_count > 0
                                                )

                                                    (
                                                    Sedang menangani
                                                    {{
                                                        $petugas->penugasans_count
                                                    }}
                                                    tugas
                                                    )

                                                @else

                                                    (Tersedia)

                                                @endif

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="mb-3">

                                    <label class="form-label small fw-bold">
                                        Tenggat Waktu
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="tenggat_waktu"
                                        class="form-control"
                                        value="{{
                                            old(
                                                'tenggat_waktu',
                                                $laporan->penugasan?->tenggat_waktu
                                                ? $laporan->penugasan->tenggat_waktu
                                                    ->format('Y-m-d\TH:i')
                                                : ''
                                            )
                                        }}"
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label small fw-bold">
                                        Catatan Admin
                                    </label>

                                    <textarea
                                        name="catatan_admin"
                                        class="form-control"
                                        rows="3"
                                    >{{ old(
                                        'catatan_admin',
                                        $laporan->penugasan?->catatan_admin
                                    ) }}</textarea>

                                </div>


                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >

                                    <i class="fa-solid fa-user-check me-1"></i>

                                    Tugaskan

                                </button>

                            </form>

                        @endif


                        <!-- SEDANG DITANGANI -->

                        @if($laporan->status === 'sedang_ditangani')

                            <div class="alert alert-info mt-2 mb-0 small">

                                <i class="fa-solid fa-circle-info me-1"></i>

                                Laporan sedang ditangani oleh petugas.

                            </div>

                        @endif


                        <!-- VALIDASI AKHIR -->

                        @if($laporan->status === 'menunggu_validasi_akhir')

                            <form
                                action="{{ route(
                                    'admin.laporan.validasi-akhir',
                                    $laporan->id
                                ) }}"
                                method="POST"
                            >

                                @csrf

                                <div class="alert alert-warning small">

                                    <strong>
                                        Penanganan selesai.
                                    </strong>

                                    <br>

                                    Periksa Foto Sebelum dan Foto Sesudah
                                    sebelum melakukan validasi.

                                </div>


                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                >

                                    <i class="fa-solid fa-check-double me-1"></i>

                                    Validasi & Selesai

                                </button>

                            </form>

                        @endif


                        <!-- SELESAI -->

                        @if($laporan->status === 'selesai')

                            <div class="alert alert-success small mb-0">

                                <i class="fa-solid fa-circle-check me-1"></i>

                                Laporan ini telah selesai divalidasi.

                            </div>

                        @endif


                        <!-- DITOLAK -->

                        @if($laporan->status === 'ditolak')

                            <div class="alert alert-danger small mb-0">

                                <strong>
                                    Laporan ditolak.
                                </strong>

                                <br>

                                {{
                                    $laporan->alasan_penolakan
                                    ?? 'Tidak ada alasan.'
                                }}

                            </div>

                        @endif

                    </div>

                </div>


                <!-- KEMBALI -->

                <a
                    href="{{ route('admin.laporan.index') }}"
                    class="btn btn-outline-secondary w-100"
                >

                    <i class="fa-solid fa-arrow-left me-1"></i>

                    Kembali ke Manajemen Laporan

                </a>

            </div>

        </div>

    </div>

</div>


<!-- ================= MODAL TOLAK ================= -->

@if($laporan->status === 'menunggu_verifikasi')

<div
    class="modal fade"
    id="modalTolak"
    tabindex="-1"
>

    <div class="modal-dialog">

        <form
            action="{{ route(
                'admin.laporan.tolak',
                $laporan->id
            ) }}"
            method="POST"
        >

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title text-danger">
                        Tolak Laporan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    <label class="form-label fw-bold">
                        Alasan Penolakan
                    </label>

                    <textarea
                        name="alasan_penolakan"
                        class="form-control"
                        rows="4"
                        required
                        maxlength="500"
                        placeholder="Masukkan alasan penolakan..."
                    ></textarea>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Tolak Laporan
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endif


<!-- ================= MODAL FOTO ================= -->

<div
    id="photoModal"
    class="photo-modal"
    onclick="tutupFoto()"
>

    <span
        class="photo-modal-close"
        onclick="tutupFoto()"
    >
        &times;
    </span>

    <img
        id="photoModalImage"
        src=""
        alt="Preview Foto"
        onclick="event.stopPropagation()"
    >

</div>


<!-- ================= LEAFLET ================= -->

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    crossorigin=""
></script>


<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        /* ================= FOTO ================= */

        window.bukaFoto = function(url) {

            document
                .getElementById('photoModalImage')
                .src = url;

            document
                .getElementById('photoModal')
                .style.display = 'flex';

        };


        window.tutupFoto = function() {

            document
                .getElementById('photoModal')
                .style.display = 'none';

            document
                .getElementById('photoModalImage')
                .src = '';

        };


        /* ================= PETA ================= */

        const mapElement =
            document.getElementById('mapDetailAdmin');


        if (mapElement) {

            const latitude =
                {{ $laporan->latitude ?? -7.6531 }};

            const longitude =
                {{ $laporan->longitude ?? 111.3284 }};


            const map =
                L.map('mapDetailAdmin')
                    .setView(
                        [latitude, longitude],
                        15
                    );


            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);


            L.marker(
                [latitude, longitude]
            )
            .addTo(map)
            .bindPopup(
                `<b>Lokasi Laporan</b><br>{{ $laporan->alamat_lengkap ?? '-' }}`
            )
            .openPopup();

        }

    }
);

</script>

@endsection