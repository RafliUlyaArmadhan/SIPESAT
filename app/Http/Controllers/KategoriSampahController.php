<?php

namespace App\Http\Controllers;

use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class KategoriSampahController extends Controller
{
    // Menampilkan semua kategori sampah
    public function index()
    {
        $kategoriSampah = KategoriSampah::latest()->get();

        return view('admin.kategori-sampah.index', compact('kategoriSampah'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('admin.kategori-sampah.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'required|boolean',
        ]);

        KategoriSampah::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()
            ->route('admin.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil ditambahkan.');
    }

    // Menampilkan form edit kategori
    public function edit(KategoriSampah $kategoriSampah)
    {
        return view('admin.kategori-sampah.edit', compact('kategoriSampah'));
    }

    // Memperbarui kategori
    public function update(Request $request, KategoriSampah $kategoriSampah)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'required|boolean',
        ]);

        $kategoriSampah->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()
            ->route('admin.kategori-sampah.index')
            ->with('success', 'Kategori sampah berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy(KategoriSampah $kategoriSampah)
    {
        $kategoriSampah->delete(); //baris utama yang menghapus dari database

        return redirect() //mengembalikan ke kategori sampah 
            ->route('admin.kategori-sampah.index') //mengembalikan pengguna ke halaman kategori sampah
            ->with('success', 'Kategori sampah berhasil dihapus.');//menampilkan pesan kategori sampah berhasil di hapus 
    }
}