<aside class="sidebar-admin">

    {{-- Logo --}}
    <div class="logo-admin">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><span class="text-highlight">Jaga</span>RT</h2>
    </div>

    {{-- Menu --}}
    <nav class="nav-links-admin">

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

        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>

        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>    
    </nav>

</aside>
