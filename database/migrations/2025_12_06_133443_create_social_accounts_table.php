<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('provider');               // google, facebook, github
            $table->string('provider_user_id');       // ID unik dari provider

            // Profil user dari provider
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('avatar_url')->nullable();

            // Token
            $table->longText('access_token')->nullable();
            $table->longText('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();

            $table->timestamps();

            $table->unique(['provider', 'provider_user_id']);  // mencegah akun ganda
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
