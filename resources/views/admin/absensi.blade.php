@extends('layouts.admin')

@section('navbar')
    @include('partials.sidebar-admin') 
@endsection

@section('content')
<style>
    .filter-card {
        background: #fff;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }

    .filter-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-input,
    .filter-select {
        flex: 1;
        min-width: 180px;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .btn-filter {
        background: #0d6efd;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
    }

    @media (max-width: 576px) {
        .filter-group {
            flex-direction: column;
        }
    }
</style>

<div class="absen-container">

    <div class="header-absen">
        <h1>Data Absensi Ronda</h1>
        <p>Berikut daftar warga yang melakukan absensi ronda.</p>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('admin.absensi') }}" class="filter-card">
        <div class="filter-group">
            <input 
                type="text" 
                name="nama" 
                class="filter-input"
                placeholder="Cari nama warga..."
                value="{{ request('nama') }}"
            >

            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="hadir" {{ request('status')=='hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="izin" {{ request('status')=='izin' ? 'selected' : '' }}>Izin</option>
                <option value="alpa" {{ request('status')=='alpa' ? 'selected' : '' }}>Alpa</option>
            </select>

            <input 
                type="date" 
                name="tanggal" 
                class="filter-input"
                value="{{ request('tanggal') }}"
            >

            <button type="submit" class="btn-filter">
                Filter
            </button>
        </div>
    </form>

    <div class="absen-card">

        <table class="absen-table">
            <thead>
                <tr>
                    <th>Nama Warga</th>
                    <th>Tanggal Ronda</th>
                    <th>Status</th>
                    <th>Waktu Absen</th>
                    <th>Bukti Foto</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($absensi as $a)
                <tr>
                    <td>{{ $a->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $a->jadwal?->tanggal_ronda ? date('d M Y', strtotime($a->jadwal->tanggal_ronda)) : '-' }}</td>

                    <td class="status-{{ $a->status }}">
                        {{ ucfirst($a->status) }}
                    </td>

                    <td>{{ \Carbon\Carbon::parse($a->waktu_absen)->format('H:i d-m-Y') }}</td>

                    <td>
                        @if ($a->bukti_foto)
                            <a href="{{ asset('storage/'.$a->bukti_foto) }}" target="_blank" class="btn-foto">
                                Lihat Foto
                            </a>
                        @else
                            <span class="no-foto">Tidak ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="no-data">Belum ada data absensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection
