@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    /* ================================
       DASHBOARD SIPESAT
    ================================= */

    .dashboard-wrapper {
        width: 100%;
    }

    /* ================================
       STATISTIC CARDS
    ================================= */

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e5e1;
        border-radius: 10px;
        min-height: 115px;
        padding: 22px 20px;
        box-shadow: 0 2px 8px rgba(31, 42, 36, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-card .stat-title {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .stat-card .stat-number {
        font-size: 28px;
        line-height: 1;
        font-weight: 700;
        color: #1f2a24;
    }

    /* Warna angka */

    .stat-number.warning {
        color: #e8a33d;
    }

    .stat-number.info {
        color: #2e7da3;
    }

    .stat-number.green {
        color: #1f6e43;
    }

    /* Icon */

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.warning {
        background: #fff3cd;
        color: #e8a33d;
    }

    .stat-icon.info {
        background: #e8f3fa;
        color: #2e7da3;
    }

    .stat-icon.green {
        background: #e8f3ec;
        color: #1f6e43;
    }

    .stat-icon.red {
        background: #fdecec;
        color: #c1443c;
    }

    .stat-number.red {
        color: #c1443c;
    }


    /* ================================
       CONTENT CARD
    ================================= */

    .dashboard-card {
        background: #ffffff;
        border: 1px solid #e2e5e1;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(31, 42, 36, 0.06);
        overflow: hidden;
    }

    .dashboard-card-header {
        padding: 15px 18px;
        border-bottom: 1px solid #e5e7eb;
        background: #ffffff;
        display: flex;
        align-items: center;
    }

    .dashboard-card-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1f2a24;
    }

    .dashboard-card-header i {
        margin-right: 8px;
        color: #1f6e43;
    }


    /* ================================
       CHART
    ================================= */

    .chart-container {
        position: relative;
        width: 100%;
        height: 315px;
        padding: 18px;
    }


    /* ================================
       SUMMARY BOX
    ================================= */

    .summary-box {
        min-height: 315px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }

    .summary-box.green {
        background: #1f6e43;
    }

    .summary-box.blue {
        background: #2e7da3;
    }

    .summary-icon {
        font-size: 43px;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .summary-number {
        font-size: 30px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 8px;
    }

    .summary-title {
        font-size: 14px;
        font-weight: 500;
    }


    /* ================================
       MAP
    ================================= */

    .map-card {
        margin-top: 18px;
    }

    .map-header {
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .map-title {
        display: flex;
        align-items: center;
    }

    .map-title i {
        color: #c1443c;
        margin-right: 8px;
    }

    .map-title h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .map-legend {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 12px;
        color: #374151;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .legend-red {
        background: #c1443c;
    }

    .legend-yellow {
        background: #e8a33d;
    }

    .legend-green {
        background: #1f6e43;
    }

    #dashboard-map {
        width: 100%;
        height: 440px;
        z-index: 1;
    }


    /* ================================
       RESPONSIVE
    ================================= */

    @media (max-width: 991px) {

        .stat-card {
            min-height: 100px;
        }

        .summary-box {
            min-height: 220px;
        }

        #dashboard-map {
            height: 380px;
        }
    }

    @media (max-width: 576px) {

        .stat-card {
            padding: 18px;
        }

        .stat-card .stat-number {
            font-size: 24px;
        }

        .chart-container {
            height: 280px;
        }

        #dashboard-map {
            height: 320px;
        }

        .map-legend {
            width: 100%;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 10px;
        }
    }
</style>


<div class="dashboard-wrapper">

    {{-- =====================================================
         1. EMPAT KARTU STATUS LAPORAN
    ====================================================== --}}

    <div class="row g-3 mb-3">

        {{-- BELUM DIATASI --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div>
                    <div class="stat-title">
                        Belum Diatasi
                    </div>

                    <div class="stat-number warning">
                        8
                    </div>
                </div>

                <div class="stat-icon warning">
                    <i class="fa-solid fa-clock"></i>
                </div>

            </div>

        </div>


        {{-- SEDANG DIPROSES --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div>
                    <div class="stat-title">
                        Sedang Diproses
                    </div>

                    <div class="stat-number info">
                        15
                    </div>
                </div>

                <div class="stat-icon info">
                    <i class="fa-solid fa-spinner"></i>
                </div>

            </div>

        </div>


        {{-- SUDAH DIATASI --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div>
                    <div class="stat-title">
                        Sudah Diatasi
                    </div>

                    <div class="stat-number green">
                        5
                    </div>
                </div>

                <div class="stat-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

            </div>

        </div>


        {{-- DITOLAK --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div>
                    <div class="stat-title">
                        Ditolak
                    </div>

                    <div class="stat-number red">
                        2
                    </div>
                </div>

                <div class="stat-icon red">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         2. GRAFIK + TOTAL LAPORAN + PETUGAS
    ====================================================== --}}

    <div class="row g-3">

        {{-- GRAFIK --}}
        <div class="col-xl-6">

            <div class="dashboard-card h-100">

                <div class="dashboard-card-header">

                    <h5>
                        <i class="fa-solid fa-chart-column"></i>
                        Statistik Kategori Sampah
                    </h5>

                </div>

                <div class="chart-container">

                    <canvas id="kategoriSampahChart"></canvas>

                </div>

            </div>

        </div>


        {{-- KARTU KANAN --}}
        <div class="col-xl-6">

            <div class="row g-3 h-100">

                {{-- TOTAL LAPORAN --}}
                <div class="col-md-6">

                    <div class="summary-box green">

                        <div class="summary-icon">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>

                        <div class="summary-number">
                            35
                        </div>

                        <div class="summary-title">
                            Total Laporan Masuk
                        </div>

                    </div>

                </div>


                {{-- PETUGAS AKTIF --}}
                <div class="col-md-6">

                    <div class="summary-box blue">

                        <div class="summary-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div class="summary-number">
                            3
                        </div>

                        <div class="summary-title">
                            Petugas Aktif
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         3. PETA SEBARAN LAPORAN
    ====================================================== --}}

    <div class="dashboard-card map-card">

        <div class="map-header">

            <div class="map-title">

                <i class="fa-solid fa-location-dot"></i>

                <h5>
                    Peta Sebaran Laporan
                </h5>

            </div>


            {{-- LEGEND --}}
            <div class="map-legend">

                <div class="legend-item">
                    <span class="legend-dot legend-red"></span>
                    <span>Belum Diatasi</span>
                </div>

                <div class="legend-item">
                    <span class="legend-dot legend-yellow"></span>
                    <span>Sedang Diproses</span>
                </div>

                <div class="legend-item">
                    <span class="legend-dot legend-green"></span>
                    <span>Sudah Diatasi</span>
                </div>

            </div>

        </div>


        {{-- MAP --}}
        <div id="dashboard-map"></div>

    </div>

</div>


{{-- =========================================================
     CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


{{-- =========================================================
     LEAFLET
========================================================= --}}

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       GRAFIK KATEGORI SAMPAH
    ====================================================== */

    const chartCanvas =
        document.getElementById('kategoriSampahChart');


    if (chartCanvas) {

        new Chart(chartCanvas, {

            type: 'bar',

            data: {

                labels: [
                    'Sampah Rumah Tangga',
                    'Sampah Liar/Pembuangan Ilegal',
                    'Sampah Sungai/Saluran Air'
                ],

                datasets: [

                    {
                        label: 'Jumlah Laporan',

                        data: [
                            13,
                            16,
                            4
                        ],

                        backgroundColor:
                            'rgba(91, 155, 118, 0.85)',

                        borderColor:
                            'rgba(91, 155, 118, 1)',

                        borderWidth: 1,

                        borderRadius: 4,

                        barPercentage: 0.55,

                        categoryPercentage: 0.7
                    }

                ]

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

                        max: 18,

                        ticks: {

                            stepSize: 2,

                            color: '#6b7280',

                            font: {
                                size: 11
                            }

                        },

                        grid: {
                            color: '#e5e7eb'
                        }

                    },

                    x: {

                        ticks: {

                            color: '#6b7280',

                            font: {
                                size: 10
                            },

                            maxRotation: 0,

                            minRotation: 0
                        },

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

    }


    /* =====================================================
       LEAFLET MAP
    ====================================================== */

    const mapElement =
        document.getElementById('dashboard-map');


    if (mapElement) {

        /*
         * Titik tengah Kabupaten Magetan
         */

        const map = L.map('dashboard-map')
            .setView(
                [-7.6431, 111.3591],
                11
            );


        /*
         * OpenStreetMap
         */

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 19,

                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);


        /* =================================================
           FUNGSI MEMBUAT MARKER
        ================================================= */

        function createMarker(
            lat,
            lng,
            color,
            title,
            status
        ) {

            const marker = L.circleMarker(
                [lat, lng],
                {
                    radius: 7,

                    fillColor: color,

                    color: '#ffffff',

                    weight: 2,

                    opacity: 1,

                    fillOpacity: 1
                }
            ).addTo(map);


            marker.bindPopup(`

                <div style="
                    min-width:190px;
                    font-family:Arial,sans-serif;
                ">

                    <strong style="
                        font-size:15px;
                    ">
                        ${title}
                    </strong>

                    <br><br>

                    <span style="
                        font-size:13px;
                        color:#555;
                    ">
                        Status:
                    </span>

                    <strong style="
                        font-size:13px;
                    ">
                        ${status}
                    </strong>

                </div>

            `);


            return marker;
        }


        /* =================================================
           DATA MARKER SEMENTARA
           
           Nanti akan diganti dengan data
           laporan dari database.
        ================================================= */


        /* MERAH = BELUM DIATASI */

        createMarker(
            -7.630,
            111.350,
            '#c1443c',
            'Laporan Sampah #001',
            'Belum Diatasi'
        );

        createMarker(
            -7.650,
            111.375,
            '#c1443c',
            'Laporan Sampah #002',
            'Belum Diatasi'
        );

        createMarker(
            -7.670,
            111.340,
            '#c1443c',
            'Laporan Sampah #003',
            'Belum Diatasi'
        );


        /* KUNING = SEDANG DIPROSES */

        createMarker(
            -7.620,
            111.365,
            '#e8a33d',
            'Laporan Sampah #004',
            'Sedang Diproses'
        );

        createMarker(
            -7.645,
            111.345,
            '#e8a33d',
            'Laporan Sampah #005',
            'Sedang Diproses'
        );

        createMarker(
            -7.660,
            111.390,
            '#e8a33d',
            'Laporan Sampah #006',
            'Sedang Diproses'
        );

        createMarker(
            -7.685,
            111.360,
            '#e8a33d',
            'Laporan Sampah #007',
            'Sedang Diproses'
        );


        /* HIJAU = SUDAH DIATASI */

        createMarker(
            -7.610,
            111.345,
            '#1f6e43',
            'Laporan Sampah #008',
            'Sudah Diatasi'
        );

        createMarker(
            -7.635,
            111.380,
            '#1f6e43',
            'Laporan Sampah #009',
            'Sudah Diatasi'
        );

        createMarker(
            -7.655,
            111.360,
            '#1f6e43',
            'Laporan Sampah #010',
            'Sudah Diatasi'
        );

        createMarker(
            -7.675,
            111.375,
            '#1f6e43',
            'Laporan Sampah #011',
            'Sudah Diatasi'
        );


        /*
         * Refresh ukuran map
         */

        setTimeout(function () {

            map.invalidateSize();

        }, 300);

    }

});

</script>

@endsection