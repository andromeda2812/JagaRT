@extends('layouts.app')

@section('content')

{{-- Sidebar --}}
@include('partials.navbar-admin')

<div class="absen-container">

    <div class="header-absen">
        <h1>Data Absensi Ronda</h1>
        <p>Berikut daftar warga yang melakukan absensi ronda.</p>
    </div>

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
                    <td>{{ $a->user->nama ?? '-' }}</td>
                    <td>{{ $a->jadwal?->tanggal_ronda ? date('d M Y', strtotime($a->jadwal->tanggal_ronda)) : '-' }}</td>

                    <td class="status-{{ $a->status }}">
                        {{ ucfirst($a->status) }}
                    </td>

                    <td>{{ $a->waktu_absen ? date('H:i d-m-Y', strtotime($a->waktu_absen)) : '-' }}</td>

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
