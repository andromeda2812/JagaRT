@extends('layouts.app')

@section('title', 'Beranda')

@section('navbar')
    @include('partials.navbar-home') 
@endsection

@section('content')
    <section class="hero">
        <div class="hero-content">
            <h2><b>Satu klik untuk keamanan bersama</b></h2>
            <p>
                <span class="text-highlight">JAGA</span>RT hadir untuk mendukung ronda malam dan laporan keamanan warga RT 04 secara online.
            </p>
            <br><br><br>
            <a href="{{ route('login') }}" class="btn-hero">GABUNG SEKARANG</a>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <div class="card-box">
                <div class="service-card light">
                    <div class="icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h4>Jadwal Ronda</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <a href="#">Lihat Jadwal Ronda →</a>
                </div>

                <div class="service-card red">
                    <div class="icon"><i class="fa-solid fa-bell"></i></div>
                    <h4>Absensi Ronda</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <a href="#">Absen Sekarang →</a>
                </div>

                <div class="service-card dark">
                    <div class="icon"><i class="fa-solid fa-user-shield"></i></div>
                    <h4>Laporan Kejadian</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <a href="#">Buat Laporan Kejadian →</a>
                </div>
            </div>
        </div>
    </section>

    <section class="about" id="tentang">
        <div class="about-container">
            <div class="about-image">
                <img src="{{ asset('image/jagaRT.png') }}" alt="Tentang Kami">
            </div>
            <div class="about-text">
                <h2>Tentang <span class="text-highlight">JagaRT</span></h2>
                <p>
                    JagaRT adalah sistem keamanan lingkungan berbasis digital yang dirancang untuk membantu warga dalam memantau ronda, kejadian, serta informasi penting di lingkungan RT.
                </p>
                <a href="#hubungi" class="btn-about">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <section class="contact" id="hubungi"></section>
@endsection