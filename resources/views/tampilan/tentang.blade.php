<!-- resources/views/about.blade.php -->
@extends('tampilan.app')

@section('title', 'About Us')

@section('content')
    <!-- HERO SECTION -->
    <section class="bg-gradient-to-br from-indigo-600 to-blue-500 text-white py-20 md:py-28 text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight">Tentang Kami</h1>
            <p class="text-lg md:text-xl text-blue-100 mt-4 max-w-2xl mx-auto">Mengenal lebih dekat MyApp dan tim di baliknya</p>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="py-16 md:py-24 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 text-slate-900 dark:text-white">Visi & Misi Kami</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                        MyApp berkomitmen untuk menyediakan solusi digital yang inovatif dan mudah digunakan bagi semua pengguna. Kami percaya bahwa teknologi harus dapat diakses oleh siapa saja, kapan saja, dan di mana saja.
                    </p>
                    
                    <!-- Visi -->
                    <div class="flex items-start gap-4 mb-6">
                        <div class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shrink-0 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Visi</h5>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Menjadi platform terdepan yang menghubungkan pengguna dengan solusi teknologi yang efisien dan user-friendly.</p>
                        </div>
                    </div>

                    <!-- Misi -->
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shrink-0 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Misi</h5>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Mengembangkan produk berkualitas tinggi yang memudahkan kehidupan sehari-hari pengguna dan mendukung produktivitas mereka.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="https://picsum.photos/seed/aboutus/600/400.jpg" alt="About Us" class="w-full h-auto rounded-2xl shadow-2xl object-cover hover:scale-[1.02] transition-transform duration-300">
                </div>
            </div>
        </div>
    </section>

    <!-- TIMELINE SECTION -->
    <section class="py-16 md:py-24 bg-slate-100 dark:bg-slate-800/50 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 text-slate-900 dark:text-white">Perjalanan Kami</h2>
            
            <div class="relative">
                <!-- Garis Vertikal Tengah (Desktop) / Kiri (Mobile) -->
                <div class="absolute left-6 md:left-1/2 top-0 bottom-0 w-1 bg-blue-600 -translate-x-1/2 rounded-full"></div>

                <!-- Timeline Item 1 (Kiri) -->
                <div class="relative mb-12 md:w-1/2 md:pr-12 md:text-right md:left-0">
                    <!-- Titik -->
                    <div class="absolute w-6 h-6 bg-white dark:bg-slate-900 border-4 border-blue-600 rounded-full top-1 -right-3 hidden md:block"></div>
                    <div class="absolute w-6 h-6 bg-white dark:bg-slate-900 border-4 border-blue-600 rounded-full top-1 -left-3 md:hidden"></div>
                    
                    <div class="pl-14 md:pl-0">
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">2023</h4>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">MyApp didirikan dengan visi untuk menciptakan solusi digital yang inovatif dan mudah digunakan.</p>
                    </div>
                </div>

                <!-- Timeline Item 2 (Kanan) -->
                <div class="relative mb-12 md:w-1/2 md:pl-12 md:left-1/2">
                    <!-- Titik -->
                    <div class="absolute w-6 h-6 bg-white dark:bg-slate-900 border-4 border-blue-600 rounded-full top-1 -left-3"></div>
                    
                    <div class="pl-14 md:pl-0">
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">2024</h4>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Meluncurkan versi beta dengan fitur-fitur dasar dan menerima umpan balik positif dari pengguna awal.</p>
                    </div>
                </div>

                <!-- Timeline Item 3 (Kiri) -->
                <div class="relative mb-0 md:w-1/2 md:pr-12 md:text-right md:left-0">
                    <!-- Titik -->
                    <div class="absolute w-6 h-6 bg-white dark:bg-slate-900 border-4 border-blue-600 rounded-full top-1 -right-3 hidden md:block"></div>
                    <div class="absolute w-6 h-6 bg-white dark:bg-slate-900 border-4 border-blue-600 rounded-full top-1 -left-3 md:hidden"></div>
                    
                    <div class="pl-14 md:pl-0">
                        <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">2025</h4>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Merilis versi stabil dengan fitur lengkap dan mulai ekspansi ke pasar yang lebih luas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM SECTION -->
    <section class="py-16 md:py-24 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-slate-900 dark:text-white">Tim Kami</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Anggota 1 -->
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group">
                    <div class="overflow-hidden">
                        <img src="https://picsum.photos/seed/person1/400/400.jpg" alt="Team Member" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-6">
                        <h5 class="text-xl font-bold text-slate-900 dark:text-white">Ahmad Rizki</h5>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-3">CEO & Founder</p>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4">Berpengalaman lebih dari 10 tahun dalam industri teknologi dan digital.</p>
                        <div class="flex space-x-4 text-slate-400 dark:text-slate-500">
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></a>
                        </div>
                    </div>
                </div>

                <!-- Anggota 2 -->
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group">
                    <div class="overflow-hidden">
                        <img src="https://picsum.photos/seed/person2/400/400.jpg" alt="Team Member" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-6">
                        <h5 class="text-xl font-bold text-slate-900 dark:text-white">Siti Nurhaliza</h5>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-3">CTO</p>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4">Ahli dalam pengembangan perangkat lunak dan arsitektur sistem yang scalable.</p>
                        <div class="flex space-x-4 text-slate-400 dark:text-slate-500">
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></a>
                        </div>
                    </div>
                </div>

                <!-- Anggota 3 -->
                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group">
                    <div class="overflow-hidden">
                        <img src="https://picsum.photos/seed/person3/400/400.jpg" alt="Team Member" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-6">
                        <h5 class="text-xl font-bold text-slate-900 dark:text-white">Budi Santoso</h5>
                        <p class="text-blue-600 dark:text-blue-400 font-medium mb-3">Head of Design</p>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4">Spesialis dalam UX/UI design dengan fokus pada pengalaman pengguna yang intuitif.</p>
                        <div class="flex space-x-4 text-slate-400 dark:text-slate-500">
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS SECTION -->
    <section class="py-16 bg-slate-100 dark:bg-slate-800/50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">10K+</h2>
                    <p class="text-slate-600 dark:text-slate-400 font-medium">Pengguna Aktif</p>
                </div>
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">50+</h2>
                    <p class="text-slate-600 dark:text-slate-400 font-medium">Fitur Tersedia</p>
                </div>
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">99.9%</h2>
                    <p class="text-slate-600 dark:text-slate-400 font-medium">Uptime Server</p>
                </div>
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">24/7</h2>
                    <p class="text-slate-600 dark:text-slate-400 font-medium">Dukungan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>
@endsection