<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $pendingMinutes = 30;

    public function showLoginForm()
    {
        return view('tampilan.login');
    }

    private function normalizeAvatar(string $provider, ?string $avatar): ?string
    {
        if (!$avatar) {
            return null;
        }

        // Google → force 512px (biar ga blur sebelum download)
        if ($provider === 'google' && str_contains($avatar, 'googleusercontent.com')) {
            // Google pakai parameter sz
            return preg_replace('/=s\d+-c/', '=s512-c', $avatar)
                ?? (str_contains($avatar, '?')
                    ? $avatar . '&sz=512'
                    : $avatar . '?sz=512');
        }

        // GitHub → force 400px
        if ($provider === 'github' && str_contains($avatar, 'githubusercontent.com')) {
            return str_contains($avatar, '?')
                ? $avatar . '&s=400'
                : $avatar . '?s=400';
        }

        // X (Twitter) → force 400x400
        if ($provider === 'x' && str_contains($avatar, 'pbs.twimg.com')) {
            return str_replace('_normal', '_400x400', $avatar);
        }

        // Discord → force 512px
        if ($provider === 'discord' && str_contains($avatar, 'discordapp')) {
            return str_contains($avatar, '?')
                ? $avatar . '&size=512'
                : $avatar . '?size=512';
        }

        return $avatar;
    }

    private function getDiscordAvatar($providerUser): string
    {
        // Avatar custom → biarkan normalizeAvatar yang urus
        if ($providerUser->getAvatar()) {
            return $providerUser->getAvatar();
        }

        // Default Discord avatar
        $raw = $providerUser->user;
        $discriminator = $raw['discriminator'] ?? '0';
        $index = intval($discriminator) % 5;

        return "https://cdn.discordapp.com/embed/avatars/{$index}.png";
    }

    private function downloadProviderAvatar(?string $url, User $user, string $provider, ?SocialAccount $social = null): ?string
    {
        if (!$url) {
            return null;
        }

        try {
            $response = Http::get($url);
            if (!$response->successful()) {
                // Jika unduhan gagal, kembalikan avatar lama jika ada dan bukan URL eksternal
                return $social?->avatar_url && !str_starts_with($social->avatar_url, 'http') ? $social->avatar_url : null;
            }

            $directory = "avatars/{$provider}";
            Storage::disk('public')->makeDirectory($directory);
            $filename = "{$directory}/{$user->id}.jpg";

            // Hapus file lama jika ada untuk menghindari penumpukan file
            if ($social && $social->avatar_url && !str_starts_with($social->avatar_url, 'http')) {
                $oldPath = str_replace("storage/", "", $social->avatar_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            Storage::disk('public')->put($filename, $response->body());
            return "storage/" . $filename;
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh avatar', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Check if email is a Gmail address
     */
    private function isGmailAddress(?string $email): bool
    {
        if (!$email) {
            return false;
        }
        
        return str_ends_with(strtolower($email), '@gmail.com');
    }

    public function redirectToProvider($provider, Request $request)
    {
        try {
            $driver = Socialite::driver($provider);

            if ($provider !== 'x') {
                $driver->stateless();
            }

            // Log untuk debugging
            Log::info("Redirecting to {$provider}", [
                'provider' => $provider,
                'redirect_url' => config("services.{$provider}.redirect"),
            ]);

            // Jika ini adalah proses konfirmasi, sematkan token ke state
            if ($request->has('confirm_token')) {
                $token = $request->get('confirm_token');
                $encryptedState = encrypt("confirm:{$token}");
                $driver->with(['state' => $encryptedState]);
                Log::info("Using confirm state for {$provider}", ['state' => $encryptedState]);
            } else {
                // Pastikan state selalu dibuat untuk X
                // if ($provider === 'x') {
                //     $state = Str::random(40);
                //     $driver->with(['state' => $state]);
                //     Log::info("Generated state for X", ['state' => $state]);
                // }
            }

            // Tambahkan scope yang diperlukan untuk mendapatkan email
            if ($provider === 'github') {
                $driver->scopes(['user:email']);
            } elseif ($provider === 'discord') {
                // Discord membutuhkan 'identify' untuk info dasar (avatar, nama) dan 'email' untuk email
                $driver->scopes(['email', 'identify']);
            } elseif (in_array($provider, ['google', 'facebook'])) {
                // Google dan Facebook hanya butuh scope 'email'
                $driver->scopes(['email']);
            } elseif ($provider === 'x') {
                // X (Twitter) OAuth 2.0 memerlukan scope khusus untuk email
                // Scope sudah didefinisikan di XProvider, jadi tidak perlu ditambahkan di sini
                Log::info("Using X provider with scopes", ['scopes' => $driver->getScopes()]);
            }

            return $driver->redirect();
        } catch (\Exception $e) {
            Log::error("Error redirecting to {$provider}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->with('error', 'Terjadi kesalahan saat menghubungkan ke ' . ucfirst($provider));
        }
    }

    public function handleProviderCallback($provider, Request $request)
    {
        $isConfirmation = false;
        $confirmToken = null;

        // Periksa apakah ini adalah proses konfirmasi dengan mendekripsi 'state'
        if ($request->has('state')) {
            try {
                $decoded = decrypt($request->get('state'));
                if (str_starts_with($decoded, 'confirm:')) {
                    $isConfirmation = true;
                    $confirmToken = str_replace('confirm:', '', $decoded);
                    session(['social_pending_token' => $confirmToken]);
                }
            } catch (\Exception $e) {
                Log::warning('Gagal mendekripsi state OAuth', ['state' => $request->get('state')]);
            }
        }

        try {
            $driver = Socialite::driver($provider);

            if ($provider !== 'x') {
                $driver->stateless();
            }

            $providerUser = $driver->user();
        } catch (\Exception $e) {
            Log::error('OAuth Error', [
                'provider' => $provider,
                'message' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return redirect('/login')->with('error', ucfirst($provider) . ' login gagal (token exchange failed)');
        }

        // Jika ini adalah proses konfirmasi, lanjutkan ke fungsi konfirmasi
        if ($isConfirmation) {
            return $this->confirmProviderCallback($provider, $request, $providerUser);
        }

        // --- Alur Login Normal / Penautan Otomatis ---

        $providerUserId = $providerUser->getId();
        $email = $providerUser->getEmail();
        $name = $providerUser->getName() ?: $providerUser->getNickname() ?: "User-{$providerUserId}";
        $rawAvatar = $provider === 'discord'
            ? $this->getDiscordAvatar($providerUser)
            : $providerUser->getAvatar();

        $avatar = $this->normalizeAvatar($provider, $rawAvatar);

        // 1. Cek apakah social account sudah terdaftar
        $social = SocialAccount::where('provider', $provider)
            ->where('provider_user_id', $providerUserId)
            ->first();

        if ($social) {
            // Siapkan data untuk diperbarui
            $updateData = [
                'name' => $name,
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'token_expires_at' => $providerUser->expiresIn ? now()->addSeconds($providerUser->expiresIn) : null,
            ];

            // Hanya perbarui email jika provider memberikan email yang tidak null.
            // Ini mencegah menimpa email yang sudah diverifikasi dengan null.
            if ($email) {
                $updateData['email'] = $email;
            }

            // Lakukan pembaruan dengan data yang sudah disiapkan
            $social->update($updateData);

            // Update avatar jika perlu
            if ($provider === 'google') {
                $downloadedAvatar = $this->downloadProviderAvatar($avatar, $social->user, $provider, $social);
                $social->update(['avatar_url' => $downloadedAvatar ?: $avatar]);
            } else {
                // Untuk provider lain (Facebook, GitHub, X, Discord), gunakan URL langsung
                $social->update(['avatar_url' => $avatar]);
            }

            $social->user->update(['last_login_provider' => $provider]);
            Auth::login($social->user);
            return redirect()->route('dashboard');
        }

        // 2. PERIKSA APAKAH EMAIL NULL ATAU BUKAN GMAIL
        if (!$email || !$this->isGmailAddress($email)) {
            $token = Str::random(40);
            Cache::put("social_missing_email:{$token}", [
                'provider' => $provider,
                'provider_user_id' => $providerUserId,
                'name' => $name,
                'avatar' => $avatar,
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'expires_in' => $providerUser->expiresIn,
                'original_email' => $email, // Simpan email asli untuk referensi
            ], $this->pendingMinutes * 60);

            $message = !$email 
                ? ucfirst($provider) . ' tidak menyediakan email Anda. Silakan masukkan email Gmail untuk melanjutkan.'
                : 'Anda harus menggunakan alamat email Gmail (@gmail.com) untuk melanjutkan. Silakan masukkan email Gmail Anda.';
                
            return redirect()->route('social.askEmail', ['token' => $token])
                ->with('info', $message);
        }

        // 3. Cek apakah email sudah digunakan oleh akun lain
        $existingSocial = SocialAccount::where('email', $email)->first();
        $existingUser = Schema::hasColumn('users', 'email') ? User::where('email', $email)->first() : null;

        if ($existingSocial || $existingUser) {
            $token = Str::random(40);
            Cache::put("social_pending:{$token}", [
                'provider' => $provider,
                'provider_user_id' => $providerUserId,
                'email' => $email,
                'name' => $name,
                'avatar' => $avatar,
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'expires_in' => $providerUser->expiresIn,
            ], $this->pendingMinutes * 60);

            return redirect()->route('social.confirm', ['token' => $token])
                ->with('info', 'Akun dengan email ini sudah ada. Silakan konfirmasi penautan.');
        }

        // 4. Buat user dan social account baru
        $user = User::create(['last_login_provider' => $provider]);

        $social = SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_user_id' => $providerUserId,
            'email' => $email,
            'name' => $name,
            'avatar_url' => $avatar,
            'access_token' => $providerUser->token,
            'refresh_token' => $providerUser->refreshToken,
            'token_expires_at' => $providerUser->expiresIn ? now()->addSeconds($providerUser->expiresIn) : null,
        ]);

        if ($provider === 'google') {
            $downloadedAvatar = $this->downloadProviderAvatar($avatar, $user, $provider, $social);
            $social->update(['avatar_url' => $downloadedAvatar ?: $avatar]);
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function showConfirmLink(Request $request)
    {
        $token = $request->query('token') ?? session('social_pending_token');

        if (!$token || !Cache::has("social_pending:{$token}")) {
            return redirect('/login')->with('error', 'Token konfirmasi tidak ditemukan atau kadaluarsa.');
        }

        return view('tampilan.social-confirm', [
            'token' => $token,
            'payload' => Cache::get("social_pending:{$token}"),
        ]);
    }

    public function confirmProviderRedirect($provider, Request $request)
    {
        $token = $request->query('token');

        if (!$token || !Cache::has("social_pending:{$token}")) {
            return redirect('/login')->with('error', 'Token tidak valid atau kedaluwarsa.');
        }

        $driver = Socialite::driver($provider)
            ->with(['state' => encrypt("confirm:{$token}")]);

        if ($provider !== 'x') {
            $driver->stateless();
        }

        // Tambahkan scope yang diperlukan
        if ($provider === 'github') {
            $driver->scopes(['user:email']);
        } elseif ($provider === 'discord') {
            $driver->scopes(['email', 'identify']);
        } elseif (in_array($provider, ['google', 'facebook'])) {
            $driver->scopes(['email']);
        } elseif ($provider === 'x') {
            // Scope sudah didefinisikan di XProvider
        }

        return $driver->redirect();
    }

    public function confirmProviderCallback($provider, Request $request, $providerUser)
    {
        $token = session('social_pending_token');
        if (!$token || !Cache::has("social_pending:{$token}")) {
            return redirect('/login')->with('error', 'Sesi konfirmasi kadaluarsa.');
        }

        $payload = Cache::get("social_pending:{$token}");

        if ($providerUser->getId() != $payload['provider_user_id']) {
            return redirect('/login')->with('error', 'Identitas provider tidak cocok.');
        }

        $email = $payload['email'];
        if (!$email) {
            return redirect('/login')->with('error', 'Email tidak tersedia untuk dikonfirmasi.');
        }

        // Pastikan email adalah Gmail
        if (!$this->isGmailAddress($email)) {
            return redirect('/login')->with('error', 'Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.');
        }

        $targetUser = null;
        $existingSocial = SocialAccount::where('email', $email)->first();
        if ($existingSocial) {
            $targetUser = $existingSocial->user;
        } else {
            if (Schema::hasColumn('users', 'email')) {
                $targetUser = User::where('email', $email)->first();
            }
        }

        if (!$targetUser) {
            return redirect('/login')->with('error', 'Akun lokal dengan email tersebut tidak ditemukan.');
        }

        $newSocial = SocialAccount::create([
            'user_id' => $targetUser->id,
            'provider' => $provider,
            'provider_user_id' => $providerUser->getId(),
            'email' => $providerUser->getEmail(),
            'name' => $providerUser->getName(),
            'avatar_url' => $this->normalizeAvatar($provider, $providerUser->getAvatar()),
            'access_token' => $providerUser->token,
            'refresh_token' => $providerUser->refreshToken,
            'token_expires_at' => $providerUser->expiresIn ? now()->addSeconds($providerUser->expiresIn) : null,
        ]);

        if ($provider === 'google') {
            $downloadedAvatar = $this->downloadProviderAvatar($newSocial->avatar_url, $targetUser, $provider, $newSocial);
            $newSocial->update(['avatar_url' => $downloadedAvatar ?: $newSocial->avatar_url]);
        }

        $targetUser->update(['last_login_provider' => $provider]);
        Auth::login($targetUser);

        Cache::forget("social_pending:{$token}");
        session()->forget('social_pending_token');

        return redirect()->route('dashboard')->with('success', 'Penautan akun ' . ucfirst($provider) . ' berhasil.');
    }

    public function requestOtp($provider, Request $request)
    {
        $token = $request->input('token');

        if (!$token || !Cache::has("social_pending:{$token}")) {
            return response()->json(['success' => false, 'message' => 'Token tidak valid.'], 400);
        }

        $payload = Cache::get("social_pending:{$token}");
        if (empty($payload['email'])) {
            return response()->json(['success' => false, 'message' => 'Email provider tidak tersedia.'], 400);
        }

        // Pastikan email adalah Gmail
        if (!$this->isGmailAddress($payload['email'])) {
            return response()->json(['success' => false, 'message' => 'Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.'], 400);
        }

        $otp = random_int(100000, 999999);
        $expires = 300; // 5 menit

        Cache::put("otp_social:{$token}", [
            'otp' => $otp,
            'email' => $payload['email'],
            'expires_at' => now()->addSeconds($expires)->toDateTimeString(),
        ], $expires);

        try {
            Mail::to($payload['email'])->send(new \App\Mail\OtpSocialConfirm($otp));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim OTP', ['email' => $payload['email'], 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email OTP.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP telah dikirim.',
            'expires_in' => $expires
        ]);
    }

    public function verifyOtp($provider, Request $request)
    {
        $token = $request->input('token');
        $code = $request->input('otp_code');

        if (!$token || !$code) {
            return response()->json(['success' => false, 'message' => 'OTP atau token tidak valid.'], 400);
        }

        if (!Cache::has("social_pending:{$token}") || !Cache::has("otp_social:{$token}")) {
            return response()->json(['success' => false, 'message' => 'Token atau OTP kadaluarsa.'], 400);
        }

        $otpData = Cache::get("otp_social:{$token}");
        $payload = Cache::get("social_pending:{$token}");

        if ($otpData['otp'] != $code) {
            return response()->json(['success' => false, 'message' => 'Kode OTP salah.'], 400);
        }

        $email = $payload['email'];
        
        // Pastikan email adalah Gmail
        if (!$this->isGmailAddress($email)) {
            return response()->json(['success' => false, 'message' => 'Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.'], 400);
        }

        $targetUser = null;
        $existingSocial = SocialAccount::where('email', $email)->first();
        if ($existingSocial) {
            $targetUser = $existingSocial->user;
        } else {
            if (Schema::hasColumn('users', 'email')) {
                $targetUser = User::where('email', $email)->first();
            }
        }

        if (!$targetUser) {
            return response()->json(['success' => false, 'message' => 'Akun tidak ditemukan.'], 404);
        }

        $social = SocialAccount::create([
            'user_id' => $targetUser->id,
            'provider' => $payload['provider'],
            'provider_user_id' => $payload['provider_user_id'],
            'email' => $payload['email'],
            'name' => $payload['name'],
            'avatar_url' => $payload['avatar'],
            'access_token' => $payload['access_token'] ?? null,
            'refresh_token' => $payload['refresh_token'] ?? null,
            'token_expires_at' => $payload['expires_in'] ? now()->addSeconds($payload['expires_in']) : null,
        ]);

        if ($provider === 'google') {
            $downloadedAvatar = $this->downloadProviderAvatar($social->avatar_url, $targetUser, $provider, $social);
            $social->update(['avatar_url' => $downloadedAvatar ?: $social->avatar_url]);
        }

        $targetUser->update(['last_login_provider' => $provider]);
        Auth::login($targetUser);

        Cache::forget("otp_social:{$token}");
        Cache::forget("social_pending:{$token}");
        session()->forget('social_pending_token');

        return response()->json([
            'success' => true,
            'redirect_url' => route('dashboard')
        ]);
    }

    public function showAskEmail(Request $request)
    {
        $token = $request->query('token');

        if (!$token || !Cache::has("social_missing_email:{$token}")) {
            return redirect('/login')->with('error', 'Token tidak ditemukan atau sudah kadaluarsa.');
        }

        $payload = Cache::get("social_missing_email:{$token}");
        $originalEmail = $payload['original_email'] ?? null;

        return view('tampilan.social-ask-email', [
            'token' => $token,
            'original_email' => $originalEmail,
            'provider' => $payload['provider']
        ]);
    }

    public function submitAskEmail(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email'
        ]);

        $token = $request->token;
        $email = $request->email;

        if (!Cache::has("social_missing_email:{$token}")) {
            return redirect('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
        }

        // Validasi bahwa email harus Gmail
        if (!$this->isGmailAddress($email)) {
            return redirect()->back()->with('error', 'Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.');
        }

        $payload = Cache::get("social_missing_email:{$token}");

        $otp = random_int(100000, 999999);

        Cache::put("social_missing_email_otp:{$token}", [
            'otp' => $otp,
            'email' => $email,
            'payload' => $payload,
            'expires_at' => now()->addMinutes(5)
        ], 300);

        try {
            Mail::to($email)->send(new \App\Mail\OtpEmailMissing($otp));
        } catch (\Exception $e) {
            Log::error("Gagal mengirim OTP missing email", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengirim email OTP.');
        }

        return redirect()->route('social.askEmailVerify', ['token' => $token]);
    }

    public function verifyAskEmailOtp(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'otp' => 'required'
        ]);

        $token = $request->token;

        if (!Cache::has("social_missing_email_otp:{$token}")) {
            return redirect('/login')->with('error', 'OTP sudah kadaluarsa.');
        }

        $data = Cache::get("social_missing_email_otp:{$token}");

        if ($data['otp'] != $request->otp) {
            return redirect()->back()->with('error', 'Kode OTP salah.');
        }

        $payload = $data['payload'];
        $email = $data['email'];

        // Pastikan email adalah Gmail
        if (!$this->isGmailAddress($email)) {
            return redirect('/login')->with('error', 'Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.');
        }

        $existingSocial = SocialAccount::where('email', $email)->first();
        $existingUser = null;

        if ($existingSocial) {
            $existingUser = $existingSocial->user;
        } else {
            if (Schema::hasColumn('users', 'email')) {
                $existingUser = User::where('email', $email)->first();
            }
        }

        if ($existingUser) {
            $existingProviderAccount = SocialAccount::where('user_id', $existingUser->id)
                ->where('provider', $payload['provider'])
                ->first();

            if ($existingProviderAccount) {
                return redirect('/login')->with('error', 'Anda sudah terhubung dengan ' . ucfirst($payload['provider']) . ' menggunakan email ini.');
            }

            $social = SocialAccount::create([
                'user_id' => $existingUser->id,
                'provider' => $payload['provider'],
                'provider_user_id' => $payload['provider_user_id'],
                'email' => $email,
                'name' => $payload['name'],
                'avatar_url' => $payload['avatar'],
                'access_token' => $payload['access_token'],
                'refresh_token' => $payload['refresh_token'],
                'token_expires_at' => $payload['expires_in'] ? now()->addSeconds($payload['expires_in']) : null,
            ]);

            if ($payload['provider'] === 'google') {
                $downloadedAvatar = $this->downloadProviderAvatar($social->avatar_url, $existingUser, $payload['provider'], $social);
                $social->update(['avatar_url' => $downloadedAvatar ?: $social->avatar_url]);
            }

            $existingUser->update(['last_login_provider' => $payload['provider']]);
            Auth::login($existingUser);

            Cache::forget("social_missing_email:{$token}");
            Cache::forget("social_missing_email_otp:{$token}");

            return redirect()->route('dashboard')->with('success', 'Akun ' . ucfirst($payload['provider']) . ' berhasil ditautkan ke akun Anda yang ada.');
        }

        $user = User::create([
            'email' => $email,
            'last_login_provider' => $payload['provider']
        ]);

        $social = SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $payload['provider'],
            'provider_user_id' => $payload['provider_user_id'],
            'email' => $email,
            'name' => $payload['name'],
            'avatar_url' => $payload['avatar'],
            'access_token' => $payload['access_token'],
            'refresh_token' => $payload['refresh_token'],
            'token_expires_at' => $payload['expires_in'] ? now()->addSeconds($payload['expires_in']) : null,
        ]);

        Auth::login($user);

        Cache::forget("social_missing_email:{$token}");
        Cache::forget("social_missing_email_otp:{$token}");

        return redirect()->route('dashboard');
    }

    public function showAskEmailVerify(Request $request)
    {
        $token = $request->query('token');

        if (!$token || !Cache::has("social_missing_email_otp:{$token}")) {
            return redirect('/login')->with('error', 'Token tidak ditemukan atau sudah kadaluarsa.');
        }

        return view('tampilan.social-ask-email-verify', [
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}