@extends('layouts.app')

@section('title', 'Profil Pengguna | JagaRT')

@section('navbar')
    @include('partials.navbar-user')
@endsection

@section('content')
<style>
    body {
        font-family: 'Zen Kaku Gothic Antique', sans-serif;
        background-color: #f9fafb;
    }

    .profile-section {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 60px 20px;
        gap: 40px;
    }

    /* KIRI */
    .profile-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 40px 30px;
        width: 380px;
        text-align: center;
    }

    .profile-card img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ff9977;
        margin-bottom: 15px;
    }

    .profile-card h3 {
        font-weight: 700;
        color: #111827;
        font-size: 20px;
    }

    .profile-card p {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .profile-card button {
        display: block;
        width: 100%;
        background-color: #ff9977;
        color: white;
        font-weight: 600;
        border: none;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .profile-card button:hover {
        background-color: #111827;
    }

    /* KANAN */
    .profile-details {
        flex: 1;
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .profile-details h4 {
        font-weight: 700;
        color: #111827;
        margin-bottom: 25px;
        border-left: 5px solid #ff9977;
        padding-left: 10px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 0;
    }

    .detail-row span:first-child {
        font-weight: 600;
        color: #111827;
    }

    .detail-row span:last-child {
        color: #374151;
    }

    /* MODAL STYLE */
    .modal-backdrop.show {
        backdrop-filter: blur(6px);
        background-color: rgba(17, 24, 39, 0.4);
    }

    .modal-content {
        border-radius: 15px;
        padding: 10px 15px 25px;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.4s ease;
    }

    .modal.fade.show .modal-content {
        transform: translateY(0);
        opacity: 1;
    }

    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 15px;
    }

    .nav-link {
        color: #111827;
        font-weight: 600;
        border: none;
    }

    .nav-link.active {
        color: #ff9977 !important;
        border-bottom: 3px solid #ff9977;
        background: none;
    }

    .form-label {
        font-weight: 600;
        color: #111827;
        font-size: 14px;
    }

    .form-control {
        border-radius: 8px;
        border: 1.8px solid #d1d5db;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #ff9977;
        box-shadow: 0 0 0 2px rgba(255, 153, 119, 0.3);
    }

    .btn-save {
        background-color: #ff9977;
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        background-color: #111827;
    }

    .btn-close-custom {
        background-color: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 15px;
    }

    @media (max-width: 992px) {
        .profile-section {
            flex-direction: column;
            align-items: center;
        }
        .profile-card, .profile-details {
            width: 100%;
            max-width: 500px;
        }
    }
</style>

<section class="profile-section">
    <div class="profile-card">
        <img src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('image/default-user.png') }}" alt="Foto Profil">
        <h3>{{ $user->nama_lengkap }}</h3>
        <p>{{ '@' . $user->username }}</p>
        <button data-bs-toggle="modal" data-bs-target="#profilModal">Edit Profil</button>
    </div>

    <div class="profile-details">
        <h4>Informasi Pribadi</h4>
        <div class="detail-row"><span>Nama Lengkap</span><span>{{ $user->nama_lengkap }}</span></div>
        <div class="detail-row"><span>Username</span><span>{{ $user->username }}</span></div>
        <div class="detail-row"><span>Email</span><span>{{ $user->email }}</span></div>
        <div class="detail-row"><span>Nomor Telepon</span><span>{{ $user->no_hp ?? '-' }}</span></div>
        <div class="detail-row"><span>Alamat</span><span>{{ $user->alamat ?? '-' }}</span></div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Pengaturan Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <ul class="nav nav-tabs justify-content-center" id="profilTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab">Edit Profil</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Ubah Password</button>
        </li>
      </ul>

      <div class="tab-content mt-3">
        <!-- Tab Edit Profil -->
        <div class="tab-pane fade show active" id="edit" role="tabpanel">
          <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 text-center">
                <img id="previewFoto" src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('image/default-user.png') }}" style="width:90px; height:90px; border-radius:50%; border:3px solid #ff9977; object-fit:cover;">
                <input type="file" name="foto" class="form-control mt-2" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ $user->alamat }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
          </form>
        </div>

        <!-- Tab Ubah Password -->
        <div class="tab-pane fade" id="password" role="tabpanel">
          <form action="{{ route('profil.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-save">Ubah Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewFoto').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@push('scripts')
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#A42421'
            });
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endif
@endpush
@endsection