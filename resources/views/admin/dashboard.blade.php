<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JagaRT - Home User</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-3" style="background-color: #111827;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('image/jagaRT-logo.png') }}" alt="JagaRT Logo" style="height: 70px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-uppercase fw-semibold">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Statistik</a></li>
                    
                    <!-- Informasi User -->
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            👤 {{ Auth::user()->name ?? 'Nama User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero d-flex align-items-center text-center" style="background-color: #ffffff;">
        <div class="container py-5">
            <h1 class="fw-bold text-dark mb-3">Selamat Datang, <span class="text-highlight">{{ Auth::user()->name ?? 'Warga RT' }}</span></h1>
            <p class="text-secondary fs-5">Pantau jadwal ronda, laporan keamanan, dan statistik lingkungan RT-mu dengan mudah.</p>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="text-center text-white py-4" style="background-color: #111827;">
        <p class="mb-0">&copy; 2025 JagaRT. Semua hak dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>