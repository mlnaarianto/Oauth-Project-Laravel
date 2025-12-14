@extends('tampilan.app')

@section('title', 'Masukkan Email Anda')

@section('content')
<div class="container py-5" style="max-width: 480px;">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3 text-center">Masukkan Email</h4>
            <p class="text-muted text-center">
                Kami tidak menerima email dari penyedia login sosial Anda.  
                Masukkan email Anda untuk melanjutkan.
            </p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('social.askEmail.submit') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="contoh: email@gmail.com"
                        required
                    >

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    Kirim OTP
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
