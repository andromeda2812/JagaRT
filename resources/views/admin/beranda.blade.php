@extends('layouts.app')

@section('title', 'Beranda - JagaRT')

@section('content')

{{-- Sidebar Admin --}}
@include('partials.navbar-admin')

<style>
    body {
        background: #f7f9fc;
    }

    /* Konten halaman tidak melebar */
    .container {
        max-width: 700px;      /* dibatasi agar elegan */
        margin-left: auto;
        margin-right: auto;
        padding: 20px;
    }

    /* Box sambutan */
    .welcome-box {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 14px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    /* Quick menu jadi kolom ke bawah */
    .quick-menu {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 20px;
    }

    .menu-card {
        background: #ffffff;
        padding: 18px;
        border-radius: 12px;
        text-align: left;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        transition: 0.2s;
        cursor: pointer;
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1e3a8a;
        font-weight: 600;
        text-decoration: none;
    }

    .menu-card:hover {
        transform: translateX(4px);
        box-shadow: 0 5px 18px rgba(0,0,0,0.12);
    }

    .menu-card i {
        font-size: 28px;
        color: #1e3a8a;
    }

    /* info singkat */
    .welcome-box .row strong {
        font-weight: 600;
        display: block;
    }

    .welcome-box .text-muted {
        font-size: 14px;
    }

    /* Aktivitas */
    .activity-box {
        background: #ffffff;
        padding: 22px 26px;
        border-radius: 14px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        margin-top: 20px;
    }

    .title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #111827;
    }
</style>

<div class="container py-4">

    {{-- Welcome Box --}}
    <div class="welcome-box">
        <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }} 👋</h3>
        <p class="text-muted mb-0">
            Kelola keamanan dan aktivitas warga RT langsung dari panel admin JagaRT.
        </p>
    </div>

    {{-- Quick Access Menu --}}
    <div class="quick-menu">
        <a href="/admin/jadwal" class="menu-card">
            <i class="bi bi-calendar-check fs-3 mb-2"></i>
            <div class="fw-semibold">Jadwal Ronda</div>
        </a>

        <a href="/admin/absensi" class="menu-card">
            <i class="bi bi-fingerprint fs-3 mb-2"></i>
            <div class="fw-semibold">Absensi Ronda</div>
        </a>

        <a href="/admin/akun-warga" class="menu-card">
            <i class="bi bi-people fs-3 mb-2"></i>
            <div class="fw-semibold">Akun Warga</div>
        </a>

        <a href="#" class="menu-card">
            <i class="bi bi-exclamation-triangle fs-3 mb-2"></i>
            <div class="fw-semibold">Laporan Kejadian</div>
        </a>
    </div>

    {{-- Status Singkat --}}
    <div class="welcome-box">
        <h4 class="title">Info Singkat Hari Ini</h4>

        <div class="row">
            <div class="col-md-4 mb-3">
                <strong>Total Warga Terdaftar:</strong>
                <div class="text-muted">{{ $totalWarga ?? 0 }} orang</div>
            </div>

            <div class="col-md-4 mb-3">
                <strong>Petugas Ronda Aktif:</strong>
                <div class="text-muted">{{ $petugasAktif ?? 0 }} orang</div>
            </div>

            <div class="col-md-4 mb-3">
                <strong>Laporan Baru:</strong>
                <div class="text-muted">{{ $laporanBaru ?? 0 }} laporan</div>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="activity-box mt-3">
        <h4 class="title">Aktivitas Terbaru</h4>
        <p class="text-muted">Belum ada aktivitas terbaru.</p>
    </div>

</div>
@endsection
