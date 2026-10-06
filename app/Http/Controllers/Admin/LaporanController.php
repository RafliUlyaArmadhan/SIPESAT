<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanSampah;
use App\Models\Penugasan;
use App\Models\Petugas;
use App\Models\LaporanStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanDitugaskan;
use App\Mail\LaporanSelesai;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan sampah.
     */
    public function index(Request $request)
    {
        $query = $this->buildFilterQuery($request);

        $laporans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = \App\Models\KategoriSampah::all();

        $kecamatans = \App\Models\Kecamatan::all();

        $petugasList = \App\Models\Petugas::with('user')
            ->where('status_petugas', 'aktif')
            ->get();

        return view(
            'admin.laporan.index',
            compact(
                'laporans',
                'kategoris',
                'kecamatans',
                'petugasList'
            )
        );
    }


    /**
     * Halaman validasi pekerjaan.
     */
    public function validasiPekerjaan(Request $request)
    {
        $laporans = LaporanSampah::with([
            'kategoriSampah',
            'kecamatan',
            'penugasan.petugas.user',
            'user',
            'dokumentasiPenanganan'
        ])
            ->whereIn('status', [
                'menunggu_validasi_akhir',
                'sedang_ditangani',
                'diverifikasi'
            ])
            ->whereHas('penugasan')
            ->latest()
            ->paginate(10);

        return view(
            'admin.laporan.validasi',
            compact('laporans')
        );
    }


    /**
     * Query filter laporan.
     */
    private function buildFilterQuery(Request $request)
    {
        $query = LaporanSampah::with([
            'kategoriSampah',
            'kecamatan',
            'penugasan.petugas.user',
            'user'
        ]);

        /*
         * Filter status
         */
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
         * Filter kategori
         */
        if ($request->filled('kategori_sampah_id')) {
            $query->where(
                'kategori_sampah_id',
                $request->kategori_sampah_id
            );
        }

        /*
         * Filter kecamatan
         */
        if ($request->filled('kecamatan_id')) {
            $query->where(
                'kecamatan_id',
                $request->kecamatan_id
            );
        }

        /*
         * Filter petugas
         */
        if ($request->filled('petugas_id')) {
            $query->whereHas(
                'penugasan',
                function ($q) use ($request) {
                    $q->where(
                        'petugas_id',
                        $request->petugas_id
                    );
                }
            );
        }

        /*
         * Filter tanggal
         */
        if (
            $request->filled('tanggal_mulai') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween(
                'created_at',
                [
                    $request->tanggal_mulai . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59'
                ]
            );
        }

        return $query;
    }


    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = $this->buildFilterQuery($request);

        $laporans = $query
            ->latest()
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'admin.laporan.pdf',
            compact(
                'laporans',
                'request'
            )
        );

        return $pdf->download(
            'laporan-sampah-' . date('Y-m-d') . '.pdf'
        );
    }


    /**
     * Export laporan ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = $this->buildFilterQuery($request);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanExport($query),
            'laporan-sampah-' . date('Y-m-d') . '.xlsx'
        );
    }


    /**
     * Detail laporan.
     */
    public function show($id)
    {
        $laporan = LaporanSampah::with([
            'user',
            'kategoriSampah',
            'kecamatan',
            'desa',
            'penugasan.petugas.user',
            'dokumentasiPenanganan',
            'laporanStatusHistories.user'
        ])
            ->findOrFail($id);

        $petugasList = Petugas::with('user')
            ->withCount([
                'penugasans' => function ($q) {
                    $q->whereHas(
                        'laporanSampah',
                        function ($q2) {
                            $q2->whereIn(
                                'status',
                                [
                                    'diverifikasi',
                                    'sedang_ditangani'
                                ]
                            );
                        }
                    );
                }
            ])
            ->where(
                'status_petugas',
                'aktif'
            )
            ->get();

        return view(
            'admin.laporan.show',
            compact(
                'laporan',
                'petugasList'
            )
        );
    }


    /**
     * Verifikasi laporan.
     */
    public function verifikasi(
        Request $request,
        $id
    ) {
        $laporan = LaporanSampah::findOrFail($id);

        if (
            $laporan->status ===
            'menunggu_verifikasi'
        ) {

            $laporan->update([
                'status' => 'diverifikasi',
                'verified_by' => auth()->id(),
                'verified_at' => now()
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' => 'menunggu_verifikasi',
                'status_sesudah' => 'diverifikasi',
                'keterangan' =>
                    'Laporan telah diverifikasi oleh Admin.'
            ]);

            logActivity(
                'Verifikasi laporan',
                'Laporan',
                'Laporan "' .
                    $laporan->kode_laporan .
                    '" diverifikasi.',
                auth()->id()
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Laporan berhasil diverifikasi. Silakan tugaskan petugas.'
                );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'Status laporan tidak valid untuk diverifikasi.'
            );
    }


    /**
     * Menolak laporan.
     */
    public function tolak(
        Request $request,
        $id
    ) {
        $request->validate([
            'alasan_penolakan' =>
                'required|string|max:500'
        ]);

        $laporan = LaporanSampah::findOrFail($id);

        if (
            $laporan->status ===
            'menunggu_verifikasi'
        ) {

            $laporan->update([
                'status' => 'ditolak',
                'alasan_penolakan' =>
                    $request->alasan_penolakan,
                'verified_by' => auth()->id(),
                'verified_at' => now()
            ]);

            LaporanStatusHistory::create([
                'laporan_sampah_id' => $laporan->id,
                'changed_by' => auth()->id(),
                'status_sebelum' =>
                    'menunggu_verifikasi',
                'status_sesudah' =>
                    'ditolak',
                'keterangan' =>
                    'Laporan ditolak. Alasan: ' .
                    $request->alasan_penolakan
            ]);

            logActivity(
                'Tolak laporan',
                'Laporan',
                'Laporan "' .
                    $laporan->kode_laporan .
                    '" ditolak.',
                auth()->id()
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Laporan berhasil ditolak.'
                );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'Status laporan tidak valid untuk ditolak.'
            );
    }


    /**
     * Menugaskan laporan kepada petugas.
     *
     * Email otomatis dikirim kepada petugas
     * setelah penugasan berhasil.
     */
    public function tugaskan(
        Request $request,
        $id
    ) {
        $request->validate([
            'petugas_id' =>
                'required|exists:petugas,id',

            'catatan_admin' =>
                'nullable|string',

            'tenggat_waktu' =>
                'nullable|date'
        ]);

        $laporan = LaporanSampah::findOrFail($id);

        /*
         * Penugasan hanya dapat dilakukan
         * jika laporan sudah diverifikasi.
         */
        if (
            $laporan->status !==
            'diverifikasi'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Laporan harus diverifikasi terlebih dahulu sebelum petugas ditugaskan.'
                );
        }

        /*
         * Simpan penugasan.
         */
        $penugasan = Penugasan::updateOrCreate(
            [
                'laporan_sampah_id' =>
                    $laporan->id
            ],
            [
                'petugas_id' =>
                    $request->petugas_id,

                'assigned_by' =>
                    auth()->id(),

                'catatan_admin' =>
                    $request->catatan_admin,

                'tenggat_waktu' =>
                    $request->tenggat_waktu,

                'assigned_at' =>
                    now()
            ]
        );

        /*
         * Simpan history penugasan.
         */
        LaporanStatusHistory::create([
            'laporan_sampah_id' =>
                $laporan->id,

            'changed_by' =>
                auth()->id(),

            'status_sebelum' =>
                'diverifikasi',

            'status_sesudah' =>
                'diverifikasi',

            'keterangan' =>
                'Petugas telah ditugaskan.'
        ]);

        /*
         * Activity log.
         */
        logActivity(
            'Tugaskan petugas',
            'Penugasan',
            'Laporan "' .
                $laporan->kode_laporan .
                '" ditugaskan ke petugas ID ' .
                $request->petugas_id .
                '.',
            auth()->id()
        );

        /*
         * ==========================================================
         * KIRIM EMAIL KE PETUGAS
         * ==========================================================
         */
        $petugas = Petugas::with('user')
            ->findOrFail(
                $request->petugas_id
            );

        if (
            $petugas->user &&
            $petugas->user->email
        ) {

            Mail::to(
                $petugas->user->email
            )->send(
                new LaporanDitugaskan(
                    $laporan,
                    $penugasan,
                    $petugas
                )
            );
        }

        /*
         * Kembali ke halaman laporan.
         */
        return redirect()
            ->route(
                'admin.laporan.index'
            )
            ->with(
                'assignment_success',
                'Petugas berhasil ditugaskan.'
            );
    }


    /**
     * Validasi akhir laporan.
     *
     * Ketika admin melakukan validasi akhir:
     *
     * menunggu_validasi_akhir
     *          ↓
     *       selesai
     *
     * Setelah status menjadi selesai,
     * sistem otomatis mengirim email
     * kepada masyarakat yang membuat laporan.
     */
    public function validasiAkhir(
        Request $request,
        $id
    ) {
        /*
         * Ambil laporan sekaligus data masyarakat
         * dan data lain yang digunakan oleh email.
         */
        $laporan = LaporanSampah::with([
            'user',
            'kategoriSampah',
            'kecamatan',
            'desa',
            'dokumentasiPenanganan'
        ])->findOrFail($id);

        /*
         * Pastikan laporan memang sedang
         * menunggu validasi akhir.
         */
        if (
            $laporan->status ===
            'menunggu_validasi_akhir'
        ) {

            /*
             * Update status menjadi selesai.
             */
            $laporan->update([
                'status' => 'selesai',
                'completed_at' => now()
            ]);

            /*
             * Simpan history perubahan status.
             */
            LaporanStatusHistory::create([
                'laporan_sampah_id' =>
                    $laporan->id,

                'changed_by' =>
                    auth()->id(),

                'status_sebelum' =>
                    'menunggu_validasi_akhir',

                'status_sesudah' =>
                    'selesai',

                'keterangan' =>
                    'Penanganan laporan telah divalidasi dan selesai.'
            ]);

            /*
             * Activity log.
             */
            logActivity(
                'Validasi akhir laporan',
                'Laporan',
                'Laporan "' .
                    $laporan->kode_laporan .
                    '" divalidasi selesai.',
                auth()->id()
            );

            /*
             * ======================================================
             * KIRIM EMAIL KE MASYARAKAT
             * ======================================================
             *
             * Email dikirim setelah status laporan
             * berhasil menjadi "selesai".
             *
             * Jika user memiliki email:
             *     kirim email.
             *
             * Jika user tidak memiliki email:
             *     proses tetap dianggap berhasil.
             */
            if (
                $laporan->user &&
                $laporan->user->email
            ) {

                Mail::to(
                    $laporan->user->email
                )->send(
                    new LaporanSelesai(
                        $laporan
                    )
                );
            }

            /*
             * Kembali ke halaman sebelumnya.
             */
            return redirect()
                ->back()
                ->with(
                    'success',
                    'Laporan berhasil divalidasi dan diselesaikan.'
                );
        }

        /*
         * Status laporan tidak sesuai.
         */
        return redirect()
            ->back()
            ->with(
                'error',
                'Status laporan tidak valid untuk validasi akhir.'
            );
    }
}