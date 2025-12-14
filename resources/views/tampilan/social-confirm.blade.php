{{-- resources/views/tampilan/social-confirm.blade.php --}}
@extends('tampilan.app')

@section('title', 'Konfirmasi Penautan Akun Sosial')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="mb-3">Konfirmasi Penautan Akun</h3>

                        @if (session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif

                        {{-- RINGKASAN AKUN PROVIDER --}}
                        <div class="d-flex align-items-center mb-3">
                            @if (!empty($payload['avatar']))
                                <img src="{{ $payload['avatar'] }}" class="rounded-circle me-3"
                                    style="width:56px;height:56px;object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-secondary me-3" style="width:56px;height:56px;"></div>
                            @endif

                            <div>
                                <strong>{{ ucfirst($payload['provider']) }} Account</strong><br>
                                <small class="text-muted">{{ $payload['email'] ?? 'Email tidak tersedia' }}</small>
                            </div>
                        </div>

                        <p>
                            Email dari provider ini sudah digunakan oleh akun lain di sistem.
                            Pilih metode verifikasi untuk melanjutkan penautan akun.
                        </p>

                        <hr>

                        {{-- ================================
                        1. USER SUDAH LOGIN → langsung tautkan
                    ================================= --}}
                        @auth
                            <div class="mb-4">
                                <h5>1) Tautkan ke akun yang sedang Anda gunakan</h5>
                                <p class="text-muted">Anda login sebagai <strong>{{ auth()->user()->email }}</strong>.</p>

                                <form action="{{ route('social.confirm.post') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <button class="btn btn-primary">
                                        Tautkan {{ ucfirst($payload['provider']) }} ke akun ini
                                    </button>
                                </form>
                            </div>
                            <hr>
                        @endauth

                        {{-- ====================================
                        2. KONFIRMASI VIA PROVIDER (UTAMA)
                    ===================================== --}}
                        <div class="mb-4">
                            <h5>
                                @auth
                                    2)
                                @else
                                    1)
                                @endauth
                                Konfirmasi dengan {{ ucfirst($payload['provider']) }}
                            </h5>

                            <p class="text-muted">
                                Gunakan login {{ ucfirst($payload['provider']) }} untuk membuktikan bahwa Anda pemilik email
                                ini.
                            </p>

                            {{-- Untuk GitHub, gunakan URL yang sama dengan login normal --}}
                            @if ($payload['provider'] === 'github')
                                <a href="{{ url('/auth/github?confirm_token=' . $token) }}" class="btn btn-success w-100">
                                    Konfirmasi via GitHub
                                </a>
                            @else
                                <a href="{{ url('/auth/confirm/' . $payload['provider'] . '?token=' . $token) }}"
                                    class="btn btn-success w-100">
                                    Konfirmasi via {{ ucfirst($payload['provider']) }}
                                </a>
                            @endif
                        </div>


                        {{-- ====================================
                        3. VERIFIKASI VIA OTP
                    ===================================== --}}
                        <div class="mb-4">
                            <h5>@auth 3)
                                @else
                                2) @endauth Verifikasi dengan Kode OTP</h5>
                            <p class="text-muted">
                                Kami akan mengirimkan kode verifikasi satu kali ke email Anda yang terdaftar di
                                {{ ucfirst($payload['provider']) }}.
                            </p>

                            {{-- Form untuk meminta OTP --}}
                            <div id="otp-request-form">
                                <button type="button" class="btn btn-info w-100" id="request-otp-btn">
                                    Kirim Kode OTP ke {{ $payload['email'] ?? 'email Anda' }}
                                </button>
                            </div>

                            {{-- Form untuk memasukkan OTP (awalnya disembunyikan) --}}
                            <div id="otp-verify-form" style="display: none;" class="mt-3">
                                <div class="mb-2">
                                    <label class="form-label">Masukkan Kode OTP</label>
                                    <div class="input-group">
                                        <input type="text" name="otp_code" id="otp-code" class="form-control"
                                            placeholder="Masukkan 6 digit kode" maxlength="6" required>
                                        <button type="button" class="btn btn-outline-secondary" id="resend-otp-btn">
                                            Kirim Ulang
                                        </button>
                                    </div>
                                    <small class="text-muted" id="otp-timer"></small>
                                </div>
                                <button type="button" class="btn btn-success w-100" id="verify-otp-btn">
                                    Verifikasi & Tautkan Akun
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}" class="btn btn-link">Kembali ke login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk menangani OTP --}}
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
