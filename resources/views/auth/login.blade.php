@extends('layouts.blank')

@section('title', 'Login - JagaRT')

@section('styles')
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
        border-radius: 20px;
        padding: 40px 35px;
        width: 400px;
        margin-right: 80px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

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

    .text-highlight {
        color: #ff9977;
    }

    @media (max-width: 992px) {
        body {
            justify-content: center;
        }
        .brand-box {
            display: none;
        }
        .login-box {
            margin: 0 20px;
            width: 100%;
            max-width: 400px;
        }
    }
</style>
@endsection

@section('content')
<div class="brand-box">
    <img src="{{ asset('image/jagaRT.png') }}" alt="Logo">
    <h2><span class="text-highlight">Jaga</span>RT</h2>
    <p>
        Situs Keamanan RT.04 yang membantu warga memantau ronda, absensi,
        dan laporan kejadian secara cepat dan aman.
    </p>
</div>

<div class="login-box">
    <h6 class="text-uppercase text-secondary fw-semibold mb-1">Selamat Datang</h6>
    <h5 class="fw-bold text-dark mb-4">Masuk Ke Akun Anda</h5>


    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login.perform') }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username anda" required value="{{ old('username') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" class="ms-1">Ingat saya</label>
            </div>
            <a href="#" class="text-link">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn btn-dark w-100 mb-3 fw-semibold">Selanjutnya</button>
    </form>
</div>
@endsection