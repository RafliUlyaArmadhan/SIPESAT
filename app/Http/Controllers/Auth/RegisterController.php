<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'captcha' => 'required|captcha',
        ], [
            'captcha.captcha' => 'Kode captcha tidak sesuai, silakan coba lagi.',
        ]);

        // Ambil role masyarakat
        $role = Role::where('name', 'masyarakat')->first();

        // Pastikan role masyarakat tersedia
        if (!$role) {
            return back()->with(
                'sweet_error',
                'Role masyarakat belum tersedia.'
            );
        }

        // Membuat akun baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        // Arahkan ke halaman login
        return redirect()->route('login')->with(
            'success',
            'Akun berhasil dibuat. Silakan login menggunakan akun baru Anda.'
        );
    }
}