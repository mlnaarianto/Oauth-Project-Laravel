{{-- resources/views/tampilan/social-confirm.blade.php --}}
@extends('tampilan.app')

@section('title', 'Konfirmasi Penautan Akun Sosial')

@section('content')
    <div class="min-h-screen py-12 px-4 sm:px-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-3xl mx-auto">
            <!-- Card Utama -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="p-6 sm:p-8">
                    
                    <h3 class="text-2xl font-bold mb-6 text-slate-900 dark:text-white">Konfirmasi Penautan Akun</h3>

                    @if (session('info'))
                        <div class="p-4 mb-6 text-sm text-blue-800 bg-blue-50 border border-blue-200 rounded-xl dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                            {{ session('info') }}
                        </div>
                    @endif

                    {{-- RINGKASAN AKUN PROVIDER --}}
                    <div class="flex items-center mb-6">
                        @if (!empty($payload['avatar']))
                            <img src="{{ $payload['avatar'] }}" class="w-14 h-14 rounded-full object-cover mr-4 border-2 border-slate-200 dark:border-slate-600">
                        @else
                            <!-- Placeholder jika tidak ada avatar -->
                            <div class="w-14 h-14 rounded-full bg-slate-300 dark:bg-slate-600 mr-4 shrink-0"></div>
                        @endif

                        <div>
                            <strong class="text-slate-900 dark:text-white block">{{ ucfirst($payload['provider']) }} Account</strong>
                            <small class="text-slate-500 dark:text-slate-400">{{ $payload['email'] ?? 'Email tidak tersedia' }}</small>
                        </div>
                    </div>

                    <p class="text-slate-700 dark:text-slate-300 mb-6">
                        Email dari provider ini sudah digunakan oleh akun lain di sistem.
                        Pilih metode verifikasi untuk melanjutkan penautan akun.
                    </p>

                    <hr class="border-slate-200 dark:border-slate-700 my-6">

                    {{-- ================================
                    1. USER SUDAH LOGIN → langsung tautkan
                    ================================= --}}
                    @auth
                        <div class="mb-6">
                            <h5 class="text-lg font-bold text-slate-900 dark:text-white mb-2">1) Tautkan ke akun yang sedang Anda gunakan</h5>
                            <p class="text-slate-600 dark:text-slate-400 mb-4">Anda login sebagai <strong class="text-slate-900 dark:text-white">{{ auth()->user()->email }}</strong>.</p>

                            <form action="{{ route('social.confirm.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <button class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                    Tautkan {{ ucfirst($payload['provider']) }} ke akun ini
                                </button>
                            </form>
                        </div>
                        <hr class="border-slate-200 dark:border-slate-700 my-6">
                    @endauth

                    {{-- ====================================
                    2. KONFIRMASI VIA PROVIDER (UTAMA)
                    ===================================== --}}
                    <div class="mb-6">
                        <h5 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                            @auth
                                2)
                            @else
                                1)
                            @endauth
                            Konfirmasi dengan {{ ucfirst($payload['provider']) }}
                        </h5>

                        <p class="text-slate-600 dark:text-slate-400 mb-4">
                            Gunakan login {{ ucfirst($payload['provider']) }} untuk membuktikan bahwa Anda pemilik email ini.
                        </p>

                        {{-- Untuk GitHub, gunakan URL yang sama dengan login normal --}}
                        @if ($payload['provider'] === 'github')
                            <a href="{{ url('/auth/github?confirm_token=' . $token) }}" class="block w-full text-center py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                Konfirmasi via GitHub
                            </a>
                        @else
                            <a href="{{ url('/auth/confirm/' . $payload['provider'] . '?token=' . $token) }}" class="block w-full text-center py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                Konfirmasi via {{ ucfirst($payload['provider']) }}
                            </a>
                        @endif
                    </div>

                    <hr class="border-slate-200 dark:border-slate-700 my-6">

                    {{-- ====================================
                    3. VERIFIKASI VIA OTP
                    ===================================== --}}
                    <div class="mb-6">
                        <h5 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                            @auth 3) @else 2) @endauth Verifikasi dengan Kode OTP
                        </h5>
                        <p class="text-slate-600 dark:text-slate-400 mb-4">
                            Kami akan mengirimkan kode verifikasi satu kali ke email Anda yang terdaftar di {{ ucfirst($payload['provider']) }}.
                        </p>

                        {{-- Form untuk meminta OTP --}}
                        <div id="otp-request-form">
                            <button type="button" class="w-full py-3 px-4 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800" id="request-otp-btn">
                                Kirim Kode OTP ke {{ $payload['email'] ?? 'email Anda' }}
                            </button>
                        </div>

                        {{-- Form untuk memasukkan OTP (awalnya disembunyikan) --}}
                        <div id="otp-verify-form" style="display: none;" class="mt-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Masukkan Kode OTP</label>
                                
                                <!-- Input Group dengan Tailwind (Flexbox) -->
                                <div class="flex">
                                    <input type="text" name="otp_code" id="otp-code" 
                                        class="w-full px-4 py-2.5 text-center tracking-[0.3em] font-mono rounded-l-xl border border-r-0 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" 
                                        placeholder="Masukkan 6 digit kode" maxlength="6" required>
                                    <button type="button" 
                                        class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-r-xl border border-l-0 border-slate-300 dark:border-slate-600 transition-colors whitespace-nowrap" 
                                        id="resend-otp-btn">
                                        Kirim Ulang
                                    </button>
                                </div>
                                <small class="block text-slate-500 dark:text-slate-400 mt-2" id="otp-timer"></small>
                            </div>
                            <button type="button" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 disabled:opacity-50 disabled:cursor-not-allowed" id="verify-otp-btn">
                                Verifikasi & Tautkan Akun
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('login') }}" class="inline-block text-blue-600 dark:text-blue-400 hover:underline font-medium">
                            Kembali ke login
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk menangani OTP (Tidak ada yang diubah) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const requestOtpBtn = document.getElementById('request-otp-btn');
                const otpVerifyForm = document.getElementById('otp-verify-form');
                const otpRequestForm = document.getElementById('otp-request-form');
                const otpCode = document.getElementById('otp-code');
                const verifyOtpBtn = document.getElementById('verify-otp-btn');
                const resendOtpBtn = document.getElementById('resend-otp-btn');
                const otpTimer = document.getElementById('otp-timer');

                let countdownInterval;
                let token = '{{ $token }}';
                let provider = '{{ $payload['provider'] }}';

                // Fungsi untuk memulai countdown timer
                function startCountdown(seconds) {
                    let remaining = seconds;
                    otpTimer.textContent = `Kode akan kadaluarsa dalam ${remaining} detik`;

                    clearInterval(countdownInterval);
                    countdownInterval = setInterval(function() {
                        remaining--;
                        if (remaining <= 0) {
                            clearInterval(countdownInterval);
                            otpTimer.textContent = 'Kode OTP telah kadaluarsa. Silakan kirim ulang.';
                            verifyOtpBtn.disabled = true;
                        } else {
                            otpTimer.textContent = `Kode akan kadaluarsa dalam ${remaining} detik`;
                        }
                    }, 1000);
                }

                // Event listener untuk tombol request OTP
                requestOtpBtn.addEventListener('click', function() {
                    fetch(`/auth/${provider}/request-otp`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                token: token
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                otpRequestForm.style.display = 'none';
                                otpVerifyForm.style.display = 'block';
                                startCountdown(data.expires_in || 300); // Default 5 menit
                                verifyOtpBtn.disabled = false;
                            } else {
                                alert(data.message || 'Gagal mengirim kode OTP. Silakan coba lagi.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                });

                // Event listener untuk tombol verify OTP
                verifyOtpBtn.addEventListener('click', function() {
                    const code = otpCode.value;

                    if (!code || code.length !== 6) {
                        alert('Masukkan kode OTP 6 digit yang valid.');
                        return;
                    }

                    fetch(`/auth/${provider}/verify-otp`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                token: token,
                                otp_code: code
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect_url || '/dashboard';
                            } else {
                                alert(data.message || 'Kode OTP tidak valid. Silakan coba lagi.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                });

                // Event listener untuk tombol resend OTP
                resendOtpBtn.addEventListener('click', function() {
                    fetch(`/auth/${provider}/request-otp`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                token: token
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                startCountdown(data.expires_in || 300); // Default 5 menit
                                verifyOtpBtn.disabled = false;
                                alert('Kode OTP baru telah dikirim.');
                            } else {
                                alert(data.message || 'Gagal mengirim ulang kode OTP. Silakan coba lagi.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                });
            });
        </script>
    @endpush
@endsection