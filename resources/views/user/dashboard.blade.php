@extends('layouts.app')

@section('title', 'Dashboard | JagaRT')

@section('navbar')
    @include('partials.navbar-user')
@endsection

@section('content')

<style>
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        margin-top: -40px;
        padding: 0 20px;
    }

    /* ======== SUMMARY CARDS ======== */
    .summary-card {
        background: #fff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        
        opacity: 0;
        animation: fadeUp 0.6s ease forwards;
    }

    .summary-card:nth-child(1) { animation-delay: 0.05s; }
    .summary-card:nth-child(2) { animation-delay: 0.15s; }
    .summary-card:nth-child(3) { animation-delay: 0.25s; }
    .summary-card:nth-child(4) { animation-delay: 0.35s; }

    /* Hover effect */
    .summary-card:hover {
        transform: translateY(-5px);
        transition: 0.25s;
        box-shadow: 0 8px 22px rgba(0,0,0,0.12);
    }

    .summary-number {
        font-size: 32px;
        font-weight: 700;
        margin: 5px 0;
    }

    .growth {
        font-size: 14px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .growth.up { color: #1DBF73; }
    .growth.down { color: #FF6767; }

    /* ======== WRAPPER (CHART + ABSENSI) ANIMASI ======== */
    .chart-absensi-wrapper {
        display: flex;
        gap: 20px;
        margin: 20px;
        align-items: flex-start;

        opacity: 0;
        animation: fadeUp 0.8s ease forwards;
        animation-delay: 0.45s;
    }

    .card-chart {
        background: linear-gradient(135deg, #fff7f3 0%, #fff3ec 100%);
        padding: 20px;
        margin: 20px;
        border-radius: 20px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.05);
        
        flex: 1.3;
        display: flex;
        flex-direction: column;

        transition: 0.3s all ease;
    }

    .card-chart canvas {
        width: 100% !important;
        height: auto !important;
        max-height: 320px;
    }

    .card-chart:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 22px rgba(0,0,0,0.12);
    }

    .table-card {
        flex: 1;
        background: #fff;
        margin: 20px;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        transition: 0.3s ease;
    }

    .table-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 22px rgba(0,0,0,0.12);
    }
    
    /* Responsif untuk HP */
    @media (max-width: 900px) {
        .chart-absensi-wrapper {
            flex-direction: column;
        }
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: white;
    }

    .badge {
        transition: 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.06);
    }

    .status-hadir { background: #1DBF73; }
    .status-izin { background: #F7C948; }
    .status-alpa { background: #FF6767; }
    .status-belum { background: #5CA9FF; }

    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(15px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-up {
        animation: fadeUp 0.6s ease forwards;
    }
</style>

{{-- ========= HEADER ========== --}}
<section class="text-center py-5" style="background-color: #ffffff;">
    <div class="container">
        <h1 class="fw-bold text-dark mb-2">
            Selamat datang, <span class="text-highlight">{{ Auth::user()->nama_lengkap }}</span> 👋
        </h1>
        <p class="text-secondary fs-5">
            Terima kasih sudah aktif menjaga keamanan lingkungan RT.
        </p>
    </div>
</section>

{{-- ========= SUMMARY CARDS ========== --}}
<div class="summary-grid">

    <div class="summary-card">
        <h6 class="text-secondary">Ronda Terlaksana</h6>
        <div class="summary-number">{{ $jumlahRonda }}</div>
        <div class="growth {{ $growthRonda >= 0 ? 'up' : 'down' }}">
            {{ $growthRonda >= 0 ? '▲' : '▼' }} 
            {{ abs($growthRonda) }}% Dari bulan lalu
        </div>
    </div>

    <div class="summary-card">
        <h6 class="text-secondary">Kehadiran Warga</h6>
        <div class="summary-number">{{ $jumlahHadir }}</div>
        <div class="growth up">
            ▲ {{ $jumlahHadir }} Total hadir
        </div>
    </div>

    <div class="summary-card">
        <h6 class="text-secondary">Laporan Dibuat</h6>
        <div class="summary-number">{{ $jumlahLaporan }}</div>
        <div class="growth {{ $jumlahLaporan > 0 ? 'up' : 'down' }}">
            {{ $jumlahLaporan > 0 ? '▲' : '▼' }}
            {{ $jumlahLaporan }} Total laporan
        </div>
    </div>

    <div class="summary-card">
        <h6 class="text-secondary">Ronda Berikutnya</h6>
        <div class="summary-number">{{ $jadwalBerikutnya }}</div>
        <div class="growth up">📅 Jadwal terdekat</div>
    </div>

</div>

<div class="chart-absensi-wrapper">
    {{-- ========= CHART AREA ========== --}}
    <div class="card-chart">
        <h5 class="fw-bold mb-3">Ronda Bulanan</h5>
        <canvas id="chartRonda"></canvas>
    </div>

    {{-- ========= TABEL ABSENSI ========== --}}
    <div class="table-card">
        <h4 class="section-title">Absensi Terakhir</h4>

        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($absensiTerakhir as $item)
                    <tr>
                        {{-- TANGGAL RONDA --}}
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_ronda)->format('d M Y') }}
                        </td>

                        {{-- JAM ABSEN / "-" --}}
                        <td>
                            {{ $item->waktu_absen ? \Carbon\Carbon::parse($item->waktu_absen)->format('H:i') : '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge
                                @if($item->status == 'hadir') bg-success
                                @elseif($item->status == 'izin') bg-warning
                                @else bg-danger
                                @endif
                            ">
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted text-center">
                            Belum ada data absensi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@php
    $jsonLabels = json_encode(array_values($labels));
    $jsonDataRonda = json_encode(array_values($dataRonda));
@endphp

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = JSON.parse('{!! $jsonLabels !!}');
    const dataRonda = JSON.parse('{!! $jsonDataRonda !!}').map(Number); 

    console.log("LABELS:", labels);
    console.log("DATA:", dataRonda);

    new Chart(document.getElementById('chartRonda'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Ronda Hadir",
                data: dataRonda,
                borderColor: "#3b5bfd",
                backgroundColor: "rgba(59, 91, 253, 0.15)",
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            scales: {
                x: {
                    type: 'category'   // ← FIX PENTING
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
</script>
@endpush

@endsection