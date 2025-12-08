<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestSiteUpdates;
use App\Filament\Widgets\SiteStatsOverview;
use App\Models\Site;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Method paling penting untuk menampilkan tombol.
    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Status')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action('refreshSiteStatuses'),
        ];
    }

    // Method untuk mengatur widget apa saja yang tampil.
    public function getWidgets(): array
    {
        return [
            SiteStatsOverview::class,
            LatestSiteUpdates::class,
        ];
    }

    // Method yang akan dijalankan saat tombol refresh diklik.
    public function refreshSiteStatuses(): void
    {
        $sites = Site::all();
        foreach ($sites as $site) {
            // Logika simulasi: 50% kemungkinan aktif, 50% inaktif
            $site->status = (bool)rand(0, 1);
            $site->save();
        }

        Notification::make()
            ->title('Status berhasil di-refresh')
            ->success()
            ->send();

        // Memicu event untuk me-refresh semua widget.
        $this->dispatch('refresh-widgets');
    }
}

