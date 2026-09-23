<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', [LandingController::class, 'index'])
    ->name('landing');

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

    // Forgot Password
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyEmail'])
        ->name('password.verify');

    Route::get('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])
        ->name('password.update');
});

// Logout
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard
Route::middleware(['auth', 'activity.log'])->group(function () {

    // Dashboard Masyarakat
    Route::get('/masyarakat/dashboard', function () {
        return view('masyarakat.dashboard');
    })->name('masyarakat.dashboard');

    // Buat Laporan Sampah
    Route::get('/masyarakat/laporan/create', [
        \App\Http\Controllers\LaporanSampahController::class,
        'create'
    ])->name('masyarakat.laporan.create');

    Route::post('/masyarakat/laporan', [
        \App\Http\Controllers\LaporanSampahController::class,
        'store'
    ])->name('masyarakat.laporan.store');

    // Update Status Laporan oleh Petugas
    Route::patch('/petugas/laporan/{laporan}/status', [
        \App\Http\Controllers\LaporanSampahController::class,
        'updateStatus'
    ])->name('petugas.laporan.update-status');

    // Dashboard Petugas
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');

    // Dashboard Admin DLH
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Log Aktivitas Sistem
    Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])
        ->name('admin.activity-log.index');

    // Master Kategori Sampah
    Route::resource(
        '/admin/kategori-sampah',
        \App\Http\Controllers\KategoriSampahController::class
    )->names('admin.kategori-sampah');

});