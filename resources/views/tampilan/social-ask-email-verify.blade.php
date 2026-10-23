@extends('tampilan.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    <div class="max-w-lg mx-auto">
        <!-- Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 sm:p-8">

                <h4 class="text-2xl font-bold mb-2 text-center text-slate-900 dark:text-white">Verifikasi Email</h4>
                <p class="text-slate-500 dark:text-slate-400 text-center mb-6">
                    Masukkan kode OTP yang telah kami kirim ke email Anda.
                </p>

                @if(session('error'))
                    <div class="p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl dark:bg-red-900/30 dark:text-red-300 dark:border-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('social.askEmailOtp.submit') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request('token') }}">

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 text-center">Kode OTP</label>
                        <!-- Menambahkan class text-center, tracking-widest, dan font-mono agar terlihat seperti form OTP -->
                        <input 
                            type="text" 
                            name="otp" 
                            class="w-full px-4 py-3 text-center tracking-[0.5em] text-lg font-mono rounded-xl border @error('otp') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-emerald-500 focus:border-emerald-500 @enderror bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 transition-colors"
                            placeholder="••••••"
                            maxlength="6"
                            required
                        >

                        @error('otp')
                            <div class="text-red-500 text-sm mt-2 text-center">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800" type="submit">
                        Verifikasi
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection