@extends('layouts.app')

@section('title','Beri Rating')

@section('content')

<div class="card">
    <div class="card-body">

        <h4>{{ $laporan->judul_laporan }}</h4>

        <hr>

        <form
            action="{{ route('masyarakat.rating.store',$laporan->id) }}"
            method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">
                    Rating
                </label>

                <select
                    name="rating"
                    class="form-control"
                    required>

                    <option value="">Pilih Rating</option>

                    <option value="5">
                        ⭐⭐⭐⭐⭐ Sangat Puas
                    </option>

                    <option value="4">
                        ⭐⭐⭐⭐ Puas
                    </option>

                    <option value="3">
                        ⭐⭐⭐ Cukup
                    </option>

                    <option value="2">
                        ⭐⭐ Kurang
                    </option>

                    <option value="1">
                        ⭐ Buruk
                    </option>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Ulasan
                </label>

                <textarea
                    name="komentar"
                    rows="5"
                    class="form-control"></textarea>
            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Kirim Rating

            </button>

        </form>

    </div>
</div>

@endsection