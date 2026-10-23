@extends('tampilan.app')

@section('title', 'Home')

@section('content')
    <!-- HERO SECTION -->
    <!-- Menggunakan gradient indigo ke biru, padding atas-bawah yang lega, dan text center -->
    <section class="bg-gradient-to-br from-indigo-600 to-blue-500 text-white py-20 md:py-28 text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight">Selamat Datang di Aplikasi Anda</h1>
            <p class="text-lg md:text-xl text-blue-100 mt-4 max-w-2xl mx-auto">Tampilan home ini responsif, modern, dan mudah digunakan.</p>
            
            <!-- Tombol dengan efek hover -->
            <a href="#features" class="inline-block mt-8 px-8 py-3 bg-white text-blue-600 font-semibold rounded-full hover:bg-slate-100 hover:-translate-y-0.5 transition-all duration-300 shadow-lg hover:shadow-xl">
                Jelajahi
            </a>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <!-- Menambahkan dark mode support untuk background section -->
    <section id="features" class="py-16 md:py-24 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-slate-900 dark:text-white">Fitur Utama</h2>
            
            <!-- Grid layout untuk 3 kolom yang responsif -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Card 1 -->
                <!-- Menggunakan background image, overlay gelap agar teks terbaca, dan efek hover -->
                <div class="relative overflow-hidden rounded-2xl bg-[url('/images/images1.png')] bg-cover bg-center group hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                    <!-- Overlay (bg-slate-900/60) -->
                    <div class="absolute inset-0 bg-slate-900/60 group-hover:bg-slate-900/70 transition-colors duration-300"></div>
                    <!-- Konten Card -->
                    <div class="relative p-8 h-full flex flex-col justify-center min-h-[220px]">
                        <h5 class="text-xl font-bold text-white mb-3">Cepat dan Stabil</h5>
                        <p class="text-slate-200 leading-relaxed">Aplikasi dirancang dengan performa tinggi dan stabil.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="relative overflow-hidden rounded-2xl bg-[url('/images/images1.png')] bg-cover bg-center group hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                    <div class="absolute inset-0 bg-slate-900/60 group-hover:bg-slate-900/70 transition-colors duration-300"></div>
                    <div class="relative p-8 h-full flex flex-col justify-center min-h-[220px]">
                        <h5 class="text-xl font-bold text-white mb-3">User Friendly</h5>
                        <p class="text-slate-200 leading-relaxed">Navigasi mudah dan tampilan nyaman untuk semua pengguna.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="relative overflow-hidden rounded-2xl bg-[url('/images/images1.png')] bg-cover bg-center group hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
                    <div class="absolute inset-0 bg-slate-900/60 group-hover:bg-slate-900/70 transition-colors duration-300"></div>
                    <div class="relative p-8 h-full flex flex-col justify-center min-h-[220px]">
                        <h5 class="text-xl font-bold text-white mb-3">Responsive</h5>
                        <p class="text-slate-200 leading-relaxed">Bisa diakses dengan baik melalui HP, tablet, maupun laptop.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection