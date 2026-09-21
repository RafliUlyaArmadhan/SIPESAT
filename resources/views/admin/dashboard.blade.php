@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<!-- Leaflet CSS -->
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      crossorigin=""/>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Dashboard Admin</h4>

        <p class="text-muted mb-0">
            Ringkasan aktivitas SIPESAT
        </p>
    </div>


    <!-- ================= 6 STATUS LAPORAN ================= -->
    <div class="row g-3 mb-4">

        <!-- Menunggu Verifikasi -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <a href="{{ route('admin.laporan.index', ['status' => 'menunggu_verifikasi']) }}"
               class="text-decoration-none text-dark">

                <div class="card p-3 border-0 shadow-sm h-100"
                     style="cursor:pointer;">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>
                            <span class="text-muted small d-block">
                                Menunggu Verifikasi
                            </span>

                            <h3 class="font-mono m-0 fw-bold">
                                {{ $menungguVerifikasi }}
                            </h3>
                        </div>

                        <div class="rounded-circle bg-warning-subtle text-warning
                                    d-flex align-items-center justify-content-center shadow-sm"
                             style="width:45px;height:45px;">
                            <i class="fa-solid fa-clock fs-5"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>


        <!-- Diverifikasi -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <a href="{{ route('admin.laporan.index', ['status' => 'diverifikasi']) }}"
               class="text-decoration-none text-dark">

                <div class="card p-3 border-0 shadow-sm h-100"
                     style="cursor:pointer;">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>
                            <span class="text-muted small d-block">
                                Diverifikasi
                            </span>

                            <h3 class="font-mono m-0 fw-bold text-primary">
                                {{ $diverifikasi }}
                            </h3>
                        </div>

                        <div class="rounded-circle bg-primary-subtle text-primary
                                    d-flex align-items-center justify-content-center shadow-sm"
                             style="width:45px;height:45px;">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>


        <!-- Sedang Ditangani -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <a href="{{ route('admin.laporan.index', ['status' => 'sedang_ditangani']) }}"
               class="text-decoration-none text-dark">

                <div class="card p-3 border-0 shadow-sm h-100"
                     style="cursor:pointer;">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>
                            <span class="text-muted small d-block">
                                Sedang Ditangani
                            </span>

                            <h3 class="font-mono m-0 fw-bold text-primary">
                                {{ $sedangDitangani }}
                            </h3>
                        </div>

                        <div class="rounded-circle bg-primary-subtle text-primary
                                    d-flex align-items-center justify-content-center shadow-sm"
                             style="width:45px;height:45px;">
                            <i class="fa-solid fa-broom fs-5"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>


        <!-- Menunggu Validasi Akhir -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <a href="{{ route('admin.laporan.index', ['status' => 'menunggu_validasi_akhir']) }}"
               class="text-decoration-none text-dark">

                <div class="card p-3 border-0 shadow-sm h-100"
                     style="cursor:pointer;">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>
                            <span class="text-muted small d-block">
                                Menunggu Validasi Akhir
                            </span>

                            <h3 class="font-mono m-0 fw-bold text-warning">
                                {{ $menungguValidasi }}
                            </h3>
                        </div>

                        <div class="rounded-circle bg-warning-subtle text-warning
                                    d-flex align-items-center justify-content-center shadow-sm"
                             style="width:45px;height:45px;">
                            <i class="fa-solid fa-hourglass-half fs-5"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>


        <!-- Selesai -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}"
               class="text-decoration-none text-dark">

                <div class="card p-3 border-0 shadow-sm h-100"
                     style="cursor:pointer;">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>
                            <span class="text-muted small d-block">
                                Selesai
                            </span>

                            <h3 class="font-mono m-0 fw-bold text-success">
                                {{ $selesai }}
                            </h3>
                        </div>

                        <div class="rounded-circle bg-success-subtle text-success
                                    d-flex align-items-center justify-content-center shadow-sm"
                             style="width:45px;height:45px;">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>


        <!-- Ditolak -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <a href="{{ route('admin.laporan.index', ['status' => 'ditolak']) }}"
               class="text-decoration-none text-dark">

                <div class="card p-3 border-0 shadow-sm h-100"
                     style="cursor:pointer;">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>
                            <span class="text-muted small d-block">
                                Ditolak
                            </span>

                            <h3 class="font-mono m-0 fw-bold text-danger">
                                {{ $ditolak }}
                            </h3>
                        </div>

                        <div class="rounded-circle bg-danger-subtle text-danger
                                    d-flex align-items-center justify-content-center shadow-sm"
                             style="width:45px;height:45px;">
                            <i class="fa-solid fa-circle-xmark fs-5"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>

    </div>


    <!-- ================= GRAFIK & STATISTIK TAMBAHAN ================= -->
    <div class="row g-4 mb-4">

        <!-- Grafik Kategori Sampah -->
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 pb-0">

                    <h6 class="fw-bold m-0">
                        <i class="fa-solid fa-chart-column me-2 text-primary"></i>
                        Statistik Kategori Sampah
                    </h6>

                </div>

                <div class="card-body">

                    <div style="height:250px;">
                        <canvas id="kategoriChart"></canvas>
                    </div>

                </div>

            </div>

        </div>


        <!-- Statistik Tambahan -->
        <div class="col-lg-7">

            <div class="row g-3 h-100">

                <!-- Total Laporan -->
                <div class="col-sm-6">

                    <a href="{{ route('admin.laporan.index') }}"
                       class="text-decoration-none">

                        <div class="card border-0 shadow-sm
                                    text-center p-3 text-white"
                             style="
                                height: 170px;
                                background: linear-gradient(
                                    135deg,
                                    #1f6e43 0%,
                                    #14532d 100%
                                );
                             ">

                            <i class="fa-solid fa-file-lines fs-1 mb-3 opacity-75"></i>

                            <h2 class="font-mono fw-bold mb-1">
                                {{ $totalLaporan }}
                            </h2>

                            <p class="mb-0">
                                Total Laporan Masuk
                            </p>

                        </div>

                    </a>

                </div>


                <!-- Petugas Aktif -->
                <div class="col-sm-6">

                    <a href="{{ route('admin.petugas.index') }}"
                       class="text-decoration-none">

                        <div class="card border-0 shadow-sm
                                    text-center p-3 text-white"
                             style="
                                height: 170px;
                                background: linear-gradient(
                                    135deg,
                                    #237da3 0%,
                                    #1e5a77 100%
                                );
                             ">

                            <i class="fa-solid fa-users-gear fs-1 mb-3 opacity-75"></i>

                            <h2 class="font-mono fw-bold mb-1">
                                {{ $totalPetugas }}
                            </h2>

                            <p class="mb-0">
                                Petugas Aktif
                            </p>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- ================= PETA ================= -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4 pb-2
                    d-flex justify-content-between align-items-center">

            <h6 class="fw-bold m-0">
                <i class="fa-solid fa-map-location-dot
                          me-2 text-primary"></i>
                Peta Sebaran Laporan (Live Map)
            </h6>

            <div class="small d-flex flex-wrap gap-1 justify-content-end">

                <span class="badge bg-warning text-dark">
                    Menunggu Verifikasi
                </span>

                <span class="badge bg-primary">
                    Diverifikasi
                </span>

                <span class="badge bg-primary">
                    Sedang Ditangani
                </span>

                <span class="badge bg-warning text-dark">
                    Menunggu Validasi Akhir
                </span>

                <span class="badge bg-success">
                    Selesai
                </span>

                <span class="badge bg-danger">
                    Ditolak
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div id="adminMap"
                 style="
                    height:500px;
                    width:100%;
                    border-bottom-left-radius:10px;
                    border-bottom-right-radius:10px;
                 ">
            </div>

        </div>

    </div>

</div>


<!-- ================= CHART.JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- ================= LEAFLET ================= -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        crossorigin="">
</script>


<script>

document.addEventListener("DOMContentLoaded", function () {

    /* ================= GRAFIK ================= */

    const ctx = document
        .getElementById('kategoriChart')
        .getContext('2d');

    const chartLabels = {!! json_encode($chartLabels) !!};

    const chartValues = {!! json_encode($chartValues) !!};


    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: chartLabels.length > 0
                ? chartLabels
                : ['Belum ada data'],

            datasets: [{

                label: 'Jumlah Laporan',

                data: chartValues.length > 0
                    ? chartValues
                    : [0],

                backgroundColor:
                    'rgba(31, 110, 67, 0.7)',

                borderColor:
                    'rgba(31, 110, 67, 1)',

                borderWidth: 1,

                borderRadius: 4

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
                        stepSize: 1
                    }

                }

            }

        }

    });


    /* ================= LEAFLET MAP ================= */

    const laporans =
        {!! json_encode($laporansMap) !!};


    // Posisi awal Magetan
    const map = L.map('adminMap')
        .setView([-7.6531, 111.3284], 12);


    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {

            maxZoom: 19,

            attribution:
                '&copy; OpenStreetMap contributors'

        }
    ).addTo(map);


    const markersGroup =
        L.featureGroup().addTo(map);


    let hasMarkers = false;


    /* Warna marker berdasarkan 6 status */

    const colorMap = {

        'menunggu_verifikasi':
            '#ffc107',

        'diverifikasi':
            '#0d6efd',

        'sedang_ditangani':
            '#0d6efd',

        'menunggu_validasi_akhir':
            '#fd7e14',

        'selesai':
            '#198754',

        'ditolak':
            '#dc3545'

    };


    const statusLabelMap = {

        'menunggu_verifikasi':
            'Menunggu Verifikasi',

        'diverifikasi':
            'Diverifikasi',

        'sedang_ditangani':
            'Sedang Ditangani',

        'menunggu_validasi_akhir':
            'Menunggu Validasi Akhir',

        'selesai':
            'Selesai',

        'ditolak':
            'Ditolak'

    };


    laporans.forEach(laporan => {

        if (
            laporan.latitude &&
            laporan.longitude
        ) {

            hasMarkers = true;


            const markerColor =
                colorMap[laporan.status] ||
                '#1F2A24';


            const customIcon =
                L.divIcon({

                    className:
                        'custom-div-icon',

                    html:
                        `<div style="
                            background-color:${markerColor};
                            width:20px;
                            height:20px;
                            border-radius:50%;
                            border:2px solid white;
                            box-shadow:0 0 5px rgba(0,0,0,0.5);
                        "></div>`,

                    iconSize: [20, 20],

                    iconAnchor: [10, 10]

                });


            const detailUrl =
                `/admin/laporan/${laporan.id}`;


            const namaKategori =
                laporan.kategori_sampah
                    ? laporan.kategori_sampah.nama_kategori
                    : '-';


            const pelapor =
                laporan.user
                    ? laporan.user.name
                    : 'Anonim';


            const formattedStatus =
                statusLabelMap[laporan.status]
                || laporan.status
                    .replace(/_/g, ' ')
                    .replace(/\b\w/g,
                        l => l.toUpperCase());


            const popupHtml = `

                <div style="min-width:200px;">

                    <div class="mb-1 d-flex justify-content-between align-items-start">

                        <h6 class="fw-bold m-0 pe-2">
                            ${laporan.judul_laporan}
                        </h6>

                        <span class="badge"
                              style="
                                background-color:${markerColor};
                                font-size:0.65rem;
                              ">

                            ${formattedStatus}

                        </span>

                    </div>


                    <small class="text-muted d-block mb-2">
                        ${laporan.kode_laporan}
                    </small>


                    <p class="mb-1 small">
                        <b>Pelapor:</b>
                        ${pelapor}
                    </p>


                    <p class="mb-2 small">
                        <b>Kategori:</b>
                        ${namaKategori}
                    </p>


                    <a href="${detailUrl}"
                       class="btn btn-sm btn-outline-primary
                              w-100 rounded-pill mt-1">

                        Lihat Detail

                    </a>

                </div>

            `;


            L.marker(
                [
                    laporan.latitude,
                    laporan.longitude
                ],
                {
                    icon: customIcon
                }
            )

            .bindPopup(popupHtml)

            .addTo(markersGroup);

        }

    });


    if (hasMarkers) {

        map.fitBounds(
            markersGroup.getBounds(),
            {
                padding: [30, 30]
            }
        );

    }

});

</script>

@endsection
