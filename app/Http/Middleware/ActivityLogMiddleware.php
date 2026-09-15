<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Simpan data kategori sebelum proses dilanjutkan
        $kategoriSebelum = null;

        if (
            $request->route()?->getActionMethod() === 'destroy' &&
            $request->route()?->getController() instanceof \App\Http\Controllers\KategoriSampahController
        ) {
            $kategori = $request->route('kategori_sampah');

            if ($kategori) {
                $kategoriSebelum = $kategori->nama_kategori;
            }
        }

        // Jalankan request terlebih dahulu
        $response = $next($request);

        // Hanya mencatat pengguna yang sudah login
        if (!auth()->check()) {
            return $response;
        }

        // Hanya mencatat aktivitas yang mengubah data
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $response;
        }

        // Hanya mencatat jika proses berhasil
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
            return $response;
        }

        $action = $request->route()?->getActionMethod();
        $routeName = $request->route()?->getName() ?? '';

        // Menentukan modul
        $module = match (true) {
            str_contains($routeName, 'kategori-sampah') => 'Kategori Sampah',
            str_contains($routeName, 'laporan') => 'Laporan',
            str_contains($routeName, 'validasi') => 'Validasi Pekerjaan',
            str_contains($routeName, 'wilayah') => 'Wilayah',
            str_contains($routeName, 'petugas') => 'Petugas',
            str_contains($routeName, 'berita') => 'Berita',
            default => 'Sistem',
        };

        // Menentukan aktivitas
        $activity = match ($action) {
            'store' => 'Menambah data',
            'update' => 'Mengubah data',
            'destroy' => 'Menghapus data',
            default => match ($request->method()) {
                'POST' => 'Menambah data',
                'PUT', 'PATCH' => 'Mengubah data',
                'DELETE' => 'Menghapus data',
                default => 'Aktivitas data',
            },
        };

        // Membuat deskripsi khusus untuk Kategori Sampah
        if ($module === 'Kategori Sampah') {

            if ($action === 'store') {

                $namaKategori = $request->input('nama_kategori');

                $description = 'Pengguna menambahkan kategori sampah "' .
                    $namaKategori .
                    '".';

            } elseif ($action === 'update') {

                $namaKategori = $request->input('nama_kategori');

                $description = 'Pengguna mengubah kategori sampah menjadi "' .
                    $namaKategori .
                    '".';

            } elseif ($action === 'destroy') {

                $description = 'Pengguna menghapus kategori sampah "' .
                    ($kategoriSebelum ?? '-') .
                    '".';

            } else {

                $description = 'Pengguna melakukan ' .
                    strtolower($activity) .
                    ' pada modul Kategori Sampah.';
            }

        } else {

            $description = 'Pengguna melakukan ' .
                strtolower($activity) .
                ' pada modul ' .
                $module .
                '.';
        }

        // Simpan aktivitas ke database
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => $activity,
            'module' => $module,
            'description' => $description,
            'ip_address' => $request->ip(),
        ]);

        return $response;
    }
}