<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Status Winfree</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700|Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

    <!-- Bootstrap CSS (via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- LeafletJS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Custom CSS (diinspirasi dari referensi) -->
    <style>
        body {
            background: #fff;
            color: #444;
            font-family: "Open Sans", sans-serif;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            color: #0056b3;
            text-decoration: none;
        }
        h1, h2, h3, h4, h5, h6, .font-primary {
            font-family: "Montserrat", sans-serif;
        }
        #header {
            height: 80px;
            transition: all 0.5s;
            z-index: 997;
            background: rgba(52, 59, 64, 0.9);
        }
        #header #logo h1 {
            font-size: 34px;
            margin: 0;
            padding: 0;
            line-height: 1;
            font-weight: 700;
            letter-spacing: 3px;
        }
        #header #logo h1 a {
            color: #fff;
        }
        .navbar a {
            color: rgba(255, 255, 255, 0.7);
        }
        .navbar a:hover, .navbar .active {
            color: #fff;
        }
        #hero {
            width: 100%;
            height: 100vh;
            background: url(https://placehold.co/1920x1080/2c3e50/ffffff?text=Winfree+Monitoring) top center;
            background-size: cover;
            position: relative;
        }
        #hero:before {
            content: "";
            background: rgba(0, 0, 0, 0.6);
            position: absolute;
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;
        }
        #hero .hero-text {
            position: absolute;
            left: 0;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            text-align: center;
            color: #fff;
        }
        #hero .hero-text h2 {
            margin: 30px 0 10px 0;
            font-size: 48px;
            font-weight: 700;
            line-height: 56px;
        }
        #hero .btn-get-started {
            font-weight: 500;
            font-size: 16px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 8px 32px;
            border-radius: 50px;
            transition: 0.5s;
            margin: 10px;
            color: #fff;
            background: #007bff;
        }
        section {
            padding: 60px 0;
        }
        .section-header h3 {
            font-size: 36px;
            color: #413e66;
            text-align: center;
            font-weight: 700;
            position: relative;
        }
        #map {
            height: 70vh;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .leaflet-popup-content-wrapper {
            background-color: #fff;
            color: #333;
            border-radius: 8px;
        }
        .leaflet-popup-tip { background-color: #fff; }
        #footer {
            background: #343b40;
            padding: 30px 0;
            color: #fff;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex justify-content-between align-items-center">
            <div id="logo">
                <h1><a href="/">Winfree Monitor</a></h1>
            </div>
            <nav class="navbar">
                <ul class="d-flex list-unstyled m-0">
                    <li class="p-2"><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li class="p-2"><a class="nav-link scrollto" href="#map-section">Peta Lokasi</a></li>
                    <li class="p-2"><a class="nav-link" href="/admin">Login Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="hero-text">
            <h2>Monitoring Status Wifi Publik</h2>
            <p>Sistem Informasi Geografis untuk Pemetaan Status Titik Winfree</p>
            <a href="#map-section" class="btn-get-started scrollto">Lihat Peta Status</a>
        </div>
    </section>

    <main id="main">
        <!-- ======= Peta Section ======= -->
        <section id="map-section" class="section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h3 class="section-title mb-5">Peta Lokasi Winfree</h3>
                </div>
                <div id="map"></div>
            </div>
        </section>

        <!-- ======= About Section ======= -->
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="font-primary">Tentang Proyek Ini</h3>
                        <p>
                            Website ini dibangun untuk memonitor status jaringan di berbagai titik lokasi Wifi Publik (Winfree) secara real-time.
                            Sistem menggunakan metode 'ping' untuk memeriksa apakah sebuah titik lokasi sedang aktif (online) atau mati (offline).
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <h3>Status Indikator</h3>
                        <ul>
                            <li><i class="bi bi-check-circle text-success"></i> <strong>Pin Hijau:</strong> Menandakan titik lokasi Winfree sedang Aktif / Online.</li>
                            <li><i class="bi bi-x-circle text-danger"></i> <strong>Pin Merah:</strong> Menandakan titik lokasi Winfree sedang Mati / Offline.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-lg-start text-center">
                    <div class="copyright">
                        &copy; Copyright <strong>Winfree Monitor</strong>. All Rights Reserved
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- LeafletJS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Smooth scroll
            document.querySelectorAll('.scrollto').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Ambil data sites dari Laravel
            const sites = @json($sites);

            // Inisialisasi Peta
            const map = L.map('map').setView([-6.9175, 107.6191], 11);

            // Tambahkan Tile Layer tema terang
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Definisikan custom icon
            const greenIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });

            // Tampilkan marker untuk setiap site
            sites.forEach(site => {
                if (site.latitude == 0 || site.longitude == 0) return;
                const icon = site.status ? greenIcon : redIcon;
                const statusText = site.status ? 'Aktif' : 'Mati';
                const statusColor = site.status ? 'green' : 'red';
                
                const popupContent = `<b>${site.name}</b><br>Status: <b style='color:${statusColor};'>${statusText}</b>`;

                L.marker([site.latitude, site.longitude], {icon: icon})
                    .addTo(map)
                    .bindPopup(popupContent);
            });
        });
    </script>
</body>
</html>
