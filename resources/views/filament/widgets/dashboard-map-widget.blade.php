<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Head Assets --}}
        @once
            @push('scripts')
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
            @endpush
        @endonce

        {{-- Custom Styles --}}
        <style>
            .leaflet-popup-content-wrapper {
                border-radius: 10px;
                background: #1f2937;
                color: #f3f4f6;
            }
            .marker-pin {
                width: 30px;
                height: 30px;
                border-radius: 50% 50% 50% 0;
                transform: rotate(-45deg);
                position: absolute;
                border: 2px solid #fff;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
            }
            .marker-pin::after {
                content: '';
                width: 14px;
                height: 14px;
                position: absolute;
                top: 8px;
                left: 8px;
                background: #fff;
                border-radius: 50%;
            }
        </style>

        {{-- Grid Layout Dashboard --}}
        <div class="space-y-6">
            {{-- Statistik Manual --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center mb-6">
                <div class="p-4 bg-gray-800/50 rounded-lg">
                    <h3 class="text-sm text-gray-400">Total Devices</h3>
                    <p class="text-2xl font-bold text-white">{{ $this->totalSites ?? 0 }}</p>
                </div>

                <div class="p-4 bg-gray-800/50 rounded-lg">
                    <h3 class="text-sm text-gray-400">Online</h3>
                    <p class="text-2xl font-bold text-green-400">{{ $this->onlineSites ?? 0 }}</p>
                </div>

                <div class="p-4 bg-gray-800/50 rounded-lg">
                    <h3 class="text-sm text-gray-400">Offline</h3>
                    <p class="text-2xl font-bold text-red-400">{{ $this->offlineSites ?? 0 }}</p>
                </div>

                <div class="p-4 bg-gray-800/50 rounded-lg">
                    <h3 class="text-sm text-gray-400">Avg Uptime</h3>
                    <p class="text-2xl font-bold text-blue-400">{{ $this->avgUptime ?? 0 }}%</p>
                </div>
            </div>

            {{-- Mini Map Section --}}
            <x-filament::section heading="Network Overview Map">
                @verbatim
                <div wire:ignore 
                    x-data="{
                        sites: $wire.get('sites'),
                        map: null,
                        init() {
                            const tryInitMap = () => {
                                if (typeof L !== 'undefined') this.initializeMap();
                                else setTimeout(tryInitMap, 100);
                            };
                            tryInitMap();
                        },
                        initializeMap() {
                            if (this.map) return;
                            this.map = L.map(this.$refs.mapContainer).setView([-2.5489, 118.0149], 5);

                            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                                attribution: '&copy; <a href=\'https://carto.com/attributions\'>CARTO</a>'
                            }).addTo(this.map);

                            this.sites.forEach(site => {
                                if (site.latitude && site.longitude) {
                                    const statusColor = site.status === 'active' ? '#22c55e' : '#ef4444';
                                    const customIcon = L.divIcon({
                                        className: 'custom-div-icon',
                                        html: `<div style='background-color:${statusColor};' class='marker-pin'></div>`,
                                        iconSize: [30, 30],
                                        iconAnchor: [15, 30]
                                    });

                                    const popupContent = `
                                        <div class='font-semibold text-base mb-1'>${site.name}</div>
                                        <div class='text-sm text-gray-400'>Status: 
                                            <span style='color:${statusColor}'>
                                                ${site.status === 'active' ? 'Online' : 'Offline'}
                                            </span>
                                        </div>
                                        <div class='text-sm text-gray-400'>IP: ${site.ip_address ?? '-'}</div>
                                        <div class='text-sm text-gray-400'>Last Check: ${site.last_checked ?? '-'}</div>
                                    `;

                                    L.marker([site.latitude, site.longitude], { icon: customIcon })
                                        .addTo(this.map)
                                        .bindPopup(popupContent);
                                }
                            });
                        }
                    }"
                    x-init="init()">
                    <div x-ref="mapContainer" class="h-[60vh] w-full rounded-lg z-10"></div>
                </div>
                @endverbatim
            </x-filament::section>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
