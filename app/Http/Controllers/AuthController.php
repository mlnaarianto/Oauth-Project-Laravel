<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    // Injeksi AuthService melalui constructor
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('tampilan.login');
    }

    public function redirectToProvider($provider, Request $request)
    {
        try {
            $driver = $this->authService->getRedirectDriver($provider, $request->get('confirm_token'));
            return $driver->redirect();
        } catch (\Exception $e) {
            Log::error("Error redirecting to {$provider}", ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'Terjadi kesalahan saat menghubungkan ke ' . ucfirst($provider));
        }
    }

    public function handleProviderCallback($provider, Request $request)
    {
        $isConfirmation = false;
        $confirmToken = null;

        if ($request->has('state')) {
            try {
                $decoded = decrypt($request->get('state'));
                if (str_starts_with($decoded, 'confirm:')) {
                    $isConfirmation = true;
                    $confirmToken = str_replace('confirm:', '', $decoded);
                    session(['social_pending_token' => $confirmToken]);
                }
            } catch (\Throwable $e) {}
        }

        try {
            $driver = Socialite::driver($provider);
            if ($provider !== 'x') $driver->stateless();
            $providerUser = $driver->user();
        } catch (\Exception $e) {
            Log::error('OAuth Error', ['message' => $e->getMessage()]);
            return redirect('/login')->with('error', ucfirst($provider) . ' login gagal.');
        }

        if ($isConfirmation) {
            return $this->confirmProviderCallback($provider, $providerUser, $confirmToken);
        }

        $result = $this->authService->processOAuthUser($provider, $providerUser);

        if ($result['status'] === 'login') {
            Auth::login($result['user']);
            return redirect()->route('dashboard')
                ->with('login_name', $result['name'])
                ->with('login_provider', $result['provider']);
        }

        if ($result['status'] === 'ask_email') {
            return redirect()->route('social.askEmail', ['token' => $result['token']])
                ->with('info', $result['message']);
        }

        if ($result['status'] === 'confirm') {
            return redirect()->route('social.confirm', ['token' => $result['token']])
                ->with('info', $result['message']);
        }
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

        return $this->authService->getRedirectDriver($provider, $token)->redirect();
    }

    private function confirmProviderCallback($provider, $providerUser, $token)
    {
        if (!Cache::has("social_pending:{$token}")) {
            return redirect('/login')->with('error', 'Sesi konfirmasi kadaluarsa.');
        }

        $payload = Cache::get("social_pending:{$token}");
        if ($providerUser->getId() != $payload['provider_user_id']) {
            return redirect('/login')->with('error', 'Identitas provider tidak cocok.');
        }

        try {
            $result = $this->authService->confirmOAuthUser($provider, $providerUser, $token);
            Auth::login($result['user']);
            session()->forget('social_pending_token');

            return redirect()->route('dashboard')
                ->with('success', 'Penautan akun berhasil.')
                ->with('login_name', $result['name'])
                ->with('login_provider', $result['provider']);
        } catch (\Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }

    public function requestOtp($provider, Request $request)
    {
        $token = $request->input('token');
        if (!$token || !Cache::has("social_pending:{$token}")) {
            return response()->json(['success' => false, 'message' => 'Token tidak valid.'], 400);
        }

        try {
            $result = $this->authService->sendSocialConfirmOtp($token);
            $status = $result['success'] ? 200 : 400;
            return response()->json($result, $status);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email OTP.'], 500);
        }
    }

    public function verifyOtp($provider, Request $request)
    {
        $token = $request->input('token');
        $code = $request->input('otp_code');

        if (!$token || !$code || !Cache::has("social_pending:{$token}") || !Cache::has("otp_social:{$token}")) {
            return response()->json(['success' => false, 'message' => 'OTP atau token tidak valid/kadaluarsa.'], 400);
        }

        try {
            $result = $this->authService->verifySocialConfirmOtp($token, $code, $provider);
            
            if (!$result['success']) {
                return response()->json($result, 400);
            }

            Auth::login($result['user']);
            session()->forget('social_pending_token');

            return response()->json([
                'success' => true,
                'redirect_url' => route('dashboard'),
                'login_name' => $result['name'],
                'login_provider' => $result['provider']
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function showAskEmail(Request $request)
    {
        $token = $request->query('token');

        if (!$token || !Cache::has("social_missing_email:{$token}")) {
            return redirect('/login')->with('error', 'Token tidak ditemukan atau kadaluarsa.');
        }

        $payload = Cache::get("social_missing_email:{$token}");
        return view('tampilan.social-ask-email', [
            'token' => $token,
            'original_email' => $payload['original_email'] ?? null,
            'provider' => $payload['provider']
        ]);
    }

    public function submitAskEmail(Request $request)
    {
        $request->validate(['token' => 'required', 'email' => 'required|email']);
        $token = $request->token;
        $email = $request->email;

        if (!Cache::has("social_missing_email:{$token}")) {
            return redirect('/login')->with('error', 'Token kadaluarsa.');
        }

        if (!$this->authService->isGmailAddress($email)) {
            return redirect()->back()->with('error', 'Hanya email Gmail (@gmail.com) yang diperbolehkan.');
        }

        try {
            $this->authService->sendAskEmailOtp($token, $email);
            return redirect()->route('social.askEmailVerify', ['token' => $token]);
        } catch (\Exception $e) {
            Log::error("Gagal mengirim OTP missing email", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengirim email OTP.');
        }
    }

    public function showAskEmailVerify(Request $request)
    {
        $token = $request->query('token');
        if (!$token || !Cache::has("social_missing_email_otp:{$token}")) {
            return redirect('/login')->with('error', 'Token tidak ditemukan atau kadaluarsa.');
        }

        return view('tampilan.social-ask-email-verify', ['token' => $token]);
    }

    public function verifyAskEmailOtp(Request $request)
    {
        $request->validate(['token' => 'required', 'otp' => 'required']);

        if (!Cache::has("social_missing_email_otp:{$request->token}")) {
            return redirect('/login')->with('error', 'OTP kadaluarsa.');
        }

        try {
            $result = $this->authService->verifyAskEmailOtp($request->token, $request->otp);
            Auth::login($result['user']);

            $message = $result['status'] === 'linked' 
                ? 'Akun berhasil ditautkan ke akun Anda yang ada.' 
                : 'Pendaftaran berhasil.';

            return redirect()->route('dashboard')
                ->with('success', $message)
                ->with('login_name', $result['name'])
                ->with('login_provider', $result['provider']);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}