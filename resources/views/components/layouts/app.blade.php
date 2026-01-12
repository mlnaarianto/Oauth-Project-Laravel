<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My App' }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- SweetAlert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* RESET */
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden; /* body tidak scroll */
        }

        /* SIDEBAR */
        #sidebar {
            width: 250px;
            height: 100vh;
            background: #212529;
            transition: all 0.3s ease-in-out;
            flex-shrink: 0;
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        #sidebar .nav-link {
            color: #adb5bd;
        }

        #sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* WRAPPER UTAMA (NAVBAR SUDAH DI LUAR) */
        .app-wrapper {
            display: flex;
            height: calc(100vh - 56px); /* tinggi navbar bootstrap */
        }

        /* AREA KANAN */
        .main-area {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-width: 0;
        }

        /* CONTENT (INI YANG SCROLL) */
        #content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: #f8f9fa;
        }

        /* FOOTER */
        footer {
            flex-shrink: 0;
            background: #fff;
            border-top: 1px solid #dee2e6;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 56px;
                left: -250px;
                z-index: 999;
            }

            #sidebar.show {
                left: 0;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <x-partials.navbar />

    {{-- BODY --}}
    <div class="app-wrapper">

        {{-- SIDEBAR --}}
        <x-partials.sidebar />

        {{-- MAIN AREA --}}
        <div class="main-area">

            {{-- CONTENT --}}
            <div id="content">
                {{ $slot }}
            </div>

            {{-- FOOTER --}}
            <x-partials.footer />

        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileToggle');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        mobileToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
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
