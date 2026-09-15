@extends('layouts.app')

@section('title', 'Edit Kategori Sampah')

@section('content')

<style>
    .kategori-form-page {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 18px;
    }

    .page-header h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1f2a24;
    }

    .page-header p {
        margin: 5px 0 0;
        font-size: 12px;
        color: #6b7280;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e2e5e1;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(31, 42, 36, 0.06);
        padding: 25px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
    }

    .required {
        color: #c1443c;
    }

    .form-control,
    .form-select {
        width: 100%;
        border: 1px solid #d9dedb;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 12px;
        color: #374151;
        background: #ffffff;
        outline: none;
        transition: 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1f6e43;
        box-shadow: 0 0 0 3px rgba(31, 110, 67, 0.08);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .form-help {
        margin-top: 5px;
        font-size: 10px;
        color: #9ca3af;
    }

    .error-message {
        margin-top: 5px;
        font-size: 10px;
        color: #c1443c;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        padding-top: 18px;
        border-top: 1px solid #eef0ee;
        margin-top: 5px;
    }

    .btn-kembali {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 15px;
        border: 1px solid #d9dedb;
        border-radius: 6px;
        background: #ffffff;
        color: #6b7280;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-kembali:hover {
        background: #f5f6f5;
        color: #374151;
    }

    .btn-update {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 16px;
        border: none;
        border-radius: 6px;
        background: #1f6e43;
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-update:hover {
        background: #16502f;
    }

    @media (max-width: 576px) {

        .form-card {
            padding: 18px;
        }

        .form-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-kembali,
        .btn-update {
            justify-content: center;
        }
    }
</style>


<div class="kategori-form-page">

    {{-- HEADER --}}
    <div class="page-header">

        <h4>
            Edit Kategori Sampah
        </h4>

        <p>
            Perbarui informasi kategori sampah.
        </p>

    </div>


    {{-- FORM --}}
    <div class="form-card">

        <form
            action="{{ route('admin.kategori-sampah.update', $kategoriSampah->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            {{-- NAMA KATEGORI --}}
            <div class="form-group">

                <label class="form-label">
                    Nama Kategori
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="nama_kategori"
                    class="form-control @error('nama_kategori') is-invalid @enderror"
                    value="{{ old('nama_kategori', $kategoriSampah->nama_kategori) }}"
                    placeholder="Contoh: Sampah Rumah Tangga"
                    required
                >

                @error('nama_kategori')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- DESKRIPSI --}}
            <div class="form-group">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    placeholder="Masukkan deskripsi kategori sampah..."
                >{{ old('deskripsi', $kategoriSampah->deskripsi) }}</textarea>

                <div class="form-help">
                    Deskripsi dapat digunakan untuk menjelaskan kategori sampah.
                </div>

                @error('deskripsi')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- STATUS --}}
            <div class="form-group">

                <label class="form-label">
                    Status
                    <span class="required">*</span>
                </label>

                <select
                    name="status_aktif"
                    class="form-select @error('status_aktif') is-invalid @enderror"
                    required
                >

                    <option
                        value="1"
                        {{ old('status_aktif', $kategoriSampah->status_aktif) == '1' ? 'selected' : '' }}
                    >
                        Aktif
                    </option>

                    <option
                        value="0"
                        {{ old('status_aktif', $kategoriSampah->status_aktif) == '0' ? 'selected' : '' }}
                    >
                        Nonaktif
                    </option>

                </select>

                @error('status_aktif')

                    <div class="error-message">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BUTTON --}}
            <div class="form-footer">

                <a
                    href="{{ route('admin.kategori-sampah.index') }}"
                    class="btn-kembali"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali

                </a>


                <button
                    type="submit"
                    class="btn-update"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection