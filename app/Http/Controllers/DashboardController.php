<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan statistik provider
     */
    public function index()
    {
        // Menghitung jumlah akun per provider
        $providerStats = SocialAccount::selectRaw('provider, COUNT(*) as count')
            ->groupBy('provider')
            ->orderBy('count', 'asc')
            ->get()
            ->keyBy('provider');
        
        // Menyiapkan data untuk grafik
        $providers = ['google', 'facebook', 'github', 'x', 'discord'];
        $providerCounts = [];
        $providerColors = [
            'google' => '#4285F4',
            'facebook' => '#1877F2',
            'github' => '#333333',
            'x' => '#1DA1F2',
            'discord' => '#7289DA'
        ];
        
        foreach ($providers as $provider) {
            $providerCounts[$provider] = $providerStats->has($provider) 
                ? $providerStats[$provider]->count 
                : 0;
        }
        
        // Total semua akun
        $totalAccounts = SocialAccount::count();
        
        // Data untuk grafik
        $chartData = [
            'labels' => array_map('ucfirst', $providers),
            'data' => array_values($providerCounts),
            'backgroundColor' => array_values(array_intersect_key($providerColors, array_flip($providers)))
        ];
        
        return view('menu.dashboard', compact('chartData', 'totalAccounts', 'providerCounts'));
    }
}