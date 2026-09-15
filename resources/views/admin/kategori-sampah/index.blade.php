@extends('layouts.app')

@section('title', 'Kategori Sampah')

@section('content')

<style>
    .kategori-page {
        width: 100%;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .page-title h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1f2a24;
    }

    .page-title p {
        margin: 5px 0 0;
        font-size: 12px;
        color: #6b7280;
    }

    .btn-tambah {
        background: #1f6e43;
        border: none;
        color: white;
        padding: 9px 15px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-tambah:hover {
        background: #16502f;
        color: white;
    }

    .kategori-card {
        background: white;
        border: 1px solid #e2e5e1;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(31, 42, 36, 0.06);
        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .kategori-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .kategori-table thead {
        background: #f8faf8;
    }

    .kategori-table th {
        padding: 13px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .kategori-table td {
        padding: 13px 16px;
        font-size: 12px;
        color: #374151;
        border-bottom: 1px solid #eef0ee;
        vertical-align: middle;
    }

    .kategori-table tbody tr:hover {
        background: #fafcfb;
    }

    .nomor {
        width: 50px;
        text-align: center !important;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }

    .status-aktif {
        background: #e8f3ec;
        color: #1f6e43;
    }

    .status-nonaktif {
        background: #fdecec;
        color: #c1443c;
    }

    .aksi {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-aksi {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        text-decoration: none;
        font-size: 11px;
    }

    .btn-edit {
        background: #e8f3fa;
        color: #2e7da3;
    }

    .btn-edit:hover {
        background: #2e7da3;
        color: white;
    }

    .btn-hapus {
        background: #fdecec;
        color: #c1443c;
    }

    .btn-hapus:hover {
        background: #c1443c;
        color: white;
    }

    .empty-data {
        text-align: center;
        padding: 45px 20px !important;
        color: #9ca3af !important;
    }

    .empty-data i {
        display: block;
        font-size: 30px;
        margin-bottom: 10px;
        color: #cbd5cf;
    }

    .empty-data span {
        font-size: 12px;
    }

    .alert-success {
        border: none;
        background: #e8f3ec;
        color: #1f6e43;
        font-size: 12px;
        border-radius: 7px;
    }

    .deskripsi {
        max-width: 350px;
        line-height: 1.5;
    }

    @media (max-width: 768px) {

        .page-header {
            align-items: flex-start;
            gap: 10px;
        }

        .page-title h4 {
            font-size: 18px;
        }

        .btn-tambah {
            padding: 8px 11px;
            font-size: 11px;
        }
    }
</style>


<div class="kategori-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div class="page-title">

            <h4>
                Kategori Sampah
            </h4>

            <p>
                Kelola data kategori sampah yang digunakan dalam sistem.
            </p>

        </div>


        <a href="{{ route('admin.kategori-sampah.create') }}"
           class="btn-tambah">

            <i class="fa-solid fa-plus"></i>

            Tambah Kategori

        </a>

    </div>


    {{-- PESAN BERHASIL --}}
    @if(session('success'))

        <div class="alert alert-success mb-3">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- TABEL --}}
    <div class="kategori-card">

        <div class="table-wrapper">

            <table class="kategori-table">

                <thead>

                    <tr>

                        <th class="nomor">
                            No
                        </th>

                        <th>
                            Nama Kategori
                        </th>

                        <th>
                            Deskripsi
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($kategoriSampah as $index => $kategori)

                        <tr>

                            <td class="nomor">
                                {{ $index + 1 }}
                            </td>


                            <td>
                                <strong>
                                    {{ $kategori->nama_kategori }}
                                </strong>
                            </td>


                            <td class="deskripsi">

                                @if($kategori->deskripsi)

                                    {{ $kategori->deskripsi }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($kategori->status_aktif)

                                    <span class="status-badge status-aktif">

                                        <i class="fa-solid fa-circle-check"></i>

                                        Aktif

                                    </span>

                                @else

                                    <span class="status-badge status-nonaktif">

                                        <i class="fa-solid fa-circle-xmark"></i>

                                        Nonaktif

                                    </span>

                                @endif

                            </td>


                            <td>

                                <div class="aksi">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.kategori-sampah.edit', $kategori->id) }}"
                                        class="btn-aksi btn-edit"
                                        title="Edit"
                                    >

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('admin.kategori-sampah.destroy', $kategori->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"
                                        style="display:inline;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-aksi btn-hapus"
                                            title="Hapus"
                                        >

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="empty-data">

                                <i class="fa-solid fa-tags"></i>

                                <span>
                                    Belum ada data kategori sampah.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection