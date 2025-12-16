@extends('layouts.app')

@section('title', 'Jadwal Ronda | JagaRT')

@section('navbar')
    @include('partials.navbar-user') 
@endsection

@section('content')
<style>
    .jadwal-thead th {
        background-color: #ff9977 !important;
        color: white !important;
    }
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
                <thead class="jadwal-thead">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status Absen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalRonda as $index => $jadwal)
                        @php
                            $absen = $jadwal->absensi->first();

                            // Hari ronda
                            $tanggalRonda = \Carbon\Carbon::parse($jadwal->tanggal_ronda);

                            // Aturan jam ronda → mulai jam 21:00 sampai 23:59
                            $mulaiAbsen = $tanggalRonda->copy()->setTime(21, 0, 0);
                            $batasAbsen = $tanggalRonda->copy()->setTime(23, 59, 59);

                            $now = \Carbon\Carbon::now();

                            // Tentukan status tampil
                            if (! $absen) {
                                $displayStatus = 'none';
                            } else {
                                $displayStatus = $absen->status;
                            }

                            // Aturan: boleh absen hanya jika hari & jam sesuai
                            $bolehAbsen = false;

                            if ($absen && $displayStatus === 'belum') {
                                if ($now->between($mulaiAbsen, $batasAbsen)) {
                                    $bolehAbsen = true;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_ronda)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $jadwal->lokasi }}</td>
                            <td>{{ $jadwal->keterangan ?? '-' }}</td>

                            <td>
                                @if ($displayStatus === 'none')
                                    <span class="btn btn-sm btn-secondary disabled">-</span>

                                @elseif ($bolehAbsen)
                                    <button 
                                        class="btn btn-sm btn-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#absenModal{{ $absen->absensi_id }}">
                                        Absen
                                    </button>

                                @elseif ($displayStatus === 'belum')
                                    <span class="btn btn-sm btn-secondary disabled">
                                        Menunggu Waktu
                                    </span>

                                @elseif ($displayStatus === 'hadir')
                                    <span class="btn btn-sm btn-success disabled">Hadir</span>

                                @elseif ($displayStatus === 'izin')
                                    <span class="btn btn-sm btn-warning text-dark disabled">Izin</span>

                                @elseif ($displayStatus === 'alpa')
                                    <span class="btn btn-sm btn-danger disabled">Alpa</span>

                                @else
                                    <span class="btn btn-sm btn-secondary disabled">-</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal Absen --}}
                        @if ($absen)
                        <div class="modal fade" id="absenModal{{ $absen->absensi_id }}" tabindex="-1" aria-labelledby="absenLabel{{ $absen->absensi_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('user.absen.store') }}" method="POST" enctype="multipart/form-data">
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