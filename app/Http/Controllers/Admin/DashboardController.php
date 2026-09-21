<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK LAPORAN
        |--------------------------------------------------------------------------
        | Dashboard menampilkan 6 status yang sama dengan Manajemen Laporan
        | dan Detail Laporan.
        */

        $menungguVerifikasi = LaporanSampah::where(
            'status',
            'menunggu_verifikasi'
        )->count();

        $diverifikasi = LaporanSampah::where(
            'status',
            'diverifikasi'
        )->count();

        $sedangDitangani = LaporanSampah::where(
            'status',
            'sedang_ditangani'
        )->count();

        $menungguValidasi = LaporanSampah::where(
            'status',
            'menunggu_validasi_akhir'
        )->count();

        $selesai = LaporanSampah::where(
            'status',
            'selesai'
        )->count();

        $ditolak = LaporanSampah::where(
            'status',
            'ditolak'
        )->count();

        // Total harus sama dengan seluruh laporan di database.
        $totalLaporan = LaporanSampah::count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PETUGAS
        |--------------------------------------------------------------------------
        | Error sebelumnya terjadi karena tabel users tidak mempunyai kolom
        | "role". Di sini struktur dicek terlebih dahulu.
        */

        $totalPetugas = 0;

        if (Schema::hasColumn('users', 'role')) {
            $totalPetugas = DB::table('users')
                ->where('role', 'petugas')
                ->count();
        } elseif (
            Schema::hasColumn('users', 'role_id') &&
            Schema::hasTable('roles') &&
            Schema::hasColumn('roles', 'name')
        ) {
            $totalPetugas = DB::table('users')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.name', 'petugas')
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | GRAFIK KATEGORI SAMPAH
        |--------------------------------------------------------------------------
        */

        $kategoriData = LaporanSampah::query()
            ->select(
                'kategori_sampah_id',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('kategori_sampah_id')
            ->with('kategoriSampah:id,nama_kategori')
            ->get();

        $chartLabels = [];
        $chartValues = [];

        foreach ($kategoriData as $item) {
            $chartLabels[] =
                $item->kategoriSampah->nama_kategori
                ?? 'Tanpa Kategori';

            $chartValues[] = (int) $item->total;
        }

        /*
        |--------------------------------------------------------------------------
        | DATA PETA
        |--------------------------------------------------------------------------
        */

        $laporansMap = LaporanSampah::query()
            ->select([
                'id',
                'kode_laporan',
                'judul_laporan',
                'status',
                'latitude',
                'longitude',
                'user_id',
                'kategori_sampah_id',
            ])
            ->with([
                'user:id,name',
                'kategoriSampah:id,nama_kategori',
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($laporan) {
                return [
                    'id' => $laporan->id,
                    'kode_laporan' => $laporan->kode_laporan,
                    'judul_laporan' => $laporan->judul_laporan,
                    'status' => $laporan->status,
                    'latitude' => (float) $laporan->latitude,
                    'longitude' => (float) $laporan->longitude,

                    'user' => $laporan->user
                        ? [
                            'name' => $laporan->user->name,
                        ]
                        : null,

                    'kategori_sampah' => $laporan->kategoriSampah
                        ? [
                            'nama_kategori' =>
                                $laporan->kategoriSampah->nama_kategori,
                        ]
                        : null,
                ];
            })
            ->values()
            ->toArray();

        return view('admin.dashboard', compact(
            'menungguVerifikasi',
            'diverifikasi',
            'sedangDitangani',
            'menungguValidasi',
            'selesai',
            'ditolak',
            'totalLaporan',
            'totalPetugas',
            'chartLabels',
            'chartValues',
            'laporansMap'
        ));
    }
}
