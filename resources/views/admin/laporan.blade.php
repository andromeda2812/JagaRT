@extends('layouts.admin')

@section('title', 'Laporan Kejadian - JagaRT')

@section('navbar')
    @include('partials.sidebar-admin')
@endsection

@section('content')

<div class="akunwarga-container">

    <h3 class="page-title">Laporan Kejadian</h3>

    <form action="{{ route('admin.laporan.printFilter') }}" method="GET" class="mb-4">

        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="baru">Baru</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100" type="submit">
                    Print Laporan (Filter)
                </button>
            </div>

        </div>

    </form>

    <div class="table-box">
        <table class="table akun-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Kejadian</th>
                    <th>Pelapor</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d F Y, H:i') }}</td>

                    <td>{{ $item->user->nama_lengkap ?? '-' }}</td>

                    <td>{{ $item->lokasi }}</td>

                    <td>{{ Str::limit($item->deskripsi, 40) }}</td>

                    <td>
                        @if($item->foto_bukti)
                            <a href="{{ asset('storage/' . $item->foto_bukti) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-dark">
                               Lihat
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if ($item->status_laporan == 'baru')
                            <span class="badge bg-secondary">Baru</span>
                        @elseif ($item->status_laporan == 'diproses')
                            <span class="badge bg-warning text-dark">Diproses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>

                    <td>
                        <button class="btn-manage btn btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $item->laporan_id }}">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- ===================== MODAL DETAIL ===================== --}}
                <div class="modal fade" id="detailModal{{ $item->laporan_id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Detail Laporan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-semibold">Tanggal Kejadian</label>
                                        <p>{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d F Y, H:i') }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="fw-semibold">Lokasi</label>
                                        <p>{{ $item->lokasi }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-semibold">Deskripsi</label>
                                    <p>{{ $item->deskripsi }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-semibold">Foto Bukti</label><br>
                                    @if ($item->foto_bukti)
                                        <img src="{{ asset('storage/' . $item->foto_bukti) }}"
                                             class="img-thumbnail"
                                             style="max-height:220px;">
                                    @else
                                        <p class="text-muted">Tidak ada bukti</p>
                                    @endif
                                </div>

                                <hr>

                                <form action="{{ route('admin.laporan.status', $item->laporan_id) }}" method="POST">
                                    @csrf
                                    <label class="fw-semibold">Ubah Status Laporan</label>
                                    <select name="status" class="form-select mb-3" required>
                                        <option value="baru" {{ $item->status_laporan == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="diproses" {{ $item->status_laporan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $item->status_laporan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>

                                    <div class="text-end">
                                        <a href="{{ route('admin.laporan.print', $item->laporan_id) }}" 
                                            target="_blank" 
                                            class="btn btn-secondary">
                                                Print Laporan
                                        </a>
                                        <button class="btn btn-dark" type="submit">Simpan Perubahan</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                {{-- ================== END MODAL DETAIL ================== --}}

                @empty
                <tr>
                    <td colspan="7" class="no-data text-center py-3">
                        Belum ada laporan kejadian.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection