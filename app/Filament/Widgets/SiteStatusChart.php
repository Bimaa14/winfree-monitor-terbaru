<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\ChartWidget;

class SiteStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Semua Site';

    protected static ?string $description = 'Persentase site yang sedang online dan offline.';

    protected static ?int $sort = 2; // Urutan widget, setelah stats overview

    protected function getData(): array
    {
        $activeSites = Site::where('status', true)->count();
        $inactiveSites = Site::where('status', false)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Sites',
                    'data' => [$activeSites, $inactiveSites],
                    'backgroundColor' => [
                        '#22c55e', // Hijau untuk Aktif
                        '#ef4444', // Merah untuk Inaktif
                    ],
                ],
            ],
            'labels' => ['Site Aktif', 'Site Inaktif'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
