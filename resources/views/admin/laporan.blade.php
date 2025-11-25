@extends('layouts.app')

@section('title', 'Laporan Kejadian - JagaRT')

@section('content')

@include('partials.navbar-admin')

<div class="admin-main-content">

    <div class="laporan-container">

        <h3 class="laporan-title">Laporan Kejadian</h3>

        <div class="laporan-card">

            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Kejadian</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th>Bukti</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>{{ $item->bukti ?? '-' }}</td>
                        <td>{{ $item->status ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty text-center">
                            Belum ada laporan kejadian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="text-align:center;">
                <a href="{{ route('admin.laporan.create') }}" class="btn-tambah-laporan">
                    + Tambah Laporan
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
