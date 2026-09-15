<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================
        // KARTU STATISTIK
        // ==========================

        $totalLaporan = 25;

        $menunggu = 8;

        $diproses = 7;

        $selesai = 8;

        $ditolak = 2;


        // ==========================
        // PETUGAS AKTIF
        // ==========================

        $totalPetugas = 5;


        // ==========================
        // DATA GRAFIK KATEGORI
        // ==========================

        $chartLabels = [
            'Sampah Rumah Tangga',
            'Sampah Lingkungan',
            'Sampah Organik'
        ];

        $chartValues = [
            10,
            8,
            7
        ];


        // ==========================
        // DATA PETA
        // ==========================

        $laporansMap = [
            [
                'latitude' => -7.6531,
                'longitude' => 111.3284,
                'judul_laporan' => 'Tumpukan Sampah di Jalan',
                'kategori' => 'Sampah Lingkungan'
            ],
            [
                'latitude' => -7.6555,
                'longitude' => 111.3310,
                'judul_laporan' => 'Sampah Rumah Tangga',
                'kategori' => 'Sampah Rumah Tangga'
            ],
            [
                'latitude' => -7.6490,
                'longitude' => 111.3250,
                'judul_laporan' => 'Sampah Organik Menumpuk',
                'kategori' => 'Sampah Organik'
            ]
        ];


        // ==========================
        // KIRIM DATA KE VIEW
        // ==========================

        return view('admin.dashboard', compact(
            'totalLaporan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak',
            'totalPetugas',
            'chartLabels',
            'chartValues',
            'laporansMap'
        ));
    }
}