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

    /** Ambil akun berdasarkan provider */
    public function socialAccountByProvider(string $provider)
    {
        return $this->socialAccounts()->where('provider', $provider)->first();
    }

    /** Ambil akun utama */
    public function primarySocialAccount()
    {
        return $this->socialAccountByProvider($this->last_login_provider)
            ?? $this->socialAccounts()->first();
    }

    /** ==== FIXED: jangan pakai name(), email(), avatar() ==== */

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
}
