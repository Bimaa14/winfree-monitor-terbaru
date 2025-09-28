<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\Widget;

class DashboardMapWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-map-widget';

    protected int | string | array $columnSpan = 'full';

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
