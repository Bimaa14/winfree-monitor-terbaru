<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;

class DashboardMapWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-map-widget';

    protected static bool $isLazy = false;

    /**
     * Fungsi ini akan dijalankan saat tombol "Cek Status Live" diklik.
     */
    public function checkStatusNow()
    {
        // Jalankan perintah artisan untuk nge-ping
        Artisan::call('winfree:check-status');
        
        // Kirim "sinyal" ke frontend bahwa proses selesai dan data siap di-refresh
        $this->dispatch('statusChecked');
    }

    /**
     * Fungsi ini mengambil semua data yang dibutuhkan oleh tampilan.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $sites = Site::all();
        $totalSites = $sites->count();
        $activeSites = $sites->where('status', true)->count();

        return [
            'sites' => $sites,
            'totalSites' => $totalSites,
            'activeSites' => $activeSites,
            'inactiveSites' => $totalSites - $activeSites,
        ];
    }
}
