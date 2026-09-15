@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')

<style>
    .tugas-page {
        font-size: 13px;
    }

    .tugas-header {
        margin-bottom: 18px;
    }

    .tugas-header h4 {
        font-weight: 700;
        margin-bottom: 4px;
    }

    .tugas-header p {
        color: #777;
        margin: 0;
    }

    .tugas-card {
        background: white;
        border-radius: 7px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 2px 5px rgba(0,0,0,.08);
        overflow: hidden;
    }

    .tugas-card-header {
        padding: 13px 16px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tugas-card-header h6 {
        font-weight: 700;
        margin: 0;
    }

    .jumlah-tugas {
        background: #6c757d;
        color: white;
        font-size: 11px;
        padding: 5px 9px;
        border-radius: 5px;
    }

    .table-tugas {
        width: 100%;
        border-collapse: collapse;
    }

    .table-tugas th {
        background: #f8f9fa;
        color: #555;
        font-size: 10px;
        font-weight: 700;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
    }

    .table-tugas td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 10px;
        vertical-align: middle;
    }

    .table-tugas tr:hover {
        background: #f8fbf9;
    }

    .kode {
        font-weight: 600;
        color: #333;
    }

    .judul {
        font-weight: 600;
        color: #333;
    }

    .tanggal {
        color: #777;
    }

    .badge-status {
        display: inline-block;
        font-size: 8px;
        padding: 4px 7px;
        border-radius: 4px;
        color: white;
        white-space: nowrap;
    }

    .status-baru {
        background: #0d9fe8;
    }

    .status-proses {
        background: #198754;
    }

    .status-selesai {
        background: #6c757d;
    }

    .status-validasi {
        background: #f0ad4e;
    }

    .btn-detail {
        display: inline-block;
        font-size: 9px;
        padding: 4px 9px;
        border: 1px solid #0d6efd;
        color: #0d6efd;
        background: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-detail:hover {
        background: #0d6efd;
        color: white;
    }

    .empty-tugas {
        text-align: center;
        padding: 35px;
        color: #777;
        font-size: 11px;
    }

    .pagination-wrapper {
        padding: 12px 16px;
    }
</style>


<div class="tugas-page">

    {{-- HEADER --}}
    <div class="tugas-header">

        <h4>Tugas Saya</h4>

        <p>
            Daftar tugas yang diberikan kepada petugas lapangan
        </p>

    </div>


    {{-- CARD --}}
    <div class="tugas-card">

        <div class="tugas-card-header">

            <h6>Daftar Tugas</h6>

            <span class="jumlah-tugas">
                {{ $penugasans->total() }} Tugas
            </span>

        </div>


        @if($penugasans->count() > 0)

            <div class="table-responsive">

                <table class="table-tugas">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Tugas</th>
                            <th>Tanggal</th>
                            <th>Judul Laporan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>


                    <tbody>

                        @foreach($penugasans as $index => $penugasan)

                            @php
                                $laporan = $penugasan->laporanSampah;
                                $status = $laporan->status ?? '';
                            @endphp

                            <tr>

                                {{-- NO --}}
                                <td>
                                    {{ $penugasans->firstItem() + $index }}
                                </td>


                                {{-- KODE --}}
                                <td>
                                    <span class="kode">
                                        {{ $laporan->kode_laporan ?? '-' }}
                                    </span>
                                </td>


                                {{-- TANGGAL --}}
                                <td>
                                    <span class="tanggal">
                                        {{ $penugasan->created_at
                                            ? $penugasan->created_at->format('d/m/Y')
                                            : '-' }}
                                    </span>
                                </td>


                                {{-- JUDUL --}}
                                <td>
                                    <span class="judul">
                                        {{ $laporan->judul_laporan ?? 'Laporan Sampah' }}
                                    </span>
                                </td>


                                {{-- KATEGORI --}}
                                <td>
                                    {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($status == 'diverifikasi')

                                        <span class="badge-status status-baru">
                                            Tugas Baru
                                        </span>

                                    @elseif($status == 'sedang_ditangani')

                                        <span class="badge-status status-proses">
                                            Sedang Dikerjakan
                                        </span>

                                    @elseif($status == 'menunggu_validasi_akhir')

                                        <span class="badge-status status-validasi">
                                            Menunggu Validasi
                                        </span>

                                    @elseif($status == 'selesai')

                                        <span class="badge-status status-selesai">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="badge-status status-selesai">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <a href="{{ route('petugas.tugas.show', $penugasan->id) }}"
                                       class="btn-detail">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if($penugasans->hasPages())

                <div class="pagination-wrapper">
                    {{ $penugasans->links() }}
                </div>

            @endif


        @else

            <div class="empty-tugas">
                Tidak ada tugas yang diberikan kepada Anda saat ini.
            </div>

        @endif

    </div>

</div>

@endsection