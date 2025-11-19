@extends('layouts.app')

@section('content')

{{-- Sidebar --}}
@include('partials.navbar-admin')

<div class="jadwal-container">

    <div class="header-jadwal">
        <h1>Jadwal Ronda</h1>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Jadwal Ronda
        </button>
    </div>

    <div class="jadwal-card">
        <table class="jadwal-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($jadwal as $j)
                <tr>
                    <td>{{ date('d M Y', strtotime($j->tanggal_ronda)) }}</td>
                    <td>{{ $j->lokasi }}</td>
                    <td>{{ $j->keterangan ?? '-' }}</td>
                    <td>{{ $j->pembuat->nama ?? 'Admin' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="no-data">Belum ada jadwal ronda</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Ronda</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Tanggal Ronda</label>
                    <input type="date" name="tanggal_ronda" class="form-control mb-2" required>

                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control mb-2" required>

                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
