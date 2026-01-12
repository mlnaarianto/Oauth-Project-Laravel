@extends('tampilan.app')

@section('title', 'Masukkan Email Gmail Pribadi')

@section('content')
<div class="container py-5" style="max-width: 480px;">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3 text-center">Masukkan Email Gmail Pribadi</h4>

            {{-- Pesan penjelasan --}}
            @if (isset($original_email) && $original_email)
                <div class="alert alert-info">
                    Email yang Anda gunakan di {{ ucfirst($provider) }} adalah
                    <strong>{{ $original_email }}</strong>.
                    <br>
                    Sistem hanya mendukung <strong>Gmail pribadi (@gmail.com)</strong>.
                    Akun Google dari kantor, kampus, atau organisasi (Google Workspace)
                    tidak dapat digunakan.
                </div>
            @else
                <div class="alert alert-info">
                    Akun {{ ucfirst($provider) }} Anda tidak menyediakan email Gmail pribadi.
                    <br>
                    Silakan masukkan <strong>alamat Gmail pribadi (@gmail.com)</strong>
                    untuk melanjutkan proses login.
                </div>
            @endif

            {{-- Error dari backend --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('social.askEmail.submit') }}" id="emailForm" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email Gmail Pribadi</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="nama@gmail.com"
                        required
                        autocomplete="email"
                    >

                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="form-text">
                        Gunakan alamat email Gmail pribadi dengan akhiran <strong>@gmail.com</strong>
                    </div>
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    Kirim Kode Verifikasi (OTP)
                </button>
            </form>

            <div class="text-muted small text-center mt-3">
                Catatan: Akun Google dari kantor, kampus, atau organisasi
                (Google Workspace) belum didukung.
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

        if (!email.endsWith('@gmail.com')) {
            e.preventDefault();

            emailInput.classList.add('is-invalid');

            if (!existingError) {
                const error = document.createElement('div');
                error.id = 'gmail-error';
                error.className = 'invalid-feedback d-block';
                error.textContent = 'Gunakan alamat Gmail pribadi dengan akhiran @gmail.com.';
                emailInput.parentNode.appendChild(error);
            }
        } else {
            emailInput.classList.remove('is-invalid');
            if (existingError) {
                existingError.remove();
            }
        }
    });
});
</script>
@endpush
@endsection
