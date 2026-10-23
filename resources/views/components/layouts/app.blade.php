<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'My App' }}</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="h-screen overflow-hidden bg-slate-50 dark:bg-slate-900 transition-colors duration-300">

    {{-- NAVBAR --}}
    <x-partials.navbar />

    {{-- BODY WRAPPER --}}
    <div class="flex h-[calc(100vh-56px)]">

        {{-- SIDEBAR --}}
        <x-partials.sidebar />

        {{-- MAIN AREA --}}
        <div class="flex flex-col flex-1 min-w-0">

            {{-- CONTENT (SCROLLABLE) --}}
            <main id="content" class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            {{-- FOOTER --}}
            <x-partials.footer />

        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileToggle');

        // Desktop toggle: geser sidebar keluar pakai margin
        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('md:-ml-64');
        });

        // Mobile toggle: geser sidebar pakai translate
        mobileToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // FIX Facebook login (#_=_)
        if (window.location.hash === "#_=_") {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }

        // SweetAlert sukses login
        @if (session('login_name') && session('login_provider'))
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                html: 'Halo <b>{{ session('login_name') }}</b> <span style="opacity:0.7;">({{ session('login_provider') }})</span>',
                showConfirmButton: false,
                timer: 2500
            });
        @endif

        // SweetAlert error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>