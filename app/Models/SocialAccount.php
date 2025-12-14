<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'email',
        'name',
        'avatar_url',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
    ];

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pastikan avatar selalu valid URL.
     */
    public function getAvatarUrlAttribute($value)
    {
        if (!$value) {
            return asset('images/default-avatar.png');
        }

        // Jika avatar provider bentuk URL → return langsung
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Jika avatar lokal
        return asset($value);
    }
}
