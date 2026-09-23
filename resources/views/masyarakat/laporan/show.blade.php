@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')

<style>
    .detail-page {
        max-width: 950px;
        margin: 0 auto;
        font-size: 13px;
    }

    .back-link {
        display: inline-block;
        color: #777;
        text-decoration: none;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .back-link:hover {
        color: #1f6e43;
    }

    .detail-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .detail-top h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: #1f2a24;
    }

    .status-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 7px 13px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 16px;
        align-items: start;
    }

    .detail-card,
    .history-card,
    .rating-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
    }

    .detail-card {
        padding: 18px;
    }

    .history-card {
        padding: 16px;
    }

    .rating-card {
        margin-top: 16px;
        padding: 18px;
    }

    .laporan-title {
        font-size: 19px;
        font-weight: 700;
        color: #1f6e43;
        margin-bottom: 5px;
    }

    .laporan-meta {
        font-size: 11px;
        color: #777;
        margin-bottom: 18px;
    }

    .label {
        font-size: 11px;
        font-weight: 700;
        color: #333;
        margin-bottom: 6px;
    }

    .value {
        font-size: 12px;
        line-height: 1.6;
        color: #333;
        margin-bottom: 14px;
    }

    .kategori {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    .kategori-icon {
        color: #1f6e43;
    }

    /* =========================================================
       FOTO
       ========================================================= */

    .foto-laporan {
        width: 220px;
        height: 125px;
        object-fit: cover;
        border-radius: 7px;
        display: block;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: .2s;
    }

    .foto-laporan:hover {
        opacity: .9;
        transform: scale(1.02);
    }

    .foto-hint {
        font-size: 10px;
        color: #888;
        margin-top: 6px;
    }

    .foto-empty {
        width: 220px;
        height: 125px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 7px;
        background: #f7f7f7;
        color: #888;
        font-size: 11px;
    }

    /* =========================================================
       MAP
       ========================================================= */

    .map-wrapper {
        height: 220px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 7px;
        overflow: hidden;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    /* =========================================================
       HISTORY
       ========================================================= */

    .history-title {
        font-size: 13px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .history-item {
        position: relative;
        padding-left: 17px;
        padding-bottom: 18px;
        margin-left: 3px;
        border-left: 1px solid #ddd;
    }

    .history-item:last-child {
        border-left: none;
        padding-bottom: 0;
    }

    .history-dot {
        position: absolute;
        left: -5px;
        top: 0;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #198754;
    }

    .history-dot.inactive {
        background: #fff;
        border: 1px solid #ccc;
    }

    .history-status {
        font-size: 11px;
        font-weight: 700;
        color: #333;
        margin-bottom: 3px;
    }

    .history-date {
        font-size: 10px;
        color: #777;
        line-height: 1.4;
    }

    .history-note {
        font-size: 10px;
        color: #999;
        margin-top: 3px;
    }

    /* =========================================================
       RATING
       ========================================================= */

    .rating-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2a24;
        margin-bottom: 5px;
    }

    .rating-description {
        font-size: 11px;
        color: #777;
        margin-bottom: 15px;
    }

    /* BINTANG NORMAL: 1 2 3 4 5 */
    .rating-stars {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        gap: 3px;
        margin-bottom: 15px;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        font-size: 36px;
        color: #d7d7d7;
        cursor: pointer;
        transition: .15s;
        line-height: 1;
        margin: 0;
    }

    .rating-stars label:hover,
    .rating-stars label.hovered,
    .rating-stars label.active {
        color: #ffc107;
    }

    .rating-comment {
        width: 100%;
        min-height: 80px;
        border: 1px solid #ddd;
        border-radius: 7px;
        padding: 10px;
        font-size: 12px;
        resize: vertical;
        margin-bottom: 12px;
        box-sizing: border-box;
    }

    .rating-comment:focus {
        outline: none;
        border-color: #198754;
    }

    .rating-done {
        padding: 12px;
        border-radius: 7px;
        background: #f1f8f4;
        color: #1f6e43;
        font-size: 12px;
    }

    /* =========================================================
       POPUP FOTO
       ========================================================= */

    .foto-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0, 0, 0, .82);
        align-items: center;
        justify-content: center;
        padding: 15px;
    }

    .foto-modal img {
        width: min(1100px, 96vw);
        max-height: 94vh;
        height: auto;
        object-fit: contain;
        display: block;
        border-radius: 8px;
        background: white;
    }

    .foto-close {
        position: absolute;
        top: 18px;
        right: 28px;
        color: white;
        font-size: 42px;
        line-height: 1;
        cursor: pointer;
        z-index: 100000;
    }

    /* =========================================================
       POPUP MESSAGE
       ========================================================= */

    .flash-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 100000;
        min-width: 280px;
        max-width: 380px;
        padding: 13px 16px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .15);
        font-size: 12px;
    }

    .flash-success {
        border-left: 4px solid #198754;
    }

    .flash-error {
        border-left: 4px solid #dc3545;
    }

    @media (max-width: 768px) {

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-top {
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
        }

        .foto-laporan,
        .foto-empty {
            width: 100%;
            max-width: 300px;
        }

        .foto-modal img {
            width: 96vw;
            max-width: 96vw;
            max-height: 90vh;
        }

        .foto-close {
            top: 10px;
            right: 15px;
        }
    }
</style>


<div class="detail-page">

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="flash-popup flash-success" id="successPopup">
            {{ session('success') }}
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if(session('error'))
        <div class="flash-popup flash-error" id="errorPopup">
            {{ session('error') }}
        </div>
    @endif


    {{-- KEMBALI --}}
    <a href="{{ route('masyarakat.dashboard') }}" class="back-link">
        ← Kembali ke Dashboard
    </a>


    {{-- JUDUL + STATUS --}}
    <div class="detail-top">

        <h4>Detail Laporan</h4>

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

        {{-- =========================================================
             BAGIAN DETAIL LAPORAN
        ========================================================== --}}
        <div>

            <div class="detail-card">

                {{-- JUDUL --}}
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

                    $fotoUrl = $fotoPertama
                        ? asset('uploads/' . $fotoPertama)
                        : null;
                @endphp


                @if($fotoUrl)

                    <img
                        src="{{ $fotoUrl }}"
                        alt="Foto Laporan"
                        class="foto-laporan"
                        onclick="bukaFoto(@js($fotoUrl))"
                        title="Klik untuk melihat gambar lebih besar"
                    >

                    <div class="foto-hint">
                        Klik foto untuk melihat ukuran lebih besar.
                    </div>

                @else

                    <div class="foto-empty">
                        Tidak ada foto laporan
                    </div>

                @endif


                {{-- LOKASI --}}
                <div
                    class="label"
                    style="margin-top: 18px;"
                >
                    Lokasi Peta
                </div>

                <div class="map-wrapper">
                    <div id="map"></div>
                </div>

            </div>


            {{-- =====================================================
                 RATING
            ====================================================== --}}

            @if($status === 'selesai')

                <div class="rating-card">

                    @if(isset($rating) && $rating)

                        {{-- SUDAH RATING --}}

                        <div class="rating-title">
                            Rating Laporan
                        </div>

                        <div class="rating-description">
                            Anda sudah memberikan rating untuk laporan ini.
                        </div>


                        <div
                            class="rating-stars"
                            style="
                                flex-direction: row;
                                justify-content: flex-start;
                                pointer-events: none;
                            "
                        >

                            @for($i = 1; $i <= 5; $i++)

                                <span
                                    style="
                                        font-size: 36px;
                                        line-height: 1;
                                        color: {{ $i <= $rating->rating ? '#ffc107' : '#d7d7d7' }};
                                    "
                                >
                                    ★
                                </span>

                            @endfor

                        </div>


                        @if($rating->komentar)

                            <div
                                style="
                                    font-size: 11px;
                                    color: #666;
                                    margin-bottom: 12px;
                                "
                            >
                                "{{ $rating->komentar }}"
                            </div>

                        @endif


                        <div class="rating-done">
                            Rating sudah tersimpan.
                        </div>

                    @else

                        {{-- BELUM RATING --}}

                        <div class="rating-title">
                            Beri Rating
                        </div>

                        <div class="rating-description">
                            Laporan sudah selesai. Silakan berikan penilaian.
                        </div>


                        <form
                            action="{{ route('masyarakat.laporan.rating', $laporan->id) }}"
                            method="POST"
                        >
                            @csrf


                            <div
                                class="rating-stars"
                                id="ratingStars"
                            >

                                @for($i = 1; $i <= 5; $i++)

                                    <input
                                        type="radio"
                                        name="rating"
                                        id="star{{ $laporan->id }}_{{ $i }}"
                                        value="{{ $i }}"
                                        {{ old('rating') == $i ? 'checked' : '' }}
                                        required
                                    >

                                    <label
                                        for="star{{ $laporan->id }}_{{ $i }}"
                                        data-value="{{ $i }}"
                                        title="{{ $i }} bintang"
                                    >
                                        ★
                                    </label>

                                @endfor

                            </div>


                            <textarea
                                name="komentar"
                                class="rating-comment"
                                placeholder="Komentar (opsional)..."
                            >{{ old('komentar') }}</textarea>


                            <button
                                type="submit"
                                class="btn btn-success btn-sm"
                            >
                                Kirim Rating
                            </button>

                        </form>

                    @endif

                </div>

            @endif

        </div>


        {{-- =========================================================
             RIWAYAT STATUS
        ========================================================== --}}

        <div class="history-card">

            <div class="history-title">
                Riwayat Status
            </div>


            {{-- MENUNGGU VERIFIKASI --}}

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


            {{-- DIVERIFIKASI --}}

            <div class="history-item">

                <span
                    class="history-dot {{
                        $status === 'menunggu_verifikasi'
                            ? 'inactive'
                            : ''
                    }}"
                ></span>

                <div class="history-status">
                    Diverifikasi
                </div>

            </div>


            {{-- SEDANG DITANGANI --}}

            <div class="history-item">

                <span
                    class="history-dot {{
                        !in_array(
                            $status,
                            [
                                'sedang_ditangani',
                                'menunggu_validasi_akhir',
                                'selesai'
                            ]
                        )
                            ? 'inactive'
                            : ''
                    }}"
                ></span>

                <div class="history-status">
                    Sedang Ditangani
                </div>

            </div>


            {{-- MENUNGGU VALIDASI --}}

            <div class="history-item">

                <span
                    class="history-dot {{
                        !in_array(
                            $status,
                            [
                                'menunggu_validasi_akhir',
                                'selesai'
                            ]
                        )
                            ? 'inactive'
                            : ''
                    }}"
                ></span>

                <div class="history-status">
                    Menunggu Validasi
                </div>

            </div>


            {{-- SELESAI --}}

            <div class="history-item">

                <span
                    class="history-dot {{
                        $status !== 'selesai'
                            ? 'inactive'
                            : ''
                    }}"
                ></span>

                <div class="history-status">
                    Selesai
                </div>

                @if($status === 'selesai')

                    <div class="history-note">
                        Laporan telah selesai dan divalidasi Admin.
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     POPUP FOTO
============================================================= --}}

<div
    id="fotoModal"
    class="foto-modal"
    onclick="tutupFoto()"
>

    <span
        class="foto-close"
        onclick="event.stopPropagation(); tutupFoto();"
    >
        &times;
    </span>


    <img
        id="fotoModalImage"
        src=""
        alt="Foto Laporan"
        onclick="event.stopPropagation();"
    >

</div>


{{-- =============================================================
     LEAFLET
============================================================= --}}

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

    /* =========================================================
       RATING BINTANG
       ========================================================= */

    document.addEventListener('DOMContentLoaded', function () {

        const ratingStars = document.getElementById('ratingStars');

        if (ratingStars) {

            const inputs = ratingStars.querySelectorAll(
                'input[name="rating"]'
            );

            const labels = ratingStars.querySelectorAll(
                'label'
            );


            /*
             * Warnai bintang sesuai nilai yang dipilih.
             */
            function tampilkanRating(nilai) {

                labels.forEach(function (label) {

                    const value = parseInt(
                        label.dataset.value
                    );

                    if (value <= nilai) {

                        label.classList.add('active');

                    } else {

                        label.classList.remove('active');

                    }

                });

            }


            /*
             * Klik bintang.
             */
            inputs.forEach(function (input) {

                input.addEventListener('change', function () {

                    const nilai = parseInt(
                        this.value
                    );

                    tampilkanRating(nilai);

                });

            });


            /*
             * Efek saat mouse diarahkan ke bintang.
             */
            labels.forEach(function (label) {

                label.addEventListener('mouseenter', function () {

                    const nilai = parseInt(
                        this.dataset.value
                    );

                    labels.forEach(function (item) {

                        const value = parseInt(
                            item.dataset.value
                        );

                        if (value <= nilai) {

                            item.classList.add('hovered');

                        } else {

                            item.classList.remove('hovered');

                        }

                    });

                });


                label.addEventListener('mouseleave', function () {

                    labels.forEach(function (item) {

                        item.classList.remove('hovered');

                    });


                    const selected =
                        ratingStars.querySelector(
                            'input[name="rating"]:checked'
                        );


                    if (selected) {

                        tampilkanRating(
                            parseInt(selected.value)
                        );

                    } else {

                        labels.forEach(function (item) {

                            item.classList.remove('active');

                        });

                    }

                });

            });


            /*
             * Kalau sebelumnya ada old('rating'),
             * tampilkan kembali pilihan tersebut.
             */
            const selected =
                ratingStars.querySelector(
                    'input[name="rating"]:checked'
                );


            if (selected) {

                tampilkanRating(
                    parseInt(selected.value)
                );

            }

        }

    });


    /* =========================================================
       POPUP FOTO
       ========================================================= */

    function bukaFoto(url) {

        const modal =
            document.getElementById('fotoModal');

        const image =
            document.getElementById('fotoModalImage');


        image.src = url;

        modal.style.display = 'flex';

    }


    function tutupFoto() {

        const modal =
            document.getElementById('fotoModal');

        const image =
            document.getElementById('fotoModalImage');


        modal.style.display = 'none';

        image.src = '';

    }


    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            tutupFoto();

        }

    });


    /* =========================================================
       LEAFLET
       ========================================================= */

    document.addEventListener('DOMContentLoaded', function () {

        const latitude =
            {{ $laporan->latitude ?? -7.6531 }};

        const longitude =
            {{ $laporan->longitude ?? 111.3284 }};


        const map =
            L.map('map').setView(
                [latitude, longitude],
                15
            );


        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);


        const marker =
            L.marker([
                latitude,
                longitude
            ]).addTo(map);


        marker.bindPopup(`
            <div style="font-size:11px;">
                <strong>Lokasi Laporan</strong><br>
                {{ $laporan->alamat_lengkap ?? '-' }}
            </div>
        `).openPopup();

    });


    /* =========================================================
       POPUP MESSAGE
       ========================================================= */

    setTimeout(function () {

        const successPopup =
            document.getElementById('successPopup');

        const errorPopup =
            document.getElementById('errorPopup');


        if (successPopup) {

            successPopup.style.display = 'none';

        }


        if (errorPopup) {

            errorPopup.style.display = 'none';

        }

    }, 4000);

</script>

@endsection