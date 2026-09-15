<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $tugasBaru = 3;
        $sedangDikerjakan = 2;
        $selesai = 1;

        $tugasTerbaru = [
            [
                'id' => 6,
                'judul' => 'Tumpukan Daun Kering dan Kantong Plastik',
                'deskripsi' => 'Ditemukan tumpukan sampah yang perlu segera ditangani.',
                'status' => 'Tugas Baru',
                'waktu' => '17 minutes ago',
            ],
            [
                'id' => 11,
                'judul' => 'Sampah Rumah Tangga Belum Diangkut',
                'deskripsi' => 'Tumpukan sampah rumah tangga belum diangkut.',
                'status' => 'Tugas Baru',
                'waktu' => '35 minutes ago',
            ],
            [
                'id' => 1,
                'judul' => 'Sampah Popok Bayi Menumpuk',
                'deskripsi' => 'Ditemukan tumpukan sampah popok bayi.',
                'status' => 'Tugas Baru',
                'waktu' => '1 hour ago',
            ],
            [
                'id' => 20,
                'judul' => 'Pembuangan Liar di Lahan Kosong',
                'deskripsi' => 'Ditemukan pembuangan sampah liar di lahan kosong.',
                'status' => 'Sedang Dikerjakan',
                'waktu' => '2 hours ago',
            ],
            [
                'id' => 16,
                'judul' => 'Sampah Sisa Acara Syukuran Warga',
                'deskripsi' => 'Sampah sisa acara syukuran warga masih menumpuk.',
                'status' => 'Sedang Dikerjakan',
                'waktu' => '3 hours ago',
            ],
        ];

        return view('petugas.dashboard', compact(
            'tugasBaru',
            'sedangDikerjakan',
            'selesai',
            'tugasTerbaru'
        ));
    }
}