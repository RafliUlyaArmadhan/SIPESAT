@extends('layouts.app')

@section('title', 'Beri Rating')

@section('content')

<div class="container pb-5">

    <div class="mb-4">
        <a
            href="{{ route('masyarakat.laporan.show', $laporan->id) }}"
            class="text-decoration-none text-muted mb-2 d-inline-block small"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Kembali ke Detail Laporan
        </a>

        <h3 class="fw-bold mb-0">
            Beri Rating
        </h3>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-1">
                            {{ $laporan->judul_laporan }}
                        </h5>

                        <small class="text-muted">
                            <i class="fa-solid fa-hashtag"></i>
                            {{ $laporan->kode_laporan }}
                        </small>
                    </div>

                    <form
                        action="{{ route('masyarakat.rating.store', $laporan->id) }}"
                        method="POST"
                    >

                        @csrf

                        {{-- Rating --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Rating Pekerjaan
                            </label>

                            <div class="rating-wrapper">

                                <div
                                    class="rating-stars fs-1 text-warning"
                                    id="ratingStars"
                                >

                                    @for($i = 1; $i <= 5; $i++)

                                        <i
                                            class="fa-regular fa-star rating-star"
                                            data-rating="{{ $i }}"
                                            style="cursor: pointer;"
                                        ></i>

                                    @endfor

                                </div>

                                <input
                                    type="hidden"
                                    name="rating"
                                    id="rating"
                                    value=""
                                >

                                <div
                                    id="ratingText"
                                    class="text-muted mt-2"
                                >
                                    Pilih jumlah bintang
                                </div>

                                @error('rating')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        {{-- Komentar --}}
                        <div class="mb-4">

                            <label
                                for="komentar"
                                class="form-label fw-bold"
                            >
                                Ulasan
                            </label>

                            <textarea
                                name="komentar"
                                id="komentar"
                                rows="5"
                                class="form-control"
                                placeholder="Berikan ulasan mengenai pelayanan atau pekerjaan petugas..."
                            >{{ old('komentar') }}</textarea>

                            @error('komentar')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('masyarakat.laporan.show', $laporan->id) }}"
                                class="btn btn-outline-secondary rounded-pill px-4"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="btn btn-warning rounded-pill px-4"
                                id="submitRating"
                                disabled
                            >
                                <i class="fa-solid fa-star me-2"></i>
                                Kirim Penilaian
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const submitButton = document.getElementById('submitRating');

    stars.forEach(function (star) {

        star.addEventListener('click', function () {

            const rating = parseInt(
                this.getAttribute('data-rating')
            );

            ratingInput.value = rating;

            submitButton.disabled = false;

            stars.forEach(function (item) {

                const itemRating = parseInt(
                    item.getAttribute('data-rating')
                );

                if (itemRating <= rating) {

                    item.classList.remove(
                        'fa-regular'
                    );

                    item.classList.add(
                        'fa-solid'
                    );

                } else {

                    item.classList.remove(
                        'fa-solid'
                    );

                    item.classList.add(
                        'fa-regular'
                    );

                }

            });

            const labels = {
                1: 'Sangat Tidak Puas',
                2: 'Tidak Puas',
                3: 'Cukup',
                4: 'Puas',
                5: 'Sangat Puas'
            };

            ratingText.textContent =
                rating + ' / 5 - ' + labels[rating];

        });

    });

});
</script>

@endsection