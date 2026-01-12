<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'youtube_url',
        'is_public',
    ];
}
