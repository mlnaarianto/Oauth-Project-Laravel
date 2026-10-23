@extends('tampilan.app')

@section('title', 'Masukkan Email Gmail Pribadi')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    <div class="max-w-lg mx-auto">
        <!-- Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 sm:p-8">

                <h4 class="text-2xl font-bold mb-6 text-center text-slate-900 dark:text-white">Masukkan Email Gmail Pribadi</h4>

                {{-- Pesan penjelasan --}}
                @if (isset($original_email) && $original_email)
                    <div class="p-4 mb-6 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                        Email yang Anda gunakan di {{ ucfirst($provider) }} adalah
                        <strong>{{ $original_email }}</strong>.
                        <br>
                        Sistem hanya mendukung <strong>Gmail pribadi (@gmail.com)</strong>.
                        Akun Google dari kantor, kampus, atau organisasi (Google Workspace)
                        tidak dapat digunakan.
                    </div>
                @else
                    <div class="p-4 mb-6 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                        Akun {{ ucfirst($provider) }} Anda tidak menyediakan email Gmail pribadi.
                        <br>
                        Silakan masukkan <strong>alamat Gmail pribadi (@gmail.com)</strong>
                        untuk melanjutkan proses login.
                    </div>
                @endif

                {{-- Error dari backend --}}
                @if(session('error'))
                    <div class="p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl dark:bg-red-900/30 dark:text-red-300 dark:border-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('social.askEmail.submit') }}" id="emailForm" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email Gmail Pribadi</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-blue-500 focus:border-blue-500 @enderror bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 transition-colors"
                            placeholder="nama@gmail.com"
                            required
                            autocomplete="email"
                        >

                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                            Gunakan alamat email Gmail pribadi dengan akhiran <strong>@gmail.com</strong>
                        </div>
                    </div>

                    <button class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800" type="submit">
                        Kirim Kode Verifikasi (OTP)
                    </button>
                </form>

                <div class="text-sm text-slate-500 dark:text-slate-400 text-center mt-6">
                    Catatan: Akun Google dari kantor, kampus, atau organisasi
                    (Google Workspace) belum didukung.
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Validasi Gmail di sisi klien --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('emailForm');
    const emailInput = document.getElementById('email');

    form.addEventListener('submit', function (e) {
        const email = emailInput.value.trim().toLowerCase();
        const existingError = document.getElementById('gmail-error');

        // Class default Tailwind untuk input normal
        const defaultClasses = ['border-slate-300', 'dark:border-slate-600', 'focus:ring-blue-500', 'focus:border-blue-500'];
        // Class Tailwind untuk input error
        const errorClasses = ['border-red-500', 'focus:ring-red-500', 'focus:border-red-500'];

        if (!email.endsWith('@gmail.com')) {
            e.preventDefault();

            // Ubah warna border jadi merah
            emailInput.classList.remove(...defaultClasses);
            emailInput.classList.add(...errorClasses);

            if (!existingError) {
                const error = document.createElement('div');
                error.id = 'gmail-error';
                // Gunakan class Tailwind untuk pesan error
                error.className = 'text-red-500 text-sm mt-1';
                error.textContent = 'Gunakan alamat Gmail pribadi dengan akhiran @gmail.com.';
                emailInput.parentNode.appendChild(error);
            }
        } else {
            // Kembalikan ke warna normal
            emailInput.classList.remove(...errorClasses);
            emailInput.classList.add(...defaultClasses);
            
            if (existingError) {
                existingError.remove();
            }
        }
    });
});
</script>
@endpush
@endsection