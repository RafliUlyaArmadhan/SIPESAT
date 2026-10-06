<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>
        {{ $tahap === 'selesai' ? 'Penanganan Selesai' : 'Penanganan Dimulai' }} - SIPESAT
    </title>
</head>
<body>

    <h2>Halo, Admin!</h2>

    @if($tahap === 'selesai')
        <p>
            Petugas <b>{{ $petugas->user->name ?? '-' }}</b> telah
            <b>menyelesaikan penanganan</b> laporan sampah berikut.
            Laporan kini berstatus <b>Menunggu Validasi Akhir</b>
            dan memerlukan pemeriksaan Anda.
        </p>
    @else
        <p>
            Petugas <b>{{ $petugas->user->name ?? '-' }}</b> telah
            <b>mulai menangani</b> laporan sampah berikut.
            Laporan kini berstatus <b>Sedang Ditangani</b>.
        </p>
    @endif

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
            <td><b>Petugas</b></td>
            <td>
                {{ $petugas->user->name ?? '-' }}
                @if(!empty($petugas->nip))
                    (NIP: {{ $petugas->nip }})
                @endif
            </td>
        </tr>
        <tr>
            <td><b>Pelapor</b></td>
            <td>{{ $laporan->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><b>Kategori</b></td>
            <td>{{ $laporan->kategoriSampah->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <td><b>Lokasi</b></td>
            <td>
                {{ $laporan->desa->nama_desa ?? '-' }},
                {{ $laporan->kecamatan->nama_kecamatan ?? '-' }}
                <br>
                {{ $laporan->alamat_lengkap ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><b>Waktu Mulai</b></td>
            <td>
                {{ optional($dokumentasi?->waktu_mulai)->format('d-m-Y H:i') ?? '-' }}
            </td>
        </tr>

        @if($tahap === 'selesai')
            <tr>
                <td><b>Waktu Selesai</b></td>
                <td>
                    {{ optional($dokumentasi?->waktu_selesai)->format('d-m-Y H:i') ?? '-' }}
                </td>
            </tr>
            <tr>
                <td><b>Catatan Petugas</b></td>
                <td>{{ $dokumentasi->catatan_pekerjaan ?? '-' }}</td>
            </tr>
        @endif
    </table>

    <br>

    <p>
        @if($tahap === 'selesai')
            Silakan login ke SIPESAT untuk memeriksa dokumentasi
            sebelum/sesudah dan melakukan validasi akhir:
            <br>
            <a href="{{ route('admin.laporan.show', $laporan->id) }}">
                Buka Detail &amp; Validasi Laporan
            </a>
        @else
            Anda dapat memantau progres penanganan melalui:
            <br>
            <a href="{{ route('admin.laporan.show', $laporan->id) }}">
                Buka Detail Laporan
            </a>
        @endif
    </p>

    <p>Terima kasih.</p>

    <hr>

    <small>Email ini dikirim otomatis oleh sistem SIPESAT.</small>

</body>
</html>