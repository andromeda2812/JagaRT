@extends('layouts.blank')

@section('content')

<!-- Modal Reset Password -->
<div class="modal fade show" id="modalResetPassword" tabindex="-1" style="display:block;" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px; padding:10px 5px;">

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="modal-header border-0">
          <h5 class="modal-title fw-semibold">Reset Kata Sandi</h5>
        </div>

        <div class="modal-body px-4 pb-4">

          <input type="hidden" name="email" value="{{ $email }}">

          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control" placeholder=" " required>
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder=" " required>
          </div>

          <button type="submit" class="btn btn-dark w-100 fw-semibold mt-3">
            Reset Password
          </button>

        </div>
      </form>

    </div>
  </div>
</div>

<!-- BACKDROP -->
<div class="modal-backdrop fade show"></div>

@endsection