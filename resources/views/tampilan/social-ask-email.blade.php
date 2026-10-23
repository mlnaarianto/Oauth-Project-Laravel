{{-- resources/views/auth/ask-email.blade.php --}}
@extends('tampilan.app')

@section('title', 'Masukkan Email Gmail Pribadi')

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
                email.enroll
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
                    langkah tambahan
                </div>

                <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-50">
                    Masukkan <span class="cyber-gradient-text">Email Gmail</span>
                </h1>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Kami butuh alamat Gmail pribadi untuk melanjutkan proses login.
                </p>
            </div>

            {{-- Info peringatan --}}
            @if (isset($original_email) && $original_email)
                <div class="mt-6 overflow-hidden rounded-lg border border-amber-500/30 bg-amber-500/5 p-3.5 dark:border-amber-400/25 dark:bg-amber-400/5" role="alert">
                    <div class="flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                            <path d="M12 9v4M12 17h.01" />
                        </svg>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                Email {{ ucfirst($provider) }} tidak memenuhi syarat
                            </p>
                            <p class="mt-0.5 text-sm leading-relaxed text-amber-700/90 dark:text-amber-300/90">
                                Akun {{ ucfirst($provider) }} Anda memakai
                                <strong class="font-mono text-[12px]">{{ $original_email }}</strong>.
                                Sistem hanya menerima <strong>Gmail pribadi (@gmail.com)</strong>;
                                akun Google Workspace (kantor, kampus, organisasi) tidak didukung.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-6 overflow-hidden rounded-lg border border-amber-500/30 bg-amber-500/5 p-3.5 dark:border-amber-400/25 dark:bg-amber-400/5" role="alert">
                    <div class="flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-amber-600 dark:text-amber-400"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                            <path d="M12 9v4M12 17h.01" />
                        </svg>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                Email {{ ucfirst($provider) }} tidak tersedia
                            </p>
                            <p class="mt-0.5 text-sm leading-relaxed text-amber-700/90 dark:text-amber-300/90">
                                Akun {{ ucfirst($provider) }} Anda tidak menyediakan email Gmail pribadi.
                                Masukkan <strong>alamat @gmail.com</strong> Anda di bawah.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Error backend --}}
            @if(session('error'))
                <div class="mt-4 overflow-hidden rounded-lg border border-red-500/30 bg-red-500/5 p-3.5 dark:border-red-400/30 dark:bg-red-400/5" role="alert">
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

            {{-- Form --}}
            <form method="POST" action="{{ route('social.askEmail.submit') }}" id="emailForm" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email"
                           class="mb-2 block font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">
                        Alamat Gmail Pribadi
                    </label>

                    <div class="flex overflow-hidden rounded-lg border border-slate-300 bg-white transition-colors focus-within:border-cyan-400 focus-within:ring-2 focus-within:ring-cyan-400/30 dark:border-slate-700 dark:bg-slate-900 dark:focus-within:border-cyan-400/60">
                        <span class="flex items-center border-r border-slate-300 bg-slate-50 px-3 text-slate-400 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3 7 9 6 9-6" />
                            </svg>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="w-full bg-transparent px-4 py-2.5 text-sm text-slate-900 outline-none placeholder:text-slate-400 dark:text-white dark:placeholder:text-slate-500"
                            placeholder="nama@gmail.com"
                            required
                            autocomplete="email"
                        >
                    </div>

                    @error('email')
                        <div class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror

                    <p class="mt-2 font-mono text-[11px] text-slate-500 dark:text-slate-500">
                        Harus diakhiri <strong class="text-cyan-700 dark:text-cyan-400">@gmail.com</strong>
                    </p>
                </div>

                <button type="submit"
                        class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-3 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_28px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                    Kirim Kode Verifikasi (OTP)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </button>
            </form>

            {{-- Catatan bawah --}}
            <div class="mt-6 flex items-center justify-center gap-1.5 font-mono text-[11px] uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">
                <span aria-hidden="true" class="text-cyan-600/70 dark:text-cyan-400/60">◇</span>
                Google Workspace belum didukung
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('emailForm');
    const emailInput = document.getElementById('email');
    const wrapper = emailInput.closest('div');

    const defaultWrapper = ['border-slate-300', 'dark:border-slate-700', 'focus-within:border-cyan-400', 'focus-within:ring-cyan-400/30', 'dark:focus-within:border-cyan-400/60'];
    const errorWrapper   = ['border-red-500', 'dark:border-red-500', 'focus-within:border-red-500', 'focus-within:ring-red-500/30'];

    form.addEventListener('submit', function (e) {
        const email = emailInput.value.trim().toLowerCase();
        const existingError = document.getElementById('gmail-error');

        if (!email.endsWith('@gmail.com')) {
            e.preventDefault();

            wrapper.classList.remove(...defaultWrapper);
            wrapper.classList.add(...errorWrapper);

            if (!existingError) {
                const error = document.createElement('div');
                error.id = 'gmail-error';
                error.className = 'mt-1.5 text-xs text-red-600 dark:text-red-400';
                error.textContent = 'Gunakan alamat Gmail pribadi dengan akhiran @gmail.com.';
                wrapper.parentNode.appendChild(error);
            }
            emailInput.focus();
        } else {
            wrapper.classList.remove(...errorWrapper);
            wrapper.classList.add(...defaultWrapper);

            if (existingError) existingError.remove();
        }
    });
});
</script>
@endpush