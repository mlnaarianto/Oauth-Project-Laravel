{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MyApp')</title>

    {{-- Cegah flash tema saat halaman dimuat (default: dark) --}}
    <script>
        (function () {
            try {
                var theme = localStorage.getItem('theme') || 'dark';
                document.documentElement.classList.toggle('dark', theme === 'dark');
                document.documentElement.style.colorScheme = theme;
            } catch (e) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    {{-- Vite (Tailwind CSS & JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        /* =========================================================
           Aksen cyberpunk — boleh dipindah ke resources/css/app.css
           ========================================================= */

        /* Grid halus di background (memudar ke bawah) */
        .cyber-grid {
            background-image:
                linear-gradient(to right, rgba(15, 23, 42, .05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, .05) 1px, transparent 1px);
            background-size: 56px 56px;
            -webkit-mask-image: radial-gradient(ellipse 85% 60% at 50% 0%, #000 25%, transparent 78%);
            mask-image: radial-gradient(ellipse 85% 60% at 50% 0%, #000 25%, transparent 78%);
        }
        .dark .cyber-grid {
            background-image:
                linear-gradient(to right, rgba(34, 211, 238, .07) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(34, 211, 238, .07) 1px, transparent 1px);
        }

        /* Underline neon tipis pada link navbar */
        .nav-link {
            position: relative;
            display: inline-block;
            padding-block: .35rem;
            font-size: .9rem;
            font-weight: 500;
            color: #475569;
            transition: color .2s ease;
        }
        .dark .nav-link { color: #94a3b8; }

        .nav-link::after {
            content: "";
            position: absolute;
            inset-inline-start: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            border-radius: 2px;
            background: linear-gradient(90deg, #22d3ee, #a78bfa);
            transition: width .25s ease;
        }
        .nav-link:hover { color: #0e7490; }
        .dark .nav-link:hover { color: #e2e8f0; }
        .nav-link:hover::after { width: 100%; }

        .nav-link.is-active { color: #0891b2; }
        .dark .nav-link.is-active { color: #22d3ee; }
        .nav-link.is-active::after { width: 100%; }

        /* Navbar saat halaman di-scroll */
        #navbar { transition: background-color .3s ease, box-shadow .3s ease, border-color .3s ease; }
        #navbar.scrolled {
            background-color: rgba(255, 255, 255, .85);
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
            border-bottom-color: rgba(34, 211, 238, .25);
            box-shadow: 0 12px 30px -18px rgba(15, 23, 42, .35);
        }
        .dark #navbar.scrolled {
            background-color: rgba(7, 11, 18, .85);
            border-bottom-color: rgba(34, 211, 238, .18);
            box-shadow: 0 12px 34px -20px rgba(34, 211, 238, .5);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition-duration: .01ms !important; animation-duration: .01ms !important; }
        }
    </style>
</head>
<body class="relative min-h-screen bg-slate-50 pt-16 font-sans text-slate-700 antialiased transition-colors duration-300 dark:bg-[#070b12] dark:text-slate-300">

    {{-- LAPISAN DEKORASI (tidak mengganggu konten) --}}
    <div aria-hidden="true" class="cyber-grid pointer-events-none fixed inset-0 -z-10"></div>
    <div aria-hidden="true" class="pointer-events-none fixed inset-x-0 top-0 -z-10 h-[520px] overflow-hidden">
        <div class="absolute -top-52 left-1/2 h-[420px] w-[760px] -translate-x-1/2 rounded-full bg-cyan-400/10 blur-[130px] dark:bg-cyan-500/15"></div>
        <div class="absolute -top-32 right-[15%] h-[280px] w-[280px] rounded-full bg-fuchsia-400/[0.07] blur-[130px] dark:bg-fuchsia-500/10"></div>
    </div>

    {{-- NAVBAR --}}
    @include('tampilan.navbar')

    {{-- CONTENT --}}
    <main class="relative min-h-screen">
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
        document.addEventListener("DOMContentLoaded", function () {
            const root   = document.documentElement;
            const navbar = document.getElementById("navbar");

            /* ---------- Tema ---------- */
            function applyTheme(theme) {
                root.classList.toggle("dark", theme === "dark");
                root.style.colorScheme = theme;

                document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
                    btn.setAttribute("aria-pressed", String(theme === "dark"));
                    btn.setAttribute("aria-label", theme === "dark" ? "Aktifkan mode terang" : "Aktifkan mode gelap");
                });
            }

            // Samakan state tombol dengan tema yang sudah dipasang di <head>
            applyTheme(root.classList.contains("dark") ? "dark" : "light");

            document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
                btn.addEventListener("click", function () {
                    const next = root.classList.contains("dark") ? "light" : "dark";
                    applyTheme(next);
                    try { localStorage.setItem("theme", next); } catch (e) {}
                });
            });

            /* ---------- Efek scroll navbar ---------- */
            function onScroll() {
                if (!navbar) return;
                navbar.classList.toggle("scrolled", window.scrollY > 8);
            }
            onScroll();
            window.addEventListener("scroll", onScroll, { passive: true });

            /* ---------- Menu mobile ---------- */
            const menuBtn = document.getElementById("mobile-menu-btn");
            const menu    = document.getElementById("mobile-menu");

            if (menuBtn && menu) {
                menuBtn.addEventListener("click", function () {
                    menu.classList.toggle("hidden");
                    const isOpen = !menu.classList.contains("hidden");
                    menuBtn.setAttribute("aria-expanded", String(isOpen));
                    menuBtn.setAttribute("aria-label", isOpen ? "Tutup menu" : "Buka menu");
                });
            }
        });
    </script>
</body>
</html>