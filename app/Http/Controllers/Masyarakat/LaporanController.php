<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\KategoriSampah;
use App\Models\Kecamatan;
use App\Models\LaporanSampah;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanSampah::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('masyarakat.laporan.index', compact('laporans'));
    }

    public function create()
    {
        $kategoris = KategoriSampah::where('is_active', true)->get();

        $kecamatans = Kecamatan::all();

        $desas = Desa::all();

        return view(
            'masyarakat.laporan.create',
            compact(
                'kategoris',
                'kecamatans',
                'desas'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan' => 'required|string|max:150',

            'kategori_sampah_id' => 'required|exists:kategori_sampahs,id',

            'kecamatan_id' => 'required|exists:kecamatans,id',

            'desa_id' => [
                'required',
                Rule::exists('desas', 'id')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'kecamatan_id',
                            $request->kecamatan_id
                        );
                    }),
            ],

            'deskripsi' => 'required|string',

            'alamat_lengkap' => 'required|string',

            'latitude' => 'required|numeric',

            'longitude' => 'required|numeric',

            /*
             * foto_laporan adalah array karena input Blade memakai:
             * name="foto_laporan[]"
             */
            'foto_laporan' => 'required|array|min:1',

            /*
             * Validasi setiap foto yang berada di dalam array.
             * Maksimal 2 MB untuk setiap file.
             */
            'foto_laporan.*' => 'required|file|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'desa_id.exists' =>
                'Desa/Kelurahan yang dipilih tidak valid atau bukan bagian dari Kecamatan yang dipilih.',

            'foto_laporan.required' =>
                'Minimal satu foto laporan wajib diunggah.',

            'foto_laporan.array' =>
                'Format foto laporan tidak valid.',

            'foto_laporan.min' =>
                'Minimal satu foto laporan wajib diunggah.',

            'foto_laporan.*.required' =>
                'Foto laporan wajib diunggah.',

            'foto_laporan.*.file' =>
                'Foto laporan harus berupa file.',

            'foto_laporan.*.image' =>
                'Foto laporan harus berupa gambar.',

            'foto_laporan.*.mimes' =>
                'Foto laporan harus berformat JPEG, JPG, atau PNG.',

            'foto_laporan.*.max' =>
                'Ukuran setiap foto maksimal 2 MB.',
        ]);

        /*
         * Jangan ikut masukkan foto_laporan ke $data,
         * karena foto akan diproses secara manual di bawah.
         */
        $data = $request->except('foto_laporan');

        $laporan = new LaporanSampah($data);

        $laporan->user_id = Auth::id();

        $laporan->kode_laporan =
            'SPT-' . date('Ymd') . '-' . rand(1000, 9999);

        /*
         * Buat folder upload jika belum tersedia.
         *
         * File disimpan di:
         * public/uploads/laporan_fotos
         *
         * Path yang disimpan di database:
         * laporan_fotos/nama_file.jpg
         */
        $destinationPath = public_path('uploads/laporan_fotos');

        if (!File::exists($destinationPath)) {
            File::makeDirectory(
                $destinationPath,
                0755,
                true
            );
        }

        /*
         * Menyimpan semua foto yang dikirim dari input foto_laporan[].
         */
        $fotoLaporan = [];

        foreach ($request->file('foto_laporan') as $index => $file) {
            $imageName =
                'laporan_' .
                time() .
                '_' .
                uniqid() .
                '_' .
                $index .
                '.' .
                $file->extension();

            $file->move(
                $destinationPath,
                $imageName
            );

            $fotoLaporan[] =
                'laporan_fotos/' . $imageName;
        }

        /*
         * Pastikan kolom foto_laporan di model menggunakan cast array.
         * Contoh:
         * protected $casts = [
         *     'foto_laporan' => 'array',
         * ];
         */
        $laporan->foto_laporan = $fotoLaporan;

        $laporan->status = 'menunggu_verifikasi';

        $laporan->save();

        logActivity(
            'Membuat laporan',
            'Laporan',
            'Laporan baru "' .
            $laporan->judul_laporan .
            '" (kode ' .
            $laporan->kode_laporan .
            ') dikirim.'
        );

        return redirect()
            ->route('masyarakat.dashboard')
            ->with(
                'success',
                'Laporan berhasil dikirim.'
            );
    }

    public function show(LaporanSampah $laporan)
    {
        if ($laporan->user_id !== Auth::id()) {
            abort(403);
        }

        $rating = Rating::where(
            'laporan_sampah_id',
            $laporan->id
        )
            ->where('user_id', Auth::id())
            ->first();

        return view(
            'masyarakat.laporan.show',
            compact(
                'laporan',
                'rating'
            )
        );
    }

    public function storeRating(
        Request $request,
        LaporanSampah $laporan
    ) {
        if ($laporan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($laporan->status !== 'selesai') {
            return back()->with(
                'error',
                'Rating hanya dapat diberikan setelah laporan selesai.'
            );
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $sudahAda = Rating::where(
            'laporan_sampah_id',
            $laporan->id
        )
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahAda) {
            return back()->with(
                'error',
                'Laporan ini sudah diberi rating.'
            );
        }

        Rating::create([
            'laporan_sampah_id' => $laporan->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with(
            'success',
            'Rating berhasil disimpan.'
        );
    }
}