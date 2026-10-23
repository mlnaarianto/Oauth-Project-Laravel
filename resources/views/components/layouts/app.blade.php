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

        /* ===== SweetAlert2 · tema cyber ===== */
        body:not(.swal2-toast-shown) .swal2-container.swal2-backdrop-show,
        body:not(.swal2-toast-shown) .swal2-container.swal2-noanimation { background: rgba(15, 23, 42, .55); backdrop-filter: blur(4px); }
        body.swal2-toast-shown .swal2-container { background: transparent !important; backdrop-filter: none !important; }

        /* --- TAMBAHAN: Menggeser posisi toast ke bawah agar tidak menutupi navbar --- */
        .swal2-container.swal2-top-end {
            top: 4.5rem !important; /* 4.5rem = 72px. Sesuaikan angkanya jika perlu */
        }
        /* --------------------------------------------------------------------------- */

        .swal-popup {
            --swal-accent: #22d3ee;
            position: relative; overflow: hidden;
            width: 26rem; max-width: calc(100vw - 2rem);
            padding: 1.75rem 1.5rem 1.5rem;
            border-radius: 1rem;
            background: #fff; color: #0f172a;
            border: 1px solid rgba(148, 163, 184, .35);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, .35);
        }
        .dark .swal-popup {
            background: #0b1220; color: #e2e8f0;
            border-color: rgba(34, 211, 238, .18);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, .8), 0 0 40px -12px var(--swal-accent);
        }
        /* garis aksen di atas popup */
        .swal-popup::before {
            content: ""; position: absolute; inset: 0 0 auto 0; height: 3px;
            background: linear-gradient(90deg, transparent, var(--swal-accent), transparent);
        }
        .swal-success  { --swal-accent: #10b981; }
        .swal-error    { --swal-accent: #f43f5e; }
        .swal-warning  { --swal-accent: #f59e0b; }
        .swal-info     { --swal-accent: #22d3ee; }
        .swal-question { --swal-accent: #8b5cf6; }

        .swal-popup .swal2-icon,
        .swal-toast .swal2-icon { border-color: var(--swal-accent) !important; color: var(--swal-accent) !important; }
        .swal-popup .swal2-icon { margin: .25rem auto 1rem; }
        .swal-popup .swal2-success-line-tip,
        .swal-popup .swal2-success-line-long,
        .swal-popup .swal2-x-mark-line-left,
        .swal-popup .swal2-x-mark-line-right,
        .swal-toast .swal2-success-line-tip,
        .swal-toast .swal2-success-line-long,
        .swal-toast .swal2-x-mark-line-left,
        .swal-toast .swal2-x-mark-line-right { background-color: var(--swal-accent) !important; }
        .swal-popup .swal2-success-ring,
        .swal-toast .swal2-success-ring { border-color: color-mix(in srgb, var(--swal-accent) 30%, transparent) !important; }
        .swal-popup .swal2-success-circular-line-left,
        .swal-popup .swal2-success-circular-line-right,
        .swal-popup .swal2-success-fix,
        .swal-toast .swal2-success-circular-line-left,
        .swal-toast .swal2-success-circular-line-right,
        .swal-toast .swal2-success-fix { background: transparent !important; }

        .swal-title { padding: 0; font-size: 1.25rem; font-weight: 700; letter-spacing: -.01em; }
        .swal-text  { margin: .5rem 0 0; font-size: .9rem; line-height: 1.55; color: #64748b; }
        .dark .swal-text { color: #94a3b8; }

        .swal-actions { gap: .6rem; margin-top: 1.5rem; }
        .swal-btn {
            padding: .6rem 1.25rem; border-radius: .65rem;
            font-size: .875rem; font-weight: 600; cursor: pointer;
            transition: transform .15s, box-shadow .15s, background .15s;
        }
        .swal-btn:active { transform: scale(.97); }
        .swal-btn:focus-visible { outline: 2px solid var(--swal-accent); outline-offset: 2px; }
        .swal-btn-confirm {
            color: #fff;
            background: linear-gradient(135deg, var(--swal-accent), color-mix(in srgb, var(--swal-accent) 65%, #000));
            box-shadow: 0 6px 18px -6px var(--swal-accent);
        }
        .swal-btn-confirm:hover { box-shadow: 0 8px 24px -6px var(--swal-accent); transform: translateY(-1px); }
        .swal-btn-cancel { color: #475569; background: transparent; border: 1px solid rgba(148, 163, 184, .5); }
        .swal-btn-cancel:hover { background: rgba(148, 163, 184, .15); }
        .dark .swal-btn-cancel { color: #cbd5e1; }

        /* animasi masuk/keluar */
        @keyframes swalIn  { from { opacity: 0; transform: translateY(12px) scale(.96); } to { opacity: 1; transform: none; } }
        @keyframes swalOut { to   { opacity: 0; transform: translateY(8px) scale(.97); } }
        .swal-in  { animation: swalIn .25s cubic-bezier(.2, .8, .2, 1); }
        .swal-out { animation: swalOut .15s ease-in forwards; }

        /* ===== Toast ===== */
        .swal-toast {
            width: 22rem !important; max-width: calc(100vw - 2rem);
            padding: .85rem 1rem !important; border-radius: .85rem !important;
            background: #fff; color: #0f172a;
            border: 1px solid rgba(148, 163, 184, .35);
            border-left: 4px solid var(--swal-accent);
            box-shadow: 0 12px 30px -10px rgba(15, 23, 42, .3) !important;
        }
        .dark .swal-toast {
            background: #0b1220; color: #e2e8f0;
            border-color: rgba(34, 211, 238, .18); border-left-color: var(--swal-accent);
            box-shadow: 0 12px 30px -10px rgba(0, 0, 0, .8), 0 0 24px -10px var(--swal-accent) !important;
        }
        .swal-toast .swal2-title { font-size: .875rem; font-weight: 600; margin: 0 0 0 .25rem; color: inherit; }
        .swal-toast .swal2-html-container { margin: .15rem 0 0 .25rem; font-size: .8rem; color: #64748b; }
        .dark .swal-toast .swal2-html-container { color: #94a3b8; }
        .swal-toast .swal2-timer-progress-bar { background: var(--swal-accent); height: 3px; }
        .swal-toast .swal2-icon { margin: 0 .5rem 0 0; transform: scale(.8); }
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

            /* ---------- Sidebar toggles ---------- */
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

            /* ---------- SweetAlert (custom) ---------- */
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 3500,
                timerProgressBar: true,
                didOpen: (t) => {
                    t.addEventListener('mouseenter', Swal.stopTimer);   // pause saat hover
                    t.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            const AppSwal = {
                toast(type, title, text = '', extra = {}) {
                    return Toast.fire(Object.assign({
                        icon: type, title, text,
                        customClass: { popup: 'swal-toast swal-' + type }
                    }, extra));
                },

                modal(type, title, text = '', extra = {}) {
                    return Swal.fire(Object.assign({
                        icon: type, title, text,
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

            /* ---------- Konfirmasi otomatis: <form data-confirm="Hapus data ini?"> ---------- */
            document.addEventListener('submit', function (e) {
                const form = e.target.closest('form[data-confirm]');
                if (!form || form.dataset.confirmed) return;
                e.preventDefault();
                AppSwal.confirm({
                    title: form.dataset.confirm,
                    text: form.dataset.confirmText || 'Tindakan ini tidak dapat dibatalkan.',
                    confirmText: form.dataset.confirmButton || 'Ya, hapus',
                    type: form.dataset.confirmType || 'warning'
                }).then(function (r) {
                    if (r.isConfirmed) { form.dataset.confirmed = '1'; form.submit(); }
                });
            });

            /* ---------- Livewire: $this->dispatch('swal', type: 'success', title: 'Tersimpan') ---------- */
            window.addEventListener('swal', function (e) {
                const d = e.detail?.[0] ?? e.detail ?? {};
                AppSwal.toast(d.type ?? 'info', d.title ?? '', d.text ?? '');
            });

            /* ---------- Flash message dari session ---------- */
            @if (session('login_name') && session('login_provider'))
                AppSwal.toast('success', 'Selamat datang, ' + @json(session('login_name')) + '!',
                    'Berhasil masuk lewat ' + @json(ucfirst((string) session('login_provider'))) + '.');
            @endif

            @if (session('success'))
                AppSwal.toast('success', @json(session('success')));
            @endif

            @if (session('info'))
                AppSwal.toast('info', @json(session('info')));
            @endif

            @if (session('warning'))
                AppSwal.toast('warning', 'Perhatian', @json(session('warning')));
            @endif

            @if (session('error'))
                AppSwal.modal('error', 'Terjadi kesalahan', @json(session('error')), {
                    confirmButtonText: 'Mengerti'
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>