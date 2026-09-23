<?php

namespace App\Http\Controllers;

use App\Models\KategoriSampah;
use App\Models\LaporanSampah;
use App\Mail\LaporanSelesaiMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class LaporanSampahController extends Controller
{
    /**
     * Menampilkan form buat laporan sampah.
     */
    public function create()
    {
        $kategoriSampah = KategoriSampah::where('status_aktif', true)
            ->orderBy('nama_kategori')
            ->get();

        return view('masyarakat.laporan.create', compact('kategoriSampah'));
    }

    /**
     * Menyimpan laporan sampah.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_laporan' => ['required', 'string', 'max:255'],
            'kategori_sampah_id' => ['required', 'exists:kategori_sampah,id'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'desa' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'alamat_lengkap' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'foto_laporan' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'judul_laporan.required' => 'Judul laporan wajib diisi.',
            'kategori_sampah_id.required' => 'Kategori sampah wajib dipilih.',
            'kategori_sampah_id.exists' => 'Kategori sampah tidak valid.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'desa.required' => 'Desa/Kelurahan wajib diisi.',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'foto_laporan.required' => 'Foto laporan wajib diunggah.',
            'foto_laporan.image' => 'File yang diunggah harus berupa gambar.',
            'foto_laporan.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_laporan.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Upload foto
        $foto = null;

        if ($request->hasFile('foto_laporan')) {
            $foto = [
                $request->file('foto_laporan')->store('laporan', 'public')
            ];
        }

        // Membuat kode laporan otomatis
        $kodeLaporan = 'LAP-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        // Simpan laporan
        LaporanSampah::create([
            'kode_laporan' => $kodeLaporan,
            'user_id' => auth()->id(),
            'kategori_sampah_id' => $validated['kategori_sampah_id'],
            'kecamatan' => $validated['kecamatan'],
            'desa' => $validated['desa'],
            'judul_laporan' => $validated['judul_laporan'],
            'deskripsi' => $validated['deskripsi'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'foto_laporan' => $foto,
            'status' => 'menunggu_verifikasi',
        ]);

        return redirect()
            ->route('masyarakat.dashboard')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    /**
     * Mengubah status laporan sampah.
     */
    public function updateStatus(Request $request, LaporanSampah $laporan)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:menunggu_verifikasi,diproses,selesai,ditolak'
            ],
        ]);

        // Simpan status sebelumnya
        $statusSebelumnya = $laporan->status;

        // Ubah status laporan
        $laporan->status = $validated['status'];

        // Jika laporan selesai, simpan waktu selesai
        if ($validated['status'] === 'selesai') {
            $laporan->completed_at = now();
        }

        $laporan->save();

        // Kirim email jika laporan baru berubah menjadi selesai
        if (
            $validated['status'] === 'selesai' &&
            $statusSebelumnya !== 'selesai'
        ) {
            Mail::to($laporan->user->email)
                ->send(new LaporanSelesaiMail($laporan));
        }

        return back()->with(
            'success',
            'Status laporan berhasil diperbarui.'
        );
    }
}