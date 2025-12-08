<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\Widget;

class DashboardMapWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-map-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $pollingInterval = 30; // refresh otomatis tiap 30 detik

    // Variabel yang dikirim ke view
    public $sites;
    public $totalSites;
    public $onlineSites;
    public $offlineSites;
    public $avgUptime;

    public function mount()
    {
        $this->loadData();
    }

    // Fungsi utama buat load data ke dashboard
    public function loadData()
    {
        // Ambil semua site dari database
        $this->sites = Site::select('id', 'name', 'status', 'latitude', 'longitude', 'ip_address', 'updated_at')->get();

        // Hitung total / online / offline
        $this->totalSites   = $this->sites->count();
        $this->onlineSites  = $this->sites->where('status', 1)->count();
        $this->offlineSites = $this->sites->where('status', 0)->count();

        // Hitung rata-rata uptime
        $this->avgUptime = $this->totalSites > 0
            ? round(($this->onlineSites / $this->totalSites) * 100, 1)
            : 0;
    }

    // Buat Livewire property agar tetap sinkron saat auto refresh
    public function getSitesProperty(): array
    {
        return $this->sites->map(function ($site) {
            return [
                'id'         => $site->id,
                'name'       => $site->name,
                'status'     => $site->status ? 'active' : 'inactive',
                'latitude'   => (float) $site->latitude,
                'longitude'  => (float) $site->longitude,
                'ip_address' => $site->ip_address ?? '-',
                'last_checked' => $site->updated_at ? $site->updated_at->diffForHumans() : '-',
            ];
        })->toArray();
    }
}
