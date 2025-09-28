<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Memuat Aset di <head> untuk memastikan ketersediaan --}}
        @once
            @push('scripts')
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            @endpush
        @endonce

        {{-- CSS untuk custom marker --}}
        <style>
            .leaflet-popup-content-wrapper { border-radius: 8px; }
            .custom-div-icon { display: flex; justify-content: center; align-items: center; }
            .marker-pin {
                width: 30px; height: 30px; border-radius: 50% 50% 50% 0;
                position: absolute; transform: rotate(-45deg);
                left: 50%; top: 50%; margin: -15px 0 0 -15px;
                border: 1px solid #FFFFFF; box-shadow: 0 0 5px rgba(0,0,0,0.5);
            }
            .marker-pin::after {
                content: ''; width: 14px; height: 14px;
                margin: 8px 0 0 8px; background: #ffffff;
                position: absolute; border-radius: 50%;
            }
        </style>

        {{-- Container Peta dengan metode "polling" yang tangguh --}}
        <div
            wire:ignore
            x-data="{
                sites: @js($this->sites),
                map: null,
                init() {
                    // Fungsi ini akan terus mencoba inisialisasi sampai Leaflet siap
                    const tryInitMap = () => {
                        // Cek apakah 'L' (objek utama Leaflet) sudah ada di window
                        if (typeof L !== 'undefined') {
                            // Jika SUDAH, jalankan inisialisasi peta
                            this.initializeMap();
                        } else {
                            // Jika BELUM, tunggu 100 milidetik lalu coba lagi
                            setTimeout(tryInitMap, 100);
                        }
                    };
                    // Mulai proses pengecekan
                    tryInitMap();
                },
                initializeMap() {
                    this.$nextTick(() => {
                        if (this.map) return; // Mencegah inisialisasi ganda

                        console.log('Leaflet is ready! Initializing map.');
                        this.map = L.map(this.$refs.mapContainer).setView([-2.5489, 118.0149], 5);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href=`https://www.openstreetmap.org/copyright`>OpenStreetMap</a> contributors'
                        }).addTo(this.map);

                        this.sites.forEach(site => {
                            if (site.latitude && site.longitude) {
                                const statusColor = site.status ? '#22c55e' : '#ef4444';
                                const customIcon = L.divIcon({
                                    className: 'custom-div-icon',
                                    html: `<div style='background-color:${statusColor};' class='marker-pin'></div>`,
                                    iconSize: [30, 30],
                                    iconAnchor: [15, 30]
                                });

                                L.marker([site.latitude, site.longitude], { icon: customIcon })
                                    .addTo(this.map)
                                    .bindPopup(`<b>${site.name}</b><br>Status: ${site.status ? 'Aktif' : 'Inaktif'}`);
                            }
                        });
                    });
                }
            }"
            x-init="init()"
            class="w-full"
        >
            {{-- Elemen div untuk peta --}}
            <div x-ref="mapContainer" class="h-[30rem] w-full rounded-lg z-10"></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

<?php
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
?>

