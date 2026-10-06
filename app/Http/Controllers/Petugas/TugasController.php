<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use App\Models\DokumentasiPenanganan;
use App\Models\LaporanStatusHistory;
use App\Models\User;
use App\Mail\PetugasUpdatePengerjaan;
use App\Mail\PetugasUpdatePengerjaanMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TugasController extends Controller
{
    /**
     * Tugas Saya
     * Menampilkan semua tugas milik petugas yang sedang login.
     */
    public function index()
    {
        $petugas = auth()->user()->petugas;

        if (!$petugas) {
            $penugasans = collect();
        } else {
            $penugasans = Penugasan::with([
                'laporanSampah.user',
                'laporanSampah.kategoriSampah',
                'laporanSampah.kecamatan',
                'laporanSampah.desa',
                'laporanSampah.dokumentasiPenanganan'
            ])
            ->where('petugas_id', $petugas->id)
            ->latest('updated_at')
            ->paginate(15);
        }

        return view(
            'petugas.tugas.index',
            compact('penugasans')
        );
    }


    /**
     * Detail Tugas
     */
    public function show($id)
    {
        $petugas = auth()->user()->petugas;

        $penugasan = Penugasan::with([
            'laporanSampah.user',
            'laporanSampah.kategoriSampah',
            'laporanSampah.kecamatan',
            'laporanSampah.desa',
            'laporanSampah.dokumentasiPenanganan'
        ])
        ->where('petugas_id', $petugas->id)
        ->findOrFail($id);

        return view(
            'petugas.tugas.show',
            compact('penugasan')
        );
    }


    /**
     * Update Status Tugas
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'foto_sebelum.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'foto_sesudah.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'catatan_pekerjaan' => 'nullable|string',
            'action' => 'required|in:mulai,selesai'
        ]);

        $petugas = auth()->user()->petugas;

        $penugasan = Penugasan::where(
            'petugas_id',
            $petugas->id
        )->findOrFail($id);

        $laporan = $penugasan->laporanSampah;

        $dokumentasi = DokumentasiPenanganan::firstOrNew([
            'laporan_sampah_id' => $laporan->id
        ]);

        $dokumentasi->petugas_id = $petugas->id;


        /*
        |--------------------------------------------------------------------------
        | MULAI MENANGANI
        |--------------------------------------------------------------------------
        */

        if ($request->action === 'mulai') {

            if ($request->hasFile('foto_sebelum')) {

                if (!empty($dokumentasi->foto_sebelum)) {

                    foreach (
                        (array) $dokumentasi->foto_sebelum
                        as $oldFoto
                    ) {

                        $oldPath = public_path(
                            'uploads/' . $oldFoto
                        );

                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                    }
                }

                $paths = [];

                foreach (
                    $request->file('foto_sebelum')
                    as $file
                ) {

                    $imageName =
                        'sebelum_' .
                        time() .
                        '_' .
                        uniqid() .
                        '.' .
                        $file->extension();

                    $file->move(
                        public_path(
                            'uploads/dokumentasi_sebelum'
                        ),
                        $imageName
                    );

                    $paths[] =
                        'dokumentasi_sebelum/' .
                        $imageName;
                }

                $dokumentasi->foto_sebelum = $paths;
            }

            $dokumentasi->waktu_mulai = now();
            $dokumentasi->save();

            $laporan->update([
                'status' => 'sedang_ditangani'
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' => 'diverifikasi',
                'status_sesudah' => 'sedang_ditangani',
                'keterangan' =>
                    'Petugas telah mulai menangani.'
            ]);

            logActivity(
                'Mulai menangani laporan',
                'Penanganan',
                'Laporan "' .
                    $laporan->kode_laporan .
                    '" mulai ditangani.',
                auth()->id()
            );

            /*
            |--------------------------------------------------------------------------
            | EMAIL KE ADMIN
            |--------------------------------------------------------------------------
            */

            $this->notifikasiEmailKeAdmin(
                $laporan,
                $petugas,
                'mulai',
                $dokumentasi
            );

            /*
            |--------------------------------------------------------------------------
            | EMAIL KE MASYARAKAT
            |--------------------------------------------------------------------------
            */

            $this->notifikasiEmailKeMasyarakat(
                $laporan,
                $petugas,
                'mulai',
                $dokumentasi
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Status diupdate menjadi sedang ditangani.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SELESAI MENANGANI
        |--------------------------------------------------------------------------
        */

        if ($request->action === 'selesai') {

            if ($request->hasFile('foto_sesudah')) {

                if (!empty($dokumentasi->foto_sesudah)) {

                    foreach (
                        (array) $dokumentasi->foto_sesudah
                        as $oldFoto
                    ) {

                        $oldPath = public_path(
                            'uploads/' . $oldFoto
                        );

                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                    }
                }

                $paths = [];

                foreach (
                    $request->file('foto_sesudah')
                    as $file
                ) {

                    $imageName =
                        'sesudah_' .
                        time() .
                        '_' .
                        uniqid() .
                        '.' .
                        $file->extension();

                    $file->move(
                        public_path(
                            'uploads/dokumentasi_sesudah'
                        ),
                        $imageName
                    );

                    $paths[] =
                        'dokumentasi_sesudah/' .
                        $imageName;
                }

                $dokumentasi->foto_sesudah = $paths;
            }

            $dokumentasi->waktu_selesai = now();

            $dokumentasi->catatan_pekerjaan =
                $request->catatan_pekerjaan;

            $dokumentasi->save();

            $laporan->update([
                'status' => 'menunggu_validasi_akhir'
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' => 'sedang_ditangani',
                'status_sesudah' => 'menunggu_validasi_akhir',
                'keterangan' =>
                    'Petugas telah selesai menangani.'
            ]);

            logActivity(
                'Selesaikan penanganan',
                'Penanganan',
                'Laporan "' .
                    $laporan->kode_laporan .
                    '" selesai ditangani.',
                auth()->id()
            );

            /*
            |--------------------------------------------------------------------------
            | EMAIL KE ADMIN
            |--------------------------------------------------------------------------
            */

            $this->notifikasiEmailKeAdmin(
                $laporan,
                $petugas,
                'selesai',
                $dokumentasi
            );

            /*
            |--------------------------------------------------------------------------
            | EMAIL KE MASYARAKAT
            |--------------------------------------------------------------------------
            */

            $this->notifikasiEmailKeMasyarakat(
                $laporan,
                $petugas,
                'selesai',
                $dokumentasi
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Status diupdate menjadi menunggu validasi akhir.'
                );
        }
    }


    /**
     * Kirim email notifikasi ke seluruh admin aktif
     * saat petugas memulai / menyelesaikan pengerjaan.
     *
     * Jika gagal kirim, hanya dicatat di log dan
     * TIDAK menggagalkan update status petugas.
     */
    private function notifikasiEmailKeAdmin(
        $laporan,
        $petugas,
        string $tahap,
        $dokumentasi = null
    ): void {
        try {

            $emailAdmins = User::whereHas(
                'role',
                fn ($q) => $q->where('name', 'admin')
            )
                ->where('is_active', true)
                ->whereNotNull('email')
                ->pluck('email')
                ->unique()
                ->values();

            if ($emailAdmins->isEmpty()) {
                return;
            }

            Mail::to($emailAdmins->all())->send(
                new PetugasUpdatePengerjaan(
                    $laporan,
                    $petugas,
                    $tahap,
                    $dokumentasi
                )
            );

        } catch (\Throwable $e) {

            Log::error(
                'Gagal mengirim email notifikasi pengerjaan ke admin: '
                . $e->getMessage()
            );
        }
    }


    /**
     * Kirim email notifikasi ke masyarakat
     * saat petugas memulai / menyelesaikan pengerjaan.
     *
     * Jika gagal kirim, hanya dicatat di log dan
     * TIDAK menggagalkan update status petugas.
     */
    private function notifikasiEmailKeMasyarakat(
        $laporan,
        $petugas,
        string $tahap,
        $dokumentasi = null
    ): void {
        try {

            $emailMasyarakat = $laporan->user?->email;

            if (!$emailMasyarakat) {
                return;
            }

            Mail::to($emailMasyarakat)->send(
                new PetugasUpdatePengerjaanMasyarakat(
                    $laporan,
                    $petugas,
                    $tahap,
                    $dokumentasi
                )
            );

        } catch (\Throwable $e) {

            Log::error(
                'Gagal mengirim email notifikasi pengerjaan ke masyarakat: '
                . $e->getMessage()
            );
        }
    }
}
