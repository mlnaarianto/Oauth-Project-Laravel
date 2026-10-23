{{-- resources/views/components/partials/sidebar.blade.php --}}
<aside id="sidebar"
    class="fixed left-0 top-14 z-40 h-[calc(100vh-56px)] w-64 flex-shrink-0 -translate-x-full
           border-r border-slate-200 bg-white transition-all duration-300
           md:relative md:top-0 md:h-full md:translate-x-0 dark:border-slate-800 dark:bg-[#0b1220]">

    <div class="flex h-full flex-col">

        {{-- Label atas --}}
        <div class="px-4 pb-2 pt-4">
            <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">navigasi</p>
        </div>

        <ul class="flex flex-col gap-1 px-2">

            {{-- Dashboard --}}
            <li>
                <a href="/dashboard"
                   @if (Request::is('dashboard')) aria-current="page" @endif
                   class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
                   {{ Request::is('dashboard')
                        ? 'bg-cyan-50 font-semibold text-cyan-700 shadow-[inset_0_0_0_1px_rgba(6,182,212,.2)] dark:bg-cyan-500/10 dark:text-cyan-300 dark:shadow-[inset_0_0_0_1px_rgba(34,211,238,.18)]'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-cyan-700 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-slate-100' }}">
                    <span class="absolute left-0 top-1/2 h-5 w-0.5 -translate-y-1/2 rounded-full bg-cyan-500 transition-opacity {{ Request::is('dashboard') ? 'opacity-100' : 'opacity-0' }} dark:bg-cyan-400"></span>
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>

            {{-- Video --}}
            <li>
                <a href="/video"
                   @if (Request::is('video')) aria-current="page" @endif
                   class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
                   {{ Request::is('video')
                        ? 'bg-cyan-50 font-semibold text-cyan-700 shadow-[inset_0_0_0_1px_rgba(6,182,212,.2)] dark:bg-cyan-500/10 dark:text-cyan-300 dark:shadow-[inset_0_0_0_1px_rgba(34,211,238,.18)]'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-cyan-700 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-slate-100' }}">
                    <span class="absolute left-0 top-1/2 h-5 w-0.5 -translate-y-1/2 rounded-full bg-cyan-500 transition-opacity {{ Request::is('video') ? 'opacity-100' : 'opacity-0' }} dark:bg-cyan-400"></span>
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Video
                </a>
            </li>

            {{-- Section Label --}}
            <li class="mt-4 px-2">
                <small class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                    Menu Lain
                </small>
            </li>

            {{-- Example Menu --}}
            <li>
                <a href="#"
                   class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
                   {{ Request::is('example')
                        ? 'bg-cyan-50 font-semibold text-cyan-700 shadow-[inset_0_0_0_1px_rgba(6,182,212,.2)] dark:bg-cyan-500/10 dark:text-cyan-300 dark:shadow-[inset_0_0_0_1px_rgba(34,211,238,.18)]'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-cyan-700 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-slate-100' }}">
                    <span class="absolute left-0 top-1/2 h-5 w-0.5 -translate-y-1/2 rounded-full bg-cyan-500 transition-opacity {{ Request::is('example') ? 'opacity-100' : 'opacity-0' }} dark:bg-cyan-400"></span>
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Example Menu
                </a>
            </li>

        </ul>

        {{-- Status bawah --}}
        <div class="mt-auto border-t border-slate-200 p-4 dark:border-slate-800">
            <div class="flex items-center justify-between font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500">
                <span class="flex items-center gap-1.5">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    </span>
                    online
                </span>
                <span>v2.0</span>
            </div>
        </div>
    </div>
</aside>