<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penugasan Baru SIPESAT</title>
</head>
<body>

    <h2>Halo, {{ $petugas->user->name ?? 'Petugas' }}!</h2>

    <p>
        Anda mendapatkan penugasan baru dari Admin untuk menangani laporan sampah berikut:
    </p>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <td><b>Kode Laporan</b></td>
            <td>{{ $laporan->kode_laporan }}</td>
        </tr>

        <tr>
            <td><b>Judul</b></td>
            <td>{{ $laporan->judul_laporan }}</td>
        </tr>

        <tr>
            <td><b>Kategori</b></td>
            <td>{{ $laporan->kategoriSampah->nama_kategori ?? '-' }}</td>
        </tr>

        <tr>
            <td><b>Kecamatan</b></td>
            <td>{{ $laporan->kecamatan->nama_kecamatan ?? '-' }}</td>
        </tr>

        <tr>
            <td><b>Desa</b></td>
            <td>{{ $laporan->desa->nama_desa ?? '-' }}</td>
        </tr>

        <tr>
            <td><b>Alamat</b></td>
            <td>{{ $laporan->alamat_lengkap ?? '-' }}</td>
        </tr>

        <tr>
            <td><b>Deskripsi</b></td>
            <td>{{ $laporan->deskripsi ?? '-' }}</td>
        </tr>

        <tr>
            <td><b>Tenggat Waktu</b></td>
            <td>
                @if($penugasan->tenggat_waktu)
                    {{ $penugasan->tenggat_waktu->format('d-m-Y H:i') }}
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td><b>Catatan Admin</b></td>
            <td>{{ $penugasan->catatan_admin ?? '-' }}</td>
        </tr>
    </table>

    <br>

    <p>
        Silakan login ke aplikasi SIPESAT untuk melihat detail penugasan dan mengunggah dokumentasi penanganan.
    </p>

    <p>
        Terima kasih.
    </p>

    <hr>

    <small>
        Email ini dikirim otomatis oleh sistem SIPESAT.
    </small>

</body>
</html>