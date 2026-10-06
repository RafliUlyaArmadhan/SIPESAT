@extends('layouts.app')

@section('content')

{{-- =========================================================
     LEAFLET CSS
========================================================= --}}

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"
/>

{{-- =========================================================
     SELECT2 CSS
========================================================= --}}

<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
/>

<link
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet"
/>

<style>
    /* =========================================================
       UPLOAD FOTO
    ========================================================= */

    .upload-drop-zone {
        border: 2px dashed var(--color-border, #E2E5E1);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background-color: var(--color-bg, #F6F7F5);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .upload-drop-zone.dragover {
        border-color: var(--color-primary, #1F6E43);
        background-color: var(--color-primary-light, #E8F3EC);
    }

    .upload-drop-zone i {
        font-size: 3rem;
        color: var(--color-muted, #6B7280);
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .upload-drop-zone.dragover i {
        color: var(--color-primary, #1F6E43);
    }

    .upload-drop-zone input[type="file"] {
        display: none;
    }

    /* =========================================================
       PREVIEW FOTO
    ========================================================= */

    #image-preview {
        display: none;
        margin-top: 15px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--color-border, #E2E5E1);
        position: relative;
        background: #f8f9fa;
    }

    #preview-gallery .preview-item {
        position: relative;
        height: 120px;
    }

    #preview-gallery .preview-thumb {
        display: block;
        width: 100%;
        height: 120px;
        object-fit: cover;
        cursor: zoom-in;
        border-radius: 6px;
        transition: transform 0.25s ease;
    }

    #preview-gallery .preview-thumb:hover {
        transform: scale(1.02);
        opacity: 0.9;
    }

    #preview-gallery .remove-single-image {
        position: absolute;
        top: 5px;
        right: 5px;
        z-index: 2;
        width: 28px;
        height: 28px;
        border: 0;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        cursor: pointer;
    }

    #btn-add-more-photo {
        border-style: dashed;
    }

    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
    }

    .remove-image:hover {
        background: #dc3545;
        transform: scale(1.08);
    }

    .preview-hint {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(
            transparent,
            rgba(0, 0, 0, 0.7)
        );
        color: white;
        padding: 25px 10px 10px;
        font-size: 13px;
        text-align: center;
        pointer-events: none;
    }

    /* =========================================================
       MODAL FOTO BESAR
    ========================================================= */

    #photoPreviewModal .modal-dialog {
        max-width: 95vw;
    }

    #photoPreviewModal .modal-content {
        background: rgba(0, 0, 0, 0.95);
        border: none;
        border-radius: 12px;
    }

    #photoPreviewModal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    #photoPreviewModal .modal-title {
        color: white;
    }

    #photoPreviewModal .btn-close {
        filter: invert(1);
    }

    #photoPreviewModal .modal-body {
        padding: 15px;
        text-align: center;
        max-height: 85vh;
        overflow: auto;
    }

    #large-preview-img {
        max-width: 100%;
        max-height: 80vh;
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 8px;
    }

    /* =========================================================
       CAMERA
    ========================================================= */

    #camera-container {
        width: 100%;
        min-height: 250px;
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #camera-video {
        display: block;
        width: 100%;
        height: auto;
        min-height: 250px;
        max-height: 65vh;
        object-fit: cover;
        border-radius: 10px;
        background: #000;
    }

    #camera-error {
        display: none;
    }

    /* =========================================================
       MAP
    ========================================================= */

    #map-picker {
        min-height: 350px;
    }

    /* =========================================================
       VALIDASI FIELD KOSONG
    ========================================================= */

    .field-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15) !important;
    }

    .select2-container.field-invalid .select2-selection {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15) !important;
    }

    .upload-drop-zone.field-invalid {
        border-color: #dc3545 !important;
        background-color: #fdecee;
    }
</style>


<div class="container my-5">

    <div class="card shadow-sm border-0">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                Buat Laporan Sampah Baru
            </h4>

        </div>


        <div class="card-body">

            {{-- =================================================
                 ERROR VALIDATION
            ================================================== --}}

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =================================================
                 FORM
            ================================================== --}}

            <form
                id="form-laporan"
                action="{{ route('masyarakat.laporan.store') }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >

                @csrf


                <div class="row">

                    {{-- =================================================
                         JUDUL
                    ================================================== --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="judul_laporan"
                            class="form-label"
                        >
                            Judul Laporan
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="judul_laporan"
                            name="judul_laporan"
                            value="{{ old('judul_laporan') }}"
                            required
                        >

                    </div>


                    {{-- =================================================
                         KATEGORI
                    ================================================== --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="kategori_sampah_id"
                            class="form-label"
                        >
                            Kategori Sampah
                        </label>

                        <select
                            class="form-select"
                            id="kategori_sampah_id"
                            name="kategori_sampah_id"
                            required
                        >

                            <option value="">
                                Pilih Kategori
                            </option>

                            @foreach($kategoris as $kategori)

                                <option
                                    value="{{ $kategori->id }}"
                                    {{ old('kategori_sampah_id') == $kategori->id ? 'selected' : '' }}
                                >
                                    {{ $kategori->nama_kategori }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         KECAMATAN
                    ================================================== --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="kecamatan_id"
                            class="form-label"
                        >
                            Kecamatan
                        </label>

                        <select
                            class="form-select"
                            id="kecamatan_id"
                            name="kecamatan_id"
                            required
                        >

                            <option value="">
                                Pilih Kecamatan
                            </option>

                            @foreach($kecamatans as $kecamatan)

                                <option
                                    value="{{ $kecamatan->id }}"
                                    {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}
                                >
                                    {{ $kecamatan->nama_kecamatan }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         DESA / KELURAHAN
                    ================================================== --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="desa_id"
                            class="form-label"
                        >
                            Desa / Kelurahan
                        </label>

                        <select
                            class="form-select"
                            id="desa_id"
                            name="desa_id"
                            required
                            disabled
                        >

                            <option value="">
                                Pilih Desa / Kelurahan
                            </option>

                        </select>

                    </div>


                    {{-- =================================================
                         DESKRIPSI
                    ================================================== --}}

                    <div class="col-md-12 mb-3">

                        <label
                            for="deskripsi"
                            class="form-label"
                        >
                            Deskripsi Laporan
                        </label>

                        <textarea
                            class="form-control"
                            id="deskripsi"
                            name="deskripsi"
                            rows="3"
                            required
                        >{{ old('deskripsi') }}</textarea>

                    </div>


                    {{-- =================================================
                         ALAMAT
                    ================================================== --}}

                    <div class="col-md-12 mb-3">

                        <label
                            for="alamat_lengkap"
                            class="form-label"
                        >
                            Alamat Lengkap
                        </label>

                        <textarea
                            class="form-control"
                            id="alamat_lengkap"
                            name="alamat_lengkap"
                            rows="2"
                            required
                        >{{ old('alamat_lengkap') }}</textarea>

                    </div>


                    {{-- =================================================
                         MAP
                    ================================================== --}}

                    <div class="col-md-12 mb-3">

                        <div class="d-flex justify-content-between align-items-end mb-2">

                            <label class="form-label mb-0">
                                Tentukan Titik Lokasi di Peta
                            </label>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-success"
                                id="btn-current-location"
                            >

                                <i class="fa-solid fa-location-crosshairs"></i>

                                Gunakan Lokasi Saat Ini

                            </button>

                        </div>


                        <div
                            id="map-picker"
                            style="height: 350px; width: 100%; z-index: 1;"
                            class="border rounded shadow-sm"
                        >
                        </div>


                        <p class="form-text text-muted">

                            Geser marker, klik pada peta, gunakan fitur pencarian
                            atau deteksi lokasi otomatis.

                        </p>


                        <div class="row mt-2">

                            <div class="col-md-6">

                                <label
                                    for="latitude"
                                    class="form-label"
                                >
                                    Latitude
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    id="latitude"
                                    name="latitude"
                                    value="{{ old('latitude') }}"
                                    readonly
                                    required
                                >

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="longitude"
                                    class="form-label"
                                >
                                    Longitude
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    id="longitude"
                                    name="longitude"
                                    value="{{ old('longitude') }}"
                                    readonly
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         FOTO LAPORAN
                    ================================================== --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Foto Laporan (Maks. 2MB)
                        </label>


                        {{-- DROP ZONE --}}

                        <div
                            class="upload-drop-zone"
                            id="drop-zone"
                        >

                            <i class="fa-solid fa-camera"></i>

                            <h6 class="fw-bold text-dark">
                                Tambahkan Foto Laporan
                            </h6>

                            <p class="text-muted small mb-3">
                                Silakan pilih salah satu cara untuk menambahkan foto
                            </p>


                            {{-- KAMERA --}}

                            <button
                                type="button"
                                class="btn btn-primary w-100 mb-2"
                                id="btn-camera"
                            >

                                <i class="fa-solid fa-camera me-1"></i>

                                Ambil Foto dari Kamera

                            </button>


                            {{-- GALERI --}}

                            <button
                                type="button"
                                class="btn btn-outline-primary w-100"
                                id="btn-gallery"
                            >

                                <i class="fa-solid fa-images me-1"></i>

                                Pilih Foto dari Galeri

                            </button>


                            {{-- INPUT GALERI --}}

                            <input
                                type="file"
                                id="foto_gallery"
                                accept="image/png,image/jpeg,image/jpg"
                                multiple
                            >


                            {{-- INPUT UTAMA --}}

                            <input
                                type="file"
                                id="foto_laporan"
                                name="foto_laporan[]"
                                accept="image/png,image/jpeg,image/jpg"
                                multiple
                                required
                                style="display:none;"
                            >

                        </div>


                        {{-- =================================================
                             PREVIEW FOTO
                        ================================================== --}}

                        <div
                            id="image-preview"
                            class="position-relative"
                        >

                            <button
                                type="button"
                                class="remove-image"
                                id="remove-btn"
                                title="Hapus Semua Foto"
                            >

                                <i class="fa-solid fa-xmark"></i>

                            </button>

                            <div id="preview-gallery" class="row g-2 p-2"></div>

                            <button
                                type="button"
                                class="btn btn-outline-primary w-100 mt-2"
                                id="btn-add-more-photo"
                            >

                                <i class="fa-solid fa-images me-1"></i>

                                Tambah Foto

                            </button>

                            <div class="preview-hint">

                                <i class="fa-solid fa-magnifying-glass-plus me-1"></i>

                                Klik foto untuk melihat ukuran besar

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     BUTTON
                ================================================== --}}

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary px-4 fw-bold"
                    >
                        Kirim Laporan
                    </button>


                    <a
                        href="{{ route('masyarakat.dashboard') }}"
                        class="btn btn-outline-secondary px-4 ms-2"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ============================================================
     MODAL KAMERA
============================================================= --}}

<div
    class="modal fade"
    id="cameraModal"
    tabindex="-1"
    aria-labelledby="cameraModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="cameraModalLabel"
                >

                    <i class="fa-solid fa-camera me-2"></i>

                    Ambil Foto dari Kamera

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    id="close-camera-btn"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                </button>

            </div>


            <div class="modal-body">

                <div id="camera-container">

                    <video
                        id="camera-video"
                        autoplay
                        playsinline
                        muted
                    >
                    </video>

                </div>


                <canvas
                    id="camera-canvas"
                    style="display:none;"
                >
                </canvas>


                <div
                    id="camera-error"
                    class="alert alert-danger mt-3 mb-0"
                >
                </div>

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
                    type="button"
                    class="btn btn-primary"
                    id="btn-take-photo"
                >

                    <i class="fa-solid fa-camera me-1"></i>

                    Ambil Foto

                </button>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     MODAL FOTO BESAR
============================================================= --}}

<div
    class="modal fade"
    id="photoPreviewModal"
    tabindex="-1"
    aria-labelledby="photoPreviewModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="photoPreviewModalLabel"
                >

                    <i class="fa-solid fa-image me-2"></i>

                    Preview Foto

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                </button>

            </div>


            <div class="modal-body">

                <img
                    src=""
                    id="large-preview-img"
                    alt="Foto Ukuran Besar"
                >

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     POPUP FILE TERLALU BESAR
============================================================= --}}

<div
    class="modal fade"
    id="fileSizeModal"
    tabindex="-1"
    aria-labelledby="fileSizeModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="fileSizeModalLabel"
                >

                    <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>

                    Ukuran Foto Terlalu Besar

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                </button>

            </div>


            <div class="modal-body text-center">

                <i
                    class="fa-solid fa-image text-warning"
                    style="font-size: 50px;"
                >
                </i>


                <p class="mt-3 mb-2 fw-bold">
                    Foto yang dipilih terlalu besar.
                </p>


                <p class="text-muted mb-0">

                    Ukuran maksimal foto adalah
                    <strong>2 MB</strong>.

                </p>


                <p class="text-muted mb-0">

                    Silakan pilih foto lain atau ambil foto kembali.

                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-dismiss="modal"
                >
                    Mengerti
                </button>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     POPUP DATA BELUM LENGKAP
============================================================= --}}

<div
    class="modal fade"
    id="incompleteModal"
    tabindex="-1"
    aria-labelledby="incompleteModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="incompleteModalLabel"
                >

                    <i class="fa-solid fa-circle-exclamation text-danger me-2"></i>

                    Data Belum Lengkap

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                </button>

            </div>


            <div class="modal-body">

                <p class="mb-2">
                    Mohon lengkapi data berikut sebelum mengirim laporan:
                </p>

                <ul
                    id="incomplete-list"
                    class="text-danger mb-0"
                >
                </ul>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-primary"
                    id="btn-incomplete-ok"
                    data-bs-dismiss="modal"
                >
                    Lengkapi Sekarang
                </button>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     LEAFLET JS
============================================================= --}}

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>


<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>


{{-- ============================================================
     JQUERY
============================================================= --}}

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


{{-- ============================================================
     SELECT2
============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


{{-- ============================================================
     BOOTSTRAP 5 JS
============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =========================================================
       MAP
    ========================================================= */

    var latInput =
        document.getElementById('latitude');

    var lngInput =
        document.getElementById('longitude');


    var defaultLat =
        latInput.value
            ? parseFloat(latInput.value)
            : -7.6531;


    var defaultLng =
        lngInput.value
            ? parseFloat(lngInput.value)
            : 111.3284;


    var map =
        L.map('map-picker')
            .setView(
                [defaultLat, defaultLng],
                12
            );


    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }
    ).addTo(map);


    /* =========================================================
       MARKER
    ========================================================= */

    var marker =
        L.marker(
            [defaultLat, defaultLng],
            {
                draggable: true
            }
        ).addTo(map);


    marker.on(
        'dragend',
        function () {

            var position =
                marker.getLatLng();

            latInput.value =
                position.lat;

            lngInput.value =
                position.lng;

        }
    );


    map.on(
        'click',
        function (e) {

            marker.setLatLng(
                e.latlng
            );

            latInput.value =
                e.latlng.lat;

            lngInput.value =
                e.latlng.lng;

        }
    );


    if (
        !latInput.value ||
        !lngInput.value
    ) {

        latInput.value =
            defaultLat;

        lngInput.value =
            defaultLng;

    }


    /* =========================================================
       GEOCODER
    ========================================================= */

    L.Control.geocoder({

        defaultMarkGeocode: false,

        placeholder:
            'Cari nama tempat / jalan...'

    })
    .on(
        'markgeocode',
        function (e) {

            var bbox =
                e.geocode.bbox;


            if (bbox) {

                var poly =
                    L.polygon([
                        bbox.getSouthEast(),
                        bbox.getNorthEast(),
                        bbox.getNorthWest(),
                        bbox.getSouthWest()
                    ]);

                map.fitBounds(
                    poly.getBounds()
                );

            } else {

                map.setView(
                    e.geocode.center,
                    16
                );

            }


            var latlng =
                e.geocode.center;


            marker.setLatLng(
                latlng
            );


            latInput.value =
                latlng.lat;

            lngInput.value =
                latlng.lng;


            var alamatInput =
                document.getElementById(
                    'alamat_lengkap'
                );


            if (!alamatInput.value) {

                alamatInput.value =
                    e.geocode.name;

            }

        }
    )
    .addTo(map);


    /* =========================================================
       LOKASI SAAT INI
    ========================================================= */

    document
        .getElementById('btn-current-location')
        .addEventListener(
            'click',
            function () {

                var btn = this;


                if (navigator.geolocation) {

                    btn.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Mencari lokasi...';


                    btn.disabled = true;


                    navigator.geolocation.getCurrentPosition(

                        function (position) {

                            var lat =
                                position.coords.latitude;

                            var lng =
                                position.coords.longitude;


                            map.setView(
                                [lat, lng],
                                16
                            );


                            marker.setLatLng(
                                [lat, lng]
                            );


                            latInput.value =
                                lat;

                            lngInput.value =
                                lng;


                            btn.innerHTML =
                                '<i class="fa-solid fa-check"></i> Lokasi Ditemukan';


                            btn.classList.replace(
                                'btn-outline-success',
                                'btn-success'
                            );


                            setTimeout(
                                function () {

                                    btn.innerHTML =
                                        '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';


                                    btn.classList.replace(
                                        'btn-success',
                                        'btn-outline-success'
                                    );


                                    btn.disabled =
                                        false;

                                },
                                3000
                            );

                        },


                        function () {

                            alert(
                                'Gagal mendapatkan lokasi. Pastikan izin lokasi (GPS) diaktifkan di browser/HP Anda.'
                            );


                            btn.innerHTML =
                                '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';


                            btn.disabled =
                                false;

                        }

                    );

                } else {

                    alert(
                        'Browser Anda tidak mendukung fitur lokasi GPS.'
                    );

                }

            }
        );

});


/* ============================================================
   FOTO LAPORAN
   KAMERA + GALERI + DRAG & DROP
============================================================= */

const dropZone =
    document.getElementById('drop-zone');

const galleryInput =
    document.getElementById('foto_gallery');

const mainFileInput =
    document.getElementById('foto_laporan');

const imagePreview =
    document.getElementById('image-preview');

const previewGallery =
    document.getElementById('preview-gallery');

const btnAddMorePhoto =
    document.getElementById('btn-add-more-photo');

const removeBtn =
    document.getElementById('remove-btn');

const btnCamera =
    document.getElementById('btn-camera');

const btnGallery =
    document.getElementById('btn-gallery');


/* ============================================================
   MODAL FOTO BESAR
============================================================= */

const photoPreviewModalElement =
    document.getElementById('photoPreviewModal');

const largePreviewImg =
    document.getElementById('large-preview-img');

let photoPreviewModal = null;


if (
    typeof bootstrap !== 'undefined' &&
    bootstrap.Modal
) {

    photoPreviewModal =
        bootstrap.Modal.getOrCreateInstance(
            photoPreviewModalElement
        );

}


/* ============================================================
   KLIK FOTO UNTUK MEMBESARKAN
============================================================= */

previewGallery.addEventListener(
    'click',
    function (event) {

        const image = event.target.closest('.preview-thumb');

        if (!image || !image.src) {
            return;
        }

        largePreviewImg.src = image.src;

        if (photoPreviewModal) {
            photoPreviewModal.show();
        }

    }
);


/* ============================================================
   BATAS UKURAN
============================================================= */

const MAX_FILE_SIZE =
    2 * 1024 * 1024;


/* ============================================================
   CAMERA ELEMENT
============================================================= */

const cameraModalElement =
    document.getElementById('cameraModal');

const cameraVideo =
    document.getElementById('camera-video');

const cameraCanvas =
    document.getElementById('camera-canvas');

const cameraError =
    document.getElementById('camera-error');

const btnTakePhoto =
    document.getElementById('btn-take-photo');

const closeCameraBtn =
    document.getElementById('close-camera-btn');

let cameraStream = null;
let cameraModal = null;


/* ============================================================
   BOOTSTRAP CAMERA MODAL
============================================================= */

function initializeCameraModal() {

    if (!cameraModalElement) {

        console.error(
            'Element #cameraModal tidak ditemukan.'
        );

        return false;

    }


    if (
        typeof bootstrap === 'undefined' ||
        !bootstrap.Modal
    ) {

        console.error(
            'Bootstrap JS belum tersedia.'
        );

        return false;

    }


    cameraModal =
        bootstrap.Modal.getOrCreateInstance(
            cameraModalElement
        );


    return true;

}


initializeCameraModal();


/* ============================================================
   ERROR KAMERA
============================================================= */

function showCameraError(message) {

    cameraError.textContent =
        message;

    cameraError.style.display =
        'block';

}


function hideCameraError() {

    cameraError.textContent =
        '';

    cameraError.style.display =
        'none';

}


/* ============================================================
   STOP CAMERA
============================================================= */

function stopCamera() {

    if (cameraStream) {

        const tracks =
            cameraStream.getTracks();


        tracks.forEach(
            function (track) {
                track.stop();
            }
        );


        cameraStream = null;

    }


    if (cameraVideo) {

        cameraVideo.pause();

        cameraVideo.srcObject =
            null;

        cameraVideo.removeAttribute(
            'src'
        );

        cameraVideo.load();

    }

}


/* ============================================================
   START CAMERA
============================================================= */

async function startCamera() {

    hideCameraError();

    stopCamera();


    if (
        !navigator.mediaDevices ||
        !navigator.mediaDevices.getUserMedia
    ) {

        showCameraError(
            'Browser Anda tidak mendukung kamera. Gunakan Chrome atau browser terbaru.'
        );

        return false;

    }


    if (
        !window.isSecureContext &&
        location.hostname !== 'localhost' &&
        location.hostname !== '127.0.0.1'
    ) {

        showCameraError(
            'Kamera membutuhkan HTTPS atau localhost.'
        );

        return false;

    }


    try {

        const stream =
            await navigator.mediaDevices.getUserMedia({

                video: true,

                audio: false

            });


        cameraStream =
            stream;


        cameraVideo.srcObject =
            cameraStream;

        cameraVideo.muted =
            true;

        cameraVideo.autoplay =
            true;

        cameraVideo.playsInline =
            true;


        await new Promise(
            function (resolve, reject) {

                let selesai = false;


                function berhasil() {

                    if (selesai) {
                        return;
                    }


                    selesai = true;

                    resolve();

                }


                cameraVideo.onloadedmetadata =
                    berhasil;


                if (
                    cameraVideo.readyState >= 1 &&
                    cameraVideo.videoWidth > 0
                ) {

                    berhasil();

                }


                setTimeout(
                    function () {

                        if (selesai) {
                            return;
                        }


                        if (
                            cameraVideo.videoWidth > 0 &&
                            cameraVideo.videoHeight > 0
                        ) {

                            berhasil();

                        } else {

                            selesai = true;

                            reject(
                                new Error(
                                    'Video kamera tidak memberikan ukuran.'
                                )
                            );

                        }

                    },
                    5000
                );

            }
        );


        try {

            await cameraVideo.play();

        } catch (playError) {

            console.error(
                'VIDEO PLAY ERROR:',
                playError
            );

        }


        if (
            cameraVideo.videoWidth <= 0 ||
            cameraVideo.videoHeight <= 0
        ) {

            showCameraError(
                'Kamera aktif tetapi gambar belum muncul. Tunggu sebentar lalu coba lagi.'
            );

            return false;

        }


        return true;


    } catch (error) {

        console.error(
            'GET USER MEDIA ERROR:',
            error
        );


        stopCamera();


        if (
            error.name === 'NotAllowedError' ||
            error.name === 'PermissionDeniedError'
        ) {

            showCameraError(
                'Akses kamera ditolak. Silakan izinkan kamera pada browser/HP Anda.'
            );

        }

        else if (
            error.name === 'NotFoundError'
        ) {

            showCameraError(
                'Kamera tidak ditemukan pada perangkat ini.'
            );

        }

        else if (
            error.name === 'NotReadableError'
        ) {

            showCameraError(
                'Kamera sedang digunakan aplikasi lain.'
            );

        }

        else if (
            error.name === 'SecurityError'
        ) {

            showCameraError(
                'Akses kamera diblokir browser. Gunakan HTTPS atau localhost.'
            );

        }

        else {

            showCameraError(
                'Kamera tidak dapat dibuka. Pastikan kamera tidak sedang digunakan aplikasi lain.'
            );

        }


        return false;

    }

}


/* ============================================================
   TOMBOL CAMERA
============================================================= */

btnCamera.addEventListener(
    'click',
    function (e) {

        e.preventDefault();

        hideCameraError();


        if (!cameraModal) {

            const berhasil =
                initializeCameraModal();


            if (!berhasil) {

                alert(
                    'Modal kamera tidak dapat dibuka karena Bootstrap JS belum tersedia.'
                );

                return;

            }

        }


        stopCamera();

        cameraModal.show();

    }
);


/* ============================================================
   MODAL KAMERA SELESAI DIBUKA
============================================================= */

cameraModalElement.addEventListener(
    'shown.bs.modal',
    function () {

        setTimeout(
            function () {
                startCamera();
            },
            300
        );

    }
);


/* ============================================================
   AMBIL FOTO
============================================================= */

btnTakePhoto.addEventListener(
    'click',
    function () {

        if (!cameraStream) {

            showCameraError(
                'Kamera belum aktif. Tunggu sampai gambar kamera muncul.'
            );

            return;

        }


        if (
            !cameraVideo.videoWidth ||
            !cameraVideo.videoHeight
        ) {

            showCameraError(
                'Kamera belum siap. Tunggu beberapa detik kemudian coba lagi.'
            );

            return;

        }


        cameraCanvas.width =
            cameraVideo.videoWidth;

        cameraCanvas.height =
            cameraVideo.videoHeight;


        const context =
            cameraCanvas.getContext('2d');


        if (!context) {

            showCameraError(
                'Browser tidak dapat memproses gambar kamera.'
            );

            return;

        }


        context.drawImage(
            cameraVideo,
            0,
            0,
            cameraCanvas.width,
            cameraCanvas.height
        );


        cameraCanvas.toBlob(
            function (blob) {

                if (!blob) {

                    showCameraError(
                        'Gagal mengambil foto. Silakan coba lagi.'
                    );

                    return;

                }


                const file =
                    new File(
                        [blob],
                        'foto-kamera.jpg',
                        {
                            type: 'image/jpeg'
                        }
                    );


                const berhasil =
                    handleSelectedFile(file);


                if (berhasil) {

                    stopCamera();


                    if (cameraModal) {
                        cameraModal.hide();
                    }

                }

            },
            'image/jpeg',
            0.85
        );

    }
);


/* ============================================================
   MODAL KAMERA DITUTUP
============================================================= */

cameraModalElement.addEventListener(
    'hidden.bs.modal',
    function () {

        stopCamera();

        hideCameraError();

    }
);


/* ============================================================
   GALERI
============================================================= */

galleryInput.addEventListener(
    'change',
    function () {

        if (this.files.length > 0) {
            handleSelectedFiles(Array.from(this.files));
        }

    }
);


/* ============================================================
   TOMBOL GALERI
============================================================= */

btnGallery.addEventListener(
    'click',
    function () {
        galleryInput.click();
    }
);


/* ============================================================
   TOMBOL TAMBAH FOTO SETELAH ADA PREVIEW
============================================================= */

btnAddMorePhoto.addEventListener(
    'click',
    function () {
        galleryInput.click();
    }
);


/* ============================================================
   PROSES BANYAK FILE
============================================================= */

let selectedFiles = [];

function handleSelectedFiles(files) {

    const validFiles = [];

    files.forEach(
        function (file) {

            if (!file || !file.type.startsWith('image/')) {
                alert(
                    'File yang dipilih bukan gambar. Silakan pilih foto PNG, JPG, atau JPEG.'
                );
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                showFileSizeModal();
                return;
            }

            validFiles.push(file);

        }
    );

    if (validFiles.length === 0) {
        galleryInput.value = '';
        return false;
    }

    selectedFiles = selectedFiles.concat(validFiles);

    syncMainFileInput();
    renderPreviews();

    galleryInput.value = '';

    return true;

}


/* Dipakai juga oleh hasil foto kamera */
function handleSelectedFile(file) {
    return handleSelectedFiles([file]);
}


function syncMainFileInput() {

    try {

        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(
            function (file) {
                dataTransfer.items.add(file);
            }
        );

        mainFileInput.files = dataTransfer.files;

    }
    catch (error) {

        console.error(
            'Gagal memasukkan file:',
            error
        );

        alert(
            'Gagal memproses foto. Silakan coba lagi.'
        );

    }

}


function renderPreviews() {

    previewGallery.innerHTML = '';

    selectedFiles.forEach(
        function (file, index) {

            const reader = new FileReader();

            reader.onload = function () {

                const wrapper = document.createElement('div');

                wrapper.className =
                    'col-6 col-md-4 preview-item';

                wrapper.innerHTML = `
                    <button
                        type="button"
                        class="remove-single-image"
                        data-index="${index}"
                        title="Hapus Foto"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <img
                        src="${reader.result}"
                        class="preview-thumb"
                        alt="Preview Foto"
                        title="Klik foto untuk melihat ukuran besar"
                    >
                `;

                previewGallery.appendChild(wrapper);

            };

            reader.readAsDataURL(file);

        }
    );

    imagePreview.style.display =
        selectedFiles.length > 0 ? 'block' : 'none';

    dropZone.style.display =
        selectedFiles.length > 0 ? 'none' : 'block';

    /* Hapus highlight merah ketika foto sudah ditambahkan */
    if (selectedFiles.length > 0) {
        dropZone.classList.remove('field-invalid');
    }

}


/* ============================================================
   HAPUS SATU FOTO
============================================================= */

previewGallery.addEventListener(
    'click',
    function (event) {

        const button =
            event.target.closest('.remove-single-image');

        if (!button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        selectedFiles.splice(
            Number(button.dataset.index),
            1
        );

        syncMainFileInput();
        renderPreviews();

    }
);


/* ============================================================
   MODAL FILE TERLALU BESAR
============================================================= */

function showFileSizeModal() {

    if (
        typeof bootstrap !== 'undefined' &&
        bootstrap.Modal
    ) {

        const modalElement =
            document.getElementById(
                'fileSizeModal'
            );


        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        modal.show();

    }

    else {

        alert(
            'Foto yang dipilih terlalu besar. Ukuran maksimal foto adalah 2 MB.'
        );

    }

}


/* ============================================================
   HAPUS FOTO
============================================================= */

removeBtn.addEventListener(
    'click',
    function (e) {

        e.preventDefault();

        e.stopPropagation();

        resetUpload();

    }
);


/* ============================================================
   RESET FOTO
============================================================= */

function resetUpload() {

    selectedFiles = [];

    galleryInput.value = '';

    mainFileInput.value = '';

    previewGallery.innerHTML = '';

    imagePreview.style.display = 'none';

    largePreviewImg.src = '';

    dropZone.style.display = 'block';

}


/* ============================================================
   DRAG & DROP
============================================================= */

[
    'dragenter',
    'dragover',
    'dragleave',
    'drop'
].forEach(
    function (eventName) {

        dropZone.addEventListener(
            eventName,
            preventDefaults,
            false
        );

    }
);


function preventDefaults(e) {

    e.preventDefault();

    e.stopPropagation();

}


/* ============================================================
   DRAG HIGHLIGHT
============================================================= */

[
    'dragenter',
    'dragover'
].forEach(
    function (eventName) {

        dropZone.addEventListener(
            eventName,
            highlight,
            false
        );

    }
);


[
    'dragleave',
    'drop'
].forEach(
    function (eventName) {

        dropZone.addEventListener(
            eventName,
            unhighlight,
            false
        );

    }
);


function highlight() {

    dropZone.classList.add(
        'dragover'
    );

}


function unhighlight() {

    dropZone.classList.remove(
        'dragover'
    );

}


/* ============================================================
   DROP FOTO
============================================================= */

dropZone.addEventListener(
    'drop',
    handleDrop,
    false
);


function handleDrop(e) {

    const files =
        e.dataTransfer.files;


    if (
        files.length > 0
    ) {

        handleSelectedFiles(
            Array.from(files)
        );

    }

}


/* ============================================================
   SELECT2 KECAMATAN & DESA / KELURAHAN
   BAGIAN INI DIPERBAIKI
============================================================= */

const $kecamatanSelect =
    $('#kecamatan_id');

const $desaSelect =
    $('#desa_id');

const oldDesaId =
    "{{ old('desa_id') }}";


/* ============================================================
   INIT SELECT2 KECAMATAN
============================================================= */

$kecamatanSelect.select2({

    theme: 'bootstrap-5',

    placeholder:
        'Cari & Pilih Kecamatan...'

});


/* ============================================================
   INIT SELECT2 DESA / KELURAHAN
============================================================= */

$desaSelect.select2({

    theme: 'bootstrap-5',

    placeholder:
        'Cari & Pilih Desa / Kelurahan...'

});


/* ============================================================
   KUNCI DROPDOWN DESA
============================================================= */

$desaSelect.on(
    'select2:closing',
    function (e) {

        if (!$(this).val()) {

            e.preventDefault();

        }

    }
);


/* ============================================================
   UPDATE DESA BERDASARKAN KECAMATAN
============================================================= */

function updateDesaDropdown(
    kecamatanId,
    autoOpen = false
) {

    /*
     * Kosongkan Desa terlebih dahulu
     */
    $desaSelect.empty();


    /*
     * Tambahkan pilihan awal
     */
    $desaSelect.append(
        new Option(
            'Pilih Desa / Kelurahan',
            '',
            true,
            true
        )
    );


    /*
     * Disable Desa ketika belum ada Kecamatan
     */
    $desaSelect.prop(
        'disabled',
        true
    );


    /*
     * Kalau Kecamatan kosong,
     * berhenti di sini.
     */
    if (!kecamatanId) {

        $desaSelect.trigger(
            'change.select2'
        );

        return;

    }


    /*
     * Ambil Desa berdasarkan Kecamatan
     */
    $.ajax({

        url:
            "{{ route('masyarakat.get.desas') }}",

        type:
            "GET",

        data: {
            kecamatan_id:
                kecamatanId
        },


        success:
            function (desas) {

                /*
                 * Masukkan semua Desa
                 */
                desas.forEach(
                    function (desa) {

                        const isSelected =
                            oldDesaId == desa.id;


                        const option =
                            new Option(
                                desa.nama_desa,
                                desa.id,
                                isSelected,
                                isSelected
                            );


                        $desaSelect.append(
                            option
                        );

                    }
                );


                /*
                 * Aktifkan kembali Desa
                 */
                $desaSelect.prop(
                    'disabled',
                    false
                );


                /*
                 * Refresh Select2
                 */
                $desaSelect.trigger(
                    'change.select2'
                );


                /*
                 * Setelah Kecamatan dipilih,
                 * otomatis buka pencarian Desa.
                 */
                if (autoOpen) {

                    setTimeout(
                        function () {

                            $desaSelect.select2(
                                'open'
                            );


                            /*
                             * Pengaman apabila Select2
                             * belum terbuka
                             */
                            if (
                                !$('.select2-container--open').length
                            ) {

                                $desaSelect.select2(
                                    'open'
                                );

                            }

                        },
                        250
                    );

                }

            },


        error:
            function () {

                alert(
                    'Gagal mengambil data Desa. Silakan coba lagi.'
                );

            }

    });

}


/* ============================================================
   KECAMATAN DIPILIH DARI SELECT2
============================================================= */

$kecamatanSelect.on(
    'select2:select',
    function () {

        updateDesaDropdown(
            this.value,
            true
        );

    }
);


/* ============================================================
   CHANGE KECAMATAN
============================================================= */

$kecamatanSelect.on(
    'change',
    function (e) {

        /*
         * Jalankan ketika nilai berubah
         * bukan dari event select2:select
         */
        if (
            !e.originalEvent &&
            !e.params
        ) {

            updateDesaDropdown(
                this.value,
                false
            );

        }

    }
);


/* ============================================================
   LOAD DESA SAAT HALAMAN PERTAMA DIBUKA
   Digunakan ketika old('kecamatan_id') masih ada
============================================================= */

if (
    $kecamatanSelect.val()
) {

    updateDesaDropdown(
        $kecamatanSelect.val(),
        false
    );

}


/* ============================================================
   VALIDASI FORM + POPUP DATA BELUM LENGKAP
============================================================= */

const formLaporan =
    document.getElementById('form-laporan');

const incompleteModalElement =
    document.getElementById('incompleteModal');

const incompleteList =
    document.getElementById('incomplete-list');


/* Daftar field wajib */
const requiredFields = [
    { id: 'judul_laporan',      label: 'Judul Laporan' },
    { id: 'kategori_sampah_id', label: 'Kategori Sampah' },
    { id: 'kecamatan_id',       label: 'Kecamatan' },
    { id: 'desa_id',            label: 'Desa / Kelurahan' },
    { id: 'deskripsi',          label: 'Deskripsi Laporan' },
    { id: 'alamat_lengkap',     label: 'Alamat Lengkap' },
    { id: 'latitude',           label: 'Titik Lokasi di Peta' }
];


/* Ambil elemen yang perlu diberi highlight merah */
function getHighlightTarget(id) {

    const el = document.getElementById(id);

    /* Select2: highlight container-nya, bukan <select> aslinya */
    if (
        el.tagName === 'SELECT' &&
        $(el).hasClass('select2-hidden-accessible')
    ) {
        return $(el).next('.select2-container')[0];
    }

    return el;

}


function clearInvalidState() {

    document
        .querySelectorAll('.field-invalid')
        .forEach(function (el) {
            el.classList.remove('field-invalid');
        });

}


function markInvalid(id) {

    const target = getHighlightTarget(id);

    if (target) {
        target.classList.add('field-invalid');
    }

}


/* Hapus highlight ketika user mulai mengisi */
requiredFields.forEach(function (field) {

    const el = document.getElementById(field.id);

    ['input', 'change'].forEach(function (evt) {

        el.addEventListener(evt, function () {

            if (el.value && el.value.trim() !== '') {

                const target = getHighlightTarget(field.id);

                if (target) {
                    target.classList.remove('field-invalid');
                }

            }

        });

    });

});


/* Select2 memicu event jQuery, bukan event native */
$('#kategori_sampah_id, #kecamatan_id, #desa_id')
    .on('change', function () {

        if (this.value) {

            const target = getHighlightTarget(this.id);

            if (target) {
                target.classList.remove('field-invalid');
            }

        }

    });


/* ============================================================
   SAAT FORM DISUBMIT
============================================================= */

formLaporan.addEventListener(
    'submit',
    function (event) {

        clearInvalidState();

        const errors = [];
        let firstInvalidId = null;


        /* Cek field biasa */
        requiredFields.forEach(function (field) {

            const el = document.getElementById(field.id);

            if (!el.value || el.value.trim() === '') {

                errors.push(field.label);
                markInvalid(field.id);

                if (!firstInvalidId) {
                    firstInvalidId = field.id;
                }

            }

        });


        /* Cek foto */
        if (selectedFiles.length === 0) {

            errors.push('Foto Laporan (minimal 1 foto)');

            dropZone.classList.add('field-invalid');

            if (!firstInvalidId) {
                firstInvalidId = 'drop-zone';
            }

        }


        /* Jika ada yang kosong: batalkan submit & tampilkan popup */
        if (errors.length > 0) {

            event.preventDefault();

            incompleteList.innerHTML = '';

            errors.forEach(function (message) {

                const li = document.createElement('li');
                li.textContent = message;
                incompleteList.appendChild(li);

            });


            const modal =
                bootstrap.Modal.getOrCreateInstance(
                    incompleteModalElement
                );

            modal.show();


            /* Setelah popup ditutup: scroll & fokus ke field pertama */
            incompleteModalElement.addEventListener(
                'hidden.bs.modal',
                function handler() {

                    incompleteModalElement.removeEventListener(
                        'hidden.bs.modal',
                        handler
                    );

                    const target =
                        document.getElementById(firstInvalidId);

                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    if (firstInvalidId === 'kecamatan_id') {
                        $('#kecamatan_id').select2('open');
                    }
                    else if (firstInvalidId === 'desa_id') {
                        $('#desa_id').select2('open');
                    }
                    else if (
                        firstInvalidId !== 'drop-zone' &&
                        firstInvalidId !== 'kategori_sampah_id' &&
                        firstInvalidId !== 'latitude'
                    ) {
                        target.focus();
                    }

                }
            );

        }

    }
);

</script>

@endsection