<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Laporan Selesai</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <div style="max-width: 650px; margin: 30px auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <div style="background-color: #198754; padding: 25px; text-align: center; color: white;">
            <h2 style="margin: 0;">
                SIPESAT MAGETAN
            </h2>

            <p style="margin: 8px 0 0;">
                Pemberitahuan Penyelesaian Laporan
            </p>
        </div>

        {{-- Content --}}
        <div style="padding: 30px;">

            <p style="font-size: 16px;">
                Halo,
                <strong>
                    {{ $laporan->user->name ?? 'Masyarakat' }}
                </strong>
            </p>

            <p style="font-size: 15px; line-height: 1.6;">
                Kami informasikan bahwa laporan sampah yang Anda kirimkan
                melalui SIPESAT Magetan telah selesai ditangani dan
                telah divalidasi oleh Admin.
            </p>

            {{-- Status --}}
            <div style="
                background-color: #d1e7dd;
                border: 1px solid #badbcc;
                border-radius: 8px;
                padding: 15px;
                margin: 20px 0;
                text-align: center;
            ">
                <strong style="color: #0f5132; font-size: 18px;">
                    STATUS: SELESAI
                </strong>
            </div>

            {{-- Detail laporan --}}
            <h3 style="margin-top: 25px;">
                Detail Laporan
            </h3>

            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">

                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; width: 35%;">
                        <strong>Kode Laporan</strong>
                    </td>

                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        {{ $laporan->kode_laporan }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Judul Laporan</strong>
                    </td>

                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        {{ $laporan->judul_laporan }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Kategori</strong>
                    </td>

                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Kecamatan</strong>
                    </td>

                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Desa</strong>
                    </td>

                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        {{ $laporan->desa->nama_desa ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Alamat</strong>
                    </td>

                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        {{ $laporan->alamat_lengkap ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding: 10px;">
                        <strong>Tanggal Selesai</strong>
                    </td>

                    <td style="padding: 10px;">
                        {{ $laporan->completed_at ? $laporan->completed_at->format('d-m-Y H:i') : '-' }}
                    </td>
                </tr>

            </table>

            @if ($laporan->dokumentasiPenanganan && $laporan->dokumentasiPenanganan->catatan_pekerjaan)

                <div style="
                    margin-top: 25px;
                    padding: 15px;
                    background-color: #f8f9fa;
                    border-left: 4px solid #198754;
                ">

                    <strong>Catatan Penanganan:</strong>

                    <p style="margin-bottom: 0; line-height: 1.6;">
                        {{ $laporan->dokumentasiPenanganan->catatan_pekerjaan }}
                    </p>

                </div>

            @endif

            <p style="margin-top: 30px; line-height: 1.6;">
                Terima kasih telah menggunakan layanan SIPESAT Magetan
                dan ikut berpartisipasi dalam menjaga kebersihan lingkungan.
            </p>

            <p style="margin-top: 25px;">
                Salam,<br>

                <strong>
                    SIPESAT Magetan
                </strong>
            </p>

        </div>

        {{-- Footer --}}
        <div style="
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        ">
            Email ini dikirim secara otomatis oleh sistem SIPESAT Magetan.
            <br>
            Mohon tidak membalas email ini.
        </div>

    </div>

</body>
</html>