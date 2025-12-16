<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JagaRT')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font & Custom CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body style="background-color: #ffffff; font-family: 'Poppins', sans-serif;">
    {{-- Navbar --}}
    @hasSection('navbar')
        @yield('navbar')
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer" id="contact">
        <div class="container">

            <hr class="footer-divider-top">

            <!-- FOOTER TOP -->
            <div class="row footer-top py-5 align-items-start">

                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="footer-logo d-flex align-items-center">
                        <img src="{{ asset('image/logo.png') }}" class="me-2">
                        <h4 class="mb-0 fw-bold">JAGA<span class="text-highlight">RT</span></h4>
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-md-9 footer-right">

                    <!-- CONTACT -->
                    <div class="footer-contact mb-3">
                        <div class="contact-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>RT. 04 Kelurahan Kenali Besar Kecamatan Alam Barajo, Kota Jambi</span>
                        </div>

                        <div class="contact-row">
                            <div class="contact-item">
                                <i class="bi bi-telephone-fill"></i>
                                <span>(0741) 456-7890</span>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-handphone-fill"></i>
                                <span>(62) 800-1234-5678</span>
                            </div>
                        </div>
                    </div>

                    <br>

                    <!-- SOCIAL -->
                    <div class="footer-social-wrapper">
                        <span class="social-label">Social Media</span>
                        <div class="footer-social">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-google"></i></a>
                            <a href="#"><i class="bi bi-pinterest"></i></a>
                            <a href="#"><i class="bi bi-rss"></i></a>
                        </div>
                    </div>

                </div>
            </div>

            <hr class="footer-divider-bottom">

            <!-- FOOTER BOTTOM -->
            <div class="row footer-bottom py-3 align-items-center">
                <div class="col-md-6">
                    <div class="footer-links">
                        <a href="#">ABOUT US</a>
                        <a href="#">CONTACT US</a>
                        <a href="#">HELP</a>
                        <a href="#">PRIVACY POLICY</a>
                        <a href="#">DISCLAIMER</a>
                    </div>
                </div>

                <div class="col-md-6 text-md-end mt-3 mt-md-0 footer-brand">
                    <p class="mb-0 text-muted">
                        Copyright © 2025 - JagaRT
                    </p>
                </div>
            </div>

        </div>
    </footer>

    <br><br>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>