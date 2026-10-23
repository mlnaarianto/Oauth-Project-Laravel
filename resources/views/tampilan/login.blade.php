{{-- resources/views/auth/login.blade.php --}}
@extends('tampilan.app')

@section('title', 'Login')

@push('styles')
<style>
    /* --- Gradient text — konsisten dengan Home & About --- */
    .cyber-gradient-text {
        background-image: linear-gradient(100deg, #0891b2 0%, #22d3ee 35%, #6366f1 70%, #a78bfa 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .dark .cyber-gradient-text {
        background-image: linear-gradient(100deg, #22d3ee 0%, #67e8f9 35%, #a5b4fc 70%, #c4b5fd 100%);
        filter: drop-shadow(0 0 24px rgba(34, 211, 238, .18));
    }

    /* --- Garis aksen tipis sebagai divider --- */
    .cyber-rule {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(34, 211, 238, .45), rgba(167, 139, 250, .35), transparent);
    }

    /* --- Bracket sudut kartu auth (ala HUD) --- */
    .auth-card::before,
    .auth-card::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-color: rgba(34, 211, 238, .45);
        border-style: solid;
        pointer-events: none;
        z-index: 2;
    }
    .auth-card::before {
        top: -1px;
        left: -1px;
        border-top-width: 2px;
        border-left-width: 2px;
        border-top-left-radius: 1rem;
    }
    .auth-card::after {
        bottom: -1px;
        right: -1px;
        border-bottom-width: 2px;
        border-right-width: 2px;
        border-bottom-right-radius: 1rem;
    }

    /* --- Tombol social --- */
    .social-btn {
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }
    .social-btn:hover {
        transform: translateY(-1px);
        border-color: rgba(34, 211, 238, .5);
        box-shadow: 0 10px 28px -14px rgba(34, 211, 238, .55);
    }
</style>
@endpush

@section('content')
<section class="relative flex min-h-[calc(100vh-4rem)] items-center justify-center px-4 py-12 sm:px-6">
    <div class="w-full max-w-md">

        {{-- Baris atas: back link + versi ---}}
        <div class="mb-5 flex items-center justify-between px-1">
            <a href="{{ url('/') }}"
               class="group inline-flex items-center gap-1.5 rounded-md text-sm font-medium text-slate-500 transition-colors hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-50 dark:text-slate-400 dark:hover:text-cyan-300 dark:focus-visible:ring-offset-[#070b12]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5M11 6l-6 6 6 6" />
                </svg>
                Beranda
            </a>
            <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600">
                auth.v2
            </span>
        </div>

        {{-- Kartu Login ---}}
        <div class="auth-card relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-[#0b1220] dark:shadow-none sm:p-8">

            {{-- Garis gradient atas ---}}
            <div aria-hidden="true"
                 class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent dark:via-cyan-400/50"></div>

            {{-- Glow lembut di belakang header ---}}
            <div aria-hidden="true"
                 class="pointer-events-none absolute -top-24 left-1/2 h-48 w-64 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

            {{-- Header ---}}
            <div class="relative text-center">
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    secure.auth
                </div>

                <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Masuk ke <span class="cyber-gradient-text">MyApp</span>
                </h1>
                <p class="mx-auto mt-2 max-w-xs text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Pilih penyedia di bawah untuk melanjutkan. Tidak perlu membuat kata sandi baru.
                </p>
            </div>

            {{-- Divider ---}}
            <div class="cyber-rule my-6"></div>

            {{-- Dynamic Provider Buttons ---}}
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
                        'label' => 'Continue with X',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg',
                    ],
                    'discord' => [
                        'label' => 'Continue with Discord',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/discord.svg',
                    ],
                ];

                $enabledProviders = config('services.enabled_providers', [
                    'google',
                    'facebook',
                    'github',
                    'x',
                    'discord',
                ]);
            @endphp

            <div class="relative space-y-2.5">
                @foreach ($enabledProviders as $provider)
                    @if (isset($providers[$provider]))
                        <a href="{{ route('oauth.redirect', $provider) }}"
                           class="social-btn group flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-200">

                            {{-- Kotak ikon provider ---}}
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 transition-colors group-hover:border-cyan-400/40 group-hover:bg-cyan-500/5 dark:border-slate-700 dark:bg-slate-900/60 dark:group-hover:border-cyan-400/30 dark:group-hover:bg-cyan-400/5">
                                <img src="{{ $providers[$provider]['icon'] }}"
                                     width="18" height="18"
                                     class="h-[18px] w-[18px] dark:invert"
                                     alt=""
                                     aria-hidden="true" />
                            </span>

                            <span class="flex-1 text-left">{{ $providers[$provider]['label'] }}</span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:text-cyan-500 dark:text-slate-500 dark:group-hover:text-cyan-400"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6" />
                            </svg>
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Error ---}}
            @if (session('error'))
                <div class="relative mt-5 overflow-hidden rounded-lg border border-red-500/30 bg-red-500/5 p-3.5 text-sm text-red-700 dark:border-red-400/30 dark:bg-red-400/5 dark:text-red-300" role="alert">
                    <div aria-hidden="true"
                         class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-red-500/60 to-transparent"></div>
                    <div class="flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 8v4M12 16h.01" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Note informatif: auto-create account ---}}
            <p class="mt-5 flex items-center justify-center gap-1.5 font-mono text-[11px] uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">
                <span aria-hidden="true" class="text-cyan-600/70 dark:text-cyan-400/60">◇</span>
                Akun baru dibuat otomatis saat login pertama
            </p>

        </div>

        {{-- Legal di luar kartu supaya tidak menumpuk ---}}
        <p class="mt-6 px-4 text-center text-xs leading-relaxed text-slate-500 dark:text-slate-500">
            Dengan melanjutkan, Anda menyetujui
            <a href="#" class="font-medium text-cyan-700 underline-offset-2 hover:underline dark:text-cyan-400">Ketentuan Layanan</a>
            dan
            <a href="#" class="font-medium text-cyan-700 underline-offset-2 hover:underline dark:text-cyan-400">Kebijakan Privasi</a>
            kami.
        </p>

    </div>
</section>
@endsection