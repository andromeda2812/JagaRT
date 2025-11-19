<header>
    <div class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo JagaRT">
        <h2><b>Jaga<span class="text-highlight">RT</span></b></h2>
    </div>

    <nav class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="#tentang">Tentang</a>
        <a href="#hubungi">Hubungi Kami</a>
        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn-masuk"><b>MASUK</b></a>
            <a href="{{ route('register') }}" class="btn-daftar"><b>DAFTAR</b></a>
        </div>
    </nav>
</header>