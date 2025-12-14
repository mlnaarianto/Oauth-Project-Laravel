<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MyApp')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Global Styles --}}
    <style>
        body {
            padding-top: 72px; /* TINGGI NAVBAR */
        }

        .hero {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .feature-card {
            border-radius: 16px;
            transition: 0.3s ease;
            background-image: url('/images/images1.png');
            background-size: cover;
            background-position: center;
            color: white;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-card h5,
        .feature-card p {
            color: white !important;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>

    {{-- NAVBAR --}}
    @include('tampilan.navbar')

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('tampilan.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    {{-- Fix Facebook Login --}}
    <script>
        if (window.location.hash === "#_=_") {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }
    </script>

     <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navbar = document.getElementById("navbar");
            const themeToggle = document.getElementById("themeToggle");

            const currentTheme = localStorage.getItem("theme") || "light";
            setTheme(currentTheme);

            function setTheme(theme) {
                if (theme === "dark") {
                    document.body.classList.add("dark");
                    navbar.classList.add("dark");
                    themeToggle.innerHTML = "☀️";
                } else {
                    document.body.classList.remove("dark");
                    navbar.classList.remove("dark");
                    themeToggle.innerHTML = "🌙";
                }
                localStorage.setItem("theme", theme);
            }

            themeToggle.addEventListener("click", () => {
                const theme = document.body.classList.contains("dark") ? "light" : "dark";
                setTheme(theme);
            });

            window.addEventListener("scroll", () => {
                navbar.classList.toggle("scrolled", window.scrollY > 20);
            });
        });
    </script>

</body>
</html>
