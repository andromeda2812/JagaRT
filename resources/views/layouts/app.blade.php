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
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo">
                    <h3>Jaga<span class="text-highlight">RT</span></h3>
                </div>

                <div class="contact-info">
                    <p><i class="fa-solid fa-location-dot"></i> ABC Company, 123 East, 17th Street, St. Louis 10001</p>
                    <p><i class="fa-solid fa-phone"></i> (123) 456-7890</p>
                    <p><i class="fa-solid fa-fax"></i> (123) 456-7890</p>
                </div>

                <div class="social-icons">
                    <span>Social Media</span>
                    <div class="icons">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-google-plus-g"></i></a>
                        <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                        <a href="#"><i class="fa-solid fa-rss"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="footer-bottom">
            <div class="footer-links">
                <a href="#">ABOUT US</a>
                <a href="#">CONTACT US</a>
                <a href="#">HELP</a>
                <a href="#">PRIVACY POLICY</a>
                <a href="#">DISCLAIMER</a>
            </div>

            <p class="copyright">Copyright © 2025 - <span class="text-highlight">JagaRT</span>.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>