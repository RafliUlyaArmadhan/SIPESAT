<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita
     */
    public function index()
    {
        $beritas = Berita::latest()->get();

        return view('admin.berita.index', compact('beritas'));
    }


    /**
     * Form tambah berita
     */
    public function create()
    {
        return view('admin.berita.create');
    }


    /**
     * Menyimpan berita baru
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        // Default thumbnail
        $thumbnailPath = null;


        /*
        |--------------------------------------------------------------------------
        | UPLOAD THUMBNAIL
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            $file = $request->file('thumbnail');

            // Buat nama file unik
            $imageName =
                'berita_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | SIMPAN KE:
            | storage/app/public/berita
            |--------------------------------------------------------------------------
            */

            Storage::disk('public')->putFileAs(
                'berita',
                $file,
                $imageName
            );


            /*
            |--------------------------------------------------------------------------
            | YANG DISIMPAN KE DATABASE
            |--------------------------------------------------------------------------
            */

            $thumbnailPath = 'berita/' . $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA BERITA
        |--------------------------------------------------------------------------
        */

        Berita::create([
            'judul' => $request->judul,

            'slug' => Str::slug($request->judul),

            'thumbnail' => $thumbnailPath,

            'konten' => $request->konten,

            'kategori' => $request->kategori ?? 'kegiatan',

            'status' => $request->status,

            'penulis_id' => auth()->id() ?? 1,

            'tanggal_publish' =>
                $request->status === 'published'
                    ? now()
                    : null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOG AKTIVITAS
        |--------------------------------------------------------------------------
        */

        logActivity(
            'Tambah berita',
            'Berita',
            'Berita "' . $request->judul . '" ditambahkan.'
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.berita.index')
            ->with(
                'success',
                'Berita berhasil ditambahkan'
            );
    }


    /**
     * Form edit berita
     */
    public function edit(Berita $beritum)
    {
        return view(
            'admin.berita.edit',
            compact('beritum')
        );
    }


    /**
     * Update berita
     */
    public function update(
        Request $request,
        Berita $beritum
    ) {

        // Validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | PERTAHANKAN GAMBAR LAMA
        |--------------------------------------------------------------------------
        */

        $thumbnailPath = $beritum->thumbnail;


        /*
        |--------------------------------------------------------------------------
        | JIKA USER UPLOAD GAMBAR BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR LAMA
            |--------------------------------------------------------------------------
            */

            if (!empty($beritum->thumbnail)) {

                // Hapus dari storage/app/public
                Storage::disk('public')->delete(
                    $beritum->thumbnail
                );


                // Fallback jika sebelumnya pernah menggunakan uploads
                $oldPath =
                    public_path(
                        'uploads/' .
                        $beritum->thumbnail
                    );

                if (File::exists($oldPath)) {

                    File::delete($oldPath);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | FILE BARU
            |--------------------------------------------------------------------------
            */

            $file = $request->file('thumbnail');


            $imageName =
                'berita_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | SIMPAN KE:
            | storage/app/public/berita
            |--------------------------------------------------------------------------
            */

            Storage::disk('public')->putFileAs(
                'berita',
                $file,
                $imageName
            );


            /*
            |--------------------------------------------------------------------------
            | PATH DATABASE
            |--------------------------------------------------------------------------
            */

            $thumbnailPath =
                'berita/' . $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $beritum->update([

            'judul' => $request->judul,

            'slug' => Str::slug(
                $request->judul
            ),

            'thumbnail' => $thumbnailPath,

            'konten' => $request->konten,

            'kategori' =>
                $request->kategori ?? 'kegiatan',

            'status' => $request->status,

            'tanggal_publish' =>
                $request->status === 'published'
                    ? (
                        $beritum->tanggal_publish
                        ?? now()
                    )
                    : null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOG AKTIVITAS
        |--------------------------------------------------------------------------
        */

        logActivity(
            'Ubah berita',
            'Berita',
            'Berita "' .
            $beritum->judul .
            '" diperbarui.'
        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.berita.index')
            ->with(
                'success',
                'Berita berhasil diperbarui'
            );
    }


    /**
     * Hapus berita
     */
    public function destroy(Berita $beritum)
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS THUMBNAIL
        |--------------------------------------------------------------------------
        */

        if (!empty($beritum->thumbnail)) {

            // Hapus dari storage/app/public
            Storage::disk('public')->delete(
                $beritum->thumbnail
            );


            // Fallback untuk file lama di public/uploads
            $oldPath =
                public_path(
                    'uploads/' .
                    $beritum->thumbnail
                );

            if (File::exists($oldPath)) {

                File::delete($oldPath);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | LOG AKTIVITAS
        |--------------------------------------------------------------------------
        */

        logActivity(
            'Hapus berita',
            'Berita',
            'Berita "' .
            $beritum->judul .
            '" dihapus.'
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA DATABASE
        |--------------------------------------------------------------------------
        */

        $beritum->delete();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.berita.index')
            ->with(
                'success',
                'Berita berhasil dihapus'
            );
    }
}