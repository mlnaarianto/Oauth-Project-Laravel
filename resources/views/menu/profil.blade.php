{{-- resources/views/menu/profil.blade.php --}}
<x-layouts.app title="Profil Saya">

    @php
        $user = Auth::user();

        $providerKey = strtolower($user->last_login_provider ?? 'sistem');

        $providerLabels = [
            'google'   => 'Google',
            'facebook' => 'Facebook',
            'github'   => 'GitHub',
            'x'        => 'X',
            'discord'  => 'Discord',
            'sistem'   => 'Sistem',
        ];
        $providerColors = [
            'google'   => '#4285F4',
            'facebook' => '#1877F2',
            'github'   => '#6E7681',
            'x'        => '#1DA1F2',
            'discord'  => '#5865F2',
            'sistem'   => '#0891b2',
        ];
        $providerLabel = $providerLabels[$providerKey] ?? ucfirst($providerKey);
        $providerColor = $providerColors[$providerKey] ?? '#0891b2';
    @endphp

    <style>
        /* ============ Sudut Lancip (Clip-Path) ============ */
        .corner-outer {
            position: relative;
            padding: 1px;
            background: linear-gradient(135deg,
                rgba(34, 211, 238, .6) 0%,
                rgba(34, 211, 238, .1) 30%,
                rgba(167, 139, 250, .1) 70%,
                rgba(167, 139, 250, .5) 100%);
            clip-path: polygon(
                20px 0, 100% 0,
                100% calc(100% - 20px), calc(100% - 20px) 100%,
                0 100%, 0 20px
            );
        }

        .corner-inner {
            clip-path: polygon(
                19px 0, 100% 0,
                100% calc(100% - 19px), calc(100% - 19px) 100%,
                0 100%, 0 19px
            );
        }

        /* Garis Aksen Sudut */
        .corner-accent {
            position: absolute;
            width: 6px;
            height: 6px;
            border-color: rgba(34, 211, 238, .8);
            border-style: solid;
            pointer-events: none;
            z-index: 3;
        }
        .corner-accent.tl {
            top: 20px; left: 6px;
            border-bottom-width: 2px; border-right-width: 2px;
        }
        .corner-accent.br {
            bottom: 20px; right: 6px;
            border-top-width: 2px; border-left-width: 2px;
        }

        /* Avatar Chip */
        .avatar-chip {
            clip-path: polygon(
                14px 0, 100% 0,
                100% calc(100% - 14px), calc(100% - 14px) 100%,
                0 100%, 0 14px
            );
        }
    </style>

    <div class="px-4 py-8 sm:px-6">
        {{-- Sedikit dilebarkan agar proporsional --}}
        <div class="mx-auto max-w-4xl">

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="relative mb-4 overflow-hidden rounded-lg border border-emerald-500/30 bg-emerald-500/5 p-3.5 dark:border-emerald-400/25 dark:bg-emerald-400/5" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="9" /><path d="m9 12 2 2 4-4" /></svg>
                        <div class="flex-1 text-sm text-emerald-800 dark:text-emerald-300">{{ session('success') }}</div>
                        <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-emerald-600/70 hover:text-emerald-700" aria-label="Tutup"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="relative mb-4 overflow-hidden rounded-lg border border-red-500/30 bg-red-500/5 p-3.5 dark:border-red-400/25 dark:bg-red-400/5" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="h-4 w-4 shrink-0 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="9" /><path d="M12 8v4M12 16h.01" /></svg>
                        <div class="flex-1 text-sm text-red-700 dark:text-red-300">{{ session('error') }}</div>
                        <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-600/70 hover:text-red-700" aria-label="Tutup"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg></button>
                    </div>
                </div>
            @endif

            {{-- KARTU PROFIL --}}
            <div class="corner-outer">
                <div class="corner-inner relative bg-white dark:bg-[#0b1220]">
                    <span class="corner-accent tl" aria-hidden="true"></span>
                    <span class="corner-accent br" aria-hidden="true"></span>

                    {{-- HEADER --}}
                    <div class="relative overflow-hidden border-b border-slate-200 px-6 py-8 dark:border-slate-800">

                        {{-- Grid background --}}
                        <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-60"
                             style="background-image: linear-gradient(to right, rgba(34,211,238,.06) 1px, transparent 1px), linear-gradient(to bottom, rgba(34,211,238,.06) 1px, transparent 1px); background-size: 32px 32px; -webkit-mask-image: radial-gradient(ellipse 70% 100% at 50% 50%, #000 30%, transparent 90%); mask-image: radial-gradient(ellipse 70% 100% at 50% 50%, #000 30%, transparent 90%);"></div>
                        <div aria-hidden="true" class="pointer-events-none absolute left-1/2 top-1/2 h-32 w-64 -translate-x-1/2 -translate-y-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

                        <div class="relative flex flex-col items-center text-center">
                            
                            {{-- Badge ditaruh di ATAS avatar agar tidak tabrakan --}}
                            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                                <span class="relative flex h-1.5 w-1.5"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span></span>
                                user.profile
                            </div>

                            {{-- Avatar (Diperkecil jadi 96px / h-24 w-24) --}}
                            <div class="relative inline-block">
                                <div class="relative" style="padding: 2px; background: linear-gradient(135deg, #22d3ee, #a78bfa);">
                                    <div class="avatar-chip bg-white dark:bg-[#0b1220]" style="padding: 2px;">
                                        <img id="avatar-preview"
                                             src="{{ $user->userAvatar() }}"
                                             alt="Avatar {{ $user->userName() }}"
                                             class="avatar-chip h-24 w-24 object-cover"
                                             onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">
                                    </div>
                                </div>
                            </div>

                            {{-- Nama & Email --}}
                            <h3 class="mt-4 text-xl font-bold tracking-tight text-slate-900 dark:text-slate-50">
                                {{ $user->userName() }}
                            </h3>
                            <p class="mt-1 max-w-[250px] truncate text-sm text-slate-500 dark:text-slate-400">
                                {{ $user->userEmail() }}
                            </p>

                            {{-- Provider --}}
                            <div class="mt-3 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/70 px-3 py-1 font-mono text-[10px] uppercase tracking-wider text-slate-600 backdrop-blur-sm dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-300">
                                <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $providerColor }}"></span>
                                masuk via {{ $providerLabel }}
                            </div>
                        </div>
                    </div>

                    {{-- BODY: GRID 2 KOLOM --}}
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        
                        {{-- KIRI: Identitas --}}
                        <section class="border-b border-dashed border-slate-200 p-6 dark:border-slate-800 md:border-b-0 md:border-r">
                            <header class="mb-4 flex items-center gap-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded border border-cyan-500/25 bg-cyan-500/10 text-cyan-600 dark:border-cyan-400/25 dark:bg-cyan-400/10 dark:text-cyan-300">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><circle cx="12" cy="8" r="4" /><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" /></svg>
                                </span>
                                <div>
                                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500">identitas</p>
                                    <h5 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Detail Dasar</h5>
                                </div>
                            </header>

                            <dl class="divide-y divide-dashed divide-slate-200 dark:divide-slate-800">
                                <div class="flex items-start justify-between gap-4 py-3">
                                    <dt class="text-sm text-slate-500 dark:text-slate-400">Nama Lengkap</dt>
                                    <dd class="text-right text-sm font-medium text-slate-900 dark:text-slate-100">{{ $user->userName() }}</dd>
                                </div>
                                <div class="flex items-start justify-between gap-4 py-3">
                                    <dt class="text-sm text-slate-500 dark:text-slate-400">Email</dt>
                                    <dd class="break-all text-right font-mono text-[13px] text-slate-900 dark:text-slate-100">{{ $user->userEmail() }}</dd>
                                </div>
                            </dl>
                        </section>

                        {{-- KANAN: Keamanan --}}
                        <section class="p-6">
                            <header class="mb-4 flex items-center gap-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded border border-violet-500/25 bg-violet-500/10 text-violet-600 dark:border-violet-400/25 dark:bg-violet-400/10 dark:text-violet-300">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M12 2 3 6v6c0 5 3.8 9 9 10 5.2-1 9-5 9-10V6l-9-4Z" /><path d="m9 12 2 2 4-4" /></svg>
                                </span>
                                <div>
                                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500">security</p>
                                    <h5 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Keamanan Akun</h5>
                                </div>
                            </header>

                            <dl class="divide-y divide-dashed divide-slate-200 dark:divide-slate-800">
                                <div class="flex items-center justify-between gap-4 py-3">
                                    <dt class="text-sm text-slate-500 dark:text-slate-400">Login Terakhir</dt>
                                    <dd>
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-2 py-1 font-mono text-[10px] text-slate-700 dark:border-slate-700 dark:bg-slate-900/60 dark:text-slate-300">
                                            <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $providerColor }}"></span>
                                            {{ $providerLabel }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between gap-4 py-3">
                                    <dt class="text-sm text-slate-500 dark:text-slate-400">Dibuat Pada</dt>
                                    <dd class="text-right text-sm font-medium text-slate-900 dark:text-slate-100">{{ $user->created_at->format('d M Y') }}</dd>
                                </div>
                            </dl>
                        </section>

                    </div>

                    {{-- FOOTER STRIP --}}
                    <div class="flex items-center justify-between border-t border-slate-200 px-6 py-3 font-mono text-[10px] uppercase tracking-[0.15em] text-slate-500 dark:border-slate-800 dark:text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="h-2.5 w-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg>
                            akun aktif
                        </span>
                        <span>id // {{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-layouts.app>