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
         Digunakan untuk membantu membuat tampilan responsive
         dan menyediakan beberapa komponen CSS.
    ========================================================= --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
         FONT AWESOME
         Digunakan untuk menampilkan icon seperti:
         - icon daun
         - icon logout
         - icon pencarian
         - icon lokasi
         - icon upload
    ========================================================= --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    {{-- =========================================================
         LEAFLET CSS
         Leaflet digunakan untuk menampilkan peta interaktif.
    ========================================================= --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >


    <style>

        /* =====================================================
           GLOBAL STYLE
           box-sizing digunakan agar padding dan border
           ikut dihitung dalam ukuran elemen.
        ===================================================== */
        * {
            box-sizing: border-box;
        }


        /* =====================================================
           BODY
           Mengatur tampilan dasar seluruh halaman.
        ===================================================== */
        body {
            margin: 0;
            padding: 0;

            /* Warna background halaman */
            background: #f4f6f8;

            /* Jenis font */
            font-family: Arial, Helvetica, sans-serif;

            /* Warna tulisan */
            color: #333;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar-sipesat {

            /* Navbar menggunakan warna putih */
            background: white;

            color: #333;

            /* Jarak bagian dalam navbar */
            padding: 10px max(20px, calc((100% - 1100px) / 2));

            /* Menyusun elemen secara horizontal */
            display: flex;

            /* Membuat elemen berada di tengah secara vertikal */
            align-items: center;

            /* Satu elemen di kiri dan satu di kanan */
            justify-content: space-between;

            /* Bayangan tipis navbar */
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
           Container utama untuk halaman laporan.
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

            /* Bayangan kotak */
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }


        /* =====================================================
           HEADER LAPORAN
        ===================================================== */

        .laporan-header {
            background: #176b43;
            color: white;
            padding: 22px 28px;
        }


        .laporan-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }


        .laporan-header p {
            margin: 7px 0 0;
            font-size: 14px;
            opacity: 0.9;
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


        /* Input pencarian menggunakan sisa ruang */
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


        /* Tombol menjadi sedikit transparan ketika disabled */
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


        /* Kotak yang menampilkan latitude dan longitude */
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


        /* Efek ketika mouse diarahkan ke area upload */
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


        /* Informasi format dan ukuran foto */
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

            /* Tombol berada di sebelah kanan */
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
           Mengatur tampilan ketika layar kecil.
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
                padding: 18px 20px;
            }


            .laporan-header h2 {
                font-size: 20px;
            }


            /*
             * Pada layar kecil,
             * input pencarian dan tombol Cari
             * disusun secara vertikal.
             */
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

                {{-- Icon daun dari Font Awesome --}}
                <i class="fa-solid fa-leaf"></i>

            </div>


            <div class="brand-text">

                {{-- Nama aplikasi --}}
                <strong>SIPESAT</strong>

            </div>

        </div>


        {{-- Area informasi user --}}
        <div class="user-area">

            {{-- Menampilkan nama user yang sedang login --}}
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

                    {{-- Icon tambah laporan --}}
                    <i class="fa-solid fa-file-circle-plus"></i>

                    Buat Laporan Sampah Baru

                </h2>


                <p>
                    Silakan isi data laporan sampah dengan lengkap dan benar.
                </p>

            </div>



            {{-- =================================================
                 BODY
            ================================================= --}}

            <div class="laporan-body">


                {{-- =================================================
                     MENAMPILKAN ERROR VALIDASI DARI LARAVEL
                ================================================= --}}

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>

                            <i class="fa-solid fa-circle-exclamation"></i>

                            Terdapat kesalahan:

                        </strong>


                        <ul class="mb-0 mt-2">

                            {{-- Mengulang semua pesan error --}}
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

                    {{-- multipart diperlukan karena form
                         mengirim file foto --}}
                    enctype="multipart/form-data"
                >

                    {{-- Token keamanan Laravel untuk mencegah CSRF --}}
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

                                {{-- Contoh isi input --}}
                                placeholder="Contoh: Tumpukan sampah di pinggir jalan"

                                {{-- old() digunakan agar input tidak hilang
                                     jika validasi gagal --}}
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


                                {{-- Mengambil data kategori dari controller --}}
                                @foreach ($kategoriSampah as $kategori)

                                    <option
                                        value="{{ $kategori->id }}"

                                        {{-- Jika sebelumnya sudah memilih kategori,
                                             pilihan tersebut tetap dipilih --}}
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


                                {{-- Daftar kecamatan Kabupaten Magetan --}}
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

                                {{-- Awalnya disabled karena
                                     kecamatan belum dipilih --}}
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


                            {{-- =================================================
                                 PENCARIAN LOKASI
                            ================================================= --}}

                            <div class="map-search">

                                <input
                                    type="text"
                                    id="search-location"
                                    class="form-control"

                                    {{-- Memberi tahu user bahwa
                                         lokasi yang dicari harus di Magetan --}}
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



                            {{-- =================================================
                                 PETA LEAFLET
                            ================================================= --}}

                            <div id="map"></div>



                            {{-- =================================================
                                 LOKASI SAAT INI
                            ================================================= --}}

                            <button
                                type="button"
                                class="location-btn"
                                id="btn-location"
                            >

                                <i class="fa-solid fa-location-crosshairs"></i>

                                Gunakan Lokasi Saat Ini

                            </button>

                        </div>



                        {{-- =================================================
                             KOORDINAT
                        ================================================= --}}

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

                                        {{-- Menampilkan koordinat lama
                                             jika validasi sebelumnya gagal --}}
                                        value="{{ old('latitude') }}"

                                        placeholder="Latitude"

                                        {{-- User tidak mengisi manual --}}
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


                            {{-- Input file --}}
                            <input
                                type="file"
                                name="foto_laporan"
                                id="foto_laporan"
                                class="form-control"

                                {{-- Format file yang disarankan --}}
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



                            {{-- =================================================
                                 PREVIEW FOTO
                            ================================================= --}}

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
         Mengaktifkan fungsi peta Leaflet.
    ========================================================= --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



    <script>


        /* =====================================================
           DATA DESA / KELURAHAN
           
           Object ini digunakan untuk menghubungkan
           kecamatan dengan daftar desa.
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

        /*
         * Mengambil elemen dropdown kecamatan
         * berdasarkan id="kecamatan".
         */
        const kecamatanSelect =
            document.getElementById('kecamatan');


        /*
         * Mengambil elemen dropdown desa
         * berdasarkan id="desa".
         */
        const desaSelect =
            document.getElementById('desa');



        /*
         * Fungsi untuk mengisi dropdown desa
         * berdasarkan kecamatan yang dipilih.
         */
        function loadDesa(
            kecamatan,
            selectedDesa = ''
        ) {

            /*
             * Menghapus isi dropdown desa sebelumnya.
             */
            desaSelect.innerHTML = '';


            /*
             * Membuat pilihan default.
             */
            const defaultOption =
                document.createElement('option');


            defaultOption.value = '';


            /*
             * Jika kecamatan sudah dipilih,
             * tampilkan "Pilih Desa".
             *
             * Jika belum,
             * tampilkan "Pilih Kecamatan terlebih dahulu".
             */
            defaultOption.textContent =
                kecamatan
                    ? 'Pilih Desa / Kelurahan'
                    : 'Pilih Kecamatan terlebih dahulu';


            desaSelect.appendChild(defaultOption);



            /*
             * Jika kecamatan kosong atau
             * tidak memiliki data desa,
             * dropdown desa dinonaktifkan.
             */
            if (
                !kecamatan ||
                !dataDesa[kecamatan]
            ) {

                desaSelect.disabled = true;

                return;

            }



            /*
             * Jika data desa tersedia,
             * dropdown desa diaktifkan.
             */
            desaSelect.disabled = false;



            /*
             * Mengulang semua desa
             * pada kecamatan yang dipilih.
             */
            dataDesa[kecamatan].forEach(
                function (desa) {

                    /*
                     * Membuat option baru.
                     */
                    const option =
                        document.createElement('option');


                    option.value = desa;

                    option.textContent = desa;



                    /*
                     * Jika desa sama dengan data lama,
                     * jadikan sebagai pilihan terpilih.
                     */
                    if (
                        desa === selectedDesa
                    ) {

                        option.selected = true;

                    }


                    /*
                     * Memasukkan option ke dropdown.
                     */
                    desaSelect.appendChild(
                        option
                    );

                }
            );

        }



        /*
         * Ketika user mengganti kecamatan,
         * fungsi loadDesa() dijalankan.
         */
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
           
           old() digunakan agar data sebelumnya
           tidak hilang ketika validasi gagal.
        ===================================================== */

        const oldKecamatan =
            @json(old('kecamatan'));

        const oldDesa =
            @json(old('desa'));


        /*
         * Jika sebelumnya sudah memilih kecamatan,
         * tampilkan kembali kecamatan dan desanya.
         */
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

        /*
         * Koordinat awal peta.
         *
         * Peta akan dibuka di sekitar Kabupaten Magetan.
         */
        const defaultLatitude =
            -7.6546;

        const defaultLongitude =
            111.3230;



        /*
         * Membuat peta Leaflet.
         *
         * setView([
         *     latitude,
         *     longitude
         * ], zoom);
         *
         * Zoom 12 berarti tampilan cukup dekat
         * untuk melihat wilayah Magetan.
         */
        const map =
            L.map('map').setView(
                [
                    defaultLatitude,
                    defaultLongitude
                ],
                12
            );



        /*
         * Menambahkan layer peta OpenStreetMap.
         *
         * OpenStreetMap digunakan sebagai sumber
         * tampilan peta.
         */
        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);



        /*
         * Variabel untuk menyimpan marker.
         *
         * Awalnya belum ada marker.
         */
        let marker = null;



        /* =====================================================
           SET LOCATION
           
           Fungsi ini digunakan ketika lokasi
           sudah dianggap valid.
        ===================================================== */

        function setLocation(
            latitude,
            longitude
        ) {

            /*
             * Menampilkan latitude pada input.
             *
             * toFixed(7) berarti koordinat ditampilkan
             * sampai 7 angka di belakang koma.
             */
            document.getElementById(
                'latitude'
            ).value =
                latitude.toFixed(7);



            /*
             * Menampilkan longitude.
             */
            document.getElementById(
                'longitude'
            ).value =
                longitude.toFixed(7);



            /*
             * Jika marker sudah ada,
             * pindahkan marker ke lokasi baru.
             */
            if (marker) {

                marker.setLatLng([
                    latitude,
                    longitude
                ]);

            } else {

                /*
                 * Jika marker belum ada,
                 * buat marker baru.
                 */
                marker =
                    L.marker([
                        latitude,
                        longitude
                    ]).addTo(map);

            }



            /*
             * Memusatkan peta ke lokasi yang dipilih.
             *
             * Zoom 16 membuat lokasi terlihat lebih detail.
             */
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


        /*
         * Jika sebelumnya sudah memiliki koordinat,
         * tampilkan kembali marker pada peta.
         */
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
           
           INI ADALAH BAGIAN PALING PENTING
           UNTUK MEMBATASI LOKASI.
        ===================================================== */

        /*
         * Fungsi ini menerima:
         *
         * latitude
         * longitude
         *
         * kemudian mengecek apakah koordinat
         * tersebut berada di wilayah Magetan.
         */
        async function isMagetanLocation(
            latitude,
            longitude
        ) {

            try {

                /*
                 * Reverse geocoding.
                 *
                 * Koordinat latitude + longitude
                 * dikirim ke Nominatim.
                 *
                 * Nominatim kemudian mengembalikan
                 * informasi wilayah dari koordinat tersebut.
                 */
                const response =
                    await fetch(
                        'https://nominatim.openstreetmap.org/reverse?format=json&lat='
                        + latitude
                        + '&lon='
                        + longitude
                        + '&zoom=10&addressdetails=1'
                    );



                /*
                 * Mengecek apakah request berhasil.
                 */
                if (!response.ok) {

                    throw new Error(
                        'Gagal memeriksa wilayah lokasi.'
                    );

                }



                /*
                 * Mengubah response menjadi JSON.
                 */
                const data =
                    await response.json();



                /*
                 * Mengambil informasi alamat
                 * dari hasil Nominatim.
                 */
                const address =
                    data.address || {};



                /*
                 * Mengambil nama wilayah.
                 *
                 * Nominatim dapat menyimpan wilayah
                 * pada county, municipality, atau city.
                 */
                const wilayah = (
                    address.county ||
                    address.municipality ||
                    address.city ||
                    ''
                ).toLowerCase();



                /*
                 * =================================================
                 * PEMBATAS WILAYAH MAGETAN
                 * =================================================
                 *
                 * Jika wilayah mengandung kata "magetan",
                 * maka fungsi menghasilkan TRUE.
                 *
                 * Jika tidak mengandung "magetan",
                 * maka menghasilkan FALSE.
                 */
                return wilayah.includes(
                    'magetan'
                );


            } catch (error) {

                /*
                 * Menampilkan error di console browser.
                 */
                console.error(error);


                /*
                 * Jika terjadi error,
                 * lokasi dianggap tidak valid.
                 */
                return false;

            }

        }



        /* =====================================================
           MAP CLICK
           
           Ketika user memilih lokasi dengan
           cara klik langsung pada peta.
        ===================================================== */

        map.on(
            'click',
            async function (e) {

                /*
                 * Mengambil latitude dari titik
                 * yang diklik user.
                 */
                const latitude =
                    e.latlng.lat;


                /*
                 * Mengambil longitude.
                 */
                const longitude =
                    e.latlng.lng;



                /*
                 * Mengecek apakah titik tersebut
                 * berada di Kabupaten Magetan.
                 */
                const isMagetan =
                    await isMagetanLocation(
                        latitude,
                        longitude
                    );



                /*
                 * =================================================
                 * JIKA LOKASI DI LUAR MAGETAN
                 * =================================================
                 */
                if (!isMagetan) {

                    /*
                     * Menampilkan peringatan kepada user.
                     */
                    alert(
                        'Lokasi yang dipilih berada di luar Kabupaten Magetan. Pelaporan sampah hanya dapat dilakukan di wilayah Kabupaten Magetan.'
                    );


                    /*
                     * return menghentikan proses.
                     *
                     * Marker tidak akan dipindahkan
                     * ke lokasi tersebut.
                     */
                    return;

                }



                /*
                 * Jika lokasi valid,
                 * marker dipindahkan ke lokasi.
                 */
                setLocation(
                    latitude,
                    longitude
                );

            }
        );



        /* =====================================================
           PENCARIAN LOKASI
           
           Digunakan ketika user mengetik nama lokasi
           kemudian menekan tombol "Cari".
        ===================================================== */

        const searchInput =
            document.getElementById(
                'search-location'
            );


        const searchButton =
            document.getElementById(
                'btn-search-location'
            );



        /*
         * Fungsi utama untuk mencari lokasi.
         */
        async function searchLocation() {

            /*
             * Mengambil teks dari input pencarian.
             *
             * trim() digunakan untuk menghilangkan
             * spasi kosong di awal dan akhir.
             */
            const query =
                searchInput.value.trim();



            /*
             * Jika user belum memasukkan pencarian,
             * tampilkan peringatan.
             */
            if (!query) {

                alert(
                    'Silakan masukkan lokasi yang ingin dicari.'
                );


                searchInput.focus();

                return;

            }



            /*
             * Menonaktifkan tombol selama proses pencarian.
             */
            searchButton.disabled = true;


            /*
             * Mengubah tulisan tombol menjadi
             * "Mencari..." dan menampilkan spinner.
             */
            searchButton.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Mencari...';



            try {


                /*
                |--------------------------------------------------------------------------
                | PENCARIAN LOKASI DI INDONESIA
                |--------------------------------------------------------------------------
                |
                | countrycodes=id
                | digunakan agar pencarian hanya dilakukan
                | di negara Indonesia.
                |
                | PERHATIAN:
                | countrycodes=id BELUM berarti hanya Magetan.
                |
                | Pembatasan Magetan dilakukan setelah hasil
                | pencarian diperoleh.
                |--------------------------------------------------------------------------
                */

                const response =
                    await fetch(
                        'https://nominatim.openstreetmap.org/search?format=json&limit=5&countrycodes=id&addressdetails=1&q='
                        + encodeURIComponent(query)
                    );



                /*
                 * Jika request gagal.
                 */
                if (!response.ok) {

                    throw new Error(
                        'Gagal menghubungi layanan pencarian lokasi.'
                    );

                }



                /*
                 * Mengubah hasil pencarian menjadi JSON.
                 */
                const data =
                    await response.json();



                /*
                 * Jika Nominatim tidak menemukan lokasi.
                 */
                if (
                    !data ||
                    data.length === 0
                ) {

                    alert(
                        'Lokasi tidak ditemukan. Coba gunakan nama jalan, desa, kecamatan, atau tempat yang lebih spesifik.'
                    );

                    return;

                }



                /*
                |--------------------------------------------------------------------------
                | CARI HASIL YANG BERADA DI MAGETAN
                |--------------------------------------------------------------------------
                |
                | Nominatim bisa memberikan beberapa hasil.
                |
                | Karena itu setiap hasil diperiksa satu per satu.
                |--------------------------------------------------------------------------
                */

                let magetanLocation =
                    null;



                /*
                 * Melakukan perulangan pada semua
                 * hasil pencarian.
                 */
                for (
                    const location of data
                ) {

                    /*
                     * Mengambil latitude dari hasil pencarian.
                     */
                    const latitude =
                        parseFloat(
                            location.lat
                        );


                    /*
                     * Mengambil longitude.
                     */
                    const longitude =
                        parseFloat(
                            location.lon
                        );



                    /*
                     * Mengecek apakah hasil tersebut
                     * berada di Kabupaten Magetan.
                     */
                    const isMagetan =
                        await isMagetanLocation(
                            latitude,
                            longitude
                        );



                    /*
                     * Jika hasil berada di Magetan,
                     * simpan hasil tersebut.
                     */
                    if (isMagetan) {

                        magetanLocation =
                            location;


                        /*
                         * break digunakan untuk menghentikan
                         * pencarian setelah menemukan hasil
                         * pertama yang valid di Magetan.
                         */
                        break;

                    }

                }



                /*
                |--------------------------------------------------------------------------
                | JIKA TIDAK ADA HASIL DI MAGETAN
                |--------------------------------------------------------------------------
                */

                if (!magetanLocation) {

                    /*
                     * =================================================
                     * PERINGATAN LOKASI DI LUAR MAGETAN
                     * =================================================
                     */
                    alert(
                        'Lokasi tersebut berada di luar Kabupaten Magetan. Pelaporan sampah hanya dapat dilakukan di wilayah Kabupaten Magetan.'
                    );


                    /*
                     * Menghentikan proses.
                     */
                    return;

                }



                /*
                |--------------------------------------------------------------------------
                | JIKA LOKASI VALID / BERADA DI MAGETAN
                |--------------------------------------------------------------------------
                */

                /*
                 * Mengambil latitude dari hasil yang valid.
                 */
                const latitude =
                    parseFloat(
                        magetanLocation.lat
                    );


                /*
                 * Mengambil longitude.
                 */
                const longitude =
                    parseFloat(
                        magetanLocation.lon
                    );



                /*
                 * Memindahkan marker ke lokasi
                 * yang sudah lolos pengecekan Magetan.
                 */
                setLocation(
                    latitude,
                    longitude
                );



                /*
                 * Mengisi input pencarian dengan
                 * nama lengkap lokasi hasil pencarian.
                 */
                searchInput.value =
                    magetanLocation.display_name;


            } catch (error) {

                /*
                 * Menampilkan error ke console.
                 */
                console.error(error);


                /*
                 * Memberikan pesan kepada user.
                 */
                alert(
                    'Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.'
                );


            } finally {

                /*
                 * Tombol pencarian diaktifkan kembali
                 * setelah proses selesai.
                 */
                searchButton.disabled =
                    false;


                /*
                 * Mengembalikan tampilan tombol
                 * menjadi "Cari".
                 */
                searchButton.innerHTML =
                    '<i class="fa-solid fa-magnifying-glass"></i> Cari';

            }

        }



        /* =====================================================
           TOMBOL CARI
           
           Ketika tombol "Cari" diklik,
           jalankan fungsi searchLocation().
        ===================================================== */

        searchButton.addEventListener(
            'click',
            function () {

                searchLocation();

            }
        );



        /* =====================================================
           TEKAN ENTER
           
           User juga bisa mencari lokasi
           dengan menekan tombol Enter.
        ===================================================== */

        searchInput.addEventListener(
            'keydown',
            function (event) {

                /*
                 * Mengecek apakah tombol yang ditekan
                 * adalah Enter.
                 */
                if (
                    event.key === 'Enter'
                ) {

                    /*
                     * Mencegah form melakukan submit
                     * ketika user menekan Enter.
                     */
                    event.preventDefault();


                    /*
                     * Jalankan pencarian lokasi.
                     */
                    searchLocation();

                }

            }
        );



        /* =====================================================
           CURRENT LOCATION
           
           Menggunakan GPS/browser untuk mengambil
           lokasi pengguna saat ini.
        ===================================================== */

        document.getElementById(
            'btn-location'
        ).addEventListener(
            'click',
            function () {


                /*
                 * Mengecek apakah browser mendukung
                 * Geolocation API.
                 */
                if (
                    !navigator.geolocation
                ) {

                    alert(
                        'Browser Anda tidak mendukung fitur lokasi.'
                    );

                    return;

                }



                /*
                 * Menyimpan tombol ke dalam variabel
                 * agar mudah diubah tampilannya.
                 */
                const button = this;



                /*
                 * Menonaktifkan tombol sementara
                 * selama GPS sedang diproses.
                 */
                button.disabled = true;


                /*
                 * Mengubah tulisan tombol.
                 */
                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i> Memeriksa lokasi...';



                /*
                 * Meminta lokasi GPS pengguna.
                 */
                navigator.geolocation.getCurrentPosition(


                    /*
                     * =================================================
                     * JIKA GPS BERHASIL DIDAPATKAN
                     * =================================================
                     */
                    async function (position) {


                        /*
                         * Mengambil latitude dari GPS.
                         */
                        const latitude =
                            position.coords.latitude;


                        /*
                         * Mengambil longitude dari GPS.
                         */
                        const longitude =
                            position.coords.longitude;



                        try {


                            /*
                            |--------------------------------------------------------------------------
                            | CEK LOKASI SAAT INI
                            |--------------------------------------------------------------------------
                            |
                            | Koordinat GPS diperiksa menggunakan
                            | fungsi isMagetanLocation().
                            |--------------------------------------------------------------------------
                            */

                            const isMagetan =
                                await isMagetanLocation(
                                    latitude,
                                    longitude
                                );



                            /*
                            |--------------------------------------------------------------------------
                            | JIKA GPS BERADA DI LUAR MAGETAN
                            |--------------------------------------------------------------------------
                            */

                            if (!isMagetan) {

                                /*
                                 * Memberikan peringatan.
                                 */
                                alert(
                                    'Lokasi Anda berada di luar Kabupaten Magetan. Pelaporan sampah hanya dapat dilakukan di wilayah Kabupaten Magetan.'
                                );


                                /*
                                 * Hentikan proses.
                                 */
                                return;

                            }



                            /*
                            |--------------------------------------------------------------------------
                            | JIKA GPS BERADA DI MAGETAN
                            |--------------------------------------------------------------------------
                            */

                            /*
                             * Lokasi GPS diterima
                             * dan marker dipindahkan.
                             */
                            setLocation(
                                latitude,
                                longitude
                            );


                        } catch (error) {

                            /*
                             * Menampilkan error ke console.
                             */
                            console.error(error);


                            alert(
                                'Lokasi tidak dapat diperiksa. Silakan coba lagi.'
                            );


                        } finally {

                            /*
                             * Mengaktifkan kembali tombol.
                             */
                            button.disabled =
                                false;


                            /*
                             * Mengembalikan tulisan tombol.
                             */
                            button.innerHTML =
                                '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';

                        }

                    },


                    /*
                     * =================================================
                     * JIKA GPS GAGAL
                     * =================================================
                     */
                    function (error) {


                        /*
                         * Mengaktifkan kembali tombol.
                         */
                        button.disabled =
                            false;


                        /*
                         * Mengembalikan tulisan tombol.
                         */
                        button.innerHTML =
                            '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saat Ini';



                        /*
                         * Menampilkan pesan bahwa lokasi
                         * tidak berhasil diperoleh.
                         */
                        alert(
                            'Lokasi tidak dapat diperoleh. Pastikan izin lokasi diberikan pada browser.'
                        );

                    },


                    /*
                     * =================================================
                     * PENGATURAN GPS
                     * =================================================
                     */
                    {
                        /*
                         * Meminta akurasi lokasi yang lebih tinggi.
                         */
                        enableHighAccuracy: true,

                        /*
                         * Waktu maksimal menunggu GPS
                         * adalah 10 detik.
                         */
                        timeout: 10000,

                        /*
                         * Tidak menggunakan lokasi lama
                         * yang tersimpan di cache.
                         */
                        maximumAge: 0
                    }

                );

            }
        );



        /* =====================================================
           FOTO PREVIEW
           
           Menampilkan preview foto sebelum dikirim.
        ===================================================== */

        /*
         * Mengambil input file.
         */
        const fotoInput =
            document.getElementById(
                'foto_laporan'
            );


        /*
         * Mengambil container preview.
         */
        const previewContainer =
            document.getElementById(
                'preview-container'
            );


        /*
         * Mengambil elemen gambar preview.
         */
        const previewImage =
            document.getElementById(
                'preview-image'
            );



        /*
         * Event change dijalankan ketika
         * user memilih file.
         */
        fotoInput.addEventListener(
            'change',
            function () {


                /*
                 * Mengambil file pertama
                 * yang dipilih user.
                 */
                const file =
                    this.files[0];



                /*
                 * Jika tidak ada file,
                 * preview disembunyikan.
                 */
                if (!file) {

                    previewContainer.style.display =
                        'none';

                    return;

                }



                /*
                 * =================================================
                 * CEK UKURAN FOTO
                 * =================================================
                 *
                 * 2 * 1024 * 1024
                 * berarti 2 MB.
                 */
                if (
                    file.size >
                    2 * 1024 * 1024
                ) {

                    alert(
                        'Ukuran foto maksimal 2 MB.'
                    );


                    /*
                     * Mengosongkan input file.
                     */
                    this.value = '';


                    /*
                     * Menyembunyikan preview.
                     */
                    previewContainer.style.display =
                        'none';

                    return;

                }



                /*
                 * =================================================
                 * CEK FORMAT FOTO
                 * =================================================
                 */

                const allowedTypes = [
                    'image/jpeg',
                    'image/png'
                ];



                /*
                 * Mengecek apakah tipe file
                 * termasuk format yang diperbolehkan.
                 */
                if (
                    !allowedTypes.includes(
                        file.type
                    )
                ) {

                    alert(
                        'Foto harus berformat JPG, JPEG, atau PNG.'
                    );


                    /*
                     * Mengosongkan input.
                     */
                    this.value = '';


                    /*
                     * Menyembunyikan preview.
                     */
                    previewContainer.style.display =
                        'none';

                    return;

                }



                /*
                 * =================================================
                 * PREVIEW FOTO
                 * =================================================
                 */

                /*
                 * FileReader digunakan untuk membaca
                 * file yang dipilih oleh user.
                 */
                const reader =
                    new FileReader();



                /*
                 * Ketika file berhasil dibaca,
                 * tampilkan hasilnya pada gambar preview.
                 */
                reader.onload =
                    function (event) {

                        /*
                         * Memasukkan hasil file
                         * ke atribut src gambar.
                         */
                        previewImage.src =
                            event.target.result;


                        /*
                         * Menampilkan container preview.
                         */
                        previewContainer.style.display =
                            'block';

                    };



                /*
                 * Membaca file sebagai Data URL
                 * agar dapat ditampilkan sebagai gambar.
                 */
                reader.readAsDataURL(
                    file
                );

            }
        );



        /* =====================================================
           FIX MAP SIZE
           
           Memastikan ukuran peta dihitung ulang
           setelah halaman selesai ditampilkan.
        ===================================================== */

        setTimeout(
            function () {

                /*
                 * Leaflet menghitung ulang ukuran peta.
                 */
                map.invalidateSize();

            },

            /*
             * Jalankan setelah 300 milidetik.
             */
            300
        );

    </script>

</body>

</html>