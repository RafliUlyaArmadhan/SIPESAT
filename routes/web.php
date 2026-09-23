<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Masyarakat\DashboardController as MasyarakatDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Masyarakat\LaporanController as MasyarakatLaporanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\KategoriSampahController;
use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Petugas\TugasController;


/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [App\Http\Controllers\LandingController::class, 'index']
)->name('landing');

Route::get(
    '/berita/{slug}',
    [App\Http\Controllers\LandingController::class, 'showBerita']
)->name('berita.show');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get(
        '/login',
        [LoginController::class, 'showLoginForm']
    )->name('login');

    Route::post(
        '/login',
        [LoginController::class, 'login']
    );


    // Register
    Route::get(
        '/register',
        [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']
    )->name('register');

    Route::post(
        '/register',
        [App\Http\Controllers\Auth\RegisterController::class, 'register']
    );


    // Forgot Password
    Route::get(
        '/forgot-password',
        [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']
    )->name('password.request');

    Route::post(
        '/forgot-password',
        [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyEmail']
    )->name('password.verify');

    Route::get(
        '/reset-password',
        [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm']
    )->name('password.reset');

    Route::post(
        '/reset-password',
        [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset']
    )->name('password.update');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
| FILE UPLOAD
|--------------------------------------------------------------------------
*/

Route::get('/uploads/{folder}/{filename}', function ($folder, $filename) {

    $path = public_path(
        'uploads/' . $folder . '/' . $filename
    );

    if (!File::exists($path)) {
        $path = storage_path(
            'uploads/' . $folder . '/' . $filename
        );
    }

    if (!File::exists($path)) {
        $path = storage_path(
            'app/public/' . $folder . '/' . $filename
        );
    }

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)
        ->header('Content-Type', $type);
});


Route::get('/storage/{folder}/{filename}', function ($folder, $filename) {

    $path = public_path(
        'uploads/' . $folder . '/' . $filename
    );

    if (!File::exists($path)) {
        $path = storage_path(
            'uploads/' . $folder . '/' . $filename
        );
    }

    if (!File::exists($path)) {
        $path = storage_path(
            'app/public/' . $folder . '/' . $filename
        );
    }

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)
        ->header('Content-Type', $type);
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | MASYARAKAT
    |--------------------------------------------------------------------------
    */

    Route::prefix('masyarakat')
        ->middleware('role:masyarakat')
        ->name('masyarakat.')
        ->group(function () {

            // Dashboard Masyarakat
            Route::get(
                '/dashboard',
                [MasyarakatDashboard::class, 'index']
            )->name('dashboard');


            // Get Desa berdasarkan Kecamatan
            Route::get('/get-desas', function (
                Illuminate\Http\Request $request
            ) {

                $kecamatanId = $request->kecamatan_id;

                return response()->json(
                    App\Models\Desa::where(
                        'kecamatan_id',
                        $kecamatanId
                    )->get()
                );

            })->name('get.desas');


            // CRUD Laporan Masyarakat
            Route::resource(
                'laporan',
                MasyarakatLaporanController::class
            );


            // Route Rating
            Route::post(
                '/laporan/{laporan}/rating',
                [MasyarakatLaporanController::class, 'storeRating']
            )->name('laporan.rating');

        });


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard Admin
            Route::get(
                '/dashboard',
                [AdminDashboard::class, 'index']
            )->name('dashboard');


            // Export laporan PDF
            Route::get(
                'laporan/export/pdf',
                [AdminLaporanController::class, 'exportPdf']
            )->name('laporan.export.pdf');


            // Export laporan Excel
            Route::get(
                'laporan/export/excel',
                [AdminLaporanController::class, 'exportExcel']
            )->name('laporan.export.excel');


            // CRUD laporan
            Route::resource(
                'laporan',
                AdminLaporanController::class
            );


            // Verifikasi laporan
            Route::post(
                'laporan/{laporan}/verifikasi',
                [AdminLaporanController::class, 'verifikasi']
            )->name('laporan.verifikasi');


            // Tolak laporan
            Route::post(
                'laporan/{laporan}/tolak',
                [AdminLaporanController::class, 'tolak']
            )->name('laporan.tolak');


            // Tugaskan laporan
            Route::post(
                'laporan/{laporan}/tugaskan',
                [AdminLaporanController::class, 'tugaskan']
            )->name('laporan.tugaskan');


            // Ganti petugas
            Route::post(
                'laporan/{laporan}/ganti-petugas',
                [AdminLaporanController::class, 'gantiPetugas']
            )->name('laporan.ganti-petugas');


            // Validasi akhir
            Route::post(
                'laporan/{laporan}/validasi-akhir',
                [AdminLaporanController::class, 'validasiAkhir']
            )->name('laporan.validasi-akhir');


            // Validasi pekerjaan
            Route::get(
                'validasi-pekerjaan',
                [AdminLaporanController::class, 'validasiPekerjaan']
            )->name('validasi-pekerjaan');


            // Kategori Sampah
            Route::resource(
                'kategori-sampah',
                KategoriSampahController::class
            );


            // Manajemen Wilayah
            Route::resource(
                'wilayah',
                WilayahController::class
            );


            // Petugas
            Route::resource(
                'petugas',
                PetugasController::class
            );


            // Berita
            Route::resource(
                'berita',
                BeritaController::class
            );


            // Monitoring
            Route::get(
                'monitoring',
                [MonitoringController::class, 'index']
            )->name('monitoring.index');


            // Statistik
            Route::get(
                'statistik',
                [StatistikController::class, 'index']
            )->name('statistik.index');


            // Activity Log
            Route::get(
                'activity-log',
                [ActivityLogController::class, 'index']
            )->name('activity-log.index');

        });


    /*
    |--------------------------------------------------------------------------
    | PETUGAS
    |--------------------------------------------------------------------------
    */

    Route::prefix('petugas')
        ->middleware('role:petugas')
        ->name('petugas.')
        ->group(function () {

            // Dashboard Petugas
            Route::get(
                '/dashboard',
                [PetugasDashboard::class, 'index']
            )->name('dashboard');


            // Tugas
            Route::resource(
                'tugas',
                TugasController::class
            );


            // Update status tugas
            Route::post(
                'tugas/{tugas}/update-status',
                [TugasController::class, 'updateStatus']
            )->name('tugas.update-status');

        });

});