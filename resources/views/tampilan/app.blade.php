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

    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @stack('styles')

    <style>
        /* =========================================================
           Aksen cyberpunk
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

        /* =========================================================
           SweetAlert2 — tema cyber (toast + modal)
           ========================================================= */
        body:not(.swal2-toast-shown) .swal2-container.swal2-backdrop-show,
        body:not(.swal2-toast-shown) .swal2-container.swal2-noanimation {
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(4px);
        }
        body.swal2-toast-shown .swal2-container {
            background: transparent !important;
            backdrop-filter: none !important;
        }

        /* ----- Toast ----- */
        .swal-toast {
            --swal-accent: #22d3ee;
            width: 22rem !important;
            max-width: calc(100vw - 2rem);
            padding: .85rem 1rem !important;
            border-radius: .85rem !important;
            background: #fff;
            color: #0f172a;
            border: 1px solid rgba(148, 163, 184, .35);
            border-left: 4px solid var(--swal-accent);
            box-shadow: 0 12px 30px -10px rgba(15, 23, 42, .3) !important;
        }
        .dark .swal-toast {
            background: #0b1220;
            color: #e2e8f0;
            border-color: rgba(34, 211, 238, .18);
            border-left-color: var(--swal-accent);
            box-shadow: 0 12px 30px -10px rgba(0, 0, 0, .8),
                        0 0 24px -10px var(--swal-accent) !important;
        }
        .swal-toast .swal2-title {
            font-size: .875rem;
            font-weight: 600;
            margin: 0 0 0 .25rem;
            color: inherit;
        }
        .swal-toast .swal2-html-container {
            margin: .15rem 0 0 .25rem;
            font-size: .8rem;
            color: #64748b;
        }
        .dark .swal-toast .swal2-html-container { color: #94a3b8; }
        .swal-toast .swal2-timer-progress-bar { background: var(--swal-accent); height: 3px; }
        .swal-toast .swal2-icon { margin: 0 .5rem 0 0; transform: scale(.8); }

        /* ----- Modal ----- */
        .swal-popup {
            --swal-accent: #22d3ee;
            position: relative;
            overflow: hidden;
            width: 26rem;
            max-width: calc(100vw - 2rem);
            padding: 1.75rem 1.5rem 1.5rem;
            border-radius: 1rem;
            background: #fff;
            color: #0f172a;
            border: 1px solid rgba(148, 163, 184, .35);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, .35);
        }
        .dark .swal-popup {
            background: #0b1220;
            color: #e2e8f0;
            border-color: rgba(34, 211, 238, .18);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, .8),
                        0 0 40px -12px var(--swal-accent);
        }
        .swal-popup::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--swal-accent), transparent);
        }
        .swal-popup .swal2-icon { margin: .25rem auto 1rem; }
        .swal-popup .swal2-icon { border-color: var(--swal-accent) !important; color: var(--swal-accent) !important; }

        .swal-title { padding: 0; font-size: 1.25rem; font-weight: 700; letter-spacing: -.01em; }
        .swal-text  { margin: .5rem 0 0; font-size: .9rem; line-height: 1.55; color: #64748b; }
        .dark .swal-text { color: #94a3b8; }

        .swal-actions { gap: .6rem; margin-top: 1.5rem; }
        .swal-btn {
            padding: .6rem 1.25rem;
            border-radius: .65rem;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, background .15s;
        }
        .swal-btn:active { transform: scale(.97); }
        .swal-btn:focus-visible { outline: 2px solid var(--swal-accent); outline-offset: 2px; }
        .swal-btn-confirm {
            color: #fff;
            background: linear-gradient(135deg, var(--swal-accent), color-mix(in srgb, var(--swal-accent) 65%, #000));
            box-shadow: 0 6px 18px -6px var(--swal-accent);
        }
        .swal-btn-confirm:hover {
            box-shadow: 0 8px 24px -6px var(--swal-accent);
            transform: translateY(-1px);
        }
        .swal-btn-cancel {
            color: #475569;
            background: transparent;
            border: 1px solid rgba(148, 163, 184, .5);
        }
        .swal-btn-cancel:hover { background: rgba(148, 163, 184, .15); }
        .dark .swal-btn-cancel { color: #cbd5e1; }

        /* Accent per-tipe */
        .swal-success  { --swal-accent: #10b981; }
        .swal-error    { --swal-accent: #f43f5e; }
        .swal-warning  { --swal-accent: #f59e0b; }
        .swal-info     { --swal-accent: #22d3ee; }
        .swal-question { --swal-accent: #8b5cf6; }

        /* Animasi masuk/keluar */
        @keyframes swalIn  { from { opacity: 0; transform: translateY(12px) scale(.96); } to { opacity: 1; transform: none; } }
        @keyframes swalOut { to   { opacity: 0; transform: translateY(8px) scale(.97); } }
        .swal-in  { animation: swalIn .25s cubic-bezier(.2, .8, .2, 1); }
        .swal-out { animation: swalOut .15s ease-in forwards; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition-duration: .01ms !important; animation-duration: .01ms !important; }
        }
    </style>
</head>
<body class="relative min-h-screen bg-slate-50 pt-16 font-sans text-slate-700 antialiased transition-colors duration-300 dark:bg-[#070b12] dark:text-slate-300">

    {{-- LAPISAN DEKORASI --}}
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

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script Dark Mode, Navbar, & SweetAlert --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const root   = document.documentElement;
            const navbar = document.getElementById("navbar");

            /* ============================================================
               Tema
               ============================================================ */
            function applyTheme(theme) {
                root.classList.toggle("dark", theme === "dark");
                root.style.colorScheme = theme;

                document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
                    btn.setAttribute("aria-pressed", String(theme === "dark"));
                    btn.setAttribute("aria-label", theme === "dark" ? "Aktifkan mode terang" : "Aktifkan mode gelap");
                });
            }

            applyTheme(root.classList.contains("dark") ? "dark" : "light");

            document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
                btn.addEventListener("click", function () {
                    const next = root.classList.contains("dark") ? "light" : "dark";
                    applyTheme(next);
                    try { localStorage.setItem("theme", next); } catch (e) {}
                });
            });

            /* ============================================================
               Efek scroll navbar
               ============================================================ */
            function onScroll() {
                if (!navbar) return;
                navbar.classList.toggle("scrolled", window.scrollY > 8);
            }
            onScroll();
            window.addEventListener("scroll", onScroll, { passive: true });

            /* ============================================================
               Menu mobile
               ============================================================ */
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

            /* ============================================================
               SweetAlert2 — Toast & Modal
               ============================================================ */
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 3500,
                timerProgressBar: true,
                didOpen: (t) => {
                    t.addEventListener('mouseenter', Swal.stopTimer);
                    t.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            const AppSwal = {
                toast(type, title, text = '', extra = {}) {
                    return Toast.fire(Object.assign({
                        icon: type,
                        title: title,
                        text: text,
                        customClass: { popup: 'swal-toast swal-' + type }
                    }, extra));
                },

                modal(type, title, text = '', extra = {}) {
                    return Swal.fire(Object.assign({
                        icon: type,
                        title: title,
                        text: text,
                        buttonsStyling: false,
                        showClass: { popup: 'swal-in' },
                        hideClass: { popup: 'swal-out' },
                        customClass: {
                            popup: 'swal-popup swal-' + type,
                            title: 'swal-title',
                            htmlContainer: 'swal-text',
                            actions: 'swal-actions',
                            confirmButton: 'swal-btn swal-btn-confirm',
                            cancelButton: 'swal-btn swal-btn-cancel'
                        }
                    }, extra));
                },

                confirm({ title = 'Apakah Anda yakin?', text = '', confirmText = 'Ya, lanjutkan', cancelText = 'Batal', type = 'question' } = {}) {
                    return AppSwal.modal(type, title, text, {
                        showCancelButton: true,
                        confirmButtonText: confirmText,
                        cancelButtonText: cancelText,
                        reverseButtons: true,
                        focusCancel: type === 'warning' || type === 'error'
                    });
                }
            };
            window.AppSwal = AppSwal;

            /* ----- Konfirmasi otomatis: <form data-confirm="..."> ----- */
            document.addEventListener('submit', function (e) {
                const form = e.target.closest('form[data-confirm]');
                if (!form || form.dataset.confirmed) return;
                e.preventDefault();
                AppSwal.confirm({
                    title: form.dataset.confirm,
                    text: form.dataset.confirmText || 'Tindakan ini tidak dapat dibatalkan.',
                    confirmText: form.dataset.confirmButton || 'Ya, lanjutkan',
                    type: form.dataset.confirmType || 'warning'
                }).then(function (r) {
                    if (r.isConfirmed) { form.dataset.confirmed = '1'; form.submit(); }
                });
            });

            /* ----- Livewire event: $this->dispatch('swal', type: 'success', title: '...') ----- */
            window.addEventListener('swal', function (e) {
                const d = e.detail?.[0] ?? e.detail ?? {};
                AppSwal.toast(d.type ?? 'info', d.title ?? '', d.text ?? '');
            });

            /* ============================================================
               Flash message dari session
               ============================================================ */

            {{-- Login --}}
            @if (session('login_name') && session('login_provider'))
                AppSwal.toast(
                    'success',
                    'Selamat datang, ' + @json(session('login_name')) + '!',
                    'Berhasil masuk lewat ' + @json(ucfirst((string) session('login_provider'))) + '.'
                );
            @endif

            {{-- Logout --}}
            @if (session('logout_name'))
                AppSwal.toast(
                    'success',
                    'Sampai jumpa, ' + @json(session('logout_name')) + '!',
                    'Anda telah berhasil logout.'
                );
            @endif

            {{-- Success generik (tidak ditampilkan saat logout agar tidak dobel) --}}
            @if (session('success') && !session('logout_name'))
                AppSwal.toast('success', @json(session('success')));
            @endif

            @if (session('info'))
                AppSwal.toast('info', @json(session('info')));
            @endif

            @if (session('warning'))
                AppSwal.toast('warning', @json(session('warning')));
            @endif

            @if (session('error'))
                AppSwal.modal('error', 'Terjadi kesalahan', @json(session('error')), {
                    confirmButtonText: 'Mengerti'
                });
            @endif
        });
    </script>
</body>
</html>