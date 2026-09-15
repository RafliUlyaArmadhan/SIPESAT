@extends('layouts.app')

@section('title', 'Manajemen Laporan')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            Manajemen Laporan
        </h4>

        <p class="text-muted mb-0">
            Daftar laporan sampah yang masuk
        </p>
    </div>


    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.laporan.index') }}">

                <div class="row g-3">

                    {{-- STATUS --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="menunggu_verifikasi"
                                {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>
                                Menunggu Verifikasi
                            </option>

                            <option value="diverifikasi"
                                {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>
                                Diverifikasi
                            </option>

                            <option value="sedang_ditangani"
                                {{ request('status') == 'sedang_ditangani' ? 'selected' : '' }}>
                                Sedang Ditangani
                            </option>

                            <option value="menunggu_validasi_akhir"
                                {{ request('status') == 'menunggu_validasi_akhir' ? 'selected' : '' }}>
                                Menunggu Validasi Akhir
                            </option>

                            <option value="selesai"
                                {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="ditolak"
                                {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>

                        </select>

                    </div>


                    {{-- KATEGORI --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Kategori Sampah
                        </label>

                        <select name="kategori_sampah_id"
                                class="form-select">

                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach($kategoris as $kategori)

                                <option value="{{ $kategori->id }}"
                                    {{ request('kategori_sampah_id') == $kategori->id ? 'selected' : '' }}>

                                    {{ $kategori->nama_kategori }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- KECAMATAN --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Kecamatan
                        </label>

                        <select name="kecamatan_id"
                                class="form-select">

                            <option value="">
                                Semua Kecamatan
                            </option>

                            @foreach($kecamatans as $kecamatan)

                                <option value="{{ $kecamatan->id }}"
                                    {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>

                                    {{ $kecamatan->nama_kecamatan }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- TOMBOL FILTER --}}
                    <div class="col-md-3 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="fa-solid fa-filter me-1"></i>
                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- DAFTAR LAPORAN --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0
                    d-flex justify-content-between
                    align-items-center">

            <h6 class="fw-bold mb-0">
                Daftar Laporan
            </h6>

            <span class="badge bg-secondary">
                {{ $laporans->total() }} Laporan
            </span>

        </div>


        <div class="card-body">

            @if($laporans->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Judul Laporan</th>
                                <th>Kategori</th>
                                <th>Kecamatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($laporans as $laporan)

                                <tr>

                                    {{-- NO --}}
                                    <td>
                                        {{
                                            $loop->iteration
                                            + (($laporans->currentPage() - 1)
                                            * $laporans->perPage())
                                        }}
                                    </td>


                                    {{-- KODE --}}
                                    <td>
                                        {{ $laporan->kode_laporan }}
                                    </td>


                                    {{-- JUDUL --}}
                                    <td>
                                        {{ $laporan->judul_laporan }}
                                    </td>


                                    {{-- KATEGORI --}}
                                    <td>
                                        {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
                                    </td>


                                    {{-- KECAMATAN --}}
                                    <td>
                                        {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}
                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        @if($laporan->status == 'menunggu_verifikasi')

                                            <span class="badge bg-warning text-dark">
                                                Menunggu Verifikasi
                                            </span>

                                        @elseif($laporan->status == 'diverifikasi')

                                            <span class="badge bg-info">
                                                Diverifikasi
                                            </span>

                                        @elseif($laporan->status == 'sedang_ditangani')

                                            <span class="badge bg-primary">
                                                Sedang Ditangani
                                            </span>

                                        @elseif($laporan->status == 'menunggu_validasi_akhir')

                                            <span class="badge bg-warning text-dark">
                                                Menunggu Validasi Akhir
                                            </span>

                                        @elseif($laporan->status == 'selesai')

                                            <span class="badge bg-success">
                                                Selesai
                                            </span>

                                        @elseif($laporan->status == 'ditolak')

                                            <span class="badge bg-danger">
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ $laporan->status }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- AKSI --}}
                                    <td>

                                        <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                                           class="btn btn-sm btn-outline-primary">

                                            <i class="fa-solid fa-eye"></i>
                                            Detail

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}
                <div class="mt-3">

                    {{ $laporans->links() }}

                </div>


            @else

                {{-- KOSONG --}}
                <div class="text-center py-5">

                    <i class="fa-solid fa-file-circle-xmark text-muted"
                       style="font-size:45px;">
                    </i>

                    <h6 class="fw-semibold text-muted mt-3">
                        Tidak ada laporan
                    </h6>

                    <p class="text-muted small mb-0">
                        Belum ada laporan yang sesuai dengan filter.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection