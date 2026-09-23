@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

<style>
    /* =========================================================
       DASHBOARD PETUGAS
    ========================================================= */

    .petugas-dashboard {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4px 0 20px;
    }

    .dashboard-header {
        margin-bottom: 20px;
    }

    .dashboard-header h4 {
        margin: 0 0 4px;
        font-size: 20px;
        font-weight: 700;
        color: #1f2a24;
    }

    .dashboard-header p {
        margin: 0;
        font-size: 12px;
        color: #777;
    }


    /* =========================================================
       STATISTIK
    ========================================================= */

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 10px;
        padding: 15px 16px;
        box-shadow: 0 2px 7px rgba(0, 0, 0, .05);

        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-label {
        font-size: 11px;
        color: #777;
        margin-bottom: 4px;
    }

    .stat-number {
        font-size: 24px;
        line-height: 1;
        font-weight: 700;
        color: #1f2a24;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 17px;
    }

    .stat-new .stat-icon {
        background: #fff3cd;
        color: #b88600;
    }

    .stat-process .stat-icon {
        background: #e7f0ff;
        color: #0d6efd;
    }

    .stat-done .stat-icon {
        background: #e8f5ee;
        color: #198754;
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .dashboard-section {
        background: #fff;
        border: 1px solid #e6e6e6;
        border-radius: 10px;
        box-shadow: 0 2px 7px rgba(0, 0, 0, .05);
        margin-bottom: 18px;
        overflow: hidden;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 14px 16px;
        border-bottom: 1px solid #ededed;
    }

    .section-title {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        color: #1f2a24;

        display: flex;
        align-items: center;
        gap: 7px;
    }

    .section-title i {
        color: #1f6e43;
        font-size: 13px;
    }

    .section-action {
        font-size: 11px;
        color: #1f6e43;
        font-weight: 600;
    }

    .section-action:hover {
        color: #14532d;
    }


    /* =========================================================
       TUGAS
    ========================================================= */

    .task-item {
        display: block;
        text-decoration: none;
        color: inherit;

        border-bottom: 1px solid #f0f0f0;

        transition:
            background-color .18s ease,
            transform .18s ease;
    }

    .task-item:last-child {
        border-bottom: none;
    }

    .task-item:hover {
        background: #f8faf9;
        color: inherit;
    }

    .task-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;

        padding: 14px 16px;
    }

    .task-main {
        min-width: 0;
        flex: 1;
    }

    .task-title {
        font-size: 13px;
        font-weight: 700;
        color: #222;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .task-description {
        font-size: 11px;
        color: #777;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .task-status {
        display: inline-flex;
        align-items: center;

        padding: 4px 8px;
        border-radius: 20px;

        font-size: 10px;
        font-weight: 600;
    }

    .status-new {
        background: #fff3cd;
        color: #856404;
    }

    .status-process {
        background: #e7f0ff;
        color: #0d5ec9;
    }

    .status-done {
        background: #e8f5ee;
        color: #198754;
    }

    .status-rejected {
        background: #fdeaea;
        color: #dc3545;
    }

    .task-time {
        font-size: 10px;
        color: #999;
        white-space: nowrap;
        padding-top: 2px;
    }


    /* =========================================================
       RATING
    ========================================================= */

    .rating-item {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .rating-item:last-child {
        border-bottom: none;
    }

    .rating-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 6px;
    }

    .rating-title {
        font-size: 12px;
        font-weight: 700;
        color: #333;
        line-height: 1.4;
    }

    .rating-time {
        font-size: 10px;
        color: #999;
        white-space: nowrap;
    }

    .rating-stars {
        display: flex;
        gap: 2px;
        margin-bottom: 5px;
    }

    .rating-stars span {
        color: #ffc107;
        font-size: 14px;
        line-height: 1;
    }

    .rating-stars span.empty {
        color: #ddd;
    }

    .rating-comment {
        font-size: 11px;
        color: #666;
        line-height: 1.5;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        padding: 25px 16px;
        text-align: center;
        color: #999;
        font-size: 11px;
    }

    .empty-state i {
        display: block;
        font-size: 24px;
        margin-bottom: 8px;
        color: #ccc;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .stat-grid {
            grid-template-columns: 1fr;
        }

        .task-row {
            flex-direction: column;
            gap: 7px;
        }

        .task-time {
            padding-top: 0;
        }

        .rating-top {
            flex-direction: column;
            gap: 3px;
        }
    }
</style>


<div class="petugas-dashboard">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="dashboard-header">

        <h4>
            Dashboard Petugas
        </h4>

        <p>
            Ringkasan tugas dan aktivitas penanganan laporan.
        </p>

    </div>


    <!-- =====================================================
         STATISTIK
    ====================================================== -->

    <div class="stat-grid">

        <!-- Tugas Baru -->
        <div class="stat-card stat-new">

            <div>

                <div class="stat-label">
                    Tugas Baru
                </div>

                <div class="stat-number">
                    {{ $tugasBaru }}
                </div>

            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>

        </div>


        <!-- Sedang Dikerjakan -->
        <div class="stat-card stat-process">

            <div>

                <div class="stat-label">
                    Sedang Dikerjakan
                </div>

                <div class="stat-number">
                    {{ $sedangDikerjakan }}
                </div>

            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-broom"></i>
            </div>

        </div>


        <!-- Selesai -->
        <div class="stat-card stat-done">

            <div>

                <div class="stat-label">
                    Selesai
                </div>

                <div class="stat-number">
                    {{ $selesai }}
                </div>

            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

        </div>

    </div>


    <!-- =====================================================
         TUGAS TERBARU
    ====================================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h6 class="section-title">

                <i class="fa-solid fa-list-check"></i>

                Tugas Terbaru

            </h6>


            <a
                href="{{ route('petugas.tugas.index') }}"
                class="section-action text-decoration-none"
            >
                Lihat Semua
            </a>

        </div>


        @if(!empty($tugasTerbaru))

            @foreach($tugasTerbaru as $tugas)

                @php

                    $statusClass = match ($tugas['status']) {

                        'Tugas Baru'
                            => 'status-new',

                        'Sedang Dikerjakan'
                            => 'status-process',

                        'Selesai'
                            => 'status-done',

                        'Ditolak'
                            => 'status-rejected',

                        default
                            => 'status-new',

                    };

                @endphp


                <!-- =================================================
                     LAPORAN BISA DIKLIK
                ================================================== -->

                <a
                    href="{{ route(
                        'petugas.tugas.show',
                        $tugas['id']
                    ) }}"
                    class="task-item"
                >

                    <div class="task-row">

                        <div class="task-main">

                            <div class="task-title">
                                {{ $tugas['judul'] }}
                            </div>

                            <div class="task-description">
                                {{ $tugas['deskripsi'] ?? '-' }}
                            </div>

                            <span
                                class="task-status {{ $statusClass }}"
                            >
                                {{ $tugas['status'] }}
                            </span>

                        </div>


                        <div class="task-time">
                            {{ $tugas['waktu'] }}
                        </div>

                    </div>

                </a>

            @endforeach

        @else

            <div class="empty-state">

                <i class="fa-regular fa-folder-open"></i>

                Belum ada tugas.

            </div>

        @endif

    </div>


    <!-- =====================================================
         RATING DARI MASYARAKAT
    ====================================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h6 class="section-title">

                <i class="fa-solid fa-star"></i>

                Rating dari Masyarakat

            </h6>

        </div>


        @if(!empty($ratingTerbaru))

            @foreach($ratingTerbaru as $rating)

                <div class="rating-item">

                    <div class="rating-top">

                        <div class="rating-title">
                            {{ $rating['judul'] }}
                        </div>

                        <div class="rating-time">
                            {{ $rating['waktu'] }}
                        </div>

                    </div>


                    <div class="rating-stars">

                        @for($i = 1; $i <= 5; $i++)

                            @if($i <= $rating['rating'])

                                <span>★</span>

                            @else

                                <span class="empty">★</span>

                            @endif

                        @endfor

                    </div>


                    @if(!empty($rating['komentar']))

                        <div class="rating-comment">
                            "{{ $rating['komentar'] }}"
                        </div>

                    @endif

                </div>

            @endforeach

        @else

            <div class="empty-state">

                <i class="fa-regular fa-star"></i>

                Belum ada rating dari masyarakat.

            </div>

        @endif

    </div>

</div>

@endsection