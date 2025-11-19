<header>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><span class="text-highlight">Jaga</span>RT</h2>
    </div>

    <nav class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="#tentang">Tentang</a>
        <a href="#hubungi">Hubungi Kami</a>
        <a href="{{ route('login') }}" class="btn-hero">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </a>
        <a href="{{ route('register') }}" class="btn-hero">
            <i class="bi bi-box-arrow-in-right me-1"></i> register
        </a>
    </nav>
</header>