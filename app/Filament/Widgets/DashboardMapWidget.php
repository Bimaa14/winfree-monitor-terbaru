<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\Widget;

class DashboardMapWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-map-widget';

    protected int | string | array $columnSpan = 'full';

    /**
     * Disediakan sebagai "Computed Property" (getSitesProperty).
     * Ini membuat data tersedia sebagai `$this->sites` di seluruh siklus hidup komponen,
     * yang menyelesaikan error "Property not found" saat Livewire melakukan update.
     */
    public function getSitesProperty(): array
    {
        // Ambil semua data site dan pastikan latitude/longitude adalah float
        return Site::all()->map(function ($site) {
            return [
                'id' => $site->id,
                'name' => $site->name,
                // Pastikan status dikirim sebagai 'active' atau 'inactive'
                'status' => $site->status ? 'active' : 'inactive',
                'latitude' => (float) $site->latitude,
                'longitude' => (float) $site->longitude,
            ];
        })->toArray();
    }
}

