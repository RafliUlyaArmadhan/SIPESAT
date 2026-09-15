<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Masyarakat - SIPESAT</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            color: #333;
        }

        .navbar {
            background: #ffffff;
            padding: 18px 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            color: #166534;
        }

        .logout {
            text-decoration: none;
            background: #dc3545;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .container {
            padding: 40px;
        }

        .welcome {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            margin-bottom: 25px;
        }

        .welcome h1 {
            margin-top: 0;
            color: #166534;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        .menu-card h3 {
            margin-top: 0;
            color: #166534;
        }

        .menu-card p {
            color: #666;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            background: #166534;
            color: white;
            padding: 11px 18px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <h2>SIPESAT</h2>

        <a href="{{ route('logout') }}" class="logout">
            Logout
        </a>

    </div>


    <!-- CONTENT -->
    <div class="container">

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif


        <!-- WELCOME -->
        <div class="welcome">

            <h1>Dashboard Masyarakat 👤</h1>

            <p>
                Selamat datang,
                <strong>{{ auth()->user()->name }}</strong>.
            </p>

            <p>
                Anda login sebagai
                <strong>{{ auth()->user()->role->label }}</strong>.
            </p>

        </div>


        <!-- MENU -->
        <div class="menu">

            <!-- BUAT LAPORAN -->
            <div class="menu-card">

                <h3>📝 Buat Laporan Sampah</h3>

                <p>
                    Laporkan permasalahan sampah yang ditemukan
                    di lingkungan sekitar Anda.
                </p>

                <a
                    href="{{ route('masyarakat.laporan.create') }}"
                    class="btn"
                >
                    Buat Laporan
                </a>

            </div>


            <!-- INFORMASI -->
            <div class="menu-card">

                <h3>📋 Informasi Laporan</h3>

                <p>
                    Laporan yang Anda kirim akan diproses oleh
                    petugas/admin untuk dilakukan verifikasi.
                </p>

            </div>


            <!-- STATUS -->
            <div class="menu-card">

                <h3>🔍 Status Laporan</h3>

                <p>
                    Status laporan dapat digunakan untuk mengetahui
                    perkembangan laporan yang telah dikirim.
                </p>

            </div>

        </div>

    </div>

</body>
</html>