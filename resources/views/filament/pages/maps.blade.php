<x-filament-panels::page>
    {{-- Sertakan CSS Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Buat container untuk peta --}}
    <div id="map" style="height: 70vh; border-radius: 1rem; z-index: 1;"></div>

    {{-- Sertakan JS Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil data sites dari PHP (Blade) dan ubah ke format JSON
            const sites = @json($sites);

            // Inisialisasi Peta, atur view awal ke Bandung
            const map = L.map('map').setView([-6.9175, 107.6191], 11);

            // Tambahkan Tile Layer (latar belakang peta) dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Definisikan custom icon hijau dan merah
            const greenIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Looping semua data site untuk membuat marker
            sites.forEach(site => {
                // Lewati site yang tidak punya koordinat
                if (site.latitude == 0 || site.longitude == 0) {
                    return;
                }

                // Pilih icon berdasarkan status
                const icon = site.status ? greenIcon : redIcon;
                const statusText = site.status ? 'Aktif' : 'Mati';

                // Buat marker dan tambahkan ke peta
                L.marker([site.latitude, site.longitude], {icon: icon})
                    .addTo(map)
                    .bindPopup(
                        `<b>${site.name}</b><br>` +
                        `IP: ${site.ip_address}<br>` +
                        `Status: <b>${statusText}</b>`
                    );
            });
        });
    </script>
</x-filament-panels::page>
