@extends('layouts.blank')

@section('content')

<style>
    body {
        margin: 0;
        font-family: 'Zen Kaku Gothic Antique', sans-serif;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                    url("/image/landing-page.png") center/cover no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .register-box {
        background-color: #ffffff;
        border-radius: 18px;
        padding: 20px 25px;
        width: 340px;
        margin-right: 205px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        margin-top: 10px;
    }

    .register-box h6 {
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 400;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .register-box h5 {
        font-weight: 500;
        margin-bottom: 14px;
        color: #111827;
    }

    /* Floating Label Input */
    .form-group {
        position: relative;
        margin-bottom: 14px;
    }

    .form-control {
        width: 100%;
        border: none;
        border-bottom: 2px solid #d1d5db;
        border-radius: 0;
        padding: 8px 4px 5px;
        font-size: 13.5px;
        background: transparent;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #ff9977;
    }

    .form-label {
        position: absolute;
        left: 4px;
        top: 8px;
        font-size: 13px;
        color: #9ca3af;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    /* saat aktif */
    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label {
        top: -9px;
        left: 3px;
        font-size: 11.5px;
        color: #ff9977;
        background-color: #fff;
        padding: 0 3px;
    }

    /* saat input aktif */
    .form-control:focus {
        outline: none;
        border-color: #ff9977 !important;
        box-shadow: none;
        transition: border-color 0.3s ease;
    }

    .btn-custom {
        background-color: #111827;
        color: #fff;
        width: 100%;
        border-radius: 6px;
        padding: 9px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
        font-size: 13.5px;
    }

    .btn-custom:hover {
        background-color: #000;
    }

    .text-link {
        color: #ff9977;
        font-weight: 600;
        text-decoration: none;
        font-size: 13.5px;
    }

    .text-link:hover {
        text-decoration: underline;
    }

    /* Bagian kiri (brand) */
    .brand-box {
        position: absolute;
        left: 80px;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        z-index: 2;
        max-width: 400px;
        padding-left: 50px;
    }

    .brand-box img {
        height: 60px;
        margin-bottom: 10px;
    }

    .brand-box h2 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .text-highlight {
        color: #ff9977;
    }

    .brand-box p {
        font-size: 15px;
        color: #e5e7eb;
    }

    @media (max-width: 992px) {
        body {
            justify-content: center;
        }
        .brand-box {
            display: none;
        }
        .register-box {
            margin: 0 15px;
            width: 100%;
            max-width: 320px;
            padding: 20px;
        }
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 0px; /* jarak antara logo dan teks */
    }

    .logo-img {
        height: 40px; /* atur sesuai kebutuhan, bisa 35–50px tergantung ukuran asli logo */
    }

    .logo-text {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
        font-size: 30px; /* sesuaikan agar sejajar dengan tinggi logo */
        color: #ffffff; /* atau warna sesuai tema kamu */
        line-height: 1;
    }
</style>

<div class="brand-box">
    <div class="logo-container">
        <img src="{{ asset('image/logo-muted.png') }}" alt="Logo" class="logo-img">
        <span class="logo-text">JagaRT</span>
    </div>
    <p>
        Situs Keamanan RT.04 yang membantu warga memantau ronda, absensi, 
        dan laporan kejadian secara cepat dan aman.
    </p>
</div>

<div class="register-box">
    <h6>Selamat Datang</h6>
    <h5>Buat Akun Baru</h5>

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder=" " required>
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
        </div>

        <div class="form-group">
            <input type="text" id="username" name="username" class="form-control" placeholder=" " required>
            <label for="username" class="form-label">Nama Pengguna</label>
        </div>

        <div class="form-group">
            <input type="email" id="email" name="email" class="form-control" placeholder=" " required>
            <label for="email" class="form-label">Email</label>
        </div>

        <div class="form-group">
            <input type="password" id="password" name="password" class="form-control" placeholder=" " required>
            <label for="password" class="form-label">Kata Sandi</label>
        </div>

        <div class="form-group">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder=" " required>
            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        </div>

        <div class="form-group">
            <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder=" ">
            <label for="no_hp" class="form-label">Nomor Telepon</label>
        </div>

        <div class="form-group">
            <textarea id="alamat" name="alamat" class="form-control" placeholder=" "></textarea>
            <label for="alamat" class="form-label">Alamat</label>
        </div>

        <button type="submit" class="btn-custom mb-3">Daftar</button>

        <div class="text-center">
            <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-link">Login Sekarang</a></p>
        </div>
    </form>
</div>
@endsection