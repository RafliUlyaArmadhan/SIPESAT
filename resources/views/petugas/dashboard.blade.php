@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

@php
    use App\Models\LaporanSampah;

    $laporanData = LaporanSampah::with('user', 'kategoriSampah')
        ->latest()
        ->get();

    $jumlahMenunggu = $laporanData->where('status', 'menunggu_verifikasi')->count();
    $jumlahDiproses = $laporanData->where('status', 'diproses')->count();
    $jumlahSelesai = $laporanData->where('status', 'selesai')->count();
    $jumlahDitolak = $laporanData->where('status', 'ditolak')->count();

    $totalLaporan = $laporanData->count();
@endphp

<style>
    /* ==============================
       DASHBOARD SIPESAT
       ============================== */

    .dashboard-page {
        background: #F6F7F5;
        min-height: calc(100vh - 73px);
        padding-bottom: 30px;
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
       DAFTAR LAPORAN
       ============================== */

    .laporan-section {
        margin-top: 15px;
    }

    .laporan-table-wrapper {
        overflow-x: auto;
    }

    .laporan-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .laporan-table th {
        background: #F6F7F5;
        color: #374151;
        font-weight: 700;
        padding: 11px 12px;
        border-bottom: 1px solid #E2E5E1;
        white-space: nowrap;
    }

    .laporan-table td {
        padding: 11px 12px;
        border-bottom: 1px solid #E2E5E1;
        vertical-align: middle;
        color: #4B5563;
    }

    .laporan-table tr:last-child td {
        border-bottom: none;
    }

    .kode-laporan {
        font-weight: 700;
        color: #1F6E43;
    }

    .judul-laporan {
        font-weight: 600;
        color: #1F2A24;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-menunggu {
        background: #FFF3CD;
        color: #856404;
    }

    .badge-diproses {
        background: #D1E7DD;
        color: #0F5132;
    }

    .badge-selesai {
        background: #D1E7DD;
        color: #146C43;
    }

    .badge-ditolak {
        background: #F8D7DA;
        color: #842029;
    }

    .status-form {
        display: flex;
        gap: 6px;
        align-items: center;
        min-width: 220px;
    }

    .status-select {
        border: 1px solid #D1D5DB;
        border-radius: 5px;
        padding: 6px 8px;
        font-size: 12px;
        background: white;
        color: #374151;
        flex: 1;
    }

    .btn-update-status {
        border: none;
        background: #1F6E43;
        color: white;
        border-radius: 5px;
        padding: 7px 10px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-update-status:hover {
        background: #185936;
    }

    .empty-laporan {
        text-align: center;
        padding: 30px 15px;
        color: #6B7280;
    }

    .alert-success-custom {
        margin-bottom: 15px;
        background: #D1E7DD;
        color: #0F5132;
        border: 1px solid #A3CFBB;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 13px;
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

        .status-form {
            min-width: 200px;
        }
    }
</style>


<div class="dashboard-page">

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif


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
                        {{ $jumlahMenunggu }}
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

                        {{ $jumlahDiproses }}

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

                        {{ $jumlahSelesai }}

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

                        {{ $jumlahDitolak }}

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
                    {{ $totalLaporan }}
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

                Peta Sebaran Laporan

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


    {{-- ==========================================
         DAFTAR LAPORAN SAMPAH
         ========================================== --}}

    <div class="dashboard-card laporan-section">

        <div class="card-header-custom">

            <i class="fa-solid fa-list-check me-2"
               style="color: #1F6E43;"></i>

            Daftar Laporan Sampah

        </div>


        <div class="laporan-table-wrapper">

            @if($laporanData->count() > 0)

                <table class="laporan-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Kode Laporan</th>
                            <th>Pelapor</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($laporanData as $index => $laporan)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="kode-laporan">
                                        {{ $laporan->kode_laporan }}
                                    </div>
                                </td>

                                <td>
                                    {{ $laporan->user->name ?? '-' }}
                                </td>

                                <td>
                                    <div class="judul-laporan">
                                        {{ $laporan->judul_laporan }}
                                    </div>
                                </td>

                                <td>
                                    {{ $laporan->alamat_lengkap }}
                                </td>

                                <td>

                                    @if($laporan->status === 'menunggu_verifikasi')

                                        <span class="status-badge badge-menunggu">
                                            Menunggu Verifikasi
                                        </span>

                                    @elseif($laporan->status === 'diproses')

                                        <span class="status-badge badge-diproses">
                                            Sedang Diproses
                                        </span>

                                    @elseif($laporan->status === 'selesai')

                                        <span class="status-badge badge-selesai">
                                            Selesai
                                        </span>

                                    @elseif($laporan->status === 'ditolak')

                                        <span class="status-badge badge-ditolak">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="status-badge">
                                            {{ $laporan->status }}
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <form
                                        action="{{ route('petugas.laporan.update-status', $laporan->id) }}"
                                        method="POST"
                                        class="status-form"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="status"
                                            class="status-select"
                                        >

                                            <option
                                                value="menunggu_verifikasi"
                                                {{ $laporan->status === 'menunggu_verifikasi' ? 'selected' : '' }}
                                            >
                                                Menunggu Verifikasi
                                            </option>

                                            <option
                                                value="diproses"
                                                {{ $laporan->status === 'diproses' ? 'selected' : '' }}
                                            >
                                                Diproses
                                            </option>

                                            <option
                                                value="selesai"
                                                {{ $laporan->status === 'selesai' ? 'selected' : '' }}
                                            >
                                                Selesai
                                            </option>

                                            <option
                                                value="ditolak"
                                                {{ $laporan->status === 'ditolak' ? 'selected' : '' }}
                                            >
                                                Ditolak
                                            </option>

                                        </select>

                                        <button
                                            type="submit"
                                            class="btn-update-status"
                                        >
                                            Update
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty-laporan">

                    <i class="fa-solid fa-inbox"
                       style="font-size: 30px; margin-bottom: 10px;"></i>

                    <div>
                        Belum ada laporan sampah.
                    </div>

                </div>

            @endif

        </div>

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
     * Data laporan dari database.
     */

    const laporan = @json(
        $laporanData
            ->filter(function ($item) {
                return $item->latitude !== null && $item->longitude !== null;
            })
            ->map(function ($item) {
                return [
                    'latitude' => (float) $item->latitude,
                    'longitude' => (float) $item->longitude,
                    'status' => $item->status,
                    'kode' => $item->kode_laporan,
                    'judul' => $item->judul_laporan,
                    'alamat' => $item->alamat_lengkap,
                ];
            })
            ->values()
    );


    laporan.forEach(function(item) {

        let warna = '#DC3545';

        if (item.status === 'diproses') {
            warna = '#F9B51E';
        }

        if (item.status === 'selesai') {
            warna = '#198754';
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
            [item.latitude, item.longitude],
            { icon: icon }
        )
        .addTo(map)
        .bindPopup(`
            <strong>${item.kode}</strong><br>
            ${item.judul}<br>
            ${item.alamat}<br>
            <strong>Status:</strong> ${item.status}
        `);

    });

</script>

@endsection