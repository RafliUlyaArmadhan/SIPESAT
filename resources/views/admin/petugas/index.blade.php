@extends('layouts.app')

@section('title', 'Manajemen Petugas')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Manajemen Petugas</h4>
        <p class="text-muted mb-0">
            Daftar petugas lapangan yang terdaftar
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Daftar Petugas</h6>

            <span class="badge bg-success">
                {{ $petugas->count() }} Petugas
            </span>
        </div>

        <div class="card-body">

            @if($petugas->count() > 0)

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Wilayah Tugas</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($petugas as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        {{ $p->user->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $p->nip ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $p->wilayahTugas->nama_kecamatan ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            Aktif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @else

                <div class="text-center py-5">
                    <p class="text-muted mb-0">
                        Belum ada petugas yang terdaftar.
                    </p>
                </div>

            @endif

        </div>
    </div>

</div>

@endsection