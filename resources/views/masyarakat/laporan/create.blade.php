@extends('layouts.app')

@section('content')

<!-- =========================================================
     LEAFLET CSS
========================================================= -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
/>

<!-- Leaflet Geocoder CSS -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"
/>

<!-- Select2 CSS -->
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
        border: 2px dashed #E2E5E1;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background-color: #F6F7F5;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .upload-drop-zone:hover {
        border-color: #1F6E43;
        background-color: #E8F3EC;
    }

    .upload-drop-zone.dragover {
        border-color: #1F6E43;
        background-color: #E8F3EC;
    }

    .upload-drop-zone i {
        font-size: 3rem;
        color: #6B7280;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .upload-drop-zone.dragover i {
        color: #1F6E43;
    }

    .upload-drop-zone input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    #image-preview {
        display: none;
        margin-top: 15px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #E2E5E1;
        position: relative;
    }

    #image-preview img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(220, 53, 69, 0.85);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
    }

    .remove-image:hover {
        background: #dc3545;
    }


    /* =========================================================
       POPUP ERROR FOTO
    ========================================================= */

    .photo-error-popup {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        width: 360px;
        max-width: calc(100vw - 40px);
        background: #ffffff;
        border-left: 5px solid #dc3545;
        border-radius: 10px;
        padding: 16px 18px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.18);
    }

    .photo-error-title {
        color: #dc3545;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .photo-error-message {
        color: #444;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .photo-error-button {
        border: none;
        background: #dc3545;
        color: white;
        padding: 7px 14px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
    }

    .photo-error-button:hover {
        background: #bb2d3b;
    }


    /* =========================================================
       POPUP ERROR SERVER LARAVEL
    ========================================================= */

    .server-error-popup {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99998;
        width: 360px;
        max-width: calc(100vw - 40px);
        background: #ffffff;
        border-left: 5px solid #dc3545;
        border-radius: 10px;
        padding: 16px 18px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.18);
    }

    .server-error-popup h6 {
        color: #dc3545;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .server-error-popup ul {
        margin: 0;
        padding-left: 18px;
        font-size: 12px;
        color: #444;
    }


    /* =========================================================
       SUCCESS POPUP
    ========================================================= */

    .success-popup {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99997;
        width: 360px;
        max-width: calc(100vw - 40px);
        background: #ffffff;
        border-left: 5px solid #198754;
        border-radius: 10px;
        padding: 16px 18px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.18);
    }

    .success-popup-title {
        color: #198754;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .success-popup-message {
        color: #444;
        font-size: 13px;
    }
</style>


<!-- =========================================================
     POPUP ERROR FOTO
========================================================= -->

<div id="photoErrorPopup" class="photo-error-popup">

    <div class="photo-error-title">
        Gagal Memilih Foto
    </div>

    <div
        id="photoErrorMessage"
        class="photo-error-message"
    ></div>

    <button
        type="button"
        class="photo-error-button"
        onclick="closePhotoError()"
    >
        Tutup
    </button>

</div>


<!-- =========================================================
     POPUP ERROR LARAVEL
========================================================= -->

@if ($errors->any())

    <div
        id="serverErrorPopup"
        class="server-error-popup"
    >

        <h6>
            Gagal Mengirim Laporan
        </h6>

        <ul>

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

        <button
            type="button"
            class="btn btn-sm btn-danger mt-3"
            onclick="closeServerError()"
        >
            Tutup
        </button>

    </div>

@endif


<!-- =========================================================
     POPUP SUCCESS
========================================================= -->

@if (session('success'))

    <div
        id="successPopup"
        class="success-popup"
    >

        <div class="success-popup-title">
            Berhasil
        </div>

        <div class="success-popup-message">
            {{ session('success') }}
        </div>

    </div>

@endif


<!-- =========================================================
     FORM LAPORAN
========================================================= -->

<div class="container my-5">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                Buat Laporan Sampah Baru
            </h4>

        </div>


        <div class="card-body">

            <form
                id="laporanForm"
                action="{{ route('masyarakat.laporan.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="row">


                    <!-- =================================================
                         JUDUL LAPORAN
                    ================================================== -->

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


                    <!-- =================================================
                         KATEGORI
                    ================================================== -->

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


                    <!-- =================================================
                         KECAMATAN
                    ================================================== -->

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


                    <!-- =================================================
                         DESA
                    ================================================== -->

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


                    <!-- =================================================
                         DESKRIPSI
                    ================================================== -->

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


                    <!-- =================================================
                         ALAMAT
                    ================================================== -->

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


                    <!-- =================================================
                         PETA
                    ================================================== -->

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
                        ></div>


                        <p class="form-text text-muted">

                            Geser marker, klik pada peta,
                            gunakan pencarian, atau gunakan lokasi otomatis.

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


                    <!-- =================================================
                         FOTO
                    ================================================== -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Foto Laporan
                            (Maks. 2 MB)

                        </label>


                        <div
                            class="upload-drop-zone"
                            id="drop-zone"
                        >

                            <i class="fa-solid fa-cloud-arrow-up"></i>


                            <h6 class="fw-bold text-dark">

                                Seret & Lepas Foto di sini

                            </h6>


                            <p class="text-muted small mb-0">

                                atau klik untuk menelusuri
                                (PNG, JPG, JPEG)

                            </p>


                            <input
                                type="file"
                                id="foto_laporan"
                                name="foto_laporan"
                                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                required
                            >

                        </div>


                        <!-- Preview -->
                        <div
                            id="image-preview"
                            class="position-relative"
                        >

                            <button
                                type="button"
                                class="remove-image"
                                id="remove-btn"
                                title="Hapus Foto"
                            >

                                <i class="fa-solid fa-xmark"></i>

                            </button>


                            <img
                                src=""
                                id="preview-img"
                                alt="Preview Foto"
                            >

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     BUTTON
                ================================================== -->

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


<!-- =========================================================
     LEAFLET JS
========================================================= -->

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>


<!-- Leaflet Geocoder -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

    /* =========================================================
       POPUP ERROR FOTO
    ========================================================== */

    function showPhotoError(message) {

        const popup =
            document.getElementById('photoErrorPopup');

        const messageElement =
            document.getElementById('photoErrorMessage');

        if (!popup || !messageElement) {
            return;
        }

        messageElement.textContent = message;

        popup.style.display = 'block';

    }


    function closePhotoError() {

        const popup =
            document.getElementById('photoErrorPopup');

        if (popup) {
            popup.style.display = 'none';
        }

    }


    /* =========================================================
       POPUP ERROR SERVER
    ========================================================== */

    function closeServerError() {

        const popup =
            document.getElementById('serverErrorPopup');

        if (popup) {
            popup.style.display = 'none';
        }

    }


    /* =========================================================
       LEAFLET MAP
    ========================================================== */

    document.addEventListener(
        "DOMContentLoaded",
        function () {


            /* -------------------------------------------------
               INPUT KOORDINAT
            ------------------------------------------------- */

            const latInput =
                document.getElementById('latitude');

            const lngInput =
                document.getElementById('longitude');


            /* -------------------------------------------------
               DEFAULT MAGETAN
            ------------------------------------------------- */

            const defaultLat =
                latInput.value
                    ? parseFloat(latInput.value)
                    : -7.6531;

            const defaultLng =
                lngInput.value
                    ? parseFloat(lngInput.value)
                    : 111.3284;


            /* -------------------------------------------------
               MAP
            ------------------------------------------------- */

            const map =
                L.map('map-picker').setView(
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


            /* -------------------------------------------------
               MARKER
            ------------------------------------------------- */

            const marker =
                L.marker(
                    [defaultLat, defaultLng],
                    {
                        draggable: true
                    }
                ).addTo(map);


            /* -------------------------------------------------
               DRAG MARKER
            ------------------------------------------------- */

            marker.on(
                'dragend',
                function () {

                    const position =
                        marker.getLatLng();

                    latInput.value =
                        position.lat;

                    lngInput.value =
                        position.lng;

                }
            );


            /* -------------------------------------------------
               CLICK MAP
            ------------------------------------------------- */

            map.on(
                'click',
                function (e) {

                    marker.setLatLng(e.latlng);

                    latInput.value =
                        e.latlng.lat;

                    lngInput.value =
                        e.latlng.lng;

                }
            );


            /* -------------------------------------------------
               SET DEFAULT KOORDINAT
            ------------------------------------------------- */

            if (
                !latInput.value ||
                !lngInput.value
            ) {

                latInput.value =
                    defaultLat;

                lngInput.value =
                    defaultLng;

            }


            /* -------------------------------------------------
               SEARCH ADDRESS
            ------------------------------------------------- */

            L.Control.geocoder({

                defaultMarkGeocode: false,

                placeholder:
                    'Cari nama tempat / jalan...'

            })

            .on(
                'markgeocode',
                function (e) {

                    const bbox =
                        e.geocode.bbox;


                    const poly =
                        L.polygon([
                            bbox.getSouthEast(),
                            bbox.getNorthEast(),
                            bbox.getNorthWest(),
                            bbox.getSouthWest()
                        ]);


                    map.fitBounds(
                        poly.getBounds()
                    );


                    const latlng =
                        e.geocode.center;


                    marker.setLatLng(latlng);


                    latInput.value =
                        latlng.lat;

                    lngInput.value =
                        latlng.lng;


                    const alamatInput =
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


            /* -------------------------------------------------
               CURRENT LOCATION
            ------------------------------------------------- */

            document
                .getElementById('btn-current-location')
                .addEventListener(
                    'click',
                    function () {

                        const btn = this;


                        if (
                            navigator.geolocation
                        ) {

                            btn.innerHTML =
                                '<i class="fa-solid fa-spinner fa-spin"></i> Mencari lokasi...';

                            btn.disabled = true;


                            navigator.geolocation.getCurrentPosition(

                                function (position) {

                                    const lat =
                                        position.coords.latitude;

                                    const lng =
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

                                    showPhotoError(
                                        'Gagal mendapatkan lokasi. Pastikan izin lokasi di browser sudah diaktifkan.'
                                    );


                                    btn.innerHTML =
                                        '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';

                                    btn.disabled =
                                        false;

                                }

                            );

                        } else {

                            showPhotoError(
                                'Browser Anda tidak mendukung fitur lokasi GPS.'
                            );

                        }

                    }
                );

        }
    );


    /* =========================================================
       FOTO UPLOAD
    ========================================================== */

    const dropZone =
        document.getElementById('drop-zone');

    const fileInput =
        document.getElementById('foto_laporan');

    const imagePreview =
        document.getElementById('image-preview');

    const previewImg =
        document.getElementById('preview-img');

    const removeBtn =
        document.getElementById('remove-btn');


    /* ---------------------------------------------------------
       PREVENT DEFAULT DRAG
    --------------------------------------------------------- */

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


    /* ---------------------------------------------------------
       HIGHLIGHT DROPZONE
    --------------------------------------------------------- */

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


    /* ---------------------------------------------------------
       DROP FILE
    --------------------------------------------------------- */

    dropZone.addEventListener(
        'drop',
        handleDrop,
        false
    );


    function handleDrop(e) {

        const files =
            e.dataTransfer.files;


        if (files.length > 0) {

            handleFiles(
                files[0]
            );

        }

    }


    /* ---------------------------------------------------------
       SELECT FILE
    --------------------------------------------------------- */

    fileInput.addEventListener(
        'change',
        function () {

            if (this.files.length > 0) {

                handleFiles(
                    this.files[0]
                );

            }

        }
    );


    /* ---------------------------------------------------------
       HANDLE FILE
    --------------------------------------------------------- */

    function handleFiles(file) {

        const allowedExtensions = [
            'jpg',
            'jpeg',
            'png'
        ];


        const fileName =
            file.name.toLowerCase();


        const fileExtension =
            fileName.split('.').pop();


        /* -----------------------------------------------
           CEK FORMAT
        ------------------------------------------------ */

        if (
            !allowedExtensions.includes(
                fileExtension
            )
        ) {

            showPhotoError(
                'Format foto harus JPG, JPEG, atau PNG.'
            );

            resetUpload();

            return;

        }


        /* -----------------------------------------------
           CEK UKURAN
        ------------------------------------------------ */

        const maxSize =
            2 * 1024 * 1024;


        if (file.size > maxSize) {

            showPhotoError(
                'Ukuran foto terlalu besar. Maksimal ukuran foto adalah 2 MB.'
            );

            resetUpload();

            return;

        }


        /* -----------------------------------------------
           PREVIEW
        ------------------------------------------------ */

        const reader =
            new FileReader();


        reader.onload =
            function () {

                previewImg.src =
                    reader.result;

                imagePreview.style.display =
                    'block';

                dropZone.style.display =
                    'none';

            };


        reader.readAsDataURL(file);

    }


    /* ---------------------------------------------------------
       REMOVE PHOTO
    --------------------------------------------------------- */

    removeBtn.addEventListener(
        'click',
        function (e) {

            e.preventDefault();

            resetUpload();

        }
    );


    function resetUpload() {

        fileInput.value = '';

        imagePreview.style.display =
            'none';

        previewImg.src = '';

        dropZone.style.display =
            'block';

    }


    /* =========================================================
       VALIDASI SAAT SUBMIT
    ========================================================== */

    document
        .getElementById('laporanForm')
        .addEventListener(
            'submit',
            function (e) {

                if (
                    !fileInput.files ||
                    !fileInput.files.length
                ) {

                    return;

                }


                const file =
                    fileInput.files[0];


                const allowedExtensions = [
                    'jpg',
                    'jpeg',
                    'png'
                ];


                const extension =
                    file.name
                        .toLowerCase()
                        .split('.')
                        .pop();


                if (
                    !allowedExtensions.includes(
                        extension
                    )
                ) {

                    e.preventDefault();

                    showPhotoError(
                        'Format foto harus JPG, JPEG, atau PNG.'
                    );

                    return;

                }


                const maxSize =
                    2 * 1024 * 1024;


                if (file.size > maxSize) {

                    e.preventDefault();

                    showPhotoError(
                        'Ukuran foto terlalu besar. Maksimal ukuran foto adalah 2 MB.'
                    );

                    resetUpload();

                }

            }
        );


    /* =========================================================
       SELECT2
    ========================================================== */

    const $kecamatanSelect =
        $('#kecamatan_id');

    const $desaSelect =
        $('#desa_id');


    const oldDesaId =
        "{{ old('desa_id') }}";


    /* ---------------------------------------------------------
       SELECT2 KECAMATAN
    --------------------------------------------------------- */

    $kecamatanSelect.select2({

        theme: 'bootstrap-5',

        placeholder:
            'Cari & Pilih Kecamatan...'

    });


    /* ---------------------------------------------------------
       SELECT2 DESA
    --------------------------------------------------------- */

    $desaSelect.select2({

        theme: 'bootstrap-5',

        placeholder:
            'Cari & Pilih Desa / Kelurahan...'

    });


    /* ---------------------------------------------------------
       PREVENT CLOSE IF EMPTY
    --------------------------------------------------------- */

    $desaSelect.on(
        'select2:closing',
        function (e) {

            if (!$(this).val()) {

                e.preventDefault();

            }

        }
    );


    /* =========================================================
       UPDATE DESA
    ========================================================== */

    function updateDesaDropdown(
        kecamatanId,
        autoOpen = false
    ) {

        $desaSelect.empty();


        $desaSelect.append(
            new Option(
                'Pilih Desa / Kelurahan',
                '',
                true,
                true
            )
        );


        $desaSelect.prop(
            'disabled',
            true
        );


        if (!kecamatanId) {

            return;

        }


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


                    $desaSelect.prop(
                        'disabled',
                        false
                    );


                    $desaSelect.trigger(
                        'change.select2'
                    );


                    if (autoOpen) {

                        setTimeout(
                            function () {

                                $desaSelect.select2(
                                    'open'
                                );

                            },
                            250
                        );

                    }

                },


            error:
                function () {

                    showPhotoError(
                        'Gagal mengambil data Desa. Silakan coba lagi.'
                    );

                }

        });

    }


    /* =========================================================
       KECAMATAN SELECT
    ========================================================== */

    $kecamatanSelect.on(
        'select2:select',
        function () {

            updateDesaDropdown(
                this.value,
                true
            );

        }
    );


    /* =========================================================
       INITIAL DESA
    ========================================================== */

    if ($kecamatanSelect.val()) {

        updateDesaDropdown(
            $kecamatanSelect.val(),
            false
        );

    }


    /* =========================================================
       SHOW SERVER ERROR
    ========================================================== */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const serverErrorPopup =
                document.getElementById(
                    'serverErrorPopup'
                );


            if (serverErrorPopup) {

                serverErrorPopup.style.display =
                    'block';


                setTimeout(
                    function () {

                        closeServerError();

                    },
                    7000
                );

            }


            const successPopup =
                document.getElementById(
                    'successPopup'
                );


            if (successPopup) {

                successPopup.style.display =
                    'block';


                setTimeout(
                    function () {

                        successPopup.style.display =
                            'none';

                    },
                    4000
                );

            }

        }
    );

</script>

@endsection