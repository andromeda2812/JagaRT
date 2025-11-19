<header>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><span class="text-highlight">Jaga</span>RT</h2>
    </div>

    <nav class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="#}">Jadwal Ronda</a>
        <a href="#">Absensi</a>
        <a href="#">Laporan Kejadian</a>
        <a class="nav-link dropdown-toggle text-maroon d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person fs-5 me-1"></i> {{ Auth::user()->name ?? 'User' }}
        </a>
    </nav>
</header>