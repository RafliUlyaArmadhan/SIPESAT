<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
            "captcha" => ["required", "captcha"]
        ], [
            "captcha.captcha" => "Kode captcha tidak sesuai, silakan coba lagi."
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();

            // Catat aktivitas login
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Login berhasil',
                'module' => 'Autentikasi',
                'description' => 'Pengguna berhasil login ke dalam sistem.',
                'ip_address' => $request->ip(),
            ]);

            $role = auth()->user()->role->name;

            return redirect()->route($role . ".dashboard");
        }

        return back()
            ->withErrors(["email" => "Kredensial tidak cocok."])
            ->onlyInput("email");
    }

    public function logout(Request $request)
    {
        // Simpan data pengguna sebelum logout
        $userId = auth()->id();

        if ($userId) {
            ActivityLog::create([
                'user_id' => $userId,
                'activity' => 'Logout',
                'module' => 'Autentikasi',
                'description' => 'Pengguna keluar dari sistem.',
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}