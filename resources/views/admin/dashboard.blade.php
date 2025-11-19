@extends('layouts.app')

@section('title', 'Dashboard Admin | JagaRT')

@section('navbar')
    @include('partials.navbar-admin')
@endsection

@section('content')

{{-- Wrapper agar konten tidak ketutup sidebar --}}
<div class="main-content-admin">

    {{-- Bagian Sambutan --}}
    <section class="welcome-section">
        <div class="container-dashboard">
            <h1 class="fw-bold text-dark mb-2">
                Selamat Datang, 
                <span class="text-highlight">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</span>
            </h1>
            <p class="text-secondary fs-6">
                Pantau jadwal ronda, lakukan absen, dan buat laporan kejadian dengan lebih mudah.
            </p>
        </div>
    </section>

    {{-- GRID CHARTS --}}
    <div class="dashboard-grid-2">

        {{-- Jumlah Ronda --}}
        <div class="card-dashboard">
            <h4 class="section-title">Jumlah Ronda Perbulan</h4>
            <canvas id="chartRonda" class="chart-box"></canvas>
        </div>

        {{-- Absensi Terakhir --}}
        <div class="card-dashboard">
            <h4 class="section-title">Absensi Terakhir</h4>

            <div class="absensi-item">
                <span class="name">Rahmat</span>
                <span class="amount minus">-850</span>
            </div>
            <div class="absensi-item">
                <span class="name">Agung</span>
                <span class="amount plus">+2,500</span>
            </div>
            <div class="absensi-item">
                <span class="name">Zulkifly</span>
                <span class="amount plus">+5,400</span>
            </div>
        </div>

    </div>

    {{-- Grafik Kehadiran --}}
    <div class="card-dashboard mt-4">
        <h4 class="section-title">Grafik Kehadiran Warga</h4>
        <canvas id="chartKehadiran" height="105"></canvas>
    </div>

</div>


{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chart 1
    new Chart(document.getElementById('chartRonda'), {
        type: 'bar',
        data: {
            labels: ['Sat','Sun','Mon','Tue','Wed','Thu','Fri'],
            datasets: [
                {
                    label: 'Deposit',
                    data: [450, 320, 330, 480, 210, 500, 390],
                    backgroundColor: '#3b5bfd'
                },
                {
                    label: 'Withdraw',
                    data: [220, 150, 290, 350, 180, 300, 340],
                    backgroundColor: '#1cd4d4'
                }
            ]
        }
    });

    // Chart 2
    new Chart(document.getElementById('chartKehadiran'), {
        type: 'line',
        data: {
            labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
            datasets: [{
                data: [240, 400, 520, 780, 430, 320, 620],
                borderColor: '#3b5bfd',
                tension: 0.4
            }]
        }
    });
</script>

@endsection
