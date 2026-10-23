{{-- resources/views/tampilan/social-confirm.blade.php --}}
@extends('tampilan.app')

@section('title', 'Konfirmasi Penautan Akun Sosial')

@push('styles')
<style>
    /* --- Gradient text — konsisten dengan Home / About / Login --- */
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

    .cyber-rule {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(34, 211, 238, .45), rgba(167, 139, 250, .35), transparent);
    }

    /* --- Bracket sudut kartu (sama seperti halaman login) --- */
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
        top: -1px; left: -1px;
        border-top-width: 2px; border-left-width: 2px;
        border-top-left-radius: 1rem;
    }
    .auth-card::after {
        bottom: -1px; right: -1px;
        border-bottom-width: 2px; border-right-width: 2px;
        border-bottom-right-radius: 1rem;
    }

    /* --- Protokol card: hover halus --- */
    .protocol-card {
        transition: border-color .25s ease, box-shadow .25s ease;
    }
    .protocol-card:hover {
        border-color: rgba(34, 211, 238, .35);
        box-shadow: 0 12px 32px -22px rgba(34, 211, 238, .5);
    }

    /* --- Timer OTP: transisi warna lembut saat hampir habis --- */
    #otp-timer { transition: color .2s ease; }
</style>
@endpush

@section('content')
<section class="relative py-12 sm:py-16">
    <div class="mx-auto max-w-2xl px-4 sm:px-6">

        {{-- Baris atas: back link + tag --}}
        <div class="mb-5 flex items-center justify-between px-1">
            <a href="{{ route('login') }}"
               class="group inline-flex items-center gap-1.5 rounded-md text-sm font-medium text-slate-500 transition-colors hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-50 dark:text-slate-400 dark:hover:text-cyan-300 dark:focus-visible:ring-offset-[#070b12]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5M11 6l-6 6 6 6" />
                </svg>
                Kembali ke Login
            </a>
            <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600">
                security.link
            </span>
        </div>

        {{-- KARTU UTAMA --}}
        <div class="auth-card relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-[#0b1220] dark:shadow-none sm:p-8">

            {{-- Garis gradient atas --}}
            <div aria-hidden="true"
                 class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent dark:via-cyan-400/50"></div>

            {{-- Glow lembut di belakang header --}}
            <div aria-hidden="true"
                 class="pointer-events-none absolute -top-24 left-1/2 h-48 w-64 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

            {{-- HEADER --}}
            <div class="relative text-center">
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    verifikasi identitas
                </div>

                <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Konfirmasi <span class="cyber-gradient-text">Penautan Akun</span>
                </h1>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Pilih satu metode untuk membuktikan kepemilikan email
                    <strong class="font-medium text-slate-700 dark:text-slate-200">{{ $payload['email'] ?? '' }}</strong>.
                </p>
            </div>

            {{-- Session info --}}
            @if (session('info'))
                <div class="mt-6 overflow-hidden rounded-lg border border-cyan-500/25 bg-cyan-500/5 p-3.5 text-sm text-cyan-800 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300" role="status">
                    <div class="flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 16v-4M12 8h.01" />
                        </svg>
                        <span>{{ session('info') }}</span>
                    </div>
                </div>
            @endif

            {{-- RINGKASAN PROVIDER --}}
            <div class="mt-6 flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50/60 p-4 dark:border-slate-800 dark:bg-slate-900/40">
                @if (!empty($payload['avatar']))
                    <img src="{{ $payload['avatar'] }}" alt=""
                         width="48" height="48" loading="lazy"
                         class="h-12 w-12 shrink-0 rounded-full border border-cyan-500/30 object-cover ring-2 ring-cyan-500/10">
                @else
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-slate-200 dark:border-slate-700 dark:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 dark:text-slate-500"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-500">
                        sumber akun
                    </p>
                    <p class="mt-0.5 truncate text-sm font-semibold text-slate-900 dark:text-slate-100">
                        {{ ucfirst($payload['provider']) }} Account
                    </p>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                        {{ $payload['email'] ?? 'Email tidak tersedia' }}
                    </p>
                </div>

                <span class="hidden shrink-0 items-center gap-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/5 px-2.5 py-1 font-mono text-[10px] uppercase tracking-wider text-emerald-700 dark:border-emerald-400/25 dark:bg-emerald-400/5 dark:text-emerald-300 sm:inline-flex">
                    <span class="h-1 w-1 rounded-full bg-emerald-500" aria-hidden="true"></span>
                    valid
                </span>
            </div>

            {{-- Peringatan email konflik --}}
            <div class="mt-4 overflow-hidden rounded-lg border border-amber-500/30 bg-amber-500/5 p-3.5 dark:border-amber-400/25 dark:bg-amber-400/5" role="alert">
                <div class="flex items-start gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                        <path d="M12 9v4M12 17h.01" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                            Email sudah terdaftar
                        </p>
                        <p class="mt-0.5 text-sm leading-relaxed text-amber-700/90 dark:text-amber-300/90">
                            Email dari {{ ucfirst($payload['provider']) }} sudah digunakan akun lain.
                            Pilih satu metode di bawah untuk membuktikan kepemilikan dan menautkan akun.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="cyber-rule my-7"></div>

            {{-- DAFTAR PROTOKOL VERIFIKASI --}}
            @php $protocol = 1; @endphp
            <div class="space-y-4">

                {{-- =====================================================
                     PROTOKOL 1: Tautkan ke akun aktif (hanya jika login)
                     ===================================================== --}}
                @auth
                    <div class="protocol-card rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900/40">
                        <div class="flex items-start gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-cyan-500/25 bg-cyan-500/10 text-cyan-600 dark:border-cyan-400/25 dark:bg-cyan-400/10 dark:text-cyan-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.8"
                                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7L12 5" />
                                    <path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7L12 19" />
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">
                                    protokol.{{ str_pad($protocol++, 2, '0', STR_PAD_LEFT) }} · tercepat
                                </p>
                                <h2 class="mt-1 text-base font-semibold text-slate-900 dark:text-slate-100">
                                    Tautkan ke akun aktif
                                </h2>
                                <p class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                                    Anda sedang login sebagai
                                    <strong class="font-medium text-slate-700 dark:text-slate-200">{{ auth()->user()->email }}</strong>.
                                    Tautkan langsung tanpa verifikasi ulang.
                                </p>

                                <form action="{{ route('social.confirm.post') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <button type="submit"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2.5 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7L12 5" />
                                            <path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7L12 19" />
                                        </svg>
                                        Tautkan {{ ucfirst($payload['provider']) }} ke akun ini
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                {{-- =====================================================
                     PROTOKOL: Konfirmasi via provider (direkomendasikan)
                     ===================================================== --}}
                <div class="protocol-card rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900/40">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-violet-500/25 bg-violet-500/10 text-violet-600 dark:border-violet-400/25 dark:bg-violet-400/10 dark:text-violet-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 2 3 6v6c0 5 3.8 9 9 10 5.2-1 9-5 9-10V6l-9-4Z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">
                                protokol.{{ str_pad($protocol++, 2, '0', STR_PAD_LEFT) }} ·
                                <span class="text-violet-600/80 dark:text-violet-400/80">direkomendasikan</span>
                            </p>
                            <h2 class="mt-1 text-base font-semibold text-slate-900 dark:text-slate-100">
                                Konfirmasi dengan {{ ucfirst($payload['provider']) }}
                            </h2>
                            <p class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                                Login ulang dengan {{ ucfirst($payload['provider']) }} untuk membuktikan
                                bahwa Anda benar pemilik email ini.
                            </p>

                            @if ($payload['provider'] === 'github')
                                <a href="{{ url('/auth/github?confirm_token=' . $token) }}"
                                   class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2.5 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                                    Konfirmasi via GitHub
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14M13 6l6 6-6 6" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ url('/auth/confirm/' . $payload['provider'] . '?token=' . $token) }}"
                                   class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2.5 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                                    Konfirmasi via {{ ucfirst($payload['provider']) }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14M13 6l6 6-6 6" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- =====================================================
                     PROTOKOL: Verifikasi via OTP
                     ===================================================== --}}
                <div class="protocol-card rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900/40">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-sky-500/25 bg-sky-500/10 text-sky-600 dark:border-sky-400/25 dark:bg-sky-400/10 dark:text-sky-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3 7 9 6 9-6" />
                            </svg>
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">
                                protokol.{{ str_pad($protocol++, 2, '0', STR_PAD_LEFT) }} · via email
                            </p>
                            <h2 class="mt-1 text-base font-semibold text-slate-900 dark:text-slate-100">
                                Verifikasi dengan Kode OTP
                            </h2>
                            <p class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                                Kami akan mengirimkan kode 6 digit ke
                                <strong class="font-medium text-slate-700 dark:text-slate-200">{{ $payload['email'] ?? 'email Anda' }}</strong>.
                            </p>

                            {{-- Form minta OTP --}}
                            <div id="otp-request-form" class="mt-4">
                                <button type="button" id="request-otp-btn"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2.5 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white sm:w-auto dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="m22 2-7 20-4-9-9-4Z" />
                                        <path d="M22 2 11 13" />
                                    </svg>
                                    Kirim Kode OTP
                                </button>
                            </div>

                            {{-- Form verifikasi OTP (awalnya tersembunyi) --}}
                            <div id="otp-verify-form" style="display: none;" class="mt-4">
                                <label for="otp-code"
                                       class="mb-2 block font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                                    Masukkan Kode OTP
                                </label>

                                <div class="flex overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-400/30 dark:border-slate-700 dark:bg-slate-900 dark:focus-within:border-cyan-400/60">
                                    <input type="text" name="otp_code" id="otp-code"
                                           inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code"
                                           class="w-full bg-transparent px-4 py-2.5 text-center font-mono text-lg tracking-[0.4em] text-slate-900 outline-none placeholder:text-sm placeholder:tracking-normal placeholder:text-slate-400 dark:text-white dark:placeholder:text-slate-500"
                                           placeholder="6 digit" maxlength="6" required>
                                    <button type="button" id="resend-otp-btn"
                                            class="shrink-0 border-l border-slate-300 bg-slate-50 px-4 text-xs font-medium text-slate-600 transition-colors hover:bg-slate-100 hover:text-cyan-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-cyan-300">
                                        Kirim Ulang
                                    </button>
                                </div>

                                <small id="otp-timer"
                                       class="mt-2 block font-mono text-[11px] text-slate-500 dark:text-slate-400"></small>

                                <button type="button" id="verify-otp-btn"
                                        class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-emerald-500/50 bg-emerald-500/10 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition-all duration-200 hover:border-emerald-400 hover:bg-emerald-500/20 hover:shadow-[0_0_22px_-6px_rgba(16,185,129,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:cursor-not-allowed disabled:opacity-50 dark:border-emerald-400/40 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:border-emerald-300 dark:hover:bg-emerald-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2.2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                    Verifikasi &amp; Tautkan Akun
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer helper --}}
            <div class="mt-8 flex items-center justify-center gap-2 font-mono text-[11px] uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-cyan-600/70 dark:text-cyan-400/60"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="4" y="10" width="16" height="10" rx="2" />
                    <path d="M8 10V7a4 4 0 1 1 8 0v3" />
                </svg>
                Koneksi terenkripsi · token sekali pakai
            </div>
        </div>

        {{-- Link batal di luar kartu --}}
        <p class="mt-6 text-center">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition-colors hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-50 dark:text-slate-400 dark:hover:text-cyan-300 dark:focus-visible:ring-offset-[#070b12]">
                Batalkan dan kembali ke login
            </a>
        </p>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const requestOtpBtn = document.getElementById('request-otp-btn');
            const otpVerifyForm = document.getElementById('otp-verify-form');
            const otpRequestForm = document.getElementById('otp-request-form');
            const otpCode = document.getElementById('otp-code');
            const verifyOtpBtn = document.getElementById('verify-otp-btn');
            const resendOtpBtn = document.getElementById('resend-otp-btn');
            const otpTimer = document.getElementById('otp-timer');

            let countdownInterval;
            let token = @json($token);
            let provider = @json($payload['provider']);

            function startCountdown(seconds) {
                let remaining = seconds;
                otpTimer.textContent = `Kode akan kadaluarsa dalam ${remaining} detik`;
                otpTimer.classList.remove('text-red-500', 'dark:text-red-400', 'text-amber-600', 'dark:text-amber-400');

                clearInterval(countdownInterval);
                countdownInterval = setInterval(function () {
                    remaining--;

                    if (remaining <= 0) {
                        clearInterval(countdownInterval);
                        otpTimer.textContent = 'Kode OTP telah kadaluarsa. Silakan kirim ulang.';
                        otpTimer.classList.add('text-red-500', 'dark:text-red-400');
                        verifyOtpBtn.disabled = true;
                    } else {
                        otpTimer.textContent = `Kode akan kadaluarsa dalam ${remaining} detik`;
                        if (remaining <= 60) {
                            otpTimer.classList.add('text-amber-600', 'dark:text-amber-400');
                        }
                    }
                }, 1000);
            }

            requestOtpBtn.addEventListener('click', function () {
                fetch(`/auth/${provider}/request-otp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ token: token })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        otpRequestForm.style.display = 'none';
                        otpVerifyForm.style.display = 'block';
                        startCountdown(data.expires_in || 300);
                        verifyOtpBtn.disabled = false;
                    } else {
                        alert(data.message || 'Gagal mengirim kode OTP. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });

            verifyOtpBtn.addEventListener('click', function () {
                const code = otpCode.value;

                if (!code || code.length !== 6) {
                    alert('Masukkan kode OTP 6 digit yang valid.');
                    return;
                }

                fetch(`/auth/${provider}/verify-otp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ token: token, otp_code: code })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_url || '/dashboard';
                    } else {
                        alert(data.message || 'Kode OTP tidak valid. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });

            resendOtpBtn.addEventListener('click', function () {
                fetch(`/auth/${provider}/request-otp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ token: token })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        startCountdown(data.expires_in || 300);
                        verifyOtpBtn.disabled = false;
                        alert('Kode OTP baru telah dikirim.');
                    } else {
                        alert(data.message || 'Gagal mengirim ulang kode OTP. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        });
    </script>
@endpush