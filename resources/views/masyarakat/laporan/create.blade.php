<!DOCTYPE html>
<html lang="id">

<head>

    {{-- Menentukan karakter yang digunakan oleh halaman --}}
    <meta charset="UTF-8">

    {{-- Membuat tampilan website menyesuaikan ukuran layar perangkat --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Judul yang tampil pada tab browser --}}
    <title>Buat Laporan Sampah - SIPESAT</title>


    {{-- =========================================================
         BOOTSTRAP
    ========================================================= --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
         FONT AWESOME
    ========================================================= --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    {{-- =========================================================
         LEAFLET CSS
    ========================================================= --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >


    <style>

        /* =====================================================
           GLOBAL STYLE
        ===================================================== */

        * {
            box-sizing: border-box;
        }


        /* =====================================================
           BODY
        ===================================================== */

        body {
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar-sipesat {

            background: white;

            color: #333;

            padding: 10px max(20px, calc((100% - 1100px) / 2));

            display: flex;

            align-items: center;

            justify-content: space-between;

            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }


        /* Mengatur bagian logo SIPESAT */
        .brand-sipesat {
            display: flex;
            align-items: center;
            gap: 5px;
        }


        /* Mengatur icon logo */
        .brand-logo {
            width: auto;
            height: auto;

            background: transparent;
            color: #176b43;

            border-radius: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;
        }


        /* Bagian teks SIPESAT */
        .brand-text {
            display: flex;
            flex-direction: column;
        }


        /* Tulisan SIPESAT */
        .brand-text strong {
            font-size: 16px;
            letter-spacing: 0;
            color: #176b43;
        }


        /* Tulisan kecil pada navbar disembunyikan */
        .brand-text small {
            display: none;
        }


        /* Area nama user dan tombol keluar */
        .user-area {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #333;
        }


        /* Tombol logout */
        .logout-btn {
            color: #dc3545;
            text-decoration: none;
            border: 1px solid #dc3545;
            padding: 5px 9px;
            border-radius: 4px;
            font-size: 12px;
            transition: 0.2s;
        }


        /* Efek ketika mouse diarahkan ke tombol logout */
        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }


        /* =====================================================
           WRAPPER
        ===================================================== */

        .laporan-wrapper {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }


        /* Kotak utama laporan */
        .laporan-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;

            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }


        /* =====================================================
           HEADER LAPORAN
           
           Dibuat lebih pendek dan sederhana.
        ===================================================== */

        .laporan-header {
            background: #176b43;
            color: white;

            /* Header dibuat lebih pendek */
            padding: 8px 16px;
        }


        /* Judul laporan */
        .laporan-header h2 {
            margin: 0;

            font-size: 16px;

            font-weight: 600;

            line-height: 1.4;
        }


        /* Deskripsi header disembunyikan */
        .laporan-header p {
            display: none;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .laporan-body {
            padding: 30px;
        }


        /* Label setiap input */
        .form-label {
            font-weight: 600;
            margin-bottom: 7px;
        }


        /* Input dan dropdown */
        .form-control,
        .form-select {
            min-height: 45px;
            border-radius: 7px;
            border: 1px solid #d7d7d7;
        }


        /* Efek ketika input sedang dipilih */
        .form-control:focus,
        .form-select:focus {
            border-color: #176b43;
            box-shadow: 0 0 0 0.2rem rgba(23, 107, 67, 0.12);
        }


        /* Tinggi textarea */
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }


        /* =====================================================
           MAP
        ===================================================== */

        .map-container {
            margin-top: 10px;
        }


        /* Container pencarian lokasi */
        .map-search {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }


        /* Input pencarian */
        .map-search input {
            flex: 1;
            min-height: 42px;
        }


        /* Tombol pencarian */
        .search-btn {
            background: #176b43;
            color: white;
            border: none;
            padding: 9px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            white-space: nowrap;
            transition: 0.2s;
        }


        /* Efek hover tombol pencarian */
        .search-btn:hover {
            background: #125636;
        }


        /* Tombol disabled */
        .search-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }


        /* Ukuran peta */
        #map {
            width: 100%;
            height: 280px;
            border-radius: 8px;
            border: 1px solid #ddd;
            overflow: hidden;
        }


        /* Tombol menggunakan lokasi GPS */
        .location-btn {
            margin-top: 12px;
            background: #176b43;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }


        /* Efek hover */
        .location-btn:hover {
            background: #125636;
        }


        /* Ketika tombol sedang diproses */
        .location-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }


        /* Kotak koordinat */
        .coordinate-box {
            background: #f8f9fa;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }


        /* =====================================================
           UPLOAD FOTO
        ===================================================== */

        .upload-area {
            border: 2px dashed #cfcfcf;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            background: #fafafa;
            transition: 0.2s;
        }


        /* Efek ketika mouse diarahkan */
        .upload-area:hover {
            border-color: #176b43;
            background: #f5fbf8;
        }


        /* Icon upload */
        .upload-icon {
            font-size: 32px;
            color: #176b43;
            margin-bottom: 10px;
        }


        /* Informasi format */
        .upload-info {
            font-size: 13px;
            color: #777;
            margin-top: 8px;
        }


        /* Preview disembunyikan sebelum foto dipilih */
        #preview-container {
            margin-top: 15px;
            display: none;
        }


        /* Ukuran preview foto */
        #preview-image {
            max-width: 250px;
            max-height: 180px;
            border-radius: 8px;
            border: 1px solid #ddd;
            object-fit: cover;
        }


        /* =====================================================
           BUTTON
        ===================================================== */

        .button-area {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;

            display: flex;

            justify-content: flex-end;

            gap: 10px;
        }


        /* Tombol batal */
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 7px;
            text-decoration: none;
        }


        .btn-cancel:hover {
            background: #5c636a;
            color: white;
        }


        /* Tombol kirim laporan */
        .btn-submit {
            background: #176b43;
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 7px;
        }


        .btn-submit:hover {
            background: #125636;
        }


        /* =====================================================
           ERROR
        ===================================================== */

        .alert-danger {
            border-radius: 8px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 768px) {

            .navbar-sipesat {
                padding: 12px 18px;
            }


            .user-area {
                font-size: 12px;
                gap: 6px;
            }


            .brand-text small {
                display: none;
            }


            .laporan-wrapper {
                margin: 20px auto;
                padding: 0 12px;
            }


            .laporan-body {
                padding: 20px;
            }


            .laporan-header {
                padding: 8px 16px;
            }


            .laporan-header h2 {
                font-size: 16px;
            }


            .map-search {
                flex-direction: column;
            }


            .search-btn {
                width: 100%;
            }


            .button-area {
                flex-direction: column;
            }


            .btn-cancel,
            .btn-submit {
                width: 100%;
                text-align: center;
            }

        }

    </style>

</head>


<body>


    {{-- =========================================================
         NAVBAR
    ========================================================= --}}

    <nav class="navbar-sipesat">

        {{-- Logo dan nama aplikasi --}}
        <div class="brand-sipesat">

            <div class="brand-logo">

                <i class="fa-solid fa-leaf"></i>

            </div>


            <div class="brand-text">

                <strong>SIPESAT</strong>

            </div>

        </div>


        {{-- Area informasi user --}}
        <div class="user-area">

            <span>
                Halo, {{ auth()->user()->name }}
            </span>


            {{-- Tombol logout --}}
            <a
                href="{{ route('logout') }}"
                class="logout-btn"
            >

                <i class="fa-solid fa-right-from-bracket"></i>

                Keluar

            </a>

        </div>

    </nav>



    {{-- =========================================================
         CONTENT
    ========================================================= --}}

    <div class="laporan-wrapper">

        <div class="laporan-card">


            {{-- =================================================
                 HEADER LAPORAN
            ================================================= --}}

            <div class="laporan-header">

                <h2>


                    Buat Laporan Sampah Baru

                </h2>

            </div>



            {{-- =================================================
                 BODY
            ================================================= --}}

            <div class="laporan-body">


                {{-- =================================================
                     ERROR VALIDASI
                ================================================= --}}

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>

                            <i class="fa-solid fa-circle-exclamation"></i>

                            Terdapat kesalahan:

                        </strong>


                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                {{-- =================================================
                     FORM LAPORAN
                ================================================= --}}

                <form
                    action="{{ route('masyarakat.laporan.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    {{-- Token keamanan Laravel --}}
                    @csrf



                    {{-- =================================================
                         JUDUL + KATEGORI
                    ================================================= --}}

                    <div class="row g-3">


                        {{-- INPUT JUDUL --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Judul Laporan
                            </label>


                            <input
                                type="text"
                                name="judul_laporan"
                                class="form-control"
                                placeholder="Contoh: Tumpukan sampah di pinggir jalan"
                                value="{{ old('judul_laporan') }}"
                                required
                            >

                        </div>



                        {{-- DROPDOWN KATEGORI --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Kategori Sampah
                            </label>


                            <select
                                name="kategori_sampah_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Pilih Kategori Sampah
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

                    </div>



                    {{-- =================================================
                         KECAMATAN + DESA
                    ================================================= --}}

                    <div class="row g-3 mt-1">


                        {{-- DROPDOWN KECAMATAN --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Kecamatan
                            </label>


                            <select
                                name="kecamatan"
                                id="kecamatan"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Pilih Kecamatan
                                </option>


                                <option value="MAGETAN">MAGETAN</option>
                                <option value="LEMBEYAN">LEMBEYAN</option>
                                <option value="PLAOSAN">PLAOSAN</option>
                                <option value="PANEKAN">PANEKAN</option>
                                <option value="KAWEDANAN">KAWEDANAN</option>
                                <option value="PARANG">PARANG</option>
                                <option value="MAOSPATI">MAOSPATI</option>
                                <option value="BARAT">BARAT</option>
                                <option value="KARANGREJO">KARANGREJO</option>
                                <option value="NGUNTORONADI">NGUNTORONADI</option>
                                <option value="SIDOREJO">SIDOREJO</option>
                                <option value="KARAS">KARAS</option>
                                <option value="BENDO">BENDO</option>
                                <option value="TAKERAN">TAKERAN</option>
                                <option value="NGARIBOYO">NGARIBOYO</option>
                                <option value="KARANGMOJO">KARANGMOJO</option>
                                <option value="SUKOMORO">SUKOMORO</option>
                                <option value="KARANGANYAR">KARANGANYAR</option>

                            </select>

                        </div>



                        {{-- DROPDOWN DESA --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Desa/Kelurahan
                            </label>


                            <select
                                name="desa"
                                id="desa"
                                class="form-select"
                                required
                                disabled
                            >

                                <option value="">
                                    Pilih Kecamatan terlebih dahulu
                                </option>

                            </select>

                        </div>

                    </div>



                    {{-- =================================================
                         DESKRIPSI
                    ================================================= --}}

                    <div class="mt-4">

                        <label class="form-label">
                            Deskripsi Laporan
                        </label>


                        <textarea
                            name="deskripsi"
                            class="form-control"
                            placeholder="Jelaskan kondisi sampah yang ditemukan..."
                            required
                        >{{ old('deskripsi') }}</textarea>

                    </div>



                    {{-- =================================================
                         ALAMAT LENGKAP
                    ================================================= --}}

                    <div class="mt-4">

                        <label class="form-label">
                            Alamat Lengkap
                        </label>


                        <textarea
                            name="alamat_lengkap"
                            class="form-control"
                            placeholder="Masukkan alamat lengkap lokasi sampah..."
                            required
                        >{{ old('alamat_lengkap') }}</textarea>

                    </div>



                    {{-- =================================================
                         MAP
                    ================================================= --}}

                    <div class="mt-4">

                        <label class="form-label">
                            Lokasi Sampah
                        </label>


                        <div class="map-container">


                            {{-- PENCARIAN LOKASI --}}

                            <div class="map-search">

                                <input
                                    type="text"
                                    id="search-location"
                                    class="form-control"
                                    placeholder="Cari lokasi di Kabupaten Magetan..."
                                >


                                <button
                                    type="button"
                                    id="btn-search-location"
                                    class="search-btn"
                                >

                                    <i class="fa-solid fa-magnifying-glass"></i>

                                    Cari

                                </button>

                            </div>



                            {{-- PETA LEAFLET --}}

                            <div id="map"></div>



                            {{-- LOKASI SAAT INI --}}

                            <button
                                type="button"
                                class="location-btn"
                                id="btn-location"
                            >

                                <i class="fa-solid fa-location-crosshairs"></i>

                                Gunakan Lokasi Saat Ini

                            </button>

                        </div>



                        {{-- KOORDINAT --}}

                        <div class="coordinate-box">

                            <div class="row g-3">


                                {{-- LATITUDE --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Latitude
                                    </label>


                                    <input
                                        type="text"
                                        name="latitude"
                                        id="latitude"
                                        class="form-control"
                                        value="{{ old('latitude') }}"
                                        placeholder="Latitude"
                                        readonly
                                    >

                                </div>



                                {{-- LONGITUDE --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Longitude
                                    </label>


                                    <input
                                        type="text"
                                        name="longitude"
                                        id="longitude"
                                        class="form-control"
                                        value="{{ old('longitude') }}"
                                        placeholder="Longitude"
                                        readonly
                                    >

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                         FOTO LAPORAN
                    ================================================= --}}

                    <div class="mt-4">

                        <label class="form-label">
                            Foto Laporan
                        </label>


                        <div class="upload-area">

                            <div class="upload-icon">

                                <i class="fa-solid fa-cloud-arrow-up"></i>

                            </div>


                            <input
                                type="file"
                                name="foto_laporan"
                                id="foto_laporan"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                                required
                            >


                            <div class="upload-info">

                                Format:
                                <strong>JPG, JPEG, PNG</strong>

                                <br>

                                Ukuran maksimal:
                                <strong>2 MB</strong>

                            </div>



                            {{-- PREVIEW FOTO --}}

                            <div id="preview-container">

                                <p class="mb-2">
                                    Preview Foto:
                                </p>


                                <img
                                    id="preview-image"
                                    src=""
                                    alt="Preview Foto"
                                >

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                         TOMBOL
                    ================================================= --}}

                    <div class="button-area">


                        {{-- Kembali ke dashboard --}}
                        <a
                            href="{{ route('masyarakat.dashboard') }}"
                            class="btn-cancel"
                        >

                            <i class="fa-solid fa-arrow-left"></i>

                            Batal

                        </a>



                        {{-- Submit form --}}
                        <button
                            type="submit"
                            class="btn-submit"
                        >

                            <i class="fa-solid fa-paper-plane"></i>

                            Kirim Laporan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    {{-- =========================================================
         LEAFLET JAVASCRIPT
    ========================================================= --}}

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



    <script>


        /* =====================================================
           DATA DESA / KELURAHAN
        ===================================================== */

        const dataDesa = {

            "MAGETAN": [
                "Magetan",
                "Selosari",
                "Sukowinangun",
                "Tambran",
                "Tawang Anom"
            ],

            "LEMBEYAN": [
                "Lembeyan",
                "Lembeyan Kulon",
                "Lembeyan Wetan",
                "Kediren",
                "Tapen"
            ],

            "PLAOSAN": [
                "Plaosan",
                "Puntukdoro",
                "Sarangan",
                "Sidomukti",
                "Bulugunung"
            ],

            "PANEKAN": [
                "Panekan",
                "Bedagung",
                "Jabung",
                "Manjung",
                "Milangasri"
            ],

            "KAWEDANAN": [
                "Kawedanan",
                "Balerejo",
                "Karangrejo",
                "Mojorejo",
                "Ngadirejo"
            ],

            "PARANG": [
                "Parang",
                "Bungkuk",
                "Nglopang",
                "Pragak",
                "Trosono"
            ],

            "MAOSPATI": [
                "Maospati",
                "Mranggen",
                "Nglames",
                "Pandeyan",
                "Sumberejo"
            ],

            "BARAT": [
                "Barat",
                "Banjarejo",
                "Karangsono",
                "Mangunharjo",
                "Tebon"
            ],

            "KARANGREJO": [
                "Karangrejo",
                "Gebyog",
                "Manisrejo",
                "Patihan",
                "Sambirembe"
            ],

            "NGUNTORONADI": [
                "Nguntoronadi",
                "Goranggareng",
                "Purworejo",
                "Semen",
                "Simokerto"
            ],

            "SIDOREJO": [
                "Sidorejo",
                "Campursari",
                "Dukuh",
                "Kalang",
                "Sidomulyo"
            ],

            "KARAS": [
                "Karas",
                "Botok",
                "Geplak",
                "Janggan",
                "Kuwon"
            ],

            "BENDO": [
                "Bendo",
                "Bulak",
                "Carikan",
                "Klecorejo",
                "Pingkuk"
            ],

            "TAKERAN": [
                "Takeran",
                "Duyung",
                "Kerik",
                "Madigondo",
                "Sawojajar"
            ],

            "NGARIBOYO": [
                "Ngariboyo",
                "Banjarejo",
                "Baleasri",
                "Mojopurno",
                "Selopanggung"
            ],

            "KARANGMOJO": [
                "Karangmojo",
                "Kedungrejo",
                "Manjung",
                "Sumberagung",
                "Tanjungsari"
            ],

            "SUKOMORO": [
                "Sukomoro",
                "Bibis",
                "Kentangan",
                "Kedungguwo",
                "Pojoksari"
            ],

            "KARANGANYAR": [
                "Karanganyar",
                "Candi",
                "Cileng",
                "Mojopurno",
                "Nguri"
            ]

        };



        /* =====================================================
           DROPDOWN KECAMATAN → DESA
        ===================================================== */

        const kecamatanSelect =
            document.getElementById('kecamatan');


        const desaSelect =
            document.getElementById('desa');



        function loadDesa(
            kecamatan,
            selectedDesa = ''
        ) {

            desaSelect.innerHTML = '';


            const defaultOption =
                document.createElement('option');


            defaultOption.value = '';


            defaultOption.textContent =
                kecamatan
                    ? 'Pilih Desa / Kelurahan'
                    : 'Pilih Kecamatan terlebih dahulu';


            desaSelect.appendChild(defaultOption);



            if (
                !kecamatan ||
                !dataDesa[kecamatan]
            ) {

                desaSelect.disabled = true;

                return;

            }



            desaSelect.disabled = false;



            dataDesa[kecamatan].forEach(
                function (desa) {

                    const option =
                        document.createElement('option');


                    option.value = desa;

                    option.textContent = desa;



                    if (
                        desa === selectedDesa
                    ) {

                        option.selected = true;

                    }



                    desaSelect.appendChild(
                        option
                    );

                }
            );

        }



        kecamatanSelect.addEventListener(
            'change',
            function () {

                loadDesa(
                    this.value
                );

            }
        );



        /* =====================================================
           LOAD OLD VALUE
        ===================================================== */

        const oldKecamatan =
            @json(old('kecamatan'));

        const oldDesa =
            @json(old('desa'));


        if (oldKecamatan) {

            kecamatanSelect.value =
                oldKecamatan;

            loadDesa(
                oldKecamatan,
                oldDesa
            );

        }



        /* =====================================================
           MAP
        ===================================================== */

        const defaultLatitude =
            -7.6546;

        const defaultLongitude =
            111.3230;



        const map =
            L.map('map').setView(
                [
                    defaultLatitude,
                    defaultLongitude
                ],
                12
            );



        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);



        let marker = null;



        /* =====================================================
           SET LOCATION
        ===================================================== */

        function setLocation(
            latitude,
            longitude
        ) {

            document.getElementById(
                'latitude'
            ).value =
                latitude.toFixed(7);



            document.getElementById(
                'longitude'
            ).value =
                longitude.toFixed(7);



            if (marker) {

                marker.setLatLng([
                    latitude,
                    longitude
                ]);

            } else {

                marker =
                    L.marker([
                        latitude,
                        longitude
                    ]).addTo(map);

            }



            map.setView(
                [
                    latitude,
                    longitude
                ],
                16
            );

        }



        /* =====================================================
           LOAD OLD COORDINATE
        ===================================================== */

        const oldLatitude =
            @json(old('latitude'));

        const oldLongitude =
            @json(old('longitude'));


        if (
            oldLatitude &&
            oldLongitude
        ) {

            setLocation(
                parseFloat(oldLatitude),
                parseFloat(oldLongitude)
            );

        }



        /* =====================================================
           CEK WILAYAH KABUPATEN MAGETAN
        ===================================================== */

        async function isMagetanLocation(
            latitude,
            longitude
        ) {

            try {

                const response =
                    await fetch(
                        'https://nominatim.openstreetmap.org/reverse?format=json&lat='
                        + latitude
                        + '&lon='
                        + longitude
                        + '&zoom=10&addressdetails=1'
                    );



                if (!response.ok) {

                    throw new Error(
                        'Gagal memeriksa wilayah lokasi.'
                    );

                }



                const data =
                    await response.json();



                const address =
                    data.address || {};



                const wilayah = (
                    address.county ||
                    address.municipality ||
                    address.city ||
                    ''
                ).toLowerCase();



                return wilayah.includes(
                    'magetan'
                );


            } catch (error) {

                console.error(error);

                return false;

            }

        }



        /* =====================================================
           MAP CLICK
        ===================================================== */

        map.on(
            'click',
            async function (e) {

                const latitude =
                    e.latlng.lat;


                const longitude =
                    e.latlng.lng;



                const isMagetan =
                    await isMagetanLocation(
                        latitude,
                        longitude
                    );



                if (!isMagetan) {

                    alert(
                        'Lokasi yang dipilih berada di luar Kabupaten Magetan. Pelaporan sampah hanya dapat dilakukan di wilayah Kabupaten Magetan.'
                    );


                    return;

                }



                setLocation(
                    latitude,
                    longitude
                );

            }
        );



        /* =====================================================
           PENCARIAN LOKASI
        ===================================================== */

        const searchInput =
            document.getElementById(
                'search-location'
            );


        const searchButton =
            document.getElementById(
                'btn-search-location'
            );



        async function searchLocation() {

            const query =
                searchInput.value.trim();



            if (!query) {

                alert(
                    'Silakan masukkan lokasi yang ingin dicari.'
                );


                searchInput.focus();

                return;

            }



            searchButton.disabled = true;


            searchButton.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Mencari...';



            try {

                const response =
                    await fetch(
                        'https://nominatim.openstreetmap.org/search?format=json&limit=5&countrycodes=id&addressdetails=1&q='
                        + encodeURIComponent(query)
                    );



                if (!response.ok) {

                    throw new Error(
                        'Gagal menghubungi layanan pencarian lokasi.'
                    );

                }



                const data =
                    await response.json();



                if (
                    !data ||
                    data.length === 0
                ) {

                    alert(
                        'Lokasi tidak ditemukan. Coba gunakan nama jalan, desa, kecamatan, atau tempat yang lebih spesifik.'
                    );

                    return;

                }



                let magetanLocation =
                    null;



                for (
                    const location of data
                ) {

                    const latitude =
                        parseFloat(
                            location.lat
                        );


                    const longitude =
                        parseFloat(
                            location.lon
                        );



                    const isMagetan =
                        await isMagetanLocation(
                            latitude,
                            longitude
                        );



                    if (isMagetan) {

                        magetanLocation =
                            location;


                        break;

                    }

                }



                if (!magetanLocation) {

                    alert(
                        'Lokasi tersebut berada di luar Kabupaten Magetan. Pelaporan sampah hanya dapat dilakukan di wilayah Kabupaten Magetan.'
                    );


                    return;

                }



                const latitude =
                    parseFloat(
                        magetanLocation.lat
                    );


                const longitude =
                    parseFloat(
                        magetanLocation.lon
                    );



                setLocation(
                    latitude,
                    longitude
                );



                searchInput.value =
                    magetanLocation.display_name;


            } catch (error) {

                console.error(error);


                alert(
                    'Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.'
                );


            } finally {

                searchButton.disabled =
                    false;


                searchButton.innerHTML =
                    '<i class="fa-solid fa-magnifying-glass"></i> Cari';

            }

        }



        /* =====================================================
           TOMBOL CARI
        ===================================================== */

        searchButton.addEventListener(
            'click',
            function () {

                searchLocation();

            }
        );



        /* =====================================================
           TEKAN ENTER
        ===================================================== */

        searchInput.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Enter'
                ) {

                    event.preventDefault();

                    searchLocation();

                }

            }
        );



        /* =====================================================
           CURRENT LOCATION
        ===================================================== */

        document.getElementById(
            'btn-location'
        ).addEventListener(
            'click',
            function () {


                if (
                    !navigator.geolocation
                ) {

                    alert(
                        'Browser Anda tidak mendukung fitur lokasi.'
                    );

                    return;

                }



                const button = this;



                button.disabled = true;


                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i> Memeriksa lokasi...';



                navigator.geolocation.getCurrentPosition(


                    async function (position) {


                        const latitude =
                            position.coords.latitude;


                        const longitude =
                            position.coords.longitude;



                        try {


                            const isMagetan =
                                await isMagetanLocation(
                                    latitude,
                                    longitude
                                );



                            if (!isMagetan) {

                                alert(
                                    'Lokasi Anda berada di luar Kabupaten Magetan. Pelaporan sampah hanya dapat dilakukan di wilayah Kabupaten Magetan.'
                                );


                                return;

                            }



                            setLocation(
                                latitude,
                                longitude
                            );


                        } catch (error) {

                            console.error(error);


                            alert(
                                'Lokasi tidak dapat diperiksa. Silakan coba lagi.'
                            );


                        } finally {

                            button.disabled =
                                false;


                            button.innerHTML =
                                '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';

                        }

                    },


                    function (error) {


                        button.disabled =
                            false;


                        button.innerHTML =
                            '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';



                        alert(
                            'Lokasi tidak dapat diperoleh. Pastikan izin lokasi diberikan pada browser.'
                        );

                    },


                    {
                        enableHighAccuracy: true,

                        timeout: 10000,

                        maximumAge: 0
                    }

                );

            }
        );



        /* =====================================================
           FOTO PREVIEW
        ===================================================== */

        const fotoInput =
            document.getElementById(
                'foto_laporan'
            );


        const previewContainer =
            document.getElementById(
                'preview-container'
            );


        const previewImage =
            document.getElementById(
                'preview-image'
            );



        fotoInput.addEventListener(
            'change',
            function () {


                const file =
                    this.files[0];



                if (!file) {

                    previewContainer.style.display =
                        'none';

                    return;

                }



                /* =================================================
                   CEK UKURAN FOTO
                ================================================= */

                if (
                    file.size >
                    2 * 1024 * 1024
                ) {

                    alert(
                        'Ukuran foto maksimal 2 MB.'
                    );


                    this.value = '';


                    previewContainer.style.display =
                        'none';

                    return;

                }



                /* =================================================
                   CEK FORMAT FOTO
                ================================================= */

                const allowedTypes = [
                    'image/jpeg',
                    'image/png'
                ];



                if (
                    !allowedTypes.includes(
                        file.type
                    )
                ) {

                    alert(
                        'Foto harus berformat JPG, JPEG, atau PNG.'
                    );


                    this.value = '';


                    previewContainer.style.display =
                        'none';

                    return;

                }



                /* =================================================
                   PREVIEW FOTO
                ================================================= */

                const reader =
                    new FileReader();



                reader.onload =
                    function (event) {

                        previewImage.src =
                            event.target.result;


                        previewContainer.style.display =
                            'block';

                    };



                reader.readAsDataURL(
                    file
                );

            }
        );



        /* =====================================================
           FIX MAP SIZE
        ===================================================== */

        setTimeout(
            function () {

                map.invalidateSize();

            },

            300
        );

    </script>

</body>

</html>