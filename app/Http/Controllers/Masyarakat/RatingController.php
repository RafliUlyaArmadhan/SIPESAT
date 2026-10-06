<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Menampilkan form rating
     */
    public function create($id)
    {
        $laporan = LaporanSampah::with('rating')
            ->findOrFail($id);

        // Pastikan laporan milik masyarakat yang sedang login
        if ($laporan->user_id !== auth()->id()) {
            abort(403);
        }

        // Rating hanya bisa diberikan jika laporan sudah selesai
        if ($laporan->status !== 'selesai') {
            return redirect()
                ->back()
                ->with('error', 'Laporan belum selesai.');
        }

        // Jika sudah pernah rating, jangan buat rating baru
        if ($laporan->rating) {
            return redirect()
                ->route('masyarakat.laporan.show', $laporan->id)
                ->with('info', 'Laporan ini sudah diberikan rating.');
        }

        return view(
            'masyarakat.rating.create',
            compact('laporan')
        );
    }

    /**
     * Menyimpan rating
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $laporan = LaporanSampah::findOrFail($id);

        // Pastikan laporan milik user yang sedang login
        if ($laporan->user_id !== auth()->id()) {
            abort(403);
        }

        // Rating hanya untuk laporan yang selesai
        if ($laporan->status !== 'selesai') {
            return redirect()
                ->back()
                ->with('error', 'Laporan belum selesai.');
        }

        // Simpan / update rating
        Rating::updateOrCreate(
            [
                'laporan_sampah_id' => $laporan->id,
            ],
            [
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]
        );

        return redirect()
            ->route('masyarakat.laporan.show', $laporan->id)
            ->with(
                'success',
                'Terima kasih atas rating dan ulasan Anda.'
            );
    }
}