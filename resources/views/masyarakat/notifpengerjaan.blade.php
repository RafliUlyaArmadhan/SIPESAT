<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>
        {{ $tahap === 'selesai'
            ? 'Penanganan Selesai'
            : 'Penanganan Dimulai' }}
        - SIPESAT
    </title>
</head>

<body>

    <h2>
        Halo, {{ $laporan->user->name ?? 'Masyarakat' }}!
    </h2>

    @if($tahap === 'selesai')

        <p>
            Kami ingin memberitahukan bahwa petugas
            <b>{{ $petugas->user->name ?? '-' }}</b>
            telah <b>menyelesaikan penanganan</b>
            laporan sampah yang Anda kirimkan.
        </p>

        <p>
            Laporan Anda saat ini berstatus
            <b>Menunggu Validasi Akhir</b>.
        </p>

    @else

        <p>
            Kami ingin memberitahukan bahwa petugas
            <b>{{ $petugas->user->name ?? '-' }}</b>
            telah <b>mulai menangani</b>
            laporan sampah yang Anda kirimkan.
        </p>

        <p>
            Laporan Anda saat ini berstatus
            <b>Sedang Ditangani</b>.
        </p>

    @endif


    <table border="1" cellpadding="8" cellspacing="0" width="100%">

        <tr>
            <td>
                <b>Kode Laporan</b>
            </td>

            <td>
                {{ $laporan->kode_laporan }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Judul Laporan</b>
            </td>

            <td>
                {{ $laporan->judul_laporan }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Petugas</b>
            </td>

            <td>
                {{ $petugas->user->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Kategori Sampah</b>
            </td>

            <td>
                {{ $laporan->kategoriSampah->nama_kategori ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Lokasi</b>
            </td>

            <td>

                {{ $laporan->desa->nama_desa ?? '-' }},
                {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}

                <br>

                {{ $laporan->alamat_lengkap ?? '-' }}

            </td>
        </tr>

        <tr>
            <td>
                <b>Waktu Mulai</b>
            </td>

            <td>
                {{ optional($dokumentasi?->waktu_mulai)->format('d-m-Y H:i') ?? '-' }}
            </td>
        </tr>


        @if($tahap === 'selesai')

            <tr>
                <td>
                    <b>Waktu Selesai</b>
                </td>

                <td>
                    {{ optional($dokumentasi?->waktu_selesai)->format('d-m-Y H:i') ?? '-' }}
                </td>
            </tr>

            <tr>
                <td>
                    <b>Catatan Petugas</b>
                </td>

                <td>
                    {{ $dokumentasi->catatan_pekerjaan ?? '-' }}
                </td>
            </tr>

        @endif

    </table>


    <br>

    <p>
        Silakan login ke aplikasi SIPESAT
        untuk melihat perkembangan laporan Anda.
    </p>

    <p>
        Terima kasih telah menggunakan SIPESAT.
    </p>

    <hr>

    <small>
        Email ini dikirim secara otomatis oleh sistem SIPESAT.
    </small>

</body>
</html>
