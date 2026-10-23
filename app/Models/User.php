<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'last_login_provider',
    ];

    protected $hidden = [
        'remember_token',
    ];

    /** Relasi ke SocialAccounts */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Ambil akun berdasarkan provider.
     * Memakai properti relasi (tanpa kurung) supaya eager loading terpakai
     * dan tidak terjadi N+1.
     */
    public function socialAccountByProvider(string $provider)
    {
        return $this->socialAccounts->firstWhere('provider', $provider);
    }

    /** Ambil akun utama */
    public function primarySocialAccount()
    {
        return $this->socialAccountByProvider((string) $this->last_login_provider)
            ?? $this->socialAccounts->first();
    }

    /** ==== Helper data profil dari social account ==== */

    public function userName()
    {
        return optional($this->primarySocialAccount())->name ?? 'User';
    }

    public function userEmail()
    {
        return optional($this->primarySocialAccount())->email ?? null;
    }

    public function userAvatar()
    {
        return optional($this->primarySocialAccount())->avatar_url
            ?? asset('images/default-avatar.png');
    }

    /**
     * Accessor opsional: $user->name langsung mengembalikan nama
     * dari social account. Aman dipakai di loop jika memakai
     * User::with('socialAccounts').
     */
    public function getNameAttribute()
    {
        return $this->userName();
    }
}