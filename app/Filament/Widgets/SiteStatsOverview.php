<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Site::count();
        $online = Site::where('status', 1)->count();
        $offline = Site::where('status', 0)->count();
        $uptime = $total > 0 ? round(($online / $total) * 100, 1) : 0;

        return [
            Stat::make('Total Devices', $total)
                ->description('Semua site terdaftar')
                ->icon('heroicon-o-server'),

            Stat::make('Online', $online)
                ->description('Site aktif')
                ->icon('heroicon-o-signal')
                ->color('success'),

            Stat::make('Offline', $offline)
                ->description('Site tidak aktif')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Avg Uptime', "{$uptime}%")
                ->description('Rata-rata ketersediaan jaringan')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}
    