<nav class="h-14 bg-slate-900 text-white px-3 flex items-center justify-between z-50 relative border-b border-slate-800">
    
    {{-- Left: Toggle Buttons + Brand --}}
    <div class="flex items-center gap-2">
        {{-- Mobile Sidebar Toggle --}}
        <button class="md:hidden p-2 rounded-lg hover:bg-slate-800 transition-colors" id="mobileToggle">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        {{-- Desktop Sidebar Toggle --}}
        <button class="hidden md:block p-2 rounded-lg hover:bg-slate-800 transition-colors" id="sidebarToggle">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125z"></path></svg>
        </button>

        <a class="ml-1 font-bold text-lg" href="#">My App</a>
    </div>

    {{-- Right: User Dropdown --}}
    <div class="flex items-center gap-3">
        @auth
            @php
                $avatar = Auth::user()->userAvatar();
                $name = Auth::user()->userName();
                $email = Auth::user()->userEmail();
            @endphp

            <div class="relative">
                {{-- Tombol Profil --}}
                <button id="profileDropdown" class="flex items-center gap-2 p-1 rounded-lg hover:bg-slate-800 transition-colors">
                    <img src="{{ $avatar }}" alt="User Avatar" class="w-9 h-9 rounded-full object-cover border border-slate-700" onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">
                    <span class="hidden md:inline font-semibold text-sm">{{ $name }}</span>
                    <svg class="hidden md:block w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                {{-- Menu Dropdown --}}
                <div id="profileMenu" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden z-50">
                    
                    {{-- Header --}}
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 text-center">
                        <img src="{{ $avatar }}" class="w-16 h-16 rounded-full mx-auto mb-2 object-cover border-2 border-slate-200 dark:border-slate-600" onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">
                        <div class="font-semibold text-sm text-slate-900 dark:text-white truncate">{{ $name }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $email }}</div>
                    </div>

                    {{-- Profile Link --}}
                    <a href="/profil" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile
                    </a>

                    <hr class="border-slate-200 dark:border-slate-700">

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>

    {{-- JS untuk Toggle Profile Dropdown --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileMenu = document.getElementById('profileMenu');

            if (profileDropdown && profileMenu) {
                profileDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function() {
                    profileMenu.classList.add('hidden');
                });
            }
        });
    </script>
</nav>