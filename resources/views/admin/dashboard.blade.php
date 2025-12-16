@extends('layouts.admin')

@section('title', 'Dashboard Admin | JagaRT')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('navbar')
    @include('partials.sidebar-admin')
@endsection

@section('content')

<div class="main-content-admin">

    {{-- BAGIAN SAMBUTAN --}}
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

    {{-- SUMMARY CARDS --}}
    <div class="stats-grid">

        <div class="stat-card">
            <h5>Total Warga</h5>
            <h2>{{ $totalWarga }}</h2>
        </div>

        <div class="stat-card">
            <h5>Jadwal Bulan Ini</h5>
            <h2>{{ $totalJadwalBulan }}</h2>
        </div>

        <div class="stat-card">
            <h5>Laporan Baru</h5>
            <h2>{{ $laporanBaru }}</h2>
        </div>

        <div class="stat-card">
            <h5>Persentase Kehadiran</h5>
            <h2>{{ $persentaseHadir }}%</h2>
        </div>

    </div>

    {{-- GRID CHARTS --}}
    <div class="dashboard-grid-2 mt-4">

        {{-- CHART RONDA --}}
        <div class="card-dashboard">
            <h4 class="section-title">Jumlah Ronda Perbulan</h4>
            <canvas id="chartRonda" class="chart-box"></canvas>
        </div>

        {{-- ABSENSI TERBARU --}}
        <div class="card-dashboard">
            <h4 class="section-title">Absensi Terakhir</h4>

            @forelse ($absensiTerakhir as $item)
                <div class="absensi-item">
                    <span class="name">{{ $item->user->nama_lengkap }}</span>
                    <span class="{{ $item->status == 'hadir' ? 'plus' : 'minus' }}">
                        {{ strtoupper($item->status) }}
                    </span>
                </div>
            @empty
                <p class="text-muted">Belum ada data absensi</p>
            @endforelse
        </div>

    </div>

    {{-- GRAFIK KEHADIRAN --}}
    <div class="card-dashboard mt-4">
        <h4 class="section-title">Grafik Kehadiran Warga</h4>
        <canvas id="chartKehadiran"></canvas>
    </div>

</div>

@endsection


{{-- =============================== --}}
{{--   PERSIAPAN DATA CHART (AMAN)   --}}
{{-- =============================== --}}
@php
    $jsonLabelsRonda     = json_encode(array_values($labelsRonda));
    $jsonDataRonda       = json_encode(array_values($dataRonda));

    $jsonLabelsKehadiran = json_encode(array_values($labelsKehadiran));
    $jsonDataKehadiran   = json_encode(array_values($dataKehadiran));
@endphp


{{-- =============================== --}}
{{--        SCRIPT CHART.JS         --}}
{{-- =============================== --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labelsRonda = JSON.parse('{!! $jsonLabelsRonda !!}');
    const dataRonda = JSON.parse('{!! $jsonDataRonda !!}').map(Number);

    const labelsKehadiran = JSON.parse('{!! $jsonLabelsKehadiran !!}');
    const dataKehadiran = JSON.parse('{!! $jsonDataKehadiran !!}').map(Number);

    console.log('Ronda:', labelsRonda, dataRonda);
    console.log('Kehadiran:', labelsKehadiran, dataKehadiran);

    // =======================
    // GRAFIK RONDA (BAR)
    // =======================
    new Chart(document.getElementById('chartRonda'), {
        type: 'line',
        data: {
            labels: labelsRonda,
            datasets: [{
                label: 'Ronda Bulanan',
                data: dataRonda.map(Number),
                borderColor: '#3b5bfd',
                backgroundColor: 'rgba(59, 91, 253, 0.15)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    bottom: 20
                }
            },            
            scales: {
                x: {
                    type: 'category',
                    ticks: {
                        padding: 8,
                        maxRotation: 0,
                        autoSkip: false
                    }            
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // =======================
    // GRAFIK KEHADIRAN (LINE)
    // =======================
    new Chart(document.getElementById('chartKehadiran'), {
        type: 'line',
        data: {
            labels: labelsKehadiran,
            datasets: [{
                label: 'Hadir',
                data: dataKehadiran,
                borderColor: '#1DBF73',
                backgroundColor: 'rgba(29, 191, 115, 0.15)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'category'
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });
</script>

<script>
document.querySelectorAll('.stat-card, .card-dashboard').forEach(card => {

    card.addEventListener('mouseenter', () => {
        card.classList.remove('card-hover-leave');
        card.classList.add('card-hover-enter');
    });

    card.addEventListener('mouseleave', () => {
        card.classList.remove('card-hover-enter');
        card.classList.add('card-hover-leave');
        card.style.transform = '';
    });

    card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        card.style.setProperty('--x', `${x}px`);
        card.style.setProperty('--y', `${y}px`);

        const rotateX = -(y / rect.height - 0.5) * 6;
        const rotateY = (x / rect.width - 0.5) * 6;

        card.style.transform = `
            translateY(-8px)
            rotateX(${rotateX}deg)
            rotateY(${rotateY}deg)
            scale(1.02)
        `;
    });
});
</script>
@endpush