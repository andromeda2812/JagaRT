@extends('layouts.app')

@section('title', 'Dashboard Admin | JagaRT')

@section('navbar')
    @include('partials.navbar-admin') 
@endsection

@section('content')
    <section class="d-flex align-items-center text-center" style="background-color: #ffffff;">
        <div class="container py-5">
            <h1 class="fw-bold text-dark mb-3">Selamat Datang, <span class="text-highlight">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</span></h1>
            <p class="text-secondary fs-5">Pantau jadwal ronda, lakukan absen, buat laporan kejadian di lingkungan RT-mu dengan mudah.</p>
        </div>
    </section>

@endsection