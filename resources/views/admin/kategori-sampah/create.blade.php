<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Laporan Sampah - SIPESAT</title>

    {{-- Leaflet CSS --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #333;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 64px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16%;
            border-bottom: 1px solid #e5e7eb;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #176b43;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .logout {
            text-decoration: none;
            color: #dc3545;
            border: 1px solid #dc3545;
            padding: 7px 12px;
            border-radius: 5px;
            font-size: 12px;
        }

        .logout:hover {
            background: #dc3545;
            color: #ffffff;
        }

        /* =========================
           CONTAINER
        ========================= */

        .page-container {
            width: 100%;
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .form-card {
            background: #ffffff;
            border: 1px solid #d8ddd9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .form-header {
            background: #1f7548;
            color: white;
            padding: 13px 14px;
        }

        .form-header h2 {
            margin: 0;
            font-size: 20px;
        }

        .form-body {
            padding: 16px;
        }

        /* =========================
           GRID
        ========================= */

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            color: #333;
        }

        .required {
            color: #dc3545;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #d7dce0;
            border-radius: 5px;
            padding: 10px 11px;
            font-size: 13px;
            outline: none;
            background: #ffffff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #1f7548;
            box-shadow: 0 0 0 2px rgba(31,117,72,.10);
        }

        textarea {
            min-height: 85px;
            resize: vertical;
        }

        /* =========================
           MAP
        ========================= */

        .map-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
        }

        .map-title label {
            margin-bottom: 0;
        }

        .location-button {
            border: 1px solid #1f7548;
            background: white;
            color: #1f7548;
            padding: 7px 11px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        .location-button:hover {
            background: #1f7548;
            color: white;
        }

        #map {
            width: 100%;
            height: 250px;
            border: 1px solid #d7dce0;
            border-radius: 5px;
        }

        .map-help {
            margin-top: 5px;
            font-size: 10px;
            color: #777;
        }

        /* =========================
           LAT LONG
        ========================= */

        .coordinate-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 15px;
        }

        input[readonly] {
            background: #f5f6f7;
        }

        /* =========================
           FOTO
        ========================= */

        .upload-box {
            border: 1px dashed #cfd5d1;
            border-radius: 8px;
            padding: 18px;
            background: #fafbfa;
        }

        .upload-box input[type="file"] {
            padding: 8px;
            background: white;
        }

        .upload-help {
            margin-top: 6px;
            font-size: 10px;
            color: #777;
        }

        #preview-container {
            margin-top: 10px;
            display: none;
        }

        #preview {
            width: 100%;
            max-width: 450px;
            max-height: 220px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        /* =========================
           ERROR
        ========================= */

        .alert {
            background: #fde8e8;
            color: #a61b1b;
            border: 1px solid #f5bcbc;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .alert ul {
            margin: 7px 0 0 18px;
            padding: 0;
        }

        /* =========================
           BUTTON
        ========================= */

        .form-footer {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-submit {
            border: none;
            background: #1f7548;
            color: white;
            padding: 10px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-submit:hover {
            background: #165a37;
        }

        .btn-cancel {
            text-decoration: none;
            border: 1px solid #aeb5b1;
            background: white;
            color: #6b7280;
            padding: 10px 18px;
            border-radius: 5px;
            font-size: 12px;
        }

        .btn-cancel:hover {
            background: #f3f4f4;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .navbar {
                padding: 0 20px;
            }

            .form-grid,
            .coordinate-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .page-container {
                margin-top: 20px;
            }

            .navbar-right span {
                display: none;
            }
        }
    </style>
</head>

<body>

{{-- =====================================================
     NAVBAR MASYARAKAT
===================================================== --}}

<div class="navbar">

    <div class="logo">
        🍃 SIPESAT
    </div>

    <div class="navbar-right">

        <span>
            Halo, {{ auth()->user()->name }}
        </span>

        <a
            href="{{ route('logout') }}"
            class="logout"
        >
            ⇥ Keluar
        </a>

    </div>

</div>


{{-- =====================================================
     CONTENT
===================================================== --}}

<div class="page-container">

    <div class="form-card">

        {{-- HEADER --}}

        <div class="form-header">

            <h2>
                Buat Laporan Sampah Baru
            </h2>

        </div>


        <div class="form-body">

            {{-- ERROR VALIDASI --}}

            @if ($errors->any())

                <div class="alert">

                    <strong>
                        Data belum dapat dikirim.
                    </strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM --}}

            <form
                action="{{ route('masyarakat.laporan.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- BARIS 1 --}}

                <div class="form-grid">

                    {{-- JUDUL --}}

                    <div class="form-group">

                        <label for="judul_laporan">

                            Judul Laporan
                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            id="judul_laporan"
                            name="judul_laporan"
                            value="{{ old('judul_laporan') }}"
                            placeholder="Masukkan judul laporan"
                            required
                        >

                    </div>


                    {{-- KATEGORI --}}

                    <div class="form-group">

                        <label for="kategori_sampah_id">

                            Kategori Sampah
                            <span class="required">*</span>

                        </label>

                        <select
                            id="kategori_sampah_id"
                            name="kategori_sampah_id"
                            required
                        >

                            <option value="">
                                Pilih Kategori
                            </option>

                            @foreach ($kategoriSampah as $kategori)

                                <option
                                    value="{{ $kategori->id }}"
                                    {{ old('kategori_sampah_id') == $kategori->id ? 'selected' : '' }}
                                >

                                    {{ $kategori->nama_kategori }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- KECAMATAN --}}

                    <div class="form-group">

                        <label for="kecamatan">

                            Kecamatan
                            <span class="required">*</span>

                        </label>

                        <select
                            id="kecamatan"
                            name="kecamatan"
                            required
                        >

                            <option value="">
                                Pilih Kecamatan
                            </option>

                            <option value="MAGETAN"
                                {{ old('kecamatan') == 'MAGETAN' ? 'selected' : '' }}>
                                MAGETAN
                            </option>

                            <option value="LEMBEYAN"
                                {{ old('kecamatan') == 'LEMBEYAN' ? 'selected' : '' }}>
                                LEMBEYAN
                            </option>

                            <option value="MAOSPATI"
                                {{ old('kecamatan') == 'MAOSPATI' ? 'selected' : '' }}>
                                MAOSPATI
                            </option>

                            <option value="PARANG"
                                {{ old('kecamatan') == 'PARANG' ? 'selected' : '' }}>
                                PARANG
                            </option>

                            <option value="PANEKAN"
                                {{ old('kecamatan') == 'PANEKAN' ? 'selected' : '' }}>
                                PANEKAN
                            </option>

                            <option value="PLAOSAN"
                                {{ old('kecamatan') == 'PLAOSAN' ? 'selected' : '' }}>
                                PLAOSAN
                            </option>

                            <option value="PONCOL"
                                {{ old('kecamatan') == 'PONCOL' ? 'selected' : '' }}>
                                PONCOL
                            </option>

                            <option value="BARAT"
                                {{ old('kecamatan') == 'BARAT' ? 'selected' : '' }}>
                                BARAT
                            </option>

                        </select>

                    </div>


                    {{-- DESA --}}

                    <div class="form-group">

                        <label for="desa">

                            Desa / Kelurahan
                            <span class="required">*</span>

                        </label>

                        <select
                            id="desa"
                            name="desa"
                            required
                        >

                            <option value="">
                                Pilih Desa / Kelurahan
                            </option>

                        </select>

                    </div>

                </div>


                {{-- DESKRIPSI --}}

                <div class="form-group">

                    <label for="deskripsi">

                        Deskripsi Laporan
                        <span class="required">*</span>

                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        placeholder="Jelaskan kondisi sampah yang ditemukan"
                        required
                    >{{ old('deskripsi') }}</textarea>

                </div>


                {{-- ALAMAT --}}

                <div class="form-group">

                    <label for="alamat_lengkap">

                        Alamat Lengkap
                        <span class="required">*</span>

                    </label>

                    <textarea
                        id="alamat_lengkap"
                        name="alamat_lengkap"
                        placeholder="Masukkan alamat lengkap lokasi sampah"
                        required
                    >{{ old('alamat_lengkap') }}</textarea>

                </div>


                {{-- PETA --}}

                <div class="form-group">

                    <div class="map-title">

                        <label>
                            Tentukan Titik Lokasi di Peta
                        </label>

                        <button
                            type="button"
                            class="location-button"
                            id="currentLocation"
                        >
                            ⦿ Gunakan Lokasi Saat Ini
                        </button>

                    </div>


                    <div id="map"></div>

                    <div class="map-help">

                        Geser marker, klik pada peta, atau gunakan
                        tombol lokasi untuk menentukan titik lokasi.

                    </div>

                </div>


                {{-- LATITUDE LONGITUDE --}}

                <div class="coordinate-grid">

                    <div class="form-group">

                        <label for="latitude">
                            Latitude
                        </label>

                        <input
                            type="text"
                            id="latitude"
                            name="latitude"
                            value="{{ old('latitude') }}"
                            readonly
                        >

                    </div>


                    <div class="form-group">

                        <label for="longitude">
                            Longitude
                        </label>

                        <input
                            type="text"
                            id="longitude"
                            name="longitude"
                            value="{{ old('longitude') }}"
                            readonly
                        >

                    </div>

                </div>


                {{-- FOTO --}}

                <div class="form-group">

                    <label for="foto_laporan">

                        Foto Laporan (Maks. 2MB)
                        <span class="required">*</span>

                    </label>

                    <div class="upload-box">

                        <input
                            type="file"
                            id="foto_laporan"
                            name="foto_laporan"
                            accept=".png,.jpg,.jpeg"
                            required
                        >

                        <div class="upload-help">

                            Format yang diperbolehkan:
                            PNG, JPG, JPEG.
                            Maksimal ukuran 2 MB.

                        </div>


                        {{-- PREVIEW FOTO --}}

                        <div id="preview-container">

                            <img
                                id="preview"
                                src=""
                                alt="Preview Foto"
                            >

                        </div>

                    </div>

                </div>


                {{-- BUTTON --}}

                <div class="form-footer">

                    <button
                        type="submit"
                        class="btn-submit"
                    >
                        Kirim Laporan
                    </button>


                    <a
                        href="{{ route('masyarakat.dashboard') }}"
                        class="btn-cancel"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =====================================================
     LEAFLET JS
===================================================== --}}

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>


<script>

    /* ==========================================
       KOORDINAT AWAL MAGETAN
    ========================================== */

    const defaultLatitude = -7.6567;
    const defaultLongitude = 111.3347;


    /* ==========================================
       MEMBUAT MAP
    ========================================== */

    const map = L.map('map').setView(
        [defaultLatitude, defaultLongitude],
        13
    );


    /* ==========================================
       OPEN STREET MAP
    ========================================== */

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution:
                '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);


    /* ==========================================
       MARKER
    ========================================== */

    let marker = L.marker(
        [defaultLatitude, defaultLongitude],
        {
            draggable: true
        }
    ).addTo(map);


    /* ==========================================
       INPUT KOORDINAT
    ========================================== */

    const latitudeInput =
        document.getElementById('latitude');

    const longitudeInput =
        document.getElementById('longitude');


    function updateCoordinates(lat, lng)
    {
        latitudeInput.value =
            Number(lat).toFixed(7);

        longitudeInput.value =
            Number(lng).toFixed(7);
    }


    /* KOORDINAT AWAL */

    updateCoordinates(
        defaultLatitude,
        defaultLongitude
    );


    /* ==========================================
       KLIK PADA PETA
    ========================================== */

    map.on('click', function(e)
    {

        marker.setLatLng(e.latlng);

        updateCoordinates(
            e.latlng.lat,
            e.latlng.lng
        );

    });


    /* ==========================================
       DRAG MARKER
    ========================================== */

    marker.on('dragend', function(e)
    {

        const position =
            e.target.getLatLng();

        updateCoordinates(
            position.lat,
            position.lng
        );

    });


    /* ==========================================
       GUNAKAN LOKASI SAAT INI
    ========================================== */

    document
        .getElementById('currentLocation')
        .addEventListener('click', function()
        {

            if (!navigator.geolocation)
            {

                alert(
                    'Browser Anda tidak mendukung deteksi lokasi.'
                );

                return;

            }


            navigator.geolocation.getCurrentPosition(

                function(position)
                {

                    const lat =
                        position.coords.latitude;

                    const lng =
                        position.coords.longitude;


                    map.setView(
                        [lat, lng],
                        17
                    );


                    marker.setLatLng(
                        [lat, lng]
                    );


                    updateCoordinates(
                        lat,
                        lng
                    );

                },

                function()
                {

                    alert(
                        'Lokasi tidak dapat diperoleh. Pastikan izin lokasi browser sudah diberikan.'
                    );

                }

            );

        });


    /* ==========================================
       PREVIEW FOTO
    ========================================== */

    document
        .getElementById('foto_laporan')
        .addEventListener('change', function(event)
        {

            const file =
                event.target.files[0];

            const previewContainer =
                document.getElementById(
                    'preview-container'
                );

            const preview =
                document.getElementById('preview');


            if (!file)
            {

                previewContainer.style.display =
                    'none';

                return;

            }


            /* CEK UKURAN */

            if (file.size > 2 * 1024 * 1024)
            {

                alert(
                    'Ukuran foto maksimal 2 MB.'
                );

                event.target.value = '';

                previewContainer.style.display =
                    'none';

                return;

            }


            /* CEK FORMAT */

            const allowedTypes = [
                'image/jpeg',
                'image/png'
            ];


            if (!allowedTypes.includes(file.type))
            {

                alert(
                    'Foto harus berformat JPG, JPEG, atau PNG.'
                );

                event.target.value = '';

                previewContainer.style.display =
                    'none';

                return;

            }


            /* TAMPILKAN PREVIEW */

            const reader =
                new FileReader();


            reader.onload =
                function(e)
                {

                    preview.src =
                        e.target.result;

                    previewContainer.style.display =
                        'block';

                };


            reader.readAsDataURL(file);

        });


    /* ==========================================
       DATA DESA SEMENTARA
    ========================================== */

    const desaData = {

        "MAGETAN": [
            "MAGETAN"
        ],

        "LEMBEYAN": [
            "KEDIREN",
            "LEMBEYAN KULON",
            "LEMBEYAN WETAN",
            "KEDUNGPANJI",
            "NGURI",
            "TAPEN",
            "KROWE"
        ],

        "MAOSPATI": [],

        "PARANG": [],

        "PANEKAN": [],

        "PLAOSAN": [],

        "PONCOL": [],

        "BARAT": []

    };


    /* ==========================================
       DROPDOWN DESA
    ========================================== */

    const kecamatan =
        document.getElementById('kecamatan');

    const desa =
        document.getElementById('desa');


    kecamatan.addEventListener(
        'change',
        function()
        {

            const selected =
                this.value;

            desa.innerHTML =
                '<option value="">Pilih Desa / Kelurahan</option>';


            if (
                desaData[selected] &&
                desaData[selected].length > 0
            )
            {

                desaData[selected].forEach(
                    function(namaDesa)
                    {

                        const option =
                            document.createElement('option');

                        option.value =
                            namaDesa;

                        option.textContent =
                            namaDesa;

                        desa.appendChild(option);

                    }
                );

            }

        }
    );

</script>

</body>
</html>