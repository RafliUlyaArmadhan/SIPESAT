<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password SIPESAT</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f5f6fa;
    font-family: Arial, sans-serif;
">

<div style="
    max-width: 600px;
    margin: 40px auto;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
">

    <h2 style="margin-top: 0;">
        Reset Password SIPESAT 🔐
    </h2>

    <p>Halo,</p>

    <p>
        Kami menerima permintaan untuk mengatur ulang password
        akun SIPESAT Anda.
    </p>

    <p>
        Silakan klik tombol di bawah ini untuk membuat password baru:
    </p>

    <div style="text-align: center; margin: 30px 0;">

        <a href="{{ $resetUrl }}"
           style="
                display: inline-block;
                padding: 14px 25px;
                background-color: #0d6efd;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: bold;
           ">
            Reset Password
        </a>

    </div>

    <p>
        <strong>Perhatian:</strong>
        Link reset password ini hanya berlaku selama
        <strong>5 menit</strong>.
    </p>

    <p>
        Jika link sudah expired, silakan melakukan permintaan
        reset password kembali.
    </p>

    <p>
        Jika Anda tidak merasa melakukan permintaan reset password,
        abaikan email ini.
    </p>

    <hr style="
        border: 0;
        border-top: 1px solid #eee;
        margin: 30px 0;
    ">

    <p style="font-size: 13px; color: #777;">
        Email ini dikirim secara otomatis oleh sistem SIPESAT.
    </p>

</div>

</body>
</html>
