{{-- resources/views/about.blade.php --}}
@extends('tampilan.app')

@section('title', 'About')

@push('styles')
<style>
    /* --- Gradient text untuk judul (sama dengan Home agar konsisten) --- */
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

    /* --- Kartu: lift halus + glow cyan saat hover --- */
    .cyber-card {
        position: relative;
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }
    .cyber-card:hover {
        transform: translateY(-4px);
        border-color: rgba(34, 211, 238, .55);
        box-shadow: 0 20px 44px -24px rgba(34, 211, 238, .55);
    }

    /* --- Bracket sudut ala HUD, muncul saat hover --- */
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
        top: 10px; left: 10px;
        border-top-width: 1px; border-left-width: 1px;
        border-style: solid;
    }
    .cyber-card::after {
        bottom: 10px; right: 10px;
        border-bottom-width: 1px; border-right-width: 1px;
        border-style: solid;
    }
    .cyber-card:hover::before,
    .cyber-card:hover::after { border-color: rgba(34, 211, 238, .55); }

    /* --- Frame foto ala "viewport" dengan corner marker --- */
    .cyber-frame {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        border: 1px solid rgba(148, 163, 184, .3);
        transition: border-color .3s ease, box-shadow .3s ease;
    }
    .dark .cyber-frame { border-color: rgba(51, 65, 85, .9); }
    .cyber-frame:hover {
        border-color: rgba(34, 211, 238, .55);
        box-shadow: 0 20px 44px -24px rgba(34, 211, 238, .55);
    }
    .cyber-frame img {
        transition: transform .5s ease, filter .5s ease;
    }
    .cyber-frame:hover img {
        transform: scale(1.03);
    }
    .dark .cyber-frame img { filter: saturate(.9) contrast(1.02); }
    .dark .cyber-frame:hover img { filter: saturate(1.05) contrast(1.05); }

    /* Corner markers foto (4 sudut) */
    .cyber-frame::before,
    .cyber-frame::after {
        content: "";
        position: absolute;
        width: 18px; height: 18px;
        border-color: rgba(34, 211, 238, .7);
        border-style: solid;
        z-index: 2;
        pointer-events: none;
    }
    .cyber-frame::before {
        top: 8px; left: 8px;
        border-top-width: 2px; border-left-width: 2px;
    }
    .cyber-frame::after {
        bottom: 8px; right: 8px;
        border-bottom-width: 2px; border-right-width: 2px;
    }

    /* Strip label di atas foto */
    .cyber-frame-label {
        position: absolute;
        top: 12px; right: 12px;
        z-index: 2;
        font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        font-size: 10px;
        letter-spacing: .18em;
        text-transform: uppercase;
        padding: 4px 8px;
        border-radius: 4px;
        background: rgba(7, 11, 18, .7);
        color: rgba(103, 232, 249, .9);
        border: 1px solid rgba(34, 211, 238, .35);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }
</style>
@endpush

@section('content')

    {{-- ============================================================
         HERO
         ============================================================ --}}
    <section class="relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 pb-16 pt-16 sm:px-6 md:pb-20 md:pt-24 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">

                {{-- Badge seksi --}}
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[11px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    about // manifest
                </div>

                {{-- Judul --}}
                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl md:text-6xl dark:text-slate-50">
                    Tentang <span class="cyber-gradient-text">MyApp</span>
                </h1>

                {{-- Garis aksen --}}
                <div class="cyber-rule mx-auto mt-6 w-24"></div>

                {{-- Subjudul --}}
                <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
                    Mengenal lebih dekat MyApp — tujuan, prinsip, dan tim kecil yang membangunnya.
                </p>

            </div>
        </div>
    </section>

    {{-- ============================================================
         KONTEN UTAMA: Teks + Foto
         ============================================================ --}}
    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">

                {{-- Kolom Teks --}}
                <div>
                    <p class="font-mono text-[11px] uppercase tracking-[0.22em] text-cyan-700 dark:text-cyan-400">
                        // latar belakang
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 md:text-4xl dark:text-slate-50">
                        Membangun tools yang <span class="cyber-gradient-text">tidak membingungkan</span>
                    </h2>

                    <p class="mt-6 text-base leading-relaxed text-slate-600 dark:text-slate-400">
                        MyApp dibangun dengan Laravel dan Tailwind CSS. Fokus kami sederhana:
                        menghadirkan aplikasi yang cepat, jelas, dan tidak memaksa pengguna
                        mempelajari ulang antarmuka setiap kali dibuka.
                    </p>
                    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-400">
                        Setiap keputusan desain diuji dengan satu pertanyaan — apakah ini
                        mempermudah pengguna mencapai tujuannya? Kalau tidak, kami buang.
                    </p>

                    {{-- Visi & Misi sebagai kartu (bukan ikon bulat biru) --}}
                    <div class="mt-8 grid gap-4 sm:grid-cols-2">

                        {{-- Visi --}}
                        <div class="cyber-card rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-[#0b1220]">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-cyan-500/25 bg-cyan-500/10 text-cyan-600 dark:border-cyan-400/25 dark:bg-cyan-400/10 dark:text-cyan-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.8"
                                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">Visi</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Menjadi platform terdepan yang menghubungkan pengguna dengan
                                solusi teknologi efisien dan mudah dipahami.
                            </p>
                        </div>

                        {{-- Misi --}}
                        <div class="cyber-card rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-[#0b1220]">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-violet-500/25 bg-violet-500/10 text-violet-600 dark:border-violet-400/25 dark:bg-violet-400/10 dark:text-violet-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.8"
                                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9" />
                                    <circle cx="12" cy="12" r="4" />
                                    <path d="M12 3v2M12 19v2M3 12h2M19 12h2" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">Misi</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                Mengembangkan produk berkualitas yang memudahkan aktivitas
                                sehari-hari dan mendukung produktivitas pengguna.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Kolom Foto --}}
                <div class="relative">
                    {{-- Glow dekoratif di belakang foto --}}
                    <div aria-hidden="true"
                         class="pointer-events-none absolute -inset-6 -z-10 rounded-[2rem] bg-gradient-to-tr from-cyan-400/10 via-transparent to-violet-400/10 blur-2xl dark:from-cyan-500/15 dark:to-violet-500/15"></div>

                    <figure class="cyber-frame">
                        <span class="cyber-frame-label">view.about</span>
                        {{-- Memanggil gambar lokal dari public/images/1.jpeg --}}
                        <img src="{{ asset('images/1.jpeg') }}"
                             alt="Ilustrasi tim MyApp"
                             width="600" height="400" loading="lazy"
                             class="h-auto w-full object-cover" />
                    </figure>

                    {{-- Caption mono kecil di bawah foto --}}
                    <figcaption class="mt-3 flex items-center justify-between font-mono text-[11px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-500">
                        <span>fig. 01 — workspace</span>
                        <span class="text-cyan-700 dark:text-cyan-400">◢ live</span>
                    </figcaption>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================
         NILAI / PRINSIP (menambah kedalaman halaman)
         ============================================================ --}}
    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-2xl text-center">
                <p class="font-mono text-[11px] uppercase tracking-[0.22em] text-cyan-700 dark:text-cyan-400">
                    // prinsip kerja
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 md:text-4xl dark:text-slate-50">
                    Yang kami pegang
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base dark:text-slate-400">
                    Tiga prinsip yang menentukan arah setiap fitur yang kami rilis.
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Prinsip 1 --}}
                <article class="cyber-card rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-[#0b1220]">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-cyan-500/25 bg-cyan-500/10 text-cyan-600 dark:border-cyan-400/25 dark:bg-cyan-400/10 dark:text-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </span>
                        <span class="font-mono text-xs tracking-widest text-slate-400 dark:text-slate-600">01</span>
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">Kejelasan</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Lebih baik satu tombol yang jelas daripada lima yang ambigu. Kami
                        memangkas yang tidak perlu.
                    </p>
                </article>

                {{-- Prinsip 2 --}}
                <article class="cyber-card rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-[#0b1220]">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-violet-500/25 bg-violet-500/10 text-violet-600 dark:border-violet-400/25 dark:bg-violet-400/10 dark:text-violet-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 2 3 6v6c0 5 3.8 9 9 10 5.2-1 9-5 9-10V6l-9-4Z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </span>
                        <span class="font-mono text-xs tracking-widest text-slate-400 dark:text-slate-600">02</span>
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">Kepercayaan</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Data pengguna dijaga dengan standar keamanan yang sama seperti kami
                        menjaga data sendiri.
                    </p>
                </article>

                {{-- Prinsip 3 --}}
                <article class="cyber-card rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-[#0b1220]">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-sky-500/25 bg-sky-500/10 text-sky-600 dark:border-sky-400/25 dark:bg-sky-400/10 dark:text-sky-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 17V7l6 6 6-6v10" />
                                <path d="M15 7h6v10h-6" />
                            </svg>
                        </span>
                        <span class="font-mono text-xs tracking-widest text-slate-400 dark:text-slate-600">03</span>
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">Konsistensi</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        Satu bahasa visual di seluruh halaman, dari beranda sampai pengaturan
                        paling dalam.
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

                <div aria-hidden="true"
                     class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent dark:via-cyan-400/50"></div>
                <div aria-hidden="true"
                     class="pointer-events-none absolute -top-24 left-1/2 h-48 w-72 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

                <p class="relative font-mono text-[11px] uppercase tracking-[0.22em] text-cyan-700 dark:text-cyan-400">
                    // lanjut
                </p>
                <h2 class="relative mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Kenali lewat pengalaman langsung
                </h2>
                <p class="relative mx-auto mt-3 max-w-lg text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Halaman ini cuma ringkasan. Coba sendiri aplikasinya untuk merasakan bedanya.
                </p>

                <div class="relative mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="{{ url('/login') }}"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-6 py-3 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_28px_-6px_rgba(34,211,238,.7)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                        Masuk ke Aplikasi
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                    <a href="{{ url('/') }}"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition-colors hover:border-slate-400 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-slate-700 dark:text-slate-200 dark:hover:border-slate-500 dark:hover:bg-slate-800/60 dark:focus-visible:ring-offset-[#0b1220]">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection