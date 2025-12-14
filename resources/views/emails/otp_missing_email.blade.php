@component('mail::message')
# Verifikasi Email

Kami menerima permintaan untuk memverifikasi email Anda.

Berikut kode OTP Anda:

# **{{ $otp }}**

Kode ini berlaku selama 5 menit.

Jika Anda tidak meminta ini, abaikan email ini.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
