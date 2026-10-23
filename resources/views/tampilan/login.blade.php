{{-- resources/views/auth/login.blade.php --}}
@extends('tampilan.app')

@section('title', 'Login')

@push('styles')
<style>
    /* =========================================================
       FIX TOTAL: MENGHILANGKAN CELAH DI ATAS FOOTER
       ========================================================= */
    
    /* 1. Ubah main agar tidak memaksa 100vh penuh, tapi pas sisa layar setelah navbar */
    main {
        min-height: calc(100vh - 4rem) !important;
        display: flex;
        flex-direction: column;
    }

    /* 2. Hilangkan margin bawaan pada footer hanya di halaman ini */
    footer {
        margin-top: 0 !important;
    }

    /* --- Gradient text --- */
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

    /* --- Divider aksen tipis --- */
    .cyber-rule {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(34, 211, 238, .45), rgba(167, 139, 250, .35), transparent);
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
{{-- 3. Gunakan flex-1 agar section otomatis merenggang mengisi seluruh ruang main --}}
<section class="relative flex flex-1 flex-col bg-white lg:flex-row dark:bg-[#070b12]">
    
    {{-- ================= KIRI: Branding panel (Full Image) ================= --}}
    <aside class="relative hidden overflow-hidden border-r border-slate-200/70 bg-slate-50 lg:flex lg:w-1/2 dark:border-slate-800/80 dark:bg-[#070b12]">
        
        {{-- Gambar Full dari folder public/images --}}
        <img src="{{ asset('images/1.jpeg') }}" 
             alt="Login Illustration" 
             class="absolute inset-0 h-full w-full object-cover object-center" />

        {{-- (Opsional) Overlay gelap tipis saat Dark Mode agar gambar tidak terlalu menyilaukan --}}
        <div class="pointer-events-none absolute inset-0 hidden bg-black/20 dark:block"></div>

    </aside>

    {{-- ================= KANAN: Form login ================= --}}
    <div class="relative flex w-full flex-col bg-white px-6 py-8 sm:px-12 lg:w-1/2 xl:px-20 dark:bg-[#070b12]">
        
        <div class="mx-auto my-auto flex w-full max-w-md flex-col py-6 sm:py-10">

            {{-- Mobile-only logo --}}
            <div class="mb-8 flex items-center gap-3 lg:hidden">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900 text-xs font-bold tracking-tight text-white dark:bg-gradient-to-br dark:from-cyan-500 dark:to-indigo-500">M</div>
                <div class="flex flex-col leading-none">
                    <span class="text-base font-semibold tracking-tight text-slate-900 dark:text-white">My<span class="cyber-gradient-text">App</span></span>
                    <span class="mt-1 text-[10px] font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Digital Workspace</span>
                </div>
            </div>

            {{-- Header --}}
            <div class="mb-6 text-center sm:text-left">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    secure.auth
                </div>
                <h2 class="mb-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Masuk ke <span class="cyber-gradient-text">MyApp</span>
                </h2>
                <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Pilih penyedia di bawah untuk melanjutkan. Akun baru dibuat otomatis saat login pertama.
                </p>
            </div>

            <div class="cyber-rule my-5"></div>

            {{-- Providers --}}
            @php
                $providers = [
                    'google'   => ['label' => 'Continue with Google',   'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/google.svg'],
                    'facebook' => ['label' => 'Continue with Facebook', 'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/facebook.svg'],
                    'github'   => ['label' => 'Continue with GitHub',   'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/github.svg'],
                    'x'        => ['label' => 'Continue with X',        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg'],
                    'discord'  => ['label' => 'Continue with Discord',  'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/discord.svg'],
                ];

                $enabledProviders = config('services.enabled_providers', [
                    'google', 'facebook', 'github', 'x', 'discord',
                ]);
            @endphp

            <div class="space-y-2.5">
                @foreach ($enabledProviders as $provider)
                    @if (isset($providers[$provider]))
                        <a href="{{ route('oauth.redirect', $provider) }}"
                           class="social-btn group flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-200">

                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 transition-colors group-hover:border-cyan-400/40 group-hover:bg-cyan-500/5 dark:border-slate-700 dark:bg-slate-900/60 dark:group-hover:border-cyan-400/30 dark:group-hover:bg-cyan-400/5">
                                <img src="{{ $providers[$provider]['icon'] }}"
                                     width="16" height="16"
                                     class="h-4 w-4 dark:invert"
                                     alt="" aria-hidden="true" />
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

            {{-- Error --}}
            @if (session('error'))
                <div class="relative mt-5 overflow-hidden rounded-lg border border-red-500/30 bg-red-500/5 p-3.5 text-sm text-red-700 dark:border-red-400/30 dark:bg-red-400/5 dark:text-red-300" role="alert">
                    <div aria-hidden="true" class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-red-500/60 to-transparent"></div>
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

            {{-- Legal --}}
            <p class="mt-6 px-2 text-center text-xs leading-relaxed text-slate-500 dark:text-slate-500">
                Dengan melanjutkan, Anda menyetujui
                <a href="#" class="font-medium text-cyan-700 underline-offset-2 hover:underline dark:text-cyan-400">Ketentuan Layanan</a>
                dan
                <a href="#" class="font-medium text-cyan-700 underline-offset-2 hover:underline dark:text-cyan-400">Kebijakan Privasi</a>
                kami.
            </p>
        </div>
    </div>
</section>
@endsection