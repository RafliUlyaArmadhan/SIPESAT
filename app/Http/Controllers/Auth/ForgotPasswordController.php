<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman lupa password
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Memeriksa email dan mengirim link reset password
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Jika email tidak terdaftar
        if (!$user) {
            return back()->with(
                'sweet_error',
                'Email tidak terdaftar pada sistem.'
            );
        }

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->delete();

        // Buat token baru
        $token = Str::random(64);

        // Simpan token dalam bentuk hash
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        // Buat URL reset password
        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        // Kirim email
        Mail::to($user->email)->send(
            new ResetPasswordMail($resetUrl)
        );

        return back()->with(
            'success',
            'Link reset password telah dikirim ke email Anda. Link berlaku selama 5 menit.'
        );
    }

    /**
     * Menampilkan form password baru
     */
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        if (!$token || !$email) {
            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password tidak valid.'
                );
        }

        // Cari token berdasarkan email
        $resetData = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetData) {
            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password tidak valid atau sudah digunakan.'
                );
        }

        // Cek masa berlaku 5 menit
        if (
            Carbon::parse($resetData->created_at) //membaca waktu token di buat
                ->addMinutes(5) //menambahkan 5 menit
                ->isPast() //mengecek apakah batas waktu tersebut sudah lewat.
        ) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password sudah expired. Silakan meminta link baru.'
                );
        }

        // Cek token
        if (!Hash::check($token, $resetData->token)) {
            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password tidak valid.'
                );
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Menyimpan password baru
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cari token
        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetData) {
            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password tidak valid atau sudah digunakan.'
                );
        }

        // Cek expired 5 menit
        if (
            Carbon::parse($resetData->created_at)
                ->addMinutes(5)
                ->isPast()
        ) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password sudah expired. Silakan meminta link baru.'
                );
        }

        // Cek token
        if (!Hash::check($request->token, $resetData->token)) {
            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Link reset password tidak valid.'
                );
        }

        // Cari user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->with(
                    'sweet_error',
                    'Pengguna tidak ditemukan.'
                );
        }

        // Simpan password baru
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token agar hanya bisa digunakan sekali
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with(
            'success',
            'Password berhasil diubah. Silakan login dengan password baru.'
        );
    }
}