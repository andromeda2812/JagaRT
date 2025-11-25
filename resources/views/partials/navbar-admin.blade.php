<aside class="sidebar-admin">

    {{-- Logo --}}
    <div class="logo-admin">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><span class="text-highlight">Jaga</span>RT</h2>
    </div>

    {{-- Menu --}}
    <nav class="nav-links-admin">

        <a href="{{ route('admin.beranda') }}" 
           class="{{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Beranda
        </a>

        <a href="{{ route('admin.dashboard') }}" 
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dasbor
        </a>

        <a href="/admin/jadwal"  class="{{ request()->is('admin/jadwal*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Jadwal Ronda
        </a>

        <a href="/admin/absensi" class="{{ request()->is('admin/absensi*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i> Absensi
        </a>

        <a href="/admin/akun-warga" class="{{ request()->is('admin/akun*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Akun Warga
        </a>

        <a href="/admin/laporan" class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Laporan Kejadian
        </a>

        {{-- USER DROPDOWN --}}
        <div class="sidebar-dropdown">
            <button class="dropdown-btn">
                <i class="bi bi-person-circle"></i>
                {{ Auth::user()->username ?? 'User' }}
                <i class="bi bi-caret-down-fill ms-1"></i>
            </button>

            <div class="dropdown-content">
                <a href="{{ route('user.profil') }}">
                    <i class="bi bi-person"></i> Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </nav>

</aside>
