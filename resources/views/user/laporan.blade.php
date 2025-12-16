@extends('layouts.app')

@section('title', 'Laporan Kejadian | JagaRT')

@section('navbar')
    @include('partials.navbar-user') 
@endsection

@section('content')
<style>
    .report-wrapper {
        padding: 60px 20px;
        background-color: #f9fafb;
        min-height: 100vh;
    }
    .report-card {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 30px;
    }
    .btn-add-report {
        background-color: #111827;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-add-report:hover {
        background-color: #000;
    }
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }
</style>

<section class="report-wrapper">
    <div class="report-card">
        <h2 class="text-center mb-4 fw-bold">Laporan Kejadian</h2>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tabel laporan --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Kejadian</th>
                        <th>Lokasi</th>
                        <th>Deskripsi Kejadian</th>
                        <th>Bukti</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $index => $lapor)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($lapor->tanggal_kejadian)->translatedFormat('d F Y, H:i') }}</td>
                            <td>{{ $lapor->lokasi }}</td>
                            <td>{{ $lapor->deskripsi }}</td>
                            <td>
                                @if ($lapor->foto_bukti)
                                    <a href="{{ asset('storage/' . $lapor->foto_bukti) }}" target="_blank" class="btn btn-sm btn-outline-dark">Lihat</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($lapor->status_laporan == 'baru')
                                    <span class="badge bg-secondary">Baru</span>
                                @elseif ($lapor->status_laporan == 'diproses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @elseif ($lapor->status_laporan == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada laporan kejadian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <button class="btn-add-report" data-bs-toggle="modal" data-bs-target="#tambahLaporanModal">
                + Tambah Laporan
            </button>
        </div>
    </div>
</section>

{{-- Modal Tambah Laporan --}}
<div class="modal fade" id="tambahLaporanModal" tabindex="-1" aria-labelledby="tambahLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="tambahLaporanLabel">Tambah Laporan Kejadian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal & Waktu Kejadian</label>
                            <input type="datetime-local" name="tanggal_kejadian" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Pos Ronda, Jalan Melati" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Kejadian</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Ceritakan kejadian yang terjadi..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Bukti (opsional)</label>
                        <input type="file" name="foto_bukti" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG (maks. 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection