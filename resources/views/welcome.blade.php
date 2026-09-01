<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPESAT Magetan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,900;1,900&family=Outfit:ital,wght@0,900;1,900&display=swap">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #ffffff !important;
            margin: 0;
        }

        .hero-section {
            position: relative;
            background:
                linear-gradient(
                    rgba(15, 23, 42, 0.20),
                    rgba(15, 23, 42, 0.25)
                ),
                url("{{ asset('images/alun_alun_hero.png') }}");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            padding: 120px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .hero-title {
            font-family: 'Montserrat', 'Outfit', 'Arial Black',
                'Plus Jakarta Sans', sans-serif !important;

            font-size: 4.5rem;
            font-weight: 900 !important;
            font-style: italic !important;
            letter-spacing: 0px;
            color: #ffffff;
            line-height: 1.05;
            text-transform: uppercase;

            -webkit-text-stroke: 1.5px currentColor;
            paint-order: stroke fill;

            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
        }

        .hero-title .text-accent {
            color: #10b981;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: #ffffff;
            font-weight: 500;
            max-width: 540px;
            line-height: 1.7;

            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
        }

        .btn-hero {
            background-color: #10b981;
            color: #fff;

            border-radius: 50px;
            padding: 16px 42px;

            font-weight: 700;
            letter-spacing: 0.5px;

            transition: all 0.3s ease;
            border: none;

            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
        }

        .btn-hero:hover {
            background-color: #059669;
            color: #fff;

            transform: translateY(-3px);

            box-shadow: 0 14px 28px rgba(16, 185, 129, 0.45);
        }

        .hero-illustration {
            max-width: 100%;
            height: auto;

            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.6));

            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .banner-card {
            border-radius: 16px;
            overflow: hidden;

            transition: transform 0.3s ease;

            border: 1px solid rgba(0, 0, 0, 0.05);

            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        }

        .banner-card:hover {
            transform: translateY(-4px);

            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #212529;
        }

        .footer-custom {
            background-color: #fff;
            border-top: 1px solid #eaeaea;
        }

        @media (max-width: 991px) {
            .hero-section {
                padding: 80px 0;
            }

            .hero-title {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 60px 0;
            }

            .hero-title {
                font-size: 2.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">

        <!-- ====================================================== -->
        <!-- HERO SECTION -->
        <!-- ====================================================== -->

        <div class="hero-section">

            <div class="container">

                <div class="row align-items-center">

                    <!-- Kolom Kiri -->
                    <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">

                        <!-- Logo -->
                        <div
                            class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3 mb-3">

                            <img
                                src="{{ asset('images/logo_magetan.png') }}"
                                alt="Logo Kabupaten Magetan"
                                style="
                                    height: 55px;
                                    width: auto;
                                    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.6));
                                "
                            >

                            <img
                                src="{{ asset('images/logo_dlh.png') }}"
                                alt="Logo DLH Magetan"
                                style="
                                    height: 55px;
                                    width: auto;
                                    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.6));
                                "
                            >

                            <img
                                src="{{ asset('images/logo_extra.png') }}"
                                alt="Logo SIPESAT"
                                style="
                                    height: 55px;
                                    width: auto;
                                    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.6));
                                "
                            >

                        </div>

                        <!-- Judul -->
                        <h1 class="hero-title mb-4">
                            SIPESAT<br>
                            <span class="text-accent">MAGETAN</span>
                        </h1>

                        <!-- Deskripsi -->
                        <p class="hero-subtitle mb-5 mx-auto mx-lg-0">
                            Sistem Pelaporan Sampah Terpadu wilayah Magetan,
                            Jawa Timur. Mari bersama wujudkan lingkungan bersih
                            dengan melaporkan tumpukan sampah atau pembuangan
                            ilegal secara cepat dan mudah.
                        </p>

                        <!-- Tombol sementara -->
                        <a
                            href="#"
                            class="btn btn-hero text-uppercase"
                            onclick="return false;"
                        >
                            Buat Laporan
                        </a>

                    </div>


                    <!-- Kolom Kanan -->
                    <div class="col-lg-6 text-center">

                        <img
                            src="{{ asset('images/hero_illustration.png') }}"
                            alt="Ilustrasi Petugas Kebersihan"
                            class="hero-illustration img-fluid"
                        >

                    </div>

                </div>

            </div>

        </div>


        <!-- ====================================================== -->
        <!-- CARA MELAPOR -->
        <!-- ====================================================== -->

        <div class="container my-5 pt-4">

            <div class="text-center mb-5">

                <h2 class="fw-bold section-title">
                    Cara Melapor di SIPESAT
                </h2>

                <p class="text-muted mt-3">
                    Sampaikan laporan Anda dalam 3 langkah mudah.
                    Kami akan segera menindaklanjutinya.
                </p>

            </div>


            <div class="row g-4 text-center justify-content-center mb-5">

                <!-- Step 1 -->
                <div class="col-md-4">

                    <div class="card border-0 h-100 banner-card p-4">

                        <div class="mb-3">

                            <div
                                class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;"
                            >
                                <i class="fa-solid fa-camera fa-2x"></i>
                            </div>

                        </div>

                        <h5 class="fw-bold">
                            1. Foto Kejadian
                        </h5>

                        <p class="text-muted">
                            Ambil foto tumpukan sampah atau pelanggaran
                            kebersihan yang Anda temui di lokasi.
                        </p>

                    </div>

                </div>


                <!-- Step 2 -->
                <div class="col-md-4">

                    <div class="card border-0 h-100 banner-card p-4">

                        <div class="mb-3">

                            <div
                                class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;"
                            >
                                <i class="fa-solid fa-map-location-dot fa-2x"></i>
                            </div>

                        </div>

                        <h5 class="fw-bold">
                            2. Tentukan Lokasi
                        </h5>

                        <p class="text-muted">
                            Isi detail lokasi dan deskripsi singkat agar
                            petugas kami mudah menemukan titik tersebut.
                        </p>

                    </div>

                </div>


                <!-- Step 3 -->
                <div class="col-md-4">

                    <div class="card border-0 h-100 banner-card p-4">

                        <div class="mb-3">

                            <div
                                class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;"
                            >
                                <i class="fa-solid fa-truck-fast fa-2x"></i>
                            </div>

                        </div>

                        <h5 class="fw-bold">
                            3. Laporan Ditangani
                        </h5>

                        <p class="text-muted">
                            Laporan diteruskan ke petugas kebersihan
                            DLH Magetan untuk segera ditangani.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Tombol laporan sementara -->
            <div class="text-center">

                <a
                    href="#"
                    class="btn btn-hero btn-lg rounded-pill px-5 py-3 fw-bold shadow"
                    onclick="return false;"
                >
                    <i class="fa-solid fa-bullhorn me-2"></i>
                    Laporkan Sekarang
                </a>

            </div>

        </div>


        <!-- ====================================================== -->
        <!-- EDUKASI SAMPAH -->
        <!-- ====================================================== -->

        <div class="py-5">

            <div class="container mb-4">

                <div class="text-center mb-5">

                    <h2 class="fw-bold section-title">
                        Edukasi & Kesadaran Lingkungan
                    </h2>

                    <p class="text-muted mt-3">
                        Mengenal jenis-jenis sampah adalah langkah awal
                        menuju pengelolaan lingkungan yang lebih baik.
                    </p>

                </div>


                <div class="card banner-card mb-5">

                    <img
                        src="{{ asset('images/edukasi_kategori_sampah.jpg') }}"
                        alt="Edukasi Kategori Sampah"
                        class="img-fluid w-100"
                    >

                    <div class="card-body bg-white text-center p-4">

                        <h4 class="fw-bold text-success mb-3">
                            Kenali Jenis Sampah di Lingkungan Kita
                        </h4>

                        <p
                            class="text-muted mb-0 mx-auto"
                            style="max-width: 800px; line-height: 1.8;"
                        >
                            Mari bersama-sama menjaga kebersihan lingkungan
                            dengan mengenali dan melaporkan berbagai jenis
                            sampah. Pemilahan yang benar antara Sampah Rumah
                            Tangga, Pembuangan Liar, Sampah Saluran Air,
                            Sampah Pasar, hingga Limbah B3 Ringan akan sangat
                            membantu proses daur ulang dan menjaga ekosistem
                            Magetan.
                        </p>

                    </div>

                </div>


                <!-- ================================================== -->
                <!-- BERITA -->
                <!-- ================================================== -->

                <div class="text-start mb-4">

                    <h4 class="fw-bold text-dark">
                        Berita & Edukasi Terkini
                    </h4>

                </div>


                <div class="row g-4">

                    @forelse($beritas as $berita)

                        <div class="col-lg-4 col-md-6">

                            <div class="card border-0 shadow-sm h-100 banner-card">

                                <div class="card-body p-4 d-flex flex-column">

                                    <img
                                        src="{{ $berita->thumbnail
                                            ? Storage::url($berita->thumbnail)
                                            : asset('images/no-image.png') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                        alt="{{ $berita->judul }}"
                                        class="img-fluid rounded mb-3"
                                        style="height: 180px; object-fit: cover;"
                                    >

                                    <div class="mb-3">

                                        <span
                                            class="badge bg-primary rounded-pill px-3 py-2 me-2"
                                        >
                                            {{ ucwords($berita->kategori) }}
                                        </span>

                                        <small class="text-muted">
                                            <i class="fa-regular fa-calendar me-1"></i>
                                            {{ $berita->created_at->format('d M Y') }}
                                        </small>

                                    </div>

                                    <h5 class="fw-bold text-dark mb-3">
                                        {{ $berita->judul }}
                                    </h5>

                                    <p
                                        class="text-muted mb-4 flex-grow-1"
                                        style="font-size: 0.95rem;"
                                    >
                                        {{ \Illuminate\Support\Str::limit($berita->konten, 120) }}
                                    </p>

                                    <a
                                        href="{{ route('berita.show', $berita->slug) }}"
                                        class="text-primary fw-bold text-decoration-none mt-auto"
                                    >
                                        Baca Selengkapnya
                                        <i class="fa-solid fa-arrow-right ms-1"></i>
                                    </a>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12 text-center text-muted">

                            <div class="py-4">

                                <i
                                    class="fa-regular fa-newspaper fa-2x mb-3"
                                ></i>

                                <p class="mb-0">
                                    Belum ada berita yang dipublikasikan.
                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        <!-- ====================================================== -->
        <!-- FOOTER -->
        <!-- ====================================================== -->

        <footer class="footer-custom py-4 mt-auto">

            <div class="container text-center text-muted">

                <p class="mb-0">
                    &copy; {{ date('Y') }}
                    SIPESAT Magetan.
                    Hak Cipta Dilindungi.
                </p>

                <small>
                    Dikelola oleh Dinas Lingkungan Hidup Kabupaten Magetan
                </small>

            </div>

        </footer>

    </div>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>