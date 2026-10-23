{{-- resources/views/auth/verify-email.blade.php --}}
@extends('tampilan.app')

@section('title', 'Verifikasi Email')

@push('styles')
<style>
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

    .auth-card::before,
    .auth-card::after {
        content: "";
        position: absolute;
        width: 20px; height: 20px;
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
</style>
@endpush

@section('content')
<section class="relative py-12 sm:py-16">
    <div class="mx-auto max-w-lg px-4 sm:px-6">

        {{-- Baris atas --}}
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
                otp.verify
            </span>
        </div>

        {{-- Kartu --}}
        <div class="auth-card relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5 dark:border-slate-800 dark:bg-[#0b1220] dark:shadow-none sm:p-8">

            <div aria-hidden="true"
                 class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent dark:via-cyan-400/50"></div>
            <div aria-hidden="true"
                 class="pointer-events-none absolute -top-24 left-1/2 h-48 w-64 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

            {{-- Header --}}
            <div class="relative text-center">
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    verifikasi kode
                </div>

                <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Cek <span class="cyber-gradient-text">Email Anda</span>
                </h1>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Kami telah mengirim kode 6 digit ke email Gmail Anda. Masukkan kode di bawah untuk melanjutkan.
                </p>
            </div>

            {{-- Error backend --}}
            @if(session('error'))
                <div class="mt-6 overflow-hidden rounded-lg border border-red-500/30 bg-red-500/5 p-3.5 dark:border-red-400/30 dark:bg-red-400/5" role="alert">
                    <div class="flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-red-600 dark:text-red-400"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 8v4M12 16h.01" />
                        </svg>
                        <span class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Divider --}}
            <div class="cyber-rule my-6"></div>

            {{-- Form OTP --}}
            <form method="POST" action="{{ route('social.askEmailOtp.submit') }}">
                @csrf
                <input type="hidden" name="token" value="{{ request('token') }}">

                <div>
                    <label for="otp"
                           class="mb-2 block text-center font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                        Kode OTP · 6 digit
                    </label>

                    <input
                        type="text"
                        name="otp"
                        id="otp"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        autocomplete="one-time-code"
                        class="w-full rounded-lg border bg-white px-4 py-3.5 text-center font-mono text-2xl tracking-[0.5em] text-slate-900 outline-none transition-colors placeholder:text-lg placeholder:tracking-[0.4em] placeholder:text-slate-300 focus:ring-2 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-600 @error('otp') border-red-500 focus:border-red-500 focus:ring-red-500/30 @else border-slate-300 focus:border-cyan-400 focus:ring-cyan-400/30 dark:border-slate-700 dark:focus:border-cyan-400/60 @enderror"
                        placeholder="••••••"
                        maxlength="6"
                        required
                        autofocus
                    >

                    @error('otp')
                        <div class="mt-2 text-center text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                        class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-emerald-500/50 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-700 transition-all duration-200 hover:border-emerald-400 hover:bg-emerald-500/20 hover:shadow-[0_0_28px_-6px_rgba(16,185,129,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-emerald-400/40 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:border-emerald-300 dark:hover:bg-emerald-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                    Verifikasi Kode
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                </button>
            </form>

            {{-- Catatan bawah --}}
            <div class="mt-6 flex items-center justify-center gap-1.5 font-mono text-[11px] uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-cyan-600/70 dark:text-cyan-400/60"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="4" y="10" width="16" height="10" rx="2" />
                    <path d="M8 10V7a4 4 0 1 1 8 0v3" />
                </svg>
                Kode bersifat pribadi · jangan bagikan
            </div>
        </div>
    </div>
</section>
@endsection