<?php

namespace App\Services;

use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected $pendingMinutes = 30;

    /**
     * Get Socialite Redirect Driver with appropriate scopes and states
     */
    public function getRedirectDriver(string $provider, ?string $confirmToken = null)
    {
        $driver = Socialite::driver($provider);

        if ($provider !== 'x') {
            $driver->stateless();
        }

        if ($confirmToken) {
            $encryptedState = encrypt("confirm:{$confirmToken}");
            $driver->with(['state' => $encryptedState]);
        }

        if ($provider === 'github') {
            $driver->scopes(['user:email']);
        } elseif ($provider === 'discord') {
            $driver->scopes(['email', 'identify']);
        } elseif (in_array($provider, ['google', 'facebook'])) {
            $driver->scopes(['email']);
        }

        return $driver;
    }

    /**
     * Process normal OAuth callback
     */
    public function processOAuthUser(string $provider, $providerUser): array
    {
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
            $updateData = [
                'name' => $name,
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'token_expires_at' => $providerUser->expiresIn ? now()->addSeconds($providerUser->expiresIn) : null,
            ];

            if ($email) {
                $updateData['email'] = $email;
            }

            $social->update($updateData);

            if ($provider === 'google') {
                $downloadedAvatar = $this->downloadProviderAvatar($avatar, $social->user, $provider, $social);
                $social->update(['avatar_url' => $downloadedAvatar ?: $avatar]);
            } else {
                $social->update(['avatar_url' => $avatar]);
            }

            $social->user->update(['last_login_provider' => $provider]);

            return ['status' => 'login', 'user' => $social->user, 'name' => $name, 'provider' => $provider];
        }

        // 2. Cek apakah email null atau bukan Gmail
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
                'original_email' => $email,
            ], $this->pendingMinutes * 60);

            $message = !$email
                ? ucfirst($provider) . ' tidak menyediakan email Anda. Silakan masukkan email Gmail untuk melanjutkan.'
                : 'Anda harus menggunakan alamat email Gmail (@gmail.com) untuk melanjutkan. Silakan masukkan email Gmail Anda.';

            return ['status' => 'ask_email', 'token' => $token, 'message' => $message];
        }

        // 3. Cek apakah email sudah digunakan oleh akun lain
        $existingSocial = SocialAccount::where('email', $email)->first();
        $existingUser = Schema::hasColumn('users', 'email') ? User::where('email', $email)->first() : null;

        if ($existingSocial || $existingUser) {
            $token = Str::random(40);

            // [BARU] Unduh avatar Google untuk preview di halaman konfirmasi
            $avatarPreview = $provider === 'google'
                ? $this->downloadPendingAvatar($avatar, $token)
                : null;

            Cache::put("social_pending:{$token}", [
                'provider' => $provider,
                'provider_user_id' => $providerUserId,
                'email' => $email,
                'name' => $name,
                'avatar' => $avatar,                // URL asli (dipakai saat membuat SocialAccount)
                'avatar_preview' => $avatarPreview, // [BARU] path lokal, khusus tampilan
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'expires_in' => $providerUser->expiresIn,
            ], $this->pendingMinutes * 60);

            return ['status' => 'confirm', 'token' => $token, 'message' => 'Akun dengan email ini sudah ada. Silakan konfirmasi penautan.'];
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

        return ['status' => 'login', 'user' => $user, 'name' => $name, 'provider' => $provider];
    }

    /**
     * Confirm account linking
     */
    public function confirmOAuthUser(string $provider, $providerUser, string $token): array
    {
        $payload = Cache::get("social_pending:{$token}");
        $email = $payload['email'];

        $targetUser = SocialAccount::where('email', $email)->first()?->user
            ?? (Schema::hasColumn('users', 'email') ? User::where('email', $email)->first() : null);

        if (!$targetUser) {
            throw new \Exception('Akun lokal dengan email tersebut tidak ditemukan.');
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

        $this->deletePendingAvatar($token); // [BARU]
        Cache::forget("social_pending:{$token}");

        return [
            'user' => $targetUser,
            'name' => $providerUser->getName(),
            'provider' => $provider
        ];
    }

    /**
     * Send OTP for linking accounts
     */
    public function sendSocialConfirmOtp(string $token): array
    {
        $payload = Cache::get("social_pending:{$token}");
        if (empty($payload['email'])) return ['success' => false, 'message' => 'Email provider tidak tersedia.'];
        if (!$this->isGmailAddress($payload['email'])) return ['success' => false, 'message' => 'Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.'];

        $otp = random_int(100000, 999999);
        $expires = 300;

        Cache::put("otp_social:{$token}", [
            'otp' => $otp,
            'email' => $payload['email'],
            'expires_at' => now()->addSeconds($expires)->toDateTimeString(),
        ], $expires);

        Mail::to($payload['email'])->send(new \App\Mail\OtpSocialConfirm($otp));

        return ['success' => true, 'message' => 'Kode OTP telah dikirim.', 'expires_in' => $expires];
    }

    /**
     * Verify OTP and link account
     */
    public function verifySocialConfirmOtp(string $token, string $code, string $provider): array
    {
        $otpData = Cache::get("otp_social:{$token}");
        $payload = Cache::get("social_pending:{$token}");

        if ($otpData['otp'] != $code) return ['success' => false, 'message' => 'Kode OTP salah.'];
        if (!$this->isGmailAddress($payload['email'])) return ['success' => false, 'message' => 'Hanya alamat email Gmail diperbolehkan.'];

        $targetUser = SocialAccount::where('email', $payload['email'])->first()?->user
            ?? (Schema::hasColumn('users', 'email') ? User::where('email', $payload['email'])->first() : null);

        if (!$targetUser) return ['success' => false, 'message' => 'Akun tidak ditemukan.'];

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

        $this->deletePendingAvatar($token); // [BARU]
        Cache::forget("otp_social:{$token}");
        Cache::forget("social_pending:{$token}");

        return [
            'success' => true,
            'user' => $targetUser,
            'name' => $payload['name'],
            'provider' => $payload['provider']
        ];
    }

    /**
     * Request OTP for missing email
     */
    public function sendAskEmailOtp(string $token, string $email): void
    {
        $payload = Cache::get("social_missing_email:{$token}");
        $otp = random_int(100000, 999999);

        Cache::put("social_missing_email_otp:{$token}", [
            'otp' => $otp,
            'email' => $email,
            'payload' => $payload,
            'expires_at' => now()->addMinutes(5)
        ], 300);

        Mail::to($email)->send(new \App\Mail\OtpEmailMissing($otp));
    }

    /**
     * Verify Missing Email OTP & Create/Link Account
     */
    public function verifyAskEmailOtp(string $token, string $otp): array
    {
        $data = Cache::get("social_missing_email_otp:{$token}");

        if ($data['otp'] != $otp) throw new \Exception('Kode OTP salah.');
        if (!$this->isGmailAddress($data['email'])) throw new \Exception('Hanya alamat email Gmail (@gmail.com) yang diperbolehkan.');

        $payload = $data['payload'];
        $email = $data['email'];

        $existingUser = SocialAccount::where('email', $email)->first()?->user
            ?? (Schema::hasColumn('users', 'email') ? User::where('email', $email)->first() : null);

        if ($existingUser) {
            $existingProviderAccount = SocialAccount::where('user_id', $existingUser->id)
                ->where('provider', $payload['provider'])
                ->first();

            if ($existingProviderAccount) {
                throw new \Exception('Anda sudah terhubung dengan ' . ucfirst($payload['provider']) . ' menggunakan email ini.');
            }

            $social = $this->createSocialAccount($existingUser->id, $payload, $email);

            if ($payload['provider'] === 'google') {
                $downloadedAvatar = $this->downloadProviderAvatar($social->avatar_url, $existingUser, $payload['provider'], $social);
                $social->update(['avatar_url' => $downloadedAvatar ?: $social->avatar_url]);
            }

            $existingUser->update(['last_login_provider' => $payload['provider']]);

            Cache::forget("social_missing_email:{$token}");
            Cache::forget("social_missing_email_otp:{$token}");

            return ['status' => 'linked', 'user' => $existingUser, 'name' => $payload['name'], 'provider' => $payload['provider']];
        }

        $user = User::create([
            'email' => $email,
            'last_login_provider' => $payload['provider']
        ]);

        $social = $this->createSocialAccount($user->id, $payload, $email);

        // [BARU] Konsisten: avatar Google juga diunduh untuk user yang baru dibuat
        if ($payload['provider'] === 'google') {
            $downloadedAvatar = $this->downloadProviderAvatar($social->avatar_url, $user, $payload['provider'], $social);
            $social->update(['avatar_url' => $downloadedAvatar ?: $social->avatar_url]);
        }

        Cache::forget("social_missing_email:{$token}");
        Cache::forget("social_missing_email_otp:{$token}");

        return ['status' => 'created', 'user' => $user, 'name' => $payload['name'], 'provider' => $payload['provider']];
    }

    // --- PRIVATE HELPER METHODS ---

    private function createSocialAccount($userId, $payload, $email)
    {
        return SocialAccount::create([
            'user_id' => $userId,
            'provider' => $payload['provider'],
            'provider_user_id' => $payload['provider_user_id'],
            'email' => $email,
            'name' => $payload['name'],
            'avatar_url' => $payload['avatar'],
            'access_token' => $payload['access_token'],
            'refresh_token' => $payload['refresh_token'],
            'token_expires_at' => $payload['expires_in'] ? now()->addSeconds($payload['expires_in']) : null,
        ]);
    }

    public function isGmailAddress(?string $email): bool
    {
        if (!$email) return false;
        return str_ends_with(strtolower($email), '@gmail.com');
    }

    private function normalizeAvatar(string $provider, ?string $avatar): ?string
    {
        if (!$avatar) return null;

        if ($provider === 'google' && str_contains($avatar, 'googleusercontent.com')) {
            return preg_replace('/=s\d+-c/', '=s512-c', $avatar)
                ?? (str_contains($avatar, '?') ? $avatar . '&sz=512' : $avatar . '?sz=512');
        }

        if ($provider === 'github' && str_contains($avatar, 'githubusercontent.com')) {
            return str_contains($avatar, '?') ? $avatar . '&s=400' : $avatar . '?s=400';
        }

        if ($provider === 'x' && str_contains($avatar, 'pbs.twimg.com')) {
            return str_replace('_normal', '_400x400', $avatar);
        }

        if ($provider === 'discord' && str_contains($avatar, 'discordapp')) {
            return str_contains($avatar, '?') ? $avatar . '&size=512' : $avatar . '?size=512';
        }

        return $avatar;
    }

    private function getDiscordAvatar($providerUser): string
    {
        if ($providerUser->getAvatar()) return $providerUser->getAvatar();
        $raw = $providerUser->user;
        $discriminator = $raw['discriminator'] ?? '0';
        $index = intval($discriminator) % 5;
        return "https://cdn.discordapp.com/embed/avatars/{$index}.png";
    }

    /**
     * [BARU] Unduh avatar Google untuk preview di halaman konfirmasi (tahap pending).
     */
    private function downloadPendingAvatar(?string $url, string $token): ?string
    {
        if (!$url) return null;

        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) return null;

            $directory = 'avatars/pending';
            Storage::disk('public')->makeDirectory($directory);

            $path = "{$directory}/{$token}.jpg";
            Storage::disk('public')->put($path, $response->body());

            return "storage/{$path}";
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh avatar pending', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * [BARU] Hapus file avatar pending setelah konfirmasi selesai.
     */
    private function deletePendingAvatar(string $token): void
    {
        Storage::disk('public')->delete("avatars/pending/{$token}.jpg");
    }

    private function downloadProviderAvatar(?string $url, User $user, string $provider, ?SocialAccount $social = null): ?string
    {
        if (!$url) return null;

        try {
            $response = Http::get($url);
            if (!$response->successful()) {
                return $social?->avatar_url && !str_starts_with($social->avatar_url, 'http') ? $social->avatar_url : null;
            }

            $directory = "avatars/{$provider}";
            Storage::disk('public')->makeDirectory($directory);
            $filename = "{$directory}/{$user->id}.jpg";

            if ($social && $social->avatar_url && !str_starts_with($social->avatar_url, 'http')) {
                $oldPath = str_replace("storage/", "", $social->avatar_url);
                if (Storage::disk('public')->exists($oldPath)) Storage::disk('public')->delete($oldPath);
            }

            Storage::disk('public')->put($filename, $response->body());
            return "storage/" . $filename;
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh avatar', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }
}