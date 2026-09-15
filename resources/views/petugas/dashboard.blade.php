@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    /* ==============================
       DASHBOARD SIPESAT
       ============================== */

    .dashboard-page {
        background: #F6F7F5;
        min-height: calc(100vh - 73px);
    }

    /* Card umum */
    .dashboard-card {
        background: #FFFFFF;
        border: 1px solid #E2E5E1;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(31, 42, 36, 0.06);
    }

    /* ==============================
       CARD STATUS
       ============================== */

    .status-card {
        height: 80px;
        padding: 15px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .status-title {
        font-size: 11px;
        color: #6B7280;
        margin-bottom: 3px;
    }

    .status-number {
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #1F2A24;
    }

    .status-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFFFFF;
        font-size: 15px;
    }

    /* ==============================
       JUDUL CARD
       ============================== */

    .card-header-custom {
        padding: 12px 15px;
        border-bottom: 1px solid #E2E5E1;
        font-size: 14px;
        font-weight: 700;
        color: #1F2A24;
    }

    /* ==============================
       GRAFIK
       ============================== */

    .chart-container {
        height: 200px;
        padding: 10px 15px 15px;
    }

    /* ==============================
       CARD TOTAL & PETUGAS
       ============================== */

    .summary-card {
        height: 145px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .summary-card-green {
        background: #1F6E43;
    }

    .summary-card-blue {
        background: #2E7DA3;
    }

    .summary-icon {
        font-size: 28px;
        margin-bottom: 7px;
        opacity: 0.85;
    }

    .summary-number {
        font-size: 25px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 5px;
    }

    .summary-title {
        font-size: 13px;
    }

    /* ==============================
       PETA
       ============================== */

    .map-card {
        margin-top: 15px;
        overflow: hidden;
    }

    .map-header {
        min-height: 48px;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #E2E5E1;
    }

    .map-title {
        font-size: 14px;
        font-weight: 700;
        color: #1F2A24;
    }

    .map-status {
        display: flex;
        gap: 5px;
    }

    .map-status span {
        color: white;
        font-size: 9px;
        font-weight: 600;
        padding: 4px 7px;
        border-radius: 4px;
    }

    .status-red {
        background: #DC3545;
    }

    .status-yellow {
        background: #F9B51E;
        color: #1F2A24 !important;
    }

    .status-green {
        background: #198754;
    }

    #laporanMap {
        width: 100%;
        height: 420px;
    }

    /* ==============================
       RESPONSIVE
       ============================== */

    @media (max-width: 992px) {

        .map-header {
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
        }

        .map-status {
            flex-wrap: wrap;
        }

    }
</style>


<div class="dashboard-page">

    {{-- ==========================================
         4 CARD STATUS LAPORAN
         ========================================== --}}

    <div class="row g-2 mb-3">

        {{-- Menunggu Verifikasi --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card status-card">

                <div>
                    <div class="status-title">
                        Menunggu Verifikasi
                    </div>

                    <div class="status-number">
                        8
                    </div>
                </div>

                <div class="status-icon"
                     style="background: #F9B51E; color: #1F2A24;">

                    <i class="fa-solid fa-clock"></i>

                </div>

            </div>

        </div>


        {{-- Sedang Ditangani --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card status-card">

                <div>
                    <div class="status-title">
                        Sedang Ditangani
                    </div>

                    <div class="status-number"
                         style="color: #1F6E43;">

                        15

                    </div>
                </div>

                <div class="status-icon"
                     style="background: #1F6E43;">

                    <i class="fa-solid fa-broom"></i>

                </div>

            </div>

        </div>


        {{-- Selesai --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card status-card">

                <div>
                    <div class="status-title">
                        Selesai
                    </div>

                    <div class="status-number"
                         style="color: #1F6E43;">

                        5

                    </div>
                </div>

                <div class="status-icon"
                     style="background: #198754;">

                    <i class="fa-solid fa-circle-check"></i>

                </div>

            </div>

        </div>


        {{-- Ditolak --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card status-card">

                <div>
                    <div class="status-title">
                        Ditolak
                    </div>

                    <div class="status-number"
                         style="color: #DC3545;">

                        2

                    </div>
                </div>

                <div class="status-icon"
                     style="background: #DC3545;">

                    <i class="fa-solid fa-circle-xmark"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================
         GRAFIK + TOTAL + PETUGAS
         ========================================== --}}

    <div class="row g-3">

        {{-- Statistik Kategori --}}
        <div class="col-xl-5">

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <i class="fa-solid fa-chart-column me-2"
                       style="color: #1F6E43;"></i>

                    Statistik Kategori Sampah

                </div>

                <div class="chart-container">

                    <canvas id="kategoriChart"></canvas>

                </div>

            </div>

        </div>


        {{-- Total Laporan --}}
        <div class="col-xl-3 col-md-6">

            <div class="summary-card summary-card-green">

                <i class="fa-solid fa-file-lines summary-icon"></i>

                <div class="summary-number">
                    35
                </div>

                <div class="summary-title">
                    Total Laporan Masuk
                </div>

            </div>

        </div>


        {{-- Petugas Aktif --}}
        <div class="col-xl-4 col-md-6">

            <div class="summary-card summary-card-blue">

                <i class="fa-solid fa-users-gear summary-icon"></i>

                <div class="summary-number">
                    3
                </div>

                <div class="summary-title">
                    Petugas Aktif
                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================
         PETA SEBARAN LAPORAN
         ========================================== --}}

    <div class="dashboard-card map-card">

        <div class="map-header">

            <div class="map-title">

                <i class="fa-solid fa-map-location-dot me-2"
                   style="color: #1F6E43;"></i>

                Peta Sebaran Laporan (Live Map)

            </div>


            <div class="map-status">

                <span class="status-red">
                    Belum Diatasi
                </span>

                <span class="status-yellow">
                    Masih Diproses
                </span>

                <span class="status-green">
                    Sudah Diatasi
                </span>

            </div>

        </div>


        <div id="laporanMap"></div>

    </div>

</div>


{{-- ==========================================
     CHART.JS
     ========================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

    const ctx = document.getElementById('kategoriChart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [
                'Sampah Rumah Tangga',
                'Sampah Liar/Pembuangan Ilegal',
                'Sampah Sungai/Saluran Air'
            ],

            datasets: [{

                data: [13, 18, 4],

                backgroundColor: 'rgba(31, 110, 67, 0.65)',

                borderColor: '#1F6E43',

                borderWidth: 1,

                borderRadius: 3

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        stepSize: 2
                    }

                }

            }

        }

    });

</script>


{{-- ==========================================
     LEAFLET MAP
     ========================================== --}}

<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

    const map = L.map('laporanMap').setView(
        [-7.6569, 111.3330],
        11
    );


    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }
    ).addTo(map);


    /*
     * Data sementara untuk menampilkan
     * posisi marker seperti desain Figma.
     *
     * Nanti data ini akan kita ambil
     * dari database laporan.
     */

    const laporan = [

        [-7.654, 111.335, 'green'],
        [-7.660, 111.340, 'yellow'],
        [-7.648, 111.325, 'red'],
        [-7.670, 111.350, 'green'],
        [-7.640, 111.315, 'yellow'],
        [-7.650, 111.345, 'red'],
        [-7.675, 111.325, 'yellow'],
        [-7.665, 111.315, 'green'],
        [-7.645, 111.350, 'red'],
        [-7.635, 111.340, 'yellow']

    ];


    laporan.forEach(function(item) {

        let warna = '#198754';

        if (item[2] === 'yellow') {
            warna = '#F9B51E';
        }

        if (item[2] === 'red') {
            warna = '#DC3545';
        }


        const icon = L.divIcon({

            className: '',

            html: `
                <div style="
                    width: 13px;
                    height: 13px;
                    background: ${warna};
                    border: 2px solid white;
                    border-radius: 50%;
                    box-shadow: 0 1px 5px rgba(0,0,0,.4);
                "></div>
            `,

            iconSize: [13, 13],

            iconAnchor: [6.5, 6.5]

        });


        L.marker(
            [item[0], item[1]],
            { icon: icon }
        ).addTo(map);

    });

</script>

@endsection