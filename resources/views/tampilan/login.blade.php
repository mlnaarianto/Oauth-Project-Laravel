@extends('tampilan.app')

@section('title', 'Login')

@section('content')
    <!-- Wrapper utama: min-h-screen, flexbox untuk center, dan background support dark mode -->
    <div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-900 p-4 transition-colors duration-300">
        
        <!-- Login Box: max-width, padding, shadow, dan dark mode support -->
        <div class="w-full max-w-md p-8 text-center bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 transition-colors duration-300">

            {{-- Header --}}
            <div class="mb-6">
                <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Login or Sign Up</h4>
                <p class="text-slate-500 dark:text-slate-400">Continue using one of the options below</p>
            </div>

            <hr class="my-6 border-slate-200 dark:border-slate-700"> {{-- Garis pemisah --}}

            {{-- Dynamic Provider Buttons --}}
            @php
                $providers = [
                    'google' => [
                        'label' => 'Continue with Google',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/google.svg',
                    ],
                    'facebook' => [
                        'label' => 'Continue with Facebook',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/facebook.svg',
                    ],
                    'github' => [
                        'label' => 'Continue with GitHub',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/github.svg',
                    ],
                    'x' => [
                        'label' => 'Continue with X (Twitter)',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/x.svg',
                    ],
                    // TAMBAHKAN KONFIGURASI DISCORD DI SINI
                    'discord' => [
                        'label' => 'Continue with Discord',
                        'icon' => 'https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/discord.svg', // Ikon Discord
                    ],
                ];

                // if someday you disable provider dynamically
                // TAMBAHKAN 'discord' KE DAFTAR DEFAULT
                $enabledProviders = config('services.enabled_providers', [
                    'google',
                    'facebook',
                    'github',
                    'x',
                    'discord',
                ]);
            @endphp

            @foreach ($enabledProviders as $provider)
                @if (isset($providers[$provider]))
                    <!-- Tombol Social: Full width, flexbox, hover effect, dan dark mode -->
                    <a href="{{ route('oauth.redirect', $provider) }}"
                        class="flex items-center justify-center gap-3 w-full px-4 py-3 mb-3 text-base font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl shadow-sm hover:bg-slate-50 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200 dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600 dark:hover:bg-slate-600">
                        
                        <!-- Tambahkan class dark:invert agar ikon hitam berubah putih di dark mode -->
                        <img src="{{ $providers[$provider]['icon'] }}" width="22" class="w-[22px] h-[22px] dark:invert"
                            alt="{{ $providers[$provider]['label'] }} Icon">
                        
                        {{ $providers[$provider]['label'] }}
                    </a>
                @endif
            @endforeach

            {{-- Error --}}
            @if (session('error'))
                <div class="mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Footer/Legal Info --}}
            <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
                By continuing, you agree to our <a href="#" class="font-semibold text-blue-600 hover:underline dark:text-blue-400">Terms of Service</a> and
                <a href="#" class="font-semibold text-blue-600 hover:underline dark:text-blue-400">Privacy Policy</a>.
            </p>

        </div>
    </div>
@endsection

{{-- Bagian @push('styles') sudah dihapus total karena tidak diperlukan lagi --}}