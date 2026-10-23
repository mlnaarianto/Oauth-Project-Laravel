@extends('tampilan.app')

@section('title', 'About')

@section('content')
    <!-- HERO SECTION -->
    <!-- Menggunakan gradient yang sama dengan halaman Home agar konsisten -->
    <section class="bg-gradient-to-br from-indigo-600 to-blue-500 text-white py-20 md:py-28 text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight">Tentang Kami</h1>
            <p class="text-lg md:text-xl text-blue-100 mt-4 max-w-2xl mx-auto">Mengenal lebih dekat MyApp dan tim di baliknya</p>
        </div>
    </section>

    <!-- ABOUT CONTENT SECTION -->
    <section class="py-16 md:py-24 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Grid 2 Kolom: 1 kolom di HP, 2 kolom di Laptop -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Kolom Teks -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 text-slate-900 dark:text-white">Tentang MyApp</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-4 leading-relaxed">
                        MyApp adalah aplikasi modern yang dibuat menggunakan Laravel dan Tailwind CSS. Kami berkomitmen untuk menyediakan solusi digital yang inovatif dan mudah digunakan bagi semua pengguna.
                    </p>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                        Aplikasi ini dirancang dengan performa tinggi, user-friendly, dan responsif, sehingga dapat diakses dengan baik melalui berbagai jenis perangkat.
                    </p>

                    <!-- Visi -->
                    <div class="flex items-start gap-4 mb-6">
                        <!-- Ikon Cek menggunakan SVG Tailwind -->
                        <div class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shrink-0 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Visi</h5>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Menjadi platform terdepan yang menghubungkan pengguna dengan solusi teknologi yang efisien dan user-friendly.</p>
                        </div>
                    </div>

                    <!-- Misi -->
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-600 text-white rounded-full flex items-center justify-center w-12 h-12 shrink-0 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Misi</h5>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Mengembangkan produk berkualitas tinggi yang memudahkan kehidupan sehari-hari pengguna dan mendukung produktivitas mereka.</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Gambar -->
                <div class="mt-8 lg:mt-0">
                    <img src="https://picsum.photos/seed/aboutus/600/400.jpg" alt="About Us" class="w-full h-auto rounded-2xl shadow-2xl object-cover hover:scale-[1.02] transition-transform duration-300">
                </div>
                
            </div>
        </div>
    </section>
@endsection

{{-- Bagian @push('styles') sudah dihapus karena tidak lagi membutuhkan Bootstrap Icons --}}