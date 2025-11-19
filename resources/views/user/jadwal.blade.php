@extends('layouts.app')

@section('title', 'Jadwal Ronda | JagaRT')

@section('navbar')
    @include('partials.navbar-user') 
@endsection

@section('content')
<style>
    .jadwal-section {
        padding: 60px 20px;
        background-color: #f9fafb;
        min-height: 100vh;
    }
    .jadwal-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 30px;
    }
    .jadwal-title {
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }
    .jadwal-desc {
        color: #6b7280;
        margin-bottom: 25px;
    }
    .jadwal-table th, .jadwal-table td {
        text-align: center;
        vertical-align: middle;
    }
    .btn-absen {
        background-color: #111827;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        padding: 6px 14px;
        transition: 0.3s;
    }
    .btn-absen:hover {
        background-color: #000;
    }
</style>

<section class="jadwal-section">
    <div class="jadwal-container">
        <h2 class="jadwal-title">Jadwal Ronda</h2>
        <p class="jadwal-desc">Berikut jadwal ronda Anda di lingkungan RT.04.</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <div class="table-responsive">
            <table class="table table-bordered jadwal-table">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status Absen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalRonda as $index => $jadwal)
                        @php
                            $absen = $jadwal->absensi->first();
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_ronda)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $jadwal->lokasi }}</td>
                            <td>{{ $jadwal->keterangan ?? '-' }}</td>
                            <td>
                                @if (!$absen)
                                    <span class="badge bg-secondary">Belum Ada</span>
                                @else
                                    @if ($absen->status === 'hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif ($absen->status === 'izin')
                                        <span class="badge bg-warning text-dark">Izin</span>
                                    @elseif ($absen->status === 'alpa')
                                        <span class="badge bg-danger">Alpa</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Absen</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($absen && $absen->status)
                                    <button class="btn btn-sm btn-secondary" disabled>Sudah Absen</button>
                                @elseif ($absen)
                                    <button 
                                        class="btn btn-sm btn-absen" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#absenModal{{ $absen->absensi_id }}">
                                        Absen
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal Absen --}}
                        @if ($absen)
                        <div class="modal fade" id="absenModal{{ $absen->absensi_id }}" tabindex="-1" aria-labelledby="absenLabel{{ $absen->absensi_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('absen.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="absenLabel{{ $absen->absensi_id }}">Form Absensi Ronda</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="absensi_id" value="{{ $absen->absensi_id }}">
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Status Kehadiran</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="hadir">Hadir</option>
                                                    <option value="izin">Izin</option>
                                                    <option value="alpa">Alpa</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Upload Bukti Foto (opsional)</label>
                                                <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                                                <small class="text-muted">Format: JPG, JPEG, PNG (max 2MB)</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-dark">Kirim Absensi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada jadwal ronda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection