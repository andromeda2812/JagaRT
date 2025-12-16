@extends('layouts.blank')

@section('title', 'Masuk - JagaRT')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .login-box {
        background-color: #ffffff;
        border-radius: 18px;
        padding: 20px 25px;
        width: 340px;
        margin-right: 205px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        margin-top: 10px;
    }

    .login-box h6 {
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 400;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .login-box h5 {
        font-weight: 500;
        margin-bottom: 14px;
        color: #111827;
    }

    /* Floating Label Input (SAMAKAN DENGAN REGISTER) */
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
        border-color: #ff9977 !important;
        box-shadow: none;
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

    /* Saat input terisi atau difokuskan */
    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label {
        top: -9px;
        left: 3px;
        font-size: 11.5px;
        color: #ff9977;
        background-color: #fff;
        padding: 0 3px;
    }

    .btn-custom {
        background-color: #212121;
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
        color: #212121;
        font-weight: 600;
        text-decoration: none;
        font-size: 13.5px;
    }

    .text-link:hover {
        text-decoration: underline;
    }

    /* Brand kiri agar sama dengan halaman register */
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
        .login-box {
            margin: 0 15px;
            width: 100%;
            max-width: 320px;
            padding: 20px;
        }
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

<div class="login-box">
    <h6>Selamat Datang</h6>
    <h5>Masuk Ke Akun Anda</h5>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.perform') }}">
        @csrf

        <div class="form-group">
            <input type="text" id="username" name="username" class="form-control"
                placeholder=" " required value="{{ old('username') }}">
            <label for="username" class="form-label">Username</label>
        </div>

        <div class="form-group">
            <input type="password" id="password" name="password" class="form-control"
                placeholder=" " required>
            <label for="password" class="form-label">Kata Sandi</label>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <!-- <input type="checkbox" id="remember" name="remember"> -->
                <!-- <label for="remember" class="ms-1">Ingat saya</label> -->
            </div>
            <a href="#" class="text-link" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">
                Lupa kata sandi?
            </a>
        </div>

        <button type="submit" class="btn btn-dark w-100 mb-3 fw-semibold">Selanjutnya</button>
    </form>

    <div class="text-center">
        <p>Belum punya akun? <a href="{{ route('register') }}" class="text-link">Daftar Sekarang</a></p>
    </div>
</div>

<!-- Modal Lupa Password -->
<div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 18px; padding: 10px 5px;">
      
      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="modal-header border-0">
          <h5 class="modal-title fw-semibold">Reset Kata Sandi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body px-4 pb-4">
          <p class="text-muted mb-3" style="font-size: 13px;">
            Masukkan email terdaftar untuk menerima link reset password.
          </p>

          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder=" " required>
            <label class="form-label">Email</label>
          </div>

          <button type="submit" class="btn btn-dark w-100 fw-semibold mt-3">
            Kirim Link Reset
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewFoto').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@push('scripts')
@if (session('status_inactive'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Akun Tidak Aktif',
                text: "{{ session('message') }}",
                confirmButtonColor: '#A42421'
            });
        });
    </script>
@endif

@if (session('reset_success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Link reset password telah dikirim ke email Anda.',
        confirmButtonColor: '#212121'
    });
});
</script>
@endif

@if (session('reset_done'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: 'Password berhasil diubah. Silakan login.',
    confirmButtonColor: '#212121'
});
</script>
@endif
@endpush

@endsection