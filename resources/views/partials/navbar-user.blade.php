<header>
    <style>
        .nav-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 25px;
            transition: 0.2s ease;
        }

        .nav-profile:hover {
            background: #ececec;
        }

        .nav-profile-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .nav-profile-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
    </style>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><b><span class="text-highlight">Jaga</span>RT</b></h2>
    </div>

    <nav class="nav-links">
        <!-- <a href="{{ route('home') }}">Beranda</a> -->
        <a href="{{ route('user.dashboard.user') }}">Dasbor</a>
        <a href="{{ route('user.jadwal') }}">Jadwal dan Absensi Ronda</a>
        <a href="{{ route('user.laporan') }}">Laporan Kejadian</a>
        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" data-bs-toggle="dropdown">
            <div class="nav-profile">
                <img 
                    src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('image/default-user.png') }}"
                    class="nav-profile-img"
                    alt="Foto Profil"
                >
                <span class="nav-profile-name">
                    {{ Auth::user()->username ?? 'User' }}
                </span>
            </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('user.profil') }}">Profil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
</header>