<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @hasSection('title')
            @yield('title') -
        @endif
        {{ config('app.name', 'Sipesat') }}
    </title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Outfit:wght@800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        /* =====================================================
           WARNA UTAMA SIPESAT
        ===================================================== */

        :root {
            --color-primary: #1F6E43;
            --color-primary-dark: #16502F;
            --color-primary-light: #E8F3EC;

            --color-accent: #7FB069;
            --color-info: #2E7DA3;
            --color-warning: #E8A33D;
            --color-danger: #C1443C;

            --color-dark: #1F2A24;
            --color-muted: #6B7280;

            --color-bg: #F6F7F5;
            --color-surface: #FFFFFF;
            --color-border: #E2E5E1;

            --font-display: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;

            --radius-md: 8px;

            --shadow-card:
                0 2px 8px rgba(31, 42, 36, 0.06);
        }


        /* =====================================================
           BODY
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            font-family: var(--font-body);

            background-color: var(--color-bg);

            color: var(--color-dark);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-display);
            font-weight: 700;
        }

        .text-primary {
            color: var(--color-primary) !important;
        }

        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .text-accent {
            color: var(--color-accent) !important;
        }


        /* =====================================================
           BUTTON
        ===================================================== */

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
        }


        /* =====================================================
           CARD
        ===================================================== */

        .card {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
        }


        /* =====================================================
           SIDEBAR ADMIN / PETUGAS
           Ukuran dibuat mendekati desain Figma
        ===================================================== */

        .sidebar {
            width: 160px;
            min-width: 160px;

            min-height: 100vh;

            background-color: var(--color-primary-dark);

            color: white;

            padding-top: 0;

            position: sticky;
            top: 0;

            height: 100vh;

            overflow-y: auto;
        }


        /* =====================================================
           LOGO SIDEBAR
        ===================================================== */

        .sidebar-brand {
            height: 105px;

            padding: 18px 14px 12px;

            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .sidebar-brand h4 {
            margin: 0;

            font-size: 18px;

            font-weight: 800;

            line-height: 1.2;

            white-space: nowrap;
        }

        .sidebar-brand h4 i {
            font-size: 14px;
            margin-right: 3px;
        }

        .sidebar-brand small {
            display: block;

            margin-top: 4px;

            font-size: 9px;

            color: rgba(255,255,255,0.65);
        }


        /* =====================================================
           MENU SIDEBAR
        ===================================================== */

        .sidebar-menu {
            padding-top: 8px;
        }

        .sidebar a {
            color: rgba(255,255,255,0.72);

            text-decoration: none;

            padding: 9px 12px;

            display: flex;

            align-items: center;

            gap: 8px;

            border-left: 3px solid transparent;

            font-size: 10px;

            font-weight: 500;

            line-height: 1.2;

            transition: all .2s ease;
        }

        .sidebar a i {
            width: 14px;

            min-width: 14px;

            text-align: center;

            font-size: 10px;
        }

        .sidebar a:hover {
            background-color: rgba(255,255,255,0.08);

            color: white;

            border-left-color: rgba(255,255,255,0.7);
        }

        .sidebar a.active {
            background-color: rgba(255,255,255,0.16);

            color: white;

            border-left-color: white;

            font-weight: 600;
        }


        /* =====================================================
           JUDUL GRUP SIDEBAR
        ===================================================== */

        .sidebar-section-title {
            margin-top: 13px;

            margin-bottom: 4px;

            padding: 0 12px;

            font-size: 8px;

            font-weight: 700;

            letter-spacing: .5px;

            color: rgba(255,255,255,0.55);
        }


        /* =====================================================
           AREA UTAMA
        ===================================================== */

        .admin-wrapper {
            display: flex;

            width: 100%;

            min-height: 100vh;
        }

        .admin-main {
            flex: 1;

            min-width: 0;

            background-color: var(--color-bg);
        }


        /* =====================================================
           TOP NAVBAR
        ===================================================== */

        .navbar-custom {
            height: 55px;

            background-color: #ffffff;

            border-bottom: 1px solid var(--color-border);

            padding: 0 18px;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }

        .navbar-title {
            margin: 0;

            font-size: 15px;

            font-weight: 700;

            color: #202522;
        }

        .navbar-user {
            display: flex;

            align-items: center;

            gap: 8px;

            font-size: 10px;
        }

        .navbar-user-name {
            color: #343a40;

            white-space: nowrap;
        }

        .navbar-user .badge {
            font-size: 8px;

            font-weight: 500;

            padding: 4px 6px;
        }

        .logout-button {
            border: 1px solid #ef3340;

            background: white;

            color: #ef3340;

            border-radius: 5px;

            padding: 5px 10px;

            font-size: 9px;

            font-weight: 500;

            transition: .2s;
        }

        .logout-button:hover {
            background: #ef3340;

            color: white;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .admin-content {
            padding: 16px;
        }


        /* =====================================================
           DASHBOARD CARD
           Supaya card dashboard mengikuti Figma
        ===================================================== */

        .dashboard-card {
            background: #ffffff;

            border: 1px solid var(--color-border);

            border-radius: 8px;

            box-shadow: var(--shadow-card);
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table {
            font-size: 12px;
        }


        /* =====================================================
           SCROLLBAR SIDEBAR
        ===================================================== */

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);

            border-radius: 10px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 991px) {

            .sidebar {
                width: 180px;

                min-width: 180px;
            }

            .sidebar a {
                font-size: 11px;

                padding: 10px 12px;
            }

            .sidebar-brand h4 {
                font-size: 19px;
            }

            .admin-content {
                padding: 14px;
            }
        }


        @media (max-width: 768px) {

            .sidebar {
                width: 65px;

                min-width: 65px;
            }

            .sidebar-brand {
                padding: 15px 8px;

                text-align: center;
            }

            .sidebar-brand h4 {
                font-size: 0;
            }

            .sidebar-brand h4 i {
                font-size: 20px;

                margin: 0;
            }

            .sidebar-brand small {
                display: none;
            }

            .sidebar a {
                justify-content: center;

                padding: 12px 5px;

                border-left: 0;

                border-bottom: 2px solid transparent;

                font-size: 0;
            }

            .sidebar a i {
                font-size: 14px;
            }

            .sidebar a.active {
                border-left: 0;

                border-bottom-color: white;
            }

            .sidebar-section-title {
                display: none;
            }

            .navbar-custom {
                padding: 0 12px;
            }

            .navbar-user-name {
                display: none;
            }

            .admin-content {
                padding: 10px;
            }
        }

    </style>
</head>


<body>

@auth

    {{-- =====================================================
         MASYARAKAT
    ====================================================== --}}

    @if(auth()->user()->role->name === 'masyarakat')

        <nav class="navbar navbar-expand-lg navbar-custom">

            <div class="container">

                <a
                    class="navbar-brand text-primary fw-bold"
                    href="{{ route('masyarakat.dashboard') }}"
                >
                    <i class="fa-solid fa-leaf"></i>
                    SIPESAT
                </a>

                <div class="ms-auto d-flex align-items-center">

                    <span class="me-3">
                        Halo, {{ auth()->user()->name }}
                    </span>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-danger"
                        >
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Keluar
                        </button>

                    </form>

                </div>

            </div>

        </nav>


        <main class="py-4">

            @yield('content')

        </main>


    @else


        {{-- =================================================
             ADMIN / PETUGAS
        ================================================== --}}

        <div class="admin-wrapper">


            {{-- =============================================
                 SIDEBAR
            ============================================== --}}

            <aside class="sidebar flex-shrink-0">


                {{-- LOGO --}}

                <div class="sidebar-brand">

                    <h4>
                        <i class="fa-solid fa-leaf"></i>
                        SIPESAT
                    </h4>

                    <small>
                        Kab. Magetan
                    </small>

                </div>


                <div class="sidebar-menu">


                    {{-- =====================================
                         ADMIN
                    ====================================== --}}

                    @if(auth()->user()->role->name === 'admin')


                        {{-- DASHBOARD --}}

                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard</span>
                        </a>


                        {{-- MANAJEMEN LAPORAN --}}

                        <a
                            href="{{ url('/admin/laporan') }}"
                            class="{{ request()->is('admin/laporan*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-clipboard-check"></i>
                            <span>Manajemen Laporan</span>
                        </a>


                        {{-- VALIDASI --}}

                        <a
                            href="{{ url('/admin/validasi-pekerjaan') }}"
                            class="{{ request()->is('admin/validasi-pekerjaan*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-check-double"></i>
                            <span>Validasi Pekerjaan</span>
                        </a>


                        {{-- STATISTIK --}}

                        <a
                            href="{{ url('/admin/statistik') }}"
                            class="{{ request()->is('admin/statistik*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Statistik</span>
                        </a>


                        {{-- DATA MASTER --}}

                        <div class="sidebar-section-title">
                            DATA MASTER
                        </div>


                        {{-- KATEGORI SAMPAH --}}

                        <a
                            href="{{ route('admin.kategori-sampah.index') }}"
                            class="{{ request()->routeIs('admin.kategori-sampah.*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-tags"></i>
                            <span>Kategori Sampah</span>
                        </a>


                        {{-- WILAYAH --}}

                        <a
                            href="{{ url('/admin/wilayah') }}"
                            class="{{ request()->is('admin/wilayah*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>Wilayah</span>
                        </a>


                        {{-- PETUGAS --}}

                        <a
                            href="{{ url('/admin/petugas') }}"
                            class="{{ request()->is('admin/petugas*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-users"></i>
                            <span>Petugas</span>
                        </a>


                        {{-- LAINNYA --}}

                        <div class="sidebar-section-title">
                            LAINNYA
                        </div>


                        {{-- BERITA --}}

                        <a
                            href="{{ url('/admin/berita') }}"
                            class="{{ request()->is('admin/berita*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-newspaper"></i>
                            <span>Berita & Edukasi</span>
                        </a>


                        {{-- LOG AKTIVITAS --}}

                        <a
                            href="{{ url('/admin/activity-log') }}"
                            class="{{ request()->is('admin/activity-log*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Log Aktivitas</span>
                        </a>


                    @else


                        {{-- =================================
                             PETUGAS
                        ================================== --}}

                        <a
                            href="{{ route('petugas.dashboard') }}"
                            class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard</span>
                        </a>


                        <a
                            href="{{ url('/petugas/tugas') }}"
                            class="{{ request()->is('petugas/tugas*') ? 'active' : '' }}"
                        >
                            <i class="fa-solid fa-clipboard-list"></i>
                            <span>Tugas Saya</span>
                        </a>


                    @endif


                </div>

            </aside>


            {{-- =============================================
                 AREA UTAMA
            ============================================== --}}

            <div class="admin-main">


                {{-- =========================================
                     HEADER
                ========================================== --}}

                <nav class="navbar-custom">


                    <h5 class="navbar-title">

                        @hasSection('title')
                            @yield('title')
                        @else
                            Dashboard
                        @endif

                    </h5>


                    <div class="navbar-user">

                        <span class="navbar-user-name">

                            {{ auth()->user()->name }}

                        </span>


                        <span class="badge bg-secondary">

                            {{ auth()->user()->role->label }}

                        </span>


                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            class="m-0"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="logout-button"
                            >
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Keluar
                            </button>

                        </form>

                    </div>


                </nav>


                {{-- =========================================
                     ISI HALAMAN
                ========================================== --}}

                <main class="admin-content">

                    @yield('content')

                </main>


            </div>

        </div>


    @endif


@else

    {{-- =====================================================
         USER BELUM LOGIN
    ====================================================== --}}

    @yield('content')

@endauth


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>