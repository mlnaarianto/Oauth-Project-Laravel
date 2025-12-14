<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::view('/', 'tampilan.home');
Route::view('/about', 'tampilan.about');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    // GENERIC OAUTH REDIRECT
    Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider'])
        ->name('oauth.redirect')
        // TAMBAHKAN 'discord' DI DAFTAR PROVIDER
        ->where('provider', 'google|facebook|github|x|discord');

    // GENERIC OAUTH CALLBACK
    Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
        ->name('oauth.callback')
        // TAMBAHKAN 'discord' DI DAFTAR PROVIDER
        ->where('provider', 'google|facebook|github|x|discord');

    /*
    |--------------------------------------------------------------------------
    | FLOW KHUSUS "EMAIL NULL" — EMAIL MANUAL + OTP
    |--------------------------------------------------------------------------
    */

    // Form input email
    Route::get('/auth/social/ask-email', [AuthController::class, 'showAskEmail'])
        ->name('social.askEmail');

    // Submit email → kirim OTP
    Route::post('/auth/social/ask-email', [AuthController::class, 'submitAskEmail'])
        ->name('social.askEmail.submit');

    // Form OTP
    Route::get('/auth/social/ask-email/verify', [AuthController::class, 'showAskEmailVerify'])
        ->name('social.askEmailVerify');

    // Submit OTP → create account
    Route::post('/auth/social/ask-email/verify', [AuthController::class, 'verifyAskEmailOtp'])
        ->name('social.askEmailOtp.submit');
});

Route::get('auth/social/confirm', [AuthController::class, 'showConfirmLink'])
    ->name('social.confirm');

// OLD (password-based) — akan diganti
Route::post('auth/social/confirm', [AuthController::class, 'confirmLink'])
    ->name('social.confirm.post');

/*
|--------------------------------------------------------------------------
| NEW — CONFIRM VIA PROVIDER (OAuth reauthentication)
|--------------------------------------------------------------------------
*/

Route::get('/auth/confirm/{provider}', [AuthController::class, 'confirmProviderRedirect'])
    ->name('social.confirm.provider')
    // TAMBAHKAN 'discord' DI DAFTAR PROVIDER
    ->where('provider', 'google|facebook|github|x|discord');

Route::get('/auth/confirm/{provider}/callback', [AuthController::class, 'confirmProviderCallback'])
    ->name('social.confirm.provider.callback')
    // TAMBAHKAN 'discord' DI DAFTAR PROVIDER
    ->where('provider', 'google|facebook|github|x|discord');

Route::post('/auth/{provider}/request-otp', [AuthController::class, 'requestOtp']);
Route::post('/auth/{provider}/verify-otp', [AuthController::class, 'verifyOtp']);

/*
|--------------------------------------------------------------------------
| AUTH REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profil');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});