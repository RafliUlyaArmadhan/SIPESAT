@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

<style>
    .petugas-dashboard {
        font-size: 13px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        padding: 13px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
        text-decoration: none;
        display: block;
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,.12);
    }

    .stat-number {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .stat-label {
        color: #777;
        font-size: 10px;
    }

    .task-card {
        background: white;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
        overflow: hidden;
    }

    .task-header {
        padding: 12px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .task-header h6 {
        font-size: 12px;
        font-weight: 700;
        margin: 0;
    }

    .btn-semua {
        font-size: 9px;
        padding: 3px 7px;
        border: 1px solid #aaa;
        color: #555;
        border-radius: 3px;
        text-decoration: none;
    }

    .btn-semua:hover {
        background: #f5f5f5;
    }

    .task-item {
        display: block;
        padding: 9px 12px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: #222;
        transition: .15s;
    }

    .task-item:last-child {
        border-bottom: none;
    }

    .task-item:hover {
        background: #f7faf8;
    }

    .task-title {
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .task-description {
        font-size: 8px;
        color: #777;
        margin-bottom: 4px;
    }

    .task-time {
        font-size: 8px;
        color: #888;
        white-space: nowrap;
        margin-left: 15px;
    }

    .badge-tugas {
        display: inline-block;
        font-size: 7px;
        padding: 3px 5px;
        border-radius: 3px;
        color: white;
    }

    .badge-baru {
        background: #0d9fe8;
    }

    .badge-proses {
        background: #198754;
    }

    .empty-task {
        padding: 20px;
        text-align: center;
        color: #888;
        font-size: 10px;
    }
</style>

<div class="petugas-dashboard">

    {{-- STATISTIK --}}
    <div class="row g-2 mb-3">

        {{-- TUGAS BARU --}}
        <div class="col-md-4">
            <a href="{{ route('petugas.tugas.index') }}"
               class="stat-card">

                <div class="stat-number text-info">
                    {{ $tugasBaru }}
                </div>

                <div class="stat-label">
                    Tugas Baru
                </div>

            </a>
        </div>


        {{-- SEDANG DIKERJAKAN --}}
        <div class="col-md-4">
            <a href="{{ route('petugas.tugas.index') }}"
               class="stat-card">

                <div class="stat-number text-success">
                    {{ $sedangDikerjakan }}
                </div>

                <div class="stat-label">
                    Sedang Dikerjakan
                </div>

            </a>
        </div>


        {{-- SELESAI --}}
        <div class="col-md-4">
            <a href="{{ route('petugas.tugas.index') }}"
               class="stat-card">

                <div class="stat-number text-success">
                    {{ $selesai }}
                </div>

                <div class="stat-label">
                    Selesai
                </div>

            </a>
        </div>

    </div>


    {{-- TUGAS TERBARU --}}
    <div class="task-card">

        <div class="task-header">

            <h6>
                Tugas Terbaru
            </h6>

            <a href="{{ route('petugas.tugas.index') }}"
               class="btn-semua">
                Lihat Semua
            </a>

        </div>


        @if(count($tugasTerbaru) > 0)

            @foreach($tugasTerbaru as $tugas)

                <a href="{{ route('petugas.tugas.show', $tugas['id']) }}"
                   class="task-item">

                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="task-title">
                                {{ $tugas['judul'] }}
                            </div>

                            <div class="task-description">
                                {{ $tugas['deskripsi'] }}
                            </div>

                            @if($tugas['status'] === 'Tugas Baru')

                                <span class="badge-tugas badge-baru">
                                    Tugas Baru
                                </span>

                            @elseif($tugas['status'] === 'Sedang Dikerjakan')

                                <span class="badge-tugas badge-proses">
                                    Sedang Dikerjakan
                                </span>

                            @endif

                        </div>

                        <span class="task-time">
                            {{ $tugas['waktu'] }}
                        </span>

                    </div>

                </a>

            @endforeach

        @else

            <div class="empty-task">
                Tidak ada tugas terbaru.
            </div>

        @endif

    </div>

</div>

@endsection