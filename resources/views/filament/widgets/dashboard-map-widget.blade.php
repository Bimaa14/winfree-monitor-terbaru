<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Muat Aset Leaflet (CSS & JS) di <head> --}}
        @push('scripts')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        @endpush

        {{-- Gunakan Alpine.js untuk mengelola state dan interaksi peta --}}
        <div x-data="dashboardMapWidget(@json($sites))" 
             x-on:status-checked.window="refreshData(@json(App\Models\Site::all()))"
             wire:ignore
             x-init="init()">
            
            {{-- Kartu Statistik dan Tombol Baru --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                {{-- Kartu Total --}}
                <div class="p-6 bg-gray-800/50 rounded-lg shadow-lg">
                    <h3 class="text-sm font-medium text-gray-400">Total Titik Winfree</h3>
                    <p class="text-3xl font-bold text-white" x-text="totalSites"></p>
                </div>
                {{-- Kartu Aktif --}}
                <div class="p-6 bg-gray-800/50 rounded-lg shadow-lg">
                    <h3 class="text-sm font-medium text-gray-400">Winfree Aktif</h3>
                    <p class="text-3xl font-bold text-green-400" x-text="activeSites"></p>
                </div>
                {{-- Kartu Mati --}}
                <div class="p-6 bg-gray-800/50 rounded-lg shadow-lg">
                    <h3 class="text-sm font-medium text-gray-400">Winfree Mati</h3>
                    <p class="text-3xl font-bold text-red-400" x-text="inactiveSites"></p>
                </div>
                {{-- Tombol Live Check --}}
                <div class="p-6 bg-gray-800/50 rounded-lg shadow-lg flex flex-col justify-center items-center">
                    <button 
                        type="button" 
                        wire:click="checkStatusNow"
                        wire:loading.attr="disabled"
                        class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 w-full flex items-center justify-center">
                        <span wire:loading.remove wire:target="checkStatusNow">Cek Status Live</span>
                        <span wire:loading wire:target="checkStatusNow">Mengecek...</span>
                    </button>
                    <p class="text-xs text-gray-500 mt-2 text-center">Auto-refresh setiap 5 menit</p>
                </div>
            </div>

            {{-- Container Peta --}}
            <div id="dashboardMap" x-ref="mapContainer" style="height: 60vh; border-radius: 0.5rem; z-index: 1;"></div>
        </div>

        {{-- Logika JavaScript untuk Peta --}}
        <script>
            function dashboardMapWidget(initialSites) {
                return {
                    sites: initialSites,
                    map: null,
                    markers: {},
                    totalSites: 0,
                    activeSites: 0,
                    inactiveSites: 0,

                    // Fungsi untuk mengupdate angka statistik
                    updateStats() {
                        this.totalSites = this.sites.length;
                        this.activeSites = this.sites.filter(site => site.status).length;
                        this.inactiveSites = this.totalSites - this.activeSites;
                    },

                    // Fungsi untuk menggambar ulang marker di peta
                    refreshMarkers() {
                        Object.values(this.markers).forEach(marker => this.map.removeLayer(marker));
                        this.markers = {};

                        const greenIcon = L.icon({ iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] });
                        const redIcon = L.icon({ iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] });

                        this.sites.forEach(site => {
                            if (!site.latitude || !site.longitude) return;
                            const icon = site.status ? greenIcon : redIcon;
                            const statusText = site.status ? 'Aktif' : 'Mati';
                            const statusColor = site.status ? '#4ade80' : '#f87171';
                            const popupContent = `<b>${site.name}</b><br>IP: ${site.ip_address}<br>Status: <b style='color:${statusColor};'>${statusText}</b>`;
                            const marker = L.marker([site.latitude, site.longitude], { icon: icon }).addTo(this.map).bindPopup(popupContent);
                            this.markers[site.id] = marker;
                        });
                    },

                    // Fungsi yang dipanggil saat data baru diterima dari Livewire
                    refreshData(newSites) {
                        this.sites = newSites;
                        this.updateStats();
                        this.refreshMarkers();
                    },

                    // Fungsi utama untuk inisialisasi
                    init() {
                        // Pastikan Leaflet sudah siap
                        if (typeof L === 'undefined') {
                            setTimeout(() => this.init(), 100);
                            return;
                        }

                        // Jangan inisialisasi peta dua kali
                        if (this.map) return;

                        this.map = L.map(this.$refs.mapContainer).setView([-6.9175, 107.6191], 11);

                        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                            attribution: '&copy; OpenStreetMap &copy; CARTO',
                            maxZoom: 20
                        }).addTo(this.map);

                        this.updateStats();
                        this.refreshMarkers();
                        
                        // Auto-refresh halaman setiap 5 menit
                        setTimeout(() => { window.location.reload(); }, 300000);
                    }
                }
            }
        </script>
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
