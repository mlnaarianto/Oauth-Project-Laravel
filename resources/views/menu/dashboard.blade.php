{{-- resources/views/menu/dashboard.blade.php --}}
<x-layouts.app title="Dashboard">

    @php
        $brandColors = [
            'google'   => '#4285F4',
            'facebook' => '#1877F2',
            'github'   => '#6E7681',
            'x'        => '#1DA1F2',
            'discord'  => '#5865F2',
        ];
        $providerLabels = [
            'google'   => 'Google',
            'facebook' => 'Facebook',
            'github'   => 'GitHub',
            'x'        => 'X',
            'discord'  => 'Discord',
        ];
        $providerIcons = [
            'google'   => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/google.svg',
            'facebook' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/facebook.svg',
            'github'   => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/github.svg',
            'x'        => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg',
            'discord'  => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/discord.svg',
        ];

        $connectedCount = count(array_filter($providerCounts));
        $emptyCount     = count($providerCounts) - $connectedCount;

        // Provider dengan akun terbanyak (null jika semua kosong)
        $topProvider = null;
        $topCount    = 0;
        foreach ($providerCounts as $p => $c) {
            if ($c > $topCount) {
                $topProvider = $p;
                $topCount    = $c;
            }
        }
    @endphp

    <style>
        .cyber-card {
            position: relative;
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }
        .cyber-card:hover {
            transform: translateY(-3px);
            border-color: rgba(34, 211, 238, .45);
            box-shadow: 0 16px 36px -22px rgba(34, 211, 238, .55);
        }
        .cyber-card::before,
        .cyber-card::after {
            content: "";
            position: absolute;
            width: 12px;
            height: 12px;
            border-color: transparent;
            border-style: solid;
            pointer-events: none;
            transition: border-color .25s ease;
        }
        .cyber-card::before {
            top: 8px; left: 8px;
            border-top-width: 1px; border-left-width: 1px;
        }
        .cyber-card::after {
            bottom: 8px; right: 8px;
            border-bottom-width: 1px; border-right-width: 1px;
        }
        .cyber-card:hover::before,
        .cyber-card:hover::after {
            border-color: rgba(34, 211, 238, .55);
        }
    </style>

    <div class="mx-auto w-full max-w-6xl py-4">

        {{-- ============================================================
             HEADER
             ============================================================ --}}
        <header class="mb-8">
            <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                </span>
                dashboard // overview
            </div>

            <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-50 sm:text-3xl">
                Statistik Akun <span class="text-cyan-700 dark:text-cyan-400">Media Sosial</span>
            </h1>
            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                Ringkasan akun sosial yang terhubung ke MyApp. Data diperbarui otomatis setiap kali ada penautan baru.
            </p>
        </header>

        @if ($totalAccounts === 0)

            {{-- ============================================================
                 EMPTY STATE — belum ada akun terhubung
                 ============================================================ --}}
            <div class="relative overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center dark:border-slate-700 dark:bg-[#0b1220] sm:p-14">
                <div aria-hidden="true"
                     class="pointer-events-none absolute -top-20 left-1/2 h-40 w-64 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-3xl dark:bg-cyan-500/15"></div>

                <span class="relative inline-flex h-14 w-14 items-center justify-center rounded-xl border border-cyan-500/25 bg-cyan-500/10 text-cyan-600 dark:border-cyan-400/25 dark:bg-cyan-400/10 dark:text-cyan-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7L12 5" />
                        <path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7L12 19" />
                    </svg>
                </span>

                <h2 class="relative mt-5 text-lg font-semibold text-slate-900 dark:text-slate-100">
                    Belum ada akun terhubung
                </h2>
                <p class="relative mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Hubungkan akun media sosial pertama Anda untuk mulai melihat statistik di sini.
                </p>

                <a href="{{ url('/login') }}"
                   class="relative mt-6 inline-flex items-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-5 py-2.5 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                    Hubungkan Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </a>
            </div>

        @else

            {{-- ============================================================
                 TOTAL BANNER
                 ============================================================ --}}
            <div class="relative mb-4 overflow-hidden rounded-2xl border border-cyan-500/25 bg-gradient-to-br from-cyan-500/5 via-white to-violet-500/5 p-6 dark:border-cyan-400/20 dark:from-cyan-500/10 dark:via-[#0b1220] dark:to-violet-500/10 sm:p-7">
                <div aria-hidden="true"
                     class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-400/60 to-transparent"></div>
                <div aria-hidden="true"
                     class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-cyan-400/15 blur-3xl dark:bg-cyan-500/20"></div>

                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-700 dark:text-cyan-400">
                            total akun terhubung
                        </p>
                        <div class="mt-2 flex items-baseline gap-3">
                            <span class="font-mono text-5xl font-bold tracking-tight text-slate-900 dark:text-slate-50 sm:text-6xl">
                                {{ $totalAccounts }}
                            </span>
                            <span class="text-sm text-slate-500 dark:text-slate-400">
                                akun dari {{ $connectedCount }} dari 5 provider
                            </span>
                        </div>
                    </div>

                    @if ($topProvider)
                        <div class="shrink-0 rounded-xl border border-slate-200 bg-white/70 px-4 py-3 backdrop-blur-sm dark:border-slate-800 dark:bg-slate-900/60">
                            <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500 dark:text-slate-500">
                                paling aktif
                            </p>
                            <p class="mt-1 flex items-center gap-2 text-sm font-semibold text-slate-900 dark:text-slate-100">
                                <span class="h-2 w-2 rounded-full" style="background-color: {{ $brandColors[$topProvider] }}" aria-hidden="true"></span>
                                {{ $providerLabels[$topProvider] }}
                                <span class="font-mono text-xs font-normal text-slate-500 dark:text-slate-400">
                                    {{ $topCount }} akun
                                </span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ============================================================
                 PROVIDER GRID
                 ============================================================ --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">

                @foreach ($providerCounts as $provider => $count)
                    @php
                        $isConnected = $count > 0;
                        $label       = $providerLabels[$provider] ?? ucfirst($provider);
                        $icon        = $providerIcons[$provider] ?? null;
                        $color       = $brandColors[$provider] ?? '#64748b';
                    @endphp

                    <article class="cyber-card overflow-hidden rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-[#0b1220]">

                        <div class="flex items-center justify-between">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900/60">
                                @if ($icon)
                                    <img src="{{ $icon }}" alt=""
                                         width="16" height="16" loading="lazy"
                                         class="h-4 w-4 dark:invert"
                                         onerror="this.style.display='none'">
                                @endif
                            </span>

                            @if ($isConnected)
                                <span class="h-2 w-2 rounded-full"
                                      style="background-color: {{ $color }}"
                                      title="{{ $label }} terhubung"
                                      aria-label="{{ $label }} terhubung"></span>
                            @else
                                <span class="font-mono text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-600">
                                    —
                                </span>
                            @endif
                        </div>

                        <p class="mt-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                            {{ $label }}
                        </p>

                        <div class="mt-1 flex items-baseline gap-1.5">
                            <span class="font-mono text-2xl font-bold {{ $isConnected ? 'text-slate-900 dark:text-slate-100' : 'text-slate-400 dark:text-slate-600' }}">
                                {{ $count }}
                            </span>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                akun
                            </span>
                        </div>

                    </article>
                @endforeach

            </div>

            {{-- ============================================================
                 INSIGHT / INFO BAWAH
                 ============================================================ --}}
            <div class="mt-6 grid gap-4 md:grid-cols-2">

                {{-- Insight koneksi --}}
                <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-[#0b1220]">
                    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-500">
                        // status koneksi
                    </p>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        <strong class="text-slate-900 dark:text-slate-100">{{ $connectedCount }} dari 5</strong>
                        provider sudah terhubung.
                        @if ($emptyCount > 0)
                            Masih ada <strong class="text-slate-900 dark:text-slate-100">{{ $emptyCount }} provider</strong>
                            yang belum ditautkan — hubungkan untuk melengkapi profil Anda.
                        @else
                            Semua provider sudah tertaut. Kerja bagus!
                        @endif
                    </p>
                </div>

                {{-- Ringkasan angka --}}
                <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-[#0b1220]">
                    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-500">
                        // ringkasan
                    </p>
                    <dl class="mt-3 grid grid-cols-2 gap-3">
                        <div>
                            <dt class="text-xs text-slate-500 dark:text-slate-400">Rata-rata per provider</dt>
                            <dd class="mt-0.5 font-mono text-lg font-semibold text-slate-900 dark:text-slate-100">
                                {{ $connectedCount > 0 ? number_format($totalAccounts / $connectedCount, 1) : '0' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500 dark:text-slate-400">Provider terhubung</dt>
                            <dd class="mt-0.5 font-mono text-lg font-semibold text-slate-900 dark:text-slate-100">
                                {{ $connectedCount }}<span class="text-sm font-normal text-slate-400 dark:text-slate-500"> / 5</span>
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>

        @endif

    </div>

</x-layouts.app>