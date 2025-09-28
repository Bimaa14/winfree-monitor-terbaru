<?php

namespace App\Filament\Pages;

use App\Models\Site;
use Filament\Pages\Page;

class Maps extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static string $view = 'filament.pages.maps';

    // Properti ini akan menampung data site
    public $sites;

    // Method ini akan dijalankan saat halaman dimuat
    public function mount(): void
    {
        // Ambil semua data site dan ubah menjadi format array
        $this->sites = Site::all()->toArray();
    }
}
