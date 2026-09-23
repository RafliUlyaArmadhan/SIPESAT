<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL PETUGAS YANG SEDANG LOGIN
        |--------------------------------------------------------------------------
        */

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $petugas = $user?->petugas;


        /*
        |--------------------------------------------------------------------------
        | JIKA USER BELUM TERHUBUNG DENGAN DATA PETUGAS
        |--------------------------------------------------------------------------
        */

        if (!$petugas) {

            $tugasBaru = 0;
            $sedangDikerjakan = 0;
            $selesai = 0;
            $tugasTerbaru = [];
            $ratingTerbaru = [];

            return view(
                'petugas.dashboard',
                compact(
                    'tugasBaru',
                    'sedangDikerjakan',
                    'selesai',
                    'tugasTerbaru',
                    'ratingTerbaru'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TUGAS BARU
        |--------------------------------------------------------------------------
        | Laporan sudah diverifikasi Admin dan sudah ditugaskan
        | kepada petugas, tetapi belum mulai ditangani.
        |--------------------------------------------------------------------------
        */

        $tugasBaru = Penugasan::where(
            'petugas_id',
            $petugas->id
        )
            ->whereHas('laporanSampah', function ($query) {

                $query->where(
                    'status',
                    'diverifikasi'
                );

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SEDANG DIKERJAKAN
        |--------------------------------------------------------------------------
        */

        $sedangDikerjakan = Penugasan::where(
            'petugas_id',
            $petugas->id
        )
            ->whereHas('laporanSampah', function ($query) {

                $query->where(
                    'status',
                    'sedang_ditangani'
                );

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        | Dashboard Petugas menganggap:
        | - menunggu_validasi_akhir
        | - selesai
        | sebagai tugas selesai dari sisi petugas.
        |--------------------------------------------------------------------------
        */

        $selesai = Penugasan::where(
            'petugas_id',
            $petugas->id
        )
            ->whereHas('laporanSampah', function ($query) {

                $query->whereIn(
                    'status',
                    [
                        'menunggu_validasi_akhir',
                        'selesai'
                    ]
                );

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA PENUGASAN PETUGAS
        |--------------------------------------------------------------------------
        | Tidak memakai take(5), supaya daftar tugas konsisten
        | dengan angka statistik di atas.
        |--------------------------------------------------------------------------
        */

        $penugasans = Penugasan::with([
            'laporanSampah'
        ])
            ->where(
                'petugas_id',
                $petugas->id
            )
            ->latest('updated_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FORMAT TUGAS TERBARU
        |--------------------------------------------------------------------------
        */

        $tugasTerbaru = $penugasans
            ->map(function ($penugasan) {

                $laporan = $penugasan->laporanSampah;


                if (!$laporan) {
                    return null;
                }


                /*
                |----------------------------------------------------------------------
                | STATUS DASHBOARD
                |----------------------------------------------------------------------
                */

                switch ($laporan->status) {

                    case 'diverifikasi':

                        $status = 'Tugas Baru';

                        break;


                    case 'sedang_ditangani':

                        $status = 'Sedang Dikerjakan';

                        break;


                    case 'menunggu_validasi_akhir':
                    case 'selesai':

                        $status = 'Selesai';

                        break;


                    case 'ditolak':

                        $status = 'Ditolak';

                        break;


                    default:

                        $status = 'Tugas Baru';

                        break;
                }


                /*
                |----------------------------------------------------------------------
                | WAKTU
                |----------------------------------------------------------------------
                */

                $waktu = $penugasan->updated_at
                    ? $penugasan->updated_at->diffForHumans()
                    : '-';


                /*
                |----------------------------------------------------------------------
                | DATA TUGAS
                |----------------------------------------------------------------------
                */

                return [

                    'id' => $penugasan->id,

                    'judul' => $laporan->judul_laporan,

                    'deskripsi' => $laporan->deskripsi,

                    'status' => $status,

                    'waktu' => $waktu,

                ];

            })
            ->filter()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | AMBIL ID SEMUA LAPORAN YANG PERNAH DITUGASKAN
        |--------------------------------------------------------------------------
        */

        $laporanIds = $penugasans
            ->pluck('laporan_sampah_id')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RATING MASYARAKAT
        |--------------------------------------------------------------------------
        | Hanya rating dari laporan yang pernah ditugaskan
        | kepada petugas yang sedang login.
        |--------------------------------------------------------------------------
        */

        $ratingData = Rating::whereIn(
            'laporan_sampah_id',
            $laporanIds
        )
            ->latest('created_at')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MAP ID LAPORAN -> JUDUL LAPORAN
        |--------------------------------------------------------------------------
        */

        $laporanMap = $penugasans
            ->mapWithKeys(function ($penugasan) {

                return [
                    $penugasan->laporan_sampah_id =>
                        $penugasan->laporanSampah
                ];

            });


        /*
        |--------------------------------------------------------------------------
        | FORMAT RATING UNTUK VIEW
        |--------------------------------------------------------------------------
        */

        $ratingTerbaru = $ratingData
            ->map(function ($rating) use ($laporanMap) {

                $laporan = $laporanMap->get(
                    $rating->laporan_sampah_id
                );


                return [

                    'id' => $rating->id,

                    'laporan_id' =>
                        $rating->laporan_sampah_id,

                    'judul' =>
                        $laporan?->judul_laporan ?? 'Laporan',

                    'rating' =>
                        (int) $rating->rating,

                    'komentar' =>
                        $rating->komentar,

                    'waktu' =>
                        $rating->created_at
                            ? $rating->created_at->diffForHumans()
                            : '-',

                ];

            })
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE DASHBOARD PETUGAS
        |--------------------------------------------------------------------------
        */

        return view(
            'petugas.dashboard',
            compact(
                'tugasBaru',
                'sedangDikerjakan',
                'selesai',
                'tugasTerbaru',
                'ratingTerbaru'
            )
        );
    }
}