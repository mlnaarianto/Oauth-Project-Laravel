{{-- resources/views/components/partials/navbar.blade.php --}}
<nav class="relative z-50 flex h-14 items-center justify-between border-b border-slate-200 bg-white px-3 text-slate-800 transition-colors duration-300 dark:border-slate-800 dark:bg-[#0b1220] dark:text-slate-100">

    {{-- Left: Toggle + Brand --}}
    <div class="flex items-center gap-2">

        {{-- Mobile Sidebar Toggle --}}
        <button id="mobileToggle" type="button" aria-label="Buka menu"
                class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-slate-100 hover:text-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 md:hidden dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-cyan-300">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Desktop Sidebar Toggle --}}
        <button id="sidebarToggle" type="button" aria-label="Sembunyikan sidebar"
                class="hidden rounded-lg p-2 text-slate-500 transition-colors hover:bg-slate-100 hover:text-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 md:block dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-cyan-300">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M9 4.5v15M15 4.5v15M4.125 19.5h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
        </button>

        {{-- Brand --}}
        <a href="{{ url('/dashboard') }}"
           class="ml-1 flex items-center gap-2.5 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60">
            <span class="flex h-7 w-7 items-center justify-center rounded-md border border-cyan-500/25 bg-cyan-50 dark:border-cyan-400/25 dark:bg-cyan-400/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-cyan-600 dark:text-cyan-400" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z" />
                </svg>
            </span>
            <span class="font-mono text-sm font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                My<span class="text-cyan-600 dark:text-cyan-400">App</span>
            </span>
        </a>
    </div>

    {{-- Right: Theme toggle + User --}}
    <div class="flex items-center gap-1.5">

        {{-- Theme toggle --}}
        <button type="button" data-theme-toggle aria-pressed="false" aria-label="Aktifkan mode terang"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition-colors hover:border-cyan-400/50 hover:text-cyan-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 dark:border-slate-700 dark:text-slate-300 dark:hover:border-cyan-400/50 dark:hover:text-cyan-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] dark:hidden" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-[18px] w-[18px] dark:block" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="4" />
                <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
            </svg>
        </button>

        @auth
            @php
                $avatar = Auth::user()->userAvatar();
                $name = Auth::user()->userName();
                $email = Auth::user()->userEmail();
            @endphp

            <div class="relative">
                {{-- Tombol Profil --}}
                <button id="profileDropdown" type="button" aria-haspopup="true" aria-expanded="false"
                        class="flex items-center gap-2 rounded-lg p-1 transition-colors hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 dark:hover:bg-white/5">
                    <img src="{{ $avatar }}" alt=""
                         width="36" height="36"
                         class="h-9 w-9 rounded-full border border-slate-200 object-cover ring-2 ring-transparent transition-all hover:ring-cyan-400/30 dark:border-slate-700"
                         onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">
                    <span class="hidden max-w-[10rem] truncate text-sm font-medium text-slate-700 md:inline dark:text-slate-200">{{ $name }}</span>
                    <svg class="hidden h-4 w-4 text-slate-400 md:block dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Menu Dropdown --}}
                <div id="profileMenu"
                     class="absolute right-0 mt-2 hidden w-64 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10 dark:border-slate-800 dark:bg-[#0b1220] dark:shadow-cyan-950/40">

                    <div aria-hidden="true" class="h-px bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent"></div>

                    <div class="border-b border-slate-200 p-4 text-center dark:border-slate-800">
                        <img src="{{ $avatar }}"
                             width="64" height="64"
                             class="mx-auto mb-2 h-16 w-16 rounded-full border-2 border-cyan-500/30 object-cover"
                             onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">
                        <div class="truncate text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $name }}</div>
                        <div class="truncate font-mono text-[11px] text-slate-500">{{ $email }}</div>
                    </div>

                    <a href="/profil"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 transition-colors hover:bg-slate-100 hover:text-cyan-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-cyan-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                    </a>

                    <hr class="border-slate-200 dark:border-slate-800">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>

    {{-- JS toggle dropdown profil --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileMenu = document.getElementById('profileMenu');

            if (profileDropdown && profileMenu) {
                profileDropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('hidden');
                    profileDropdown.setAttribute('aria-expanded', String(!profileMenu.classList.contains('hidden')));
                });

                document.addEventListener('click', function () {
                    profileMenu.classList.add('hidden');
                    profileDropdown.setAttribute('aria-expanded', 'false');
                });
            }
        });
    </script>
</nav>