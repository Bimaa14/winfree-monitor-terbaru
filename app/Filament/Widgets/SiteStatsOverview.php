<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ambil data dari database
        $totalSites = Site::count();
        $activeSites = Site::where('status', 'active')->count();
        $inactiveSites = Site::where('status', 'inactive')->count();

        return [
            // Kartu 1: Total Sites
            Stat::make('Total Sites', $totalSites)
                ->description('Semua site yang terdaftar')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),

            // Kartu 2: Sites Aktif
            Stat::make('Sites Aktif', $activeSites)
                ->description('Site yang sedang online')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            // Kartu 3: Sites Inaktif
            Stat::make('Sites Inaktif', $inactiveSites)
                ->description('Site yang sedang offline')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
