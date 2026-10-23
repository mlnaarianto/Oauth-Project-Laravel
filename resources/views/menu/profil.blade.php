<x-layouts.app title="Profil Saya">

    <div class="py-8 px-4 sm:px-6">
        <div class="max-w-3xl mx-auto">

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="flex items-start gap-3 p-4 mb-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl dark:bg-green-900/30 dark:text-green-300 dark:border-green-800" role="alert">
                    <!-- Ikon Check Circle -->
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="flex-1">{{ session('success') }}</div>
                    <button type="button" class="ml-auto text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200" onclick="this.parentElement.remove()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if (session('error'))
                <div class="flex items-start gap-3 p-4 mb-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl dark:bg-red-900/30 dark:text-red-300 dark:border-red-800" role="alert">
                    <!-- Ikon Warning -->
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div class="flex-1">{{ session('error') }}</div>
                    <button type="button" class="ml-auto text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" onclick="this.parentElement.remove()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <!-- CARD UTAMA PROFIL -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">

                {{-- Header Profil --}}
                <div class="p-8 text-center bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                    
                    {{-- Avatar --}}
                    <div class="relative inline-block mb-4">
                        <img id="avatar-preview" 
                             src="{{ Auth::user()->userAvatar() }}"
                             class="w-36 h-36 rounded-full shadow-lg border-4 border-white dark:border-slate-700 object-cover mx-auto"
                             onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">{{ Auth::user()->userName() }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-0">{{ Auth::user()->userEmail() }}</p>
                </div>

                {{-- Konten Utama: Grid 2 Kolom --}}
                <div class="grid grid-cols-1 md:grid-cols-2">

                    {{-- Kolom Kiri: Informasi Akun --}}
                    <div class="p-6 md:border-r border-slate-200 dark:border-slate-700">
                        <h5 class="flex items-center gap-2 text-lg font-bold text-blue-600 dark:text-blue-400 mb-6">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Detail Dasar
                        </h5>

                        <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                            <li class="flex justify-between items-center py-4">
                                <span class="text-slate-500 dark:text-slate-400">Nama Lengkap</span>
                                <span class="font-semibold text-slate-900 dark:text-white text-right">{{ Auth::user()->userName() }}</span>
                            </li>

                            <li class="flex justify-between items-center py-4">
                                <span class="text-slate-500 dark:text-slate-400">Email</span>
                                <span class="font-semibold text-slate-900 dark:text-white text-right break-all">{{ Auth::user()->userEmail() }}</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Kolom Kanan: Keamanan Akun --}}
                    <div class="p-6">
                        <h5 class="flex items-center gap-2 text-lg font-bold text-red-600 dark:text-red-400 mb-6">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Keamanan Akun
                        </h5>

                        <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                            <li class="flex justify-between items-center py-4">
                                <span class="text-slate-500 dark:text-slate-400">Login Terakhir Via</span>
                                <!-- Badge Provider -->
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    {{ ucfirst(Auth::user()->last_login_provider ?? 'Sistem') }}
                                </span>
                            </li>

                            <li class="flex justify-between items-center py-4">
                                <span class="text-slate-500 dark:text-slate-400">Tanggal Dibuat</span>
                                <span class="font-semibold text-slate-900 dark:text-white text-right">{{ Auth::user()->created_at->format('d F Y') }}</span>
                            </li>
                        </ul>
                    </div>
                    
                </div> {{-- Akhir Grid --}}
                
            </div> {{-- Akhir Card --}}

        </div>
    </div>

</x-layouts.app>