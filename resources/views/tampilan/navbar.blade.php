<nav id="navbar" class="fixed top-0 left-0 w-full z-50 py-3 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            
            <!-- Brand -->
            <a class="text-xl font-bold text-slate-900 dark:text-white" href="{{ url('/') }}">
                MyApp
            </a>

            <!-- Tombol Hamburger (Mobile) -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-600 dark:text-slate-300 hover:text-blue-600" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Menu Desktop -->
            <div class="hidden md:flex items-center space-x-6">
                <a class="font-medium transition-colors {{ request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" href="{{ url('/') }}">Home</a>
                <a class="font-medium transition-colors {{ request()->is('about') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" href="{{ url('/about') }}">About</a>

                <!-- Toggle Theme -->
                <button id="themeToggle" class="p-2 rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    🌙
                </button>

                <!-- Tombol Login -->
                <a class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-medium transition-colors" href="{{ url('/login') }}">
                    Login
                </a>
            </div>
        </div>

        <!-- Menu Mobile (Tersembunyi secara default) -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-4 border-t border-slate-200 dark:border-slate-700 pt-4">
            <a class="block font-medium text-slate-600 dark:text-slate-300" href="{{ url('/') }}">Home</a>
            <a class="block font-medium text-slate-600 dark:text-slate-300" href="{{ url('/about') }}">About</a>
            <div class="flex items-center space-x-4 pt-2">
                <button id="themeToggleMobile" class="p-2 rounded-full border border-slate-300 dark:border-slate-600" onclick="document.getElementById('themeToggle').click()">
                    🌙
                </button>
                <a class="bg-blue-600 text-white px-5 py-2 rounded-full font-medium text-center flex-1" href="{{ url('/login') }}">Login</a>
            </div>
        </div>
    </div>
</nav>