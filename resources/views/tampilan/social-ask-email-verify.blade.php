@extends('tampilan.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container py-5" style="max-width: 480px;">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3 text-center">Verifikasi Email</h4>
            <p class="text-muted text-center">
                Masukkan kode OTP yang telah kami kirim ke email Anda.
            </p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('social.askEmailOtp.submit') }}">
                @csrf

                <input type="hidden" name="token" value="{{ request('token') }}">

                <div class="mb-3">
                    <label class="form-label">Kode OTP</label>
                    <input 
                        type="text" 
                        name="otp" 
                        class="form-control @error('otp') is-invalid @enderror"
                        placeholder="6 digit kode"
                        required
                    >

                    @error('otp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-success w-100" type="submit">
                    Verifikasi
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
