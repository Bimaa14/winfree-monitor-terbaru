<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Status Winfree</title>

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            background-color: #0b0f19;
            color: #e5e7eb;
            font-family: 'Montserrat', sans-serif;
            scroll-behavior: smooth;
        }

        /* Navbar */
        #header {
            background: rgba(17, 25, 40, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        #header h1 a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
        }
        .navbar a {
            color: #e5e7eb;
            font-weight: 500;
            margin-left: 1rem;
        }
        .navbar a:hover {
            color: #3b82f6;
        }

        /* Hero */
        #hero {
            height: 100vh;
            background: linear-gradient(to bottom right, #111827, #1e293b);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
        }
        #hero h2 {
            font-size: 48px;
            font-weight: 700;
            color: #fff;
        }
        #hero p {
            color: #9ca3af;
            max-width: 600px;
            margin: 20px auto;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
            border-radius: 50px;
            padding: 10px 28px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* Map Section */
        #map {
            height: 70vh;
            width: 100%;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 0 25px rgba(59,130,246,0.1);
        }
        .section-header h3 {
            color: #fff;
            margin-bottom: 30px;
            font-weight: 700;
        }

        /* Footer */
        #footer {
            background: #111827;
            color: #9ca3af;
            padding: 25px 0;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header id="header" class="fixed-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="m-0"><a href="/">Winfree Monitor</a></h1>
            <nav class="navbar">
                <a href="#hero">Home</a>
                <a href="#map-section">Peta Lokasi</a>
                <a href="/admin"><i class="bi bi-shield-lock-fill me-1"></i> Admin</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section id="hero">
        <h2>Monitoring Status Wifi Publik</h2>
        <p>Sistem Informasi Geografis untuk pemetaan titik Winfree secara real-time</p>
        <a href="#map-section" class="btn btn-primary mt-3">Lihat Peta Status</a>
    </section>

    <!-- Map Section -->
    <section id="map-section" class="py-5">
        <div class="container text-center">
            <div class="section-header">
                <h3>Peta Lokasi Winfree</h3>
            </div>
            <div id="map"></div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            © {{ date('Y') }} Winfree by Simaya Jejaring Mandiri. All Rights Reserved.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sites = @json($sites, JSON_HEX_TAG);
            const map = L.map('map').setView([-6.9175, 107.6191], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            const greenIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });

            sites.forEach(site => {
                if (!site.latitude || !site.longitude) return;
                const icon = site.status ? greenIcon : redIcon;
                const statusText = site.status ? 'Aktif' : 'Mati';
                const statusColor = site.status ? '#22c55e' : '#ef4444';

                const popup = `
                    <div style="font-weight:600;">
                        ${site.name}
                        <br><span style="color:${statusColor};">Status: ${statusText}</span>
                    </div>`;
                L.marker([site.latitude, site.longitude], { icon }).addTo(map).bindPopup(popup);
            });
        });
    </script>
</body>
</html>
