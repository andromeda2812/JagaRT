<header>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><span class="text-highlight">Jaga</span>RT</h2>
    </div>

    <nav class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('user.dashboard') }}">Dasbor</a>
        <a href="#}">Jadwal Ronda</a>
        <a href="#">Absensi</a>
        <a href="#">Akun Warga</a>
        <a href="#">Laporan Kejadian</a>
        <a class="nav-link dropdown-toggle text-maroon d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person fs-5 me-1"></i> {{ Auth::user()->username ?? 'User' }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('user.profil') }}">Profil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</header>