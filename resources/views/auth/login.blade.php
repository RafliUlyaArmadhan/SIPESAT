@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
    /* ================================
       LOGIN SIPESAT
       ================================ */

    .login-page {
        min-height: 100vh;
        background: #F6F7F5;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* LEFT SIDE */
    .login-left {
        background: #1F6E43 !important;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        color: #ffffff;
    }

    .login-left::before {
        content: "";
        position: absolute;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        top: -120px;
        left: -120px;
    }

    .login-left::after {
        content: "";
        position: absolute;
        width: 450px;
        height: 450px;
        background: rgba(0, 0, 0, 0.08);
        border-radius: 50%;
        bottom: -200px;
        right: -150px;
    }

    .login-brand {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 520px;
    }

    .login-brand h1 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 48px;
        margin-bottom: 25px;
    }

    .login-brand h1 i {
        color: #7FB069;
    }

    .login-brand p {
        font-size: 17px;
        line-height: 1.8;
        opacity: 0.85;
        margin-bottom: 40px;
    }

    .login-icon-box {
        width: 220px;
        height: 180px;
        margin: auto;
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.20);
        border-radius: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(10px);
    }

    .login-icon-box i {
        font-size: 90px;
        color: rgba(255,255,255,0.9);
    }

    /* RIGHT SIDE */
    .login-right {
        min-height: 100vh;
        background: #F6F7F5;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .login-card {
        width: 100%;
        max-width: 470px;
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #E2E5E1;
        box-shadow: 0 8px 30px rgba(31, 42, 36, 0.08);
    }

    .login-card-body {
        padding: 45px;
    }

    .mobile-logo {
        color: #1F6E43;
        font-weight: 800;
        font-size: 28px;
    }

    .mobile-logo i {
        color: #7FB069;
    }

    .back-home {
        color: #6B7280;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .back-home:hover {
        color: #1F6E43;
    }

    .login-title {
        color: #1F2A24;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .login-description {
        color: #6B7280;
        margin-bottom: 30px;
    }

    .login-label {
        color: #1F2A24;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .login-input {
        background: #F6F7F5 !important;
        border: 1px solid #E2E5E1 !important;
        border-radius: 10px !important;
        min-height: 50px;
        padding: 12px 15px;
        color: #1F2A24;
    }

    .login-input:focus {
        border-color: #1F6E43 !important;
        box-shadow: 0 0 0 3px rgba(31, 110, 67, 0.10) !important;
    }

    .password-group .login-input {
        border-right: 0 !important;
        border-radius: 10px 0 0 10px !important;
    }

    .password-toggle {
        background: #F6F7F5 !important;
        border: 1px solid #E2E5E1 !important;
        border-left: 0 !important;
        color: #6B7280 !important;
        border-radius: 0 10px 10px 0 !important;
    }

    .forgot-password {
        color: #1F6E43;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .forgot-password:hover {
        color: #16502F;
    }

    .captcha-box {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .captcha-image {
        border: 1px solid #E2E5E1;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
    }

    .captcha-refresh {
        width: 42px;
        height: 42px;
        border-radius: 8px;
    }

    .login-button {
        width: 100%;
        background: #1F6E43 !important;
        border: none !important;
        color: #ffffff !important;
        border-radius: 12px !important;
        padding: 14px !important;
        font-size: 16px;
        font-weight: 700;
        transition: 0.2s;
    }

    .login-button:hover {
        background: #16502F !important;
        transform: translateY(-1px);
    }

    .register-text {
        color: #6B7280;
        font-size: 14px;
    }

    .register-link {
        color: #1F6E43;
        text-decoration: none;
        font-weight: 700;
    }

    .register-link:hover {
        color: #16502F;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .login-right {
            min-height: 100vh;
            padding: 25px;
        }

        .login-card-body {
            padding: 35px 25px;
        }
    }

    @media (max-width: 576px) {
        .login-right {
            padding: 15px;
        }

        .login-card-body {
            padding: 30px 20px;
        }
    }
</style>


<div class="container-fluid p-0 login-page">

    <div class="row g-0">

        <!-- =========================================
             BAGIAN KIRI
             ========================================= -->
        <div class="col-lg-6 d-none d-lg-flex login-left align-items-center justify-content-center p-5">

            <div class="login-brand">

                <h1>
                    <i class="fa-solid fa-leaf"></i>
                    SIPESAT
                </h1>

                <p>
                    Sistem Pengelolaan Sampah Terpadu yang memudahkan
                    masyarakat dan petugas dalam menjaga kebersihan
                    lingkungan bersama.
                </p>

                <div class="login-icon-box">
                    <i class="fa-solid fa-recycle"></i>
                </div>

            </div>

        </div>


        <!-- =========================================
             BAGIAN KANAN
             ========================================= -->
        <div class="col-lg-6 login-right">

            <div class="login-card">

                <div class="login-card-body">

                    <!-- Logo Mobile -->
                    <div class="d-lg-none text-center mb-4">
                        <div class="mobile-logo">
                            <i class="fa-solid fa-leaf"></i>
                            SIPESAT
                        </div>
                    </div>


                    <!-- Header -->
                    <div class="mb-4">

                        <a href="{{ url('/') }}" class="back-home d-inline-block mb-4">
                            <i class="fa-solid fa-arrow-left me-1"></i>
                            Kembali ke Beranda
                        </a>

                        <h3 class="login-title">
                            Selamat Datang 👋
                        </h3>

                        <p class="login-description">
                            Silakan masuk ke akun Anda untuk melanjutkan.
                        </p>

                    </div>


                    <!-- Pesan Error -->
                    @if(session('error'))
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif


                    <!-- FORM LOGIN -->
                    <form action="{{ route('login') }}" method="POST">

                        @csrf


                        <!-- EMAIL -->
                        <div class="mb-4">

                            <label class="form-label login-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control login-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                                autofocus
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- PASSWORD -->
                        <div class="mb-4">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <label class="form-label login-label mb-0">
                                    Password
                                </label>

                                <a
                                    href="{{ route('password.request') }}"
                                    class="forgot-password"
                                >
                                    Lupa password?
                                </a>

                            </div>


                            <div class="input-group password-group">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control login-input"
                                    placeholder="••••••••"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn password-toggle toggle-password"
                                    data-target="#password"
                                >
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>

                            </div>

                        </div>


                        <!-- CAPTCHA -->
                        <div class="mb-4">

                            <label class="form-label login-label">
                                Captcha
                            </label>

                            <div class="captcha-box">

                                <div class="captcha-image">
                                    {!! captcha_img('flat') !!}
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary captcha-refresh"
                                    onclick="refreshCaptcha()"
                                >
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>

                            </div>

                            <input
                                type="text"
                                name="captcha"
                                class="form-control login-input @error('captcha') is-invalid @enderror"
                                placeholder="Masukkan kode captcha di atas"
                                required
                            >

                            @error('captcha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- INGAT SAYA -->
                        <div class="mb-4 form-check">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="remember"
                                name="remember"
                            >

                            <label
                                class="form-check-label register-text"
                                for="remember"
                            >
                                Ingat saya
                            </label>

                        </div>


                        <!-- BUTTON LOGIN -->
                        <button
                            type="submit"
                            class="btn login-button mb-4"
                        >
                            Masuk Sekarang
                        </button>


                        <!-- REGISTER -->
                        <div class="text-center">

                            <p class="register-text mb-0">
                                Belum punya akun?

                                <a
                                    href="{{ route('register') }}"
                                    class="register-link"
                                >
                                    Daftar di sini
                                </a>
                            </p>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================
     JAVASCRIPT
     ========================================= -->

<script>

    // Toggle Password
    document.addEventListener('DOMContentLoaded', function () {

        const buttons = document.querySelectorAll('.toggle-password');

        buttons.forEach(function(button) {

            button.addEventListener('click', function() {

                const target = document.querySelector(
                    this.getAttribute('data-target')
                );

                const icon = this.querySelector('i');

                if (target.type === 'password') {

                    target.type = 'text';

                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');

                } else {

                    target.type = 'password';

                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');

                }

            });

        });

    });


    // Refresh Captcha
    function refreshCaptcha() {

        const captchaImage = document.querySelector('.captcha-image img');

        if (captchaImage) {

            captchaImage.src = '/captcha/flat?' + Math.random();

        }

    }

</script>


<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {

        @if(session('success'))

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonColor: '#1F6E43'
            });

        @endif


        @if(session('sweet_error'))

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('sweet_error')),
                confirmButtonColor: '#1F6E43'
            });

        @endif

    });

</script>

@endsection