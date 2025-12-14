@extends('tampilan.app')

@section('title', 'Login')

@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="login-box text-center p-4">

            {{-- Header --}}
            <div class="mb-4">
                {{-- Menggunakan h4 untuk judul dan h5 untuk deskripsi agar lebih lembut --}}
                <h4 class="fw-bold">Login or Sign Up</h4>
                <p class="text-muted mb-0">Continue using one of the options below</p>
            </div>

            <hr class="my-4"> {{-- Tambahkan garis pemisah untuk memperjelas --}}

            {{-- Dynamic Provider Buttons --}}
            @php
                $providers = [
                    'google' => [
                        'label' => 'Continue with Google',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/google.svg',
                    ],
                    'facebook' => [
                        'label' => 'Continue with Facebook',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/facebook.svg',
                    ],
                    'github' => [
                        'label' => 'Continue with GitHub',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/github.svg',
                    ],
                    'x' => [
                        'label' => 'Continue with X (Twitter)',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg',
                    ],
                    // TAMBAHKAN KONFIGURASI DISCORD DI SINI
                    'discord' => [
                        'label' => 'Continue with Discord',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/discord.svg', // Ikon Discord
                    ],
                ];

                // if someday you disable provider dynamically
                // TAMBAHKAN 'discord' KE DAFTAR DEFAULT
                $enabledProviders = config('services.enabled_providers', [
                    'google',
                    'facebook',
                    'github',
                    'x',
                    'discord',
                ]);
            @endphp

            @foreach ($enabledProviders as $provider)
                @if (isset($providers[$provider]))
                    <a href="{{ route('oauth.redirect', $provider) }}"
                        class="btn btn-light btn-social w-100 shadow-sm py-2 mb-3 d-flex align-items-center justify-content-center gap-2">
                        <img src="{{ $providers[$provider]['icon'] }}" width="22"
                            alt="{{ $providers[$provider]['label'] }} Icon">
                        {{ $providers[$provider]['label'] }}
                    </a>
                @endif
            @endforeach

            {{-- Error --}}
            @if (session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Footer/Legal Info --}}
            <p class="text-muted small mt-4 mb-0">By continuing, you agree to our <a href="#">Terms of Service</a> and
                <a href="#">Privacy Policy</a>.</p>

        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Menggunakan font-family yang lebih universal atau diimport (jika ada) */
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            /* Border radius sedikit lebih kecil untuk tampilan modern */
            border-radius: 12px;
            background: white;
            /* Menggunakan box-shadow yang lebih dalam tapi lembut */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Hapus border: 1px solid #eee; karena sudah ada shadow */
        }

        .btn-social {
            /* Styling default dihilangkan karena sudah menggunakan btn btn-light Bootstrap */

            /* Border dan warna diserahkan ke Bootstrap, kita hanya perhalus hover */
            border-radius: 8px;
            /* Sudut tombol lebih lembut */
            font-size: 1rem;
            /* Ukuran font standar */
            font-weight: 600;
            /* Sedikit lebih tebal */
            transition: all .2s ease-in-out;
            border: 1px solid #dee2e6;
            /* Border tipis untuk tombol light */
        }

        .btn-social:hover {
            /* Efek hover lebih menonjol */
            background-color: #f1f1f1 !important;
            border-color: #ced4da !important;
            transform: translateY(-1px);
            /* Efek 'angkat' saat di-hover */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn-social img {
            /* Pastikan ikon tidak berubah ukuran */
            flex-shrink: 0;
        }

        /* Responsif: Padding lebih kecil di layar sangat kecil */
        @media (max-width: 576px) {
            .login-box {
                max-width: 95%;
                margin: 20px;
            }
        }
    </style>
@endpush
