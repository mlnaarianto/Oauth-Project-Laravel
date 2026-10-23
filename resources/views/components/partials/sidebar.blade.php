<aside id="sidebar" 
    class="w-64 bg-slate-900 flex-shrink-0 transition-all duration-300 
           fixed md:relative top-14 md:top-0 left-0 h-[calc(100vh-56px)] md:h-full z-40
           -translate-x-full md:translate-x-0">
    
    <ul class="flex flex-col pt-3 px-2">

        {{-- Dashboard --}}
        <li>
            <a href="/dashboard" 
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-md mb-1 text-sm transition-colors
                {{ Request::is('dashboard') 
                    ? 'bg-white text-black font-semibold' 
                    : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
        </li>

        {{-- Video --}}
        <li>
            <a href="/video" 
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-md mb-1 text-sm transition-colors
                {{ Request::is('video') 
                    ? 'bg-white text-black font-semibold' 
                    : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Video
            </a>
        </li>

        {{-- Section Label --}}
        <li class="mt-3">
            <small class="text-slate-500 text-xs font-semibold uppercase tracking-wider ml-2">Menu Lain</small>
        </li>

        {{-- Example Menu --}}
        <li>
            <a href="#" 
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-md mb-1 text-sm transition-colors
                {{ Request::is('example') 
                    ? 'bg-white text-black font-semibold' 
                    : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Example Menu
            </a>
        </li>

    </ul>
</aside>