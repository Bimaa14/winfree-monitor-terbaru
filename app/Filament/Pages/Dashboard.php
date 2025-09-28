<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardMapWidget;
use App\Filament\Widgets\SiteStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        // Widget yang akan tampil di bagian ATAS (header)
        return [
            SiteStatsOverview::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        // Widget yang akan tampil di bagian BAWAH (footer/main content)
        return [
            DashboardMapWidget::class,
        ];
    }
}
