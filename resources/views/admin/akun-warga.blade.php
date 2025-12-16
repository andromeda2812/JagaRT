@extends('layouts.admin')
@section('title', 'Akun Warga - JagaRT')
@section('navbar')
    @include('partials.sidebar-admin')
@endsection

@section('content')
<style>
    /* FILTER CARD */
    .filter-card {
        background: #ffffff;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
    }

    /* FLEX WRAPPER */
    .filter-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    /* INPUT & SELECT */
    .filter-input,
    .filter-select {
        flex: 1;
        min-width: 200px;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
    }

    /* BUTTON */
    .btn-filter {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: 0.3s;
    }

    .btn-filter:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* MOBILE */
    @media (max-width: 576px) {
        .filter-group {
            flex-direction: column;
        }

        .btn-filter {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="akunwarga-container">

    <h3 class="page-title">Akun Warga</h3>

    {{-- FILTER --}}
    <form class="filter-card" method="GET" action="{{ route('admin.akun-warga') }}">
        <div class="filter-group">
            <input 
                type="text" 
                name="search" 
                class="filter-input"
                placeholder="Cari nama warga..." 
                value="{{ request('search') }}"
            >

            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status')=='aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="nonaktif" {{ request('status')=='nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>

            <button type="submit" class="btn-filter">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>

    <div class="table-box">
        <table class="table akun-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($warga as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->username }}</td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">

                            {{-- BUTTON DETAIL (triggers modal) --}}
                            <button 
                                class="btn btn-info btn-sm btn-detail" 
                                data-id="{{ $item->user_id }}"
                                data-nama="{{ $item->nama_lengkap }}"
                                data-username="{{ $item->username }}"
                                data-email="{{ $item->email }}"
                                data-nohp="{{ $item->no_hp }}"
                                data-alamat="{{ $item->alamat }}"
                                data-status="{{ $item->status }}"
                            >
                                Detail
                            </button>

                            {{-- BUTTON TOGGLE STATUS --}}
                            <form action="{{ route('admin.akun-warga.toggle-status', $item->user_id) }}" 
                                method="POST" style="display:inline;">
                                @csrf
                                @if($item->status === 'aktif')
                                    <button class="btn btn-danger btn-sm">Nonaktif</button>
                                @else
                                    <button class="btn btn-success btn-sm">Aktif</button>
                                @endif
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data text-center py-3">
                        Belum ada data warga.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <!-- MODAL DETAIL WARGA -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Detail Warga</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            <p><strong>Nama Lengkap:</strong> <span id="detail-nama"></span></p>
            <p><strong>Username:</strong> <span id="detail-username"></span></p>
            <p><strong>Email:</strong> <span id="detail-email"></span></p>
            <p><strong>No HP:</strong> <span id="detail-nohp"></span></p>
            <p><strong>Alamat:</strong> <span id="detail-alamat"></span></p>
            <p><strong>Status:</strong> <span id="detail-status" class="fw-bold"></span></p>

        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>

        </div>
    </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailButtons = document.querySelectorAll('.btn-detail');

    detailButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('detail-nama').innerText = this.dataset.nama;
            document.getElementById('detail-username').innerText = this.dataset.username;
            document.getElementById('detail-email').innerText = this.dataset.email;
            document.getElementById('detail-nohp').innerText = this.dataset.nohp;
            document.getElementById('detail-alamat').innerText = this.dataset.alamat;

            // Badge Status
            const statusElement = document.getElementById('detail-status');
            const statusValue = this.dataset.status;

            statusElement.innerText = statusValue.charAt(0).toUpperCase() + statusValue.slice(1);

            if (statusValue === 'aktif') {
                statusElement.style.color = 'green';
            } else {
                statusElement.style.color = 'red';
            }

            // Show Modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
            modal.show();
        });
    });
});
</script>
@endsection