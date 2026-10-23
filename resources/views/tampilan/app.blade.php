<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MyApp')</title>

    {{-- Vite (Tailwind CSS & JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="pt-[72px] bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-50 transition-colors duration-300 font-sans">

    {{-- NAVBAR --}}
    @include('tampilan.navbar')

    {{-- CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('tampilan.footer')

    @stack('scripts')

    {{-- Fix Facebook Login --}}
    <script>
        if (window.location.hash === "#_=_") {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }
    </script>

    {{-- Script Dark Mode & Navbar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navbar = document.getElementById("navbar");
            const themeToggle = document.getElementById("themeToggle");
            const html = document.documentElement;

            // Ambil tema dari localStorage
            const currentTheme = localStorage.getItem("theme") || "light";
            setTheme(currentTheme);

            function setTheme(theme) {
                if (theme === "dark") {
                    html.classList.add("dark");
                    themeToggle.innerHTML = "☀️";
                } else {
                    html.classList.remove("dark");
                    themeToggle.innerHTML = "🌙";
                }
                localStorage.setItem("theme", theme);
            }

            themeToggle.addEventListener("click", () => {
                const theme = html.classList.contains("dark") ? "light" : "dark";
                setTheme(theme);
            });

            // Efek Scroll pada Navbar (Menggunakan Tailwind class)
            window.addEventListener("scroll", () => {
                if (window.scrollY > 20) {
                    navbar.classList.add("shadow-md", "bg-white/90", "dark:bg-slate-900/90", "backdrop-blur-md");
                    navbar.classList.remove("bg-white", "dark:bg-slate-900");
                } else {
                    navbar.classList.remove("shadow-md", "bg-white/90", "dark:bg-slate-900/90", "backdrop-blur-md");
                    navbar.classList.add("bg-white", "dark:bg-slate-900");
                }
            });
        });
    </script>
</body>
</html>