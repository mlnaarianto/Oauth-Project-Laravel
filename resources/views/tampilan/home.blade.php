{{-- resources/views/home.blade.php --}}
@extends('tampilan.app')

@section('title', 'Home')

@push('styles')
<style>
    /* --- Judul dengan gradient cyan → violet (glow sangat tipis) --- */
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

    /* --- Garis pemisah aksen di bawah judul --- */
    .cyber-rule {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(34, 211, 238, .55), rgba(167, 139, 250, .45), transparent);
    }

    /* --- Kartu fitur: lift halus + glow cyan saat hover --- */
    .cyber-card {
        position: relative;
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }
    .cyber-card:hover {
        transform: translateY(-4px);
        border-color: rgba(34, 211, 238, .55);
        box-shadow: 0 20px 44px -24px rgba(34, 211, 238, .55);
    }

    /* --- Bracket sudut ala HUD (muncul saat hover) --- */
    .cyber-card::before,
    .cyber-card::after {
        content: "";
        position: absolute;
        width: 14px;
        height: 14px;
        pointer-events: none;
        transition: border-color .3s ease;
        border-color: transparent;
    }
    .cyber-card::before {
        top: 10px;
        left: 10px;
        border-top-width: 1px;
        border-left-width: 1px;
        border-style: solid;
    }
    .cyber-card::after {
        bottom: 10px;
        right: 10px;
        border-bottom-width: 1px;
        border-right-width: 1px;
        border-style: solid;
    }
    .cyber-card:hover::before,
    .cyber-card:hover::after { border-color: rgba(34, 211, 238, .55); }

    /* --- Scanline dekoratif di hero (sangat halus) --- */
    .cyber-scan {
        background-image: repeating-linear-gradient(
            to bottom,
            rgba(34, 211, 238, .05) 0px,
            rgba(34, 211, 238, .05) 1px,
            transparent 1px,
            transparent 4px
        );
        -webkit-mask-image: linear-gradient(to bottom, #000, transparent 70%);
        mask-image: linear-gradient(to bottom, #000, transparent 70%);
    }
</style>
@endpush

@section('content')

    {{-- ============================================================
         HERO
         ============================================================ --}}
    <section class="relative overflow-hidden">
        {{-- Scanline dekoratif, non-interaktif --}}
        <div aria-hidden="true" class="cyber-scan pointer-events-none absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-7xl px-4 pb-20 pt-16 sm:px-6 md:pb-28 md:pt-24 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">

                {{-- Badge status --}}
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[11px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    system online // v2.0
                </div>

                {{-- Judul --}}
                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl md:text-6xl dark:text-slate-50">
                    Selamat datang di
                    <span class="cyber-gradient-text">MyApp</span>
                </h1>

                {{-- Garis aksen --}}
                <div class="cyber-rule mx-auto mt-6 w-24"></div>

                {{-- Subjudul --}}
                <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                    Platform yang cepat, stabil, dan ramah pengguna. Dirancang untuk tampil
                    nyaman di segala perangkat tanpa mengorbankan kejelasan.
                </p>

                {{-- CTA --}}
                <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="#features"
                       class="group inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-6 py-3 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_28px_-6px_rgba(34,211,238,.7)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#070b12]">
                        Jelajahi Fitur
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>

                    <a href="{{ url('/about') }}"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition-colors hover:border-slate-400 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-slate-700 dark:text-slate-200 dark:hover:border-slate-500 dark:hover:bg-slate-800/60 dark:focus-visible:ring-offset-[#070b12]">
                        Tentang Kami
                    </a>
                </div>

                {{-- Baris metrik singkat --}}
                <dl class="mx-auto mt-12 grid max-w-xl grid-cols-3 divide-x divide-slate-200 overflow-hidden rounded-xl border border-slate-200 bg-white/70 backdrop-blur-sm dark:divide-slate-800 dark:border-slate-800 dark:bg-slate-900/40">
                    <div class="px-3 py-4">
                        <dt class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-500">Uptime</dt>
                        <dd class="mt-1 font-mono text-base font-semibold text-slate-900 dark:text-cyan-300">99.9%</dd>
                    </div>
                    <div class="px-3 py-4">
                        <dt class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-500">Response</dt>
                        <dd class="mt-1 font-mono text-base font-semibold text-slate-900 dark:text-cyan-300">&lt;120ms</dd>
                    </div>
                    <div class="px-3 py-4">
                        <dt class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-500">Support</dt>
                        <dd class="mt-1 font-mono text-base font-semibold text-slate-900 dark:text-cyan-300">24/7</dd>
                    </div>
                </dl>

            </div>
        </div>
    </section>

    {{-- ============================================================
         FEATURES
         ============================================================ --}}
    <section id="features" class="scroll-mt-24 py-16 md:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header seksi --}}
            <div class="mx-auto max-w-2xl text-center">
                <p class="font-mono text-[11px] uppercase tracking-[0.22em] text-cyan-700 dark:text-cyan-400">
                    // modul inti
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 md:text-4xl dark:text-slate-50">
                    Fitur Utama
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base dark:text-slate-400">
                    Tiga pilar yang membuat aplikasi ini terasa cepat dan tidak membingungkan.
                </p>
            </div>

            {{-- Grid kartu --}}
            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Card 1 --}}
                <article class="cyber-card overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-[#0b1220]">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-cyan-500/25 bg-cyan-500/10 text-cyan-600 dark:border-cyan-400/25 dark:bg-cyan-400/10 dark:text-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z" />
                            </svg>
                        </span>
                        <span class="font-mono text-xs tracking-widest text-slate-400 dark:text-slate-600">01</span>
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">Cepat dan Stabil</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Performa tinggi dengan waktu muat singkat, sehingga aktivitas harian tetap lancar.
                    </p>
                </article>

                {{-- Card 2 --}}
                <article class="cyber-card overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-[#0b1220]">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-violet-500/25 bg-violet-500/10 text-violet-600 dark:border-violet-400/25 dark:bg-violet-400/10 dark:text-violet-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 4l7.5 16 2.5-6.5L20.5 11 4 4Z" />
                            </svg>
                        </span>
                        <span class="font-mono text-xs tracking-widest text-slate-400 dark:text-slate-600">02</span>
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">User Friendly</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Navigasi sederhana, kontras teks terjaga, dan alur yang mudah dipahami pengguna baru.
                    </p>
                </article>

                {{-- Card 3 --}}
                <article class="cyber-card overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-[#0b1220]">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-sky-500/25 bg-sky-500/10 text-sky-600 dark:border-sky-400/25 dark:bg-sky-400/10 dark:text-sky-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="12" rx="2" />
                                <path d="M8 20h8M12 16v4" />
                            </svg>
                        </span>
                        <span class="font-mono text-xs tracking-widest text-slate-400 dark:text-slate-600">03</span>
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">Responsive</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Tampil optimal di ponsel, tablet, maupun desktop tanpa perlu zoom.
                    </p>
                </article>

            </div>
        </div>
    </section>

    {{-- ============================================================
         CTA PENUTUP
         ============================================================ --}}
    <section class="pb-20 md:pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-8 text-center sm:p-12 dark:border-slate-800 dark:bg-[#0b1220]">

                {{-- Garis aksen atas --}}
                <div aria-hidden="true"
                     class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent dark:via-cyan-400/50"></div>

                {{-- Glow lembut di belakang --}}
                <div aria-hidden="true"
                     class="pointer-events-none absolute -top-24 left-1/2 h-48 w-72 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

                <p class="relative font-mono text-[11px] uppercase tracking-[0.22em] text-cyan-700 dark:text-cyan-400">
                    // mulai sekarang
                </p>
                <h2 class="relative mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Siap mencoba MyApp?
                </h2>
                <p class="relative mx-auto mt-3 max-w-lg text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Masuk ke akun Anda dan rasakan alur kerja yang lebih ringkas.
                </p>

                <a href="{{ url('/login') }}"
                   class="relative mt-8 inline-flex items-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-6 py-3 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_28px_-6px_rgba(34,211,238,.7)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                    Masuk ke Aplikasi
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

@endsection