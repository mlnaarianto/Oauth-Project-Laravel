{{-- resources/views/components/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'My App' }}</title>

    {{-- Cegah flash tema (default: dark, konsisten dengan halaman publik) --}}
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

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Grid halus di belakang area konten */
        .cyber-grid {
            background-image:
                linear-gradient(to right, rgba(15, 23, 42, .04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, .04) 1px, transparent 1px);
            background-size: 56px 56px;
            -webkit-mask-image: radial-gradient(ellipse 100% 80% at 50% 0%, #000 30%, transparent 85%);
            mask-image: radial-gradient(ellipse 100% 80% at 50% 0%, #000 30%, transparent 85%);
        }
        .dark .cyber-grid {
            background-image:
                linear-gradient(to right, rgba(34, 211, 238, .05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(34, 211, 238, .05) 1px, transparent 1px);
        }

        /* Scrollbar ramping di area konten */
        #content::-webkit-scrollbar { width: 10px; height: 10px; }
        #content::-webkit-scrollbar-track { background: transparent; }
        #content::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, .35);
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: content-box;
        }
        #content::-webkit-scrollbar-thumb:hover { background: rgba(34, 211, 238, .55); background-clip: content-box; }
    </style>
</head>

<body class="h-screen overflow-hidden bg-slate-50 font-sans text-slate-700 transition-colors duration-300 dark:bg-[#070b12] dark:text-slate-300">

    {{-- NAVBAR --}}
    <x-partials.navbar />

    {{-- BODY WRAPPER --}}
    <div class="relative flex h-[calc(100vh-56px)]">

        {{-- Grid dekoratif (di bawah konten, di atas background) --}}
        <div aria-hidden="true" class="cyber-grid pointer-events-none absolute inset-0 z-0"></div>

        {{-- SIDEBAR --}}
        <x-partials.sidebar />

        {{-- MAIN AREA --}}
        <div class="relative z-10 flex min-w-0 flex-1 flex-col">

            {{-- CONTENT (SCROLLABLE) --}}
            <main id="content" class="flex-1 overflow-y-auto p-4 sm:p-6">
                {{ $slot }}
            </main>

            {{-- FOOTER --}}
            <x-partials.footer />

        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.documentElement;
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileToggle = document.getElementById('mobileToggle');

            /* ---------- Tema ---------- */
            function applyTheme(theme) {
                root.classList.toggle('dark', theme === 'dark');
                root.style.colorScheme = theme;
                document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                    btn.setAttribute('aria-pressed', String(theme === 'dark'));
                    btn.setAttribute('aria-label', theme === 'dark' ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
                });
            }
            applyTheme(root.classList.contains('dark') ? 'dark' : 'light');

            document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const next = root.classList.contains('dark') ? 'light' : 'dark';
                    applyTheme(next);
                    try { localStorage.setItem('theme', next); } catch (e) {}
                });
            });

            /* ---------- Sidebar toggles (logika asli, tidak diubah) ---------- */
            sidebarToggle?.addEventListener('click', () => {
                sidebar.classList.toggle('md:-ml-64');
            });

            mobileToggle?.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            /* ---------- Fix Facebook login ---------- */
            if (window.location.hash === "#_=_") {
                history.replaceState(null, null, window.location.pathname + window.location.search);
            }

            /* ---------- SweetAlert ---------- */
            const isDark = root.classList.contains('dark');
            const swalTheme = {
                background: isDark ? '#0b1220' : '#ffffff',
                color: isDark ? '#e2e8f0' : '#0f172a',
                confirmButtonColor: '#0891b2'
            };

            function escapeHtml(str) {
                return String(str ?? '').replace(/[&<>"']/g, function (c) {
                    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
                });
            }

            @if (session('login_name') && session('login_provider'))
                Swal.fire(Object.assign({}, @json($swalThemeJs ?? null) || {}, {
                    icon: 'success',
                    title: 'Login Berhasil',
                    html: 'Halo <b>' + escapeHtml(@json(session('login_name'))) + '</b> '
                        + '<span style="opacity:.65">(' + escapeHtml(@json(session('login_provider'))) + ')</span>',
                    showConfirmButton: false,
                    timer: 2500,
                    background: swalTheme.background,
                    color: swalTheme.color
                }));
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: @json(session('error')),
                    background: swalTheme.background,
                    color: swalTheme.color,
                    confirmButtonColor: swalTheme.confirmButtonColor
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>