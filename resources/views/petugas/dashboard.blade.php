@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

<div class="row g-3 mb-4">

    {{-- TUGAS BARU --}}
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-info">
                {{ $tugasBaru }}
            </h2>

            <span class="text-muted small">
                Tugas Baru
            </span>
        </div>
    </div>


    {{-- SEDANG DIKERJAKAN --}}
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-primary">
                {{ $sedangDikerjakan }}
            </h2>

            <span class="text-muted small">
                Sedang Dikerjakan
            </span>
        </div>
    </div>


    {{-- SELESAI --}}
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h2 class="font-mono m-0 text-success">
                {{ $selesai }}
            </h2>

            <span class="text-muted small">
                Selesai
            </span>
        </div>
    </div>

</div>


{{-- TUGAS TERBARU --}}
<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="m-0">
            Tugas Terbaru
        </h5>

        <a
            href="{{ route('petugas.tugas.index') }}"
            class="btn btn-sm btn-outline-secondary"
        >
            Lihat Semua
        </a>

    </div>


    @if(count($tugasTerbaru) > 0)

        <div class="list-group list-group-flush">

            @foreach($tugasTerbaru as $tugas)

                <a
                    href="{{ route('petugas.tugas.show', $tugas['id']) }}"
                    class="list-group-item list-group-item-action px-0"
                >

                    <div class="d-flex w-100 justify-content-between">

                        <h6 class="mb-1">
                            {{ $tugas['judul'] }}
                        </h6>

                        <small class="text-muted">
                            {{ $tugas['waktu'] }}
                        </small>

                    </div>


                    <p class="mb-1 small text-muted">

                        {{ Str::limit($tugas['deskripsi'], 100) }}

                    </p>


                    <small>

                        @if($tugas['status'] == 'Tugas Baru')

                            <span class="badge bg-info">
                                Tugas Baru
                            </span>

                        @elseif($tugas['status'] == 'Sedang Dikerjakan')

                            <span class="badge bg-primary">
                                Sedang Dikerjakan
                            </span>

                        @elseif($tugas['status'] == 'Selesai')

                            <span class="badge bg-success">
                                Selesai
                            </span>

                        @elseif($tugas['status'] == 'Ditolak')

                            <span class="badge bg-danger">
                                Ditolak
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $tugas['status'] }}
                            </span>

                        @endif

                    </small>

                </a>

            @endforeach

        </div>

    @else

        <p class="text-muted mb-0">
            Tidak ada tugas baru saat ini.
        </p>

    @endif

</div>


{{-- RATING TERBARU --}}
@if(isset($ratingTerbaru) && count($ratingTerbaru) > 0)

<div class="card p-4 mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="m-0">
            Rating Terbaru
        </h5>

    </div>


    <div class="list-group list-group-flush">

        @foreach($ratingTerbaru as $rating)

            <div class="list-group-item px-0">

                <div class="d-flex justify-content-between align-items-center">

                    <h6 class="mb-1">
                        {{ $rating['judul'] }}
                    </h6>

                    <span class="text-warning">
                        {{ str_repeat('★', $rating['rating']) }}
                        {{ str_repeat('☆', 5 - $rating['rating']) }}
                    </span>

                </div>


                @if(!empty($rating['komentar']))

                    <p class="mb-1 small text-muted">
                        {{ $rating['komentar'] }}
                    </p>

                @endif


                <small class="text-muted">
                    {{ $rating['waktu'] }}
                </small>

            </div>

        @endforeach

    </div>

</div>
<div class="card mt-4">
    <div class="card-header">
        Rating Masyarakat
    </div>

    <div class="card-body">

        @forelse($ratingTerbaru as $rating)

            <div class="border-bottom mb-3 pb-3">

                <h6>
                    {{ $rating['judul'] }}
                </h6>

                <div>
                    ⭐ {{ $rating['rating'] }}/5
                </div>

                <small>
                    {{ $rating['komentar'] }}
                </small>

            </div>

        @empty

            <p>Belum ada rating.</p>

        @endforelse

    </div>
</div>

@endif

@endsection