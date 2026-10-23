<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan ringkasan akun per provider.
     */
    public function index()
    {
        // Ambil jumlah akun per provider dalam satu query
        $providerStats = SocialAccount::selectRaw('provider, COUNT(*) as count')
            ->groupBy('provider')
            ->get()
            ->keyBy('provider');

        // Daftar provider yang didukung — urutan tetap dijaga
        $providers = ['google', 'facebook', 'github', 'x', 'discord'];

        $providerCounts = [];
        foreach ($providers as $provider) {
            $providerCounts[$provider] = $providerStats->has($provider)
                ? (int) $providerStats[$provider]->count
                : 0;
        }

        // Total hanya menghitung provider yang tampil di UI
        $totalAccounts = array_sum($providerCounts);

        return view('menu.dashboard', compact('providerCounts', 'totalAccounts'));
    }
}