<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Sampah Selesai</title>
</head>
<body>
    <h2>Laporan Sampah Telah Selesai Ditangani</h2>

    <p>Halo, {{ $laporan->user->name }}.</p>

    <p>
        Laporan sampah yang Anda kirimkan telah selesai ditangani oleh petugas.
    </p>

    <p><strong>Detail Laporan:</strong></p>

    <ul>
        <li><strong>Kode Laporan:</strong> {{ $laporan->kode_laporan }}</li>
        <li><strong>Judul:</strong> {{ $laporan->judul_laporan }}</li>
        <li><strong>Lokasi:</strong> {{ $laporan->alamat_lengkap }}</li>
        <li><strong>Status:</strong> {{ $laporan->status }}</li>
    </ul>

    <p>
        Terima kasih telah berpartisipasi dalam menjaga kebersihan lingkungan.
    </p>

    <p>
        Salam,<br>
        <strong>SIPESAT</strong>
    </p>
</body>
</html>