{{-- resources/views/tampilan/navbar.blade.php --}}
<nav id="navbar"
     class="fixed top-0 left-0 z-50 w-full border-b border-slate-200 bg-white dark:border-slate-800/80 dark:bg-[#070b12]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            <!-- Brand -->
            <a href="{{ url('/') }}"
               class="group flex items-center gap-2.5 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-[#070b12]">
                <span class="relative flex h-8 w-8 items-center justify-center rounded-md border border-cyan-500/30 bg-cyan-500/10 dark:border-cyan-400/25 dark:bg-cyan-400/10">
                    <span class="absolute inset-0 rounded-md bg-cyan-400/25 opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-100"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="relative h-4 w-4 text-cyan-600 dark:text-cyan-400"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z" />
                    </svg>
                </span>
                <span class="font-mono text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    My<span class="text-cyan-600 dark:text-cyan-400">App</span>
                </span>
            </a>

            <!-- Tombol Hamburger (Mobile) -->
            <button id="mobile-menu-btn" type="button"
                    aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu"
                    class="rounded-lg p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 md:hidden dark:text-slate-300 dark:hover:bg-slate-800/70 dark:hover:text-cyan-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Menu Desktop -->
            <div class="hidden items-center gap-7 md:flex">
                <a href="{{ url('/') }}"
                   @if (request()->is('/')) aria-current="page" @endif
                   class="nav-link {{ request()->is('/') ? 'is-active' : '' }}">Home</a>

                <a href="{{ url('/about') }}"
                   @if (request()->is('about')) aria-current="page" @endif
                   class="nav-link {{ request()->is('about') ? 'is-active' : '' }}">About</a>

                <!-- Toggle Tema -->
                <button type="button" data-theme-toggle aria-pressed="false" aria-label="Aktifkan mode terang"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 text-slate-600 transition-colors hover:border-cyan-400/60 hover:text-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-slate-700 dark:text-slate-300 dark:hover:border-cyan-400/50 dark:hover:text-cyan-300 dark:focus-visible:ring-offset-[#070b12]">
                    {{-- Ikon bulan (mode terang aktif) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:hidden" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />
                    </svg>
                    {{-- Ikon matahari (mode gelap aktif) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 dark:block" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                    </svg>
                </button>

                <!-- Tombol Login -->
                <a href="{{ url('/login') }}"
                   class="inline-flex items-center rounded-lg border border-cyan-500/40 bg-cyan-500/10 px-4 py-2 text-sm font-medium text-cyan-700 transition-all duration-200 hover:border-cyan-400/70 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-cyan-400/35 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300/70 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#070b12]">
                    Login
                </a>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden pb-4 md:hidden">
            <div class="mt-3 space-y-1 border-t border-slate-200 pt-3 dark:border-slate-800">

                <a href="{{ url('/') }}"
                   class="block rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('/') ? 'bg-cyan-500/10 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/70' }}">
                    Home
                </a>

                <a href="{{ url('/about') }}"
                   class="block rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->is('about') ? 'bg-cyan-500/10 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800/70' }}">
                    About
                </a>

                <div class="mt-3 flex items-center gap-2 border-t border-slate-200 pt-3 dark:border-slate-800">
                    <button type="button" data-theme-toggle aria-pressed="false" aria-label="Aktifkan mode terang"
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-300 text-slate-600 transition-colors hover:border-cyan-400/60 hover:text-cyan-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-cyan-400/50 dark:hover:text-cyan-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:hidden" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 dark:block" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                             stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                        </svg>
                    </button>

                    <a href="{{ url('/login') }}"
                       class="flex-1 rounded-lg border border-cyan-500/40 bg-cyan-500/10 px-4 py-2.5 text-center text-sm font-medium text-cyan-700 transition-colors hover:bg-cyan-500/20 dark:border-cyan-400/35 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:bg-cyan-400/15">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>