<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denah Bandara</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="<?php echo base_url().'vendor/twbs/bootstrap/dist/css/bootstrap.css'; ?>">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="<?php echo base_url().'vendor/twbs/bootstrap-icons/font/bootstrap-icons.css'?>">
    <link rel="stylesheet" href="<?php echo base_url().'leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.css';  ?>">
    <script src="<?php echo base_url().'leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.js'; ?>"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <style>
        .title {
            top: 8px;
            left: 100px;
            z-index: 1001;
            position: fixed;
            font-family: "Orbitron", serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
        .row {
            height: 100vh;
        }
        body {
            font-family: Arial, sans-serif;
        }
        #trigger-offcanvas {
            position: fixed;
            top: 100px;
            left: 24px;
            transform: translateY(-50%);
            z-index: 1001;
        }
        #ruteTo {
            position: fixed;
            bottom: 10px;
            left: 24px;
            z-index: 1001;
            max-width: 320px;
        }
        .custom-pin {
            position: relative;
            width: 30px;
            height: 40px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }
        .custom-pin i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            font-size: 14px;
            color: #fff;
        }
        .custom-layout {
            position: fixed;
            bottom: 10px;
            left: 25px;
            z-index: 1000; /* Supaya berada di atas peta */
            border-radius: 5px;
        }
        .border-none {
            border: none;
            box-shadow: none;
            background-color: transparent;
        }
    </style>
</head>
<body>
    <div class="offcanvas offcanvas-start" id="sidebar">
        <div class="offcanvas-header">
            <h4 class="ms-2"><i class="bi bi-map-fill"></i></h4>
            <button class="btn btn-close" type="button" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container ps-2">
                <form action="<?php echo base_url().'ViewController/MarkersByName'; ?>" method="post">
                    <label for="search" class="label-form text-secondary">Cari lokasi</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Cari">
                        <button type="submit" name="submit" class="btn btn-primary ms-2"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="container ps-2 pe-2 mt-4">
                <label for="opsi" class="label-form text-secondary">Pilihan Denah</label>
                <select class="form-select text-secondary" name="opsi" id="opsi">
                    <option selected value="<?php echo base_url().'ViewController/index' ?>">Denah Komplek Bandara</option>
                    <option value="<?php echo base_url().'ViewController/terminalL1' ?>">Denah Terminal Bandara - Lt.1</option>
                    <option value="<?php echo base_url().'ViewController/terminalL2' ?>">Denah Terminal Bandara - Lt.2</option>
                    <option value="<?php echo base_url().'ViewController/terminalL3' ?>">Denah Terminal Bandara - Lt.3</option>
                </select>
            </div>
        </div>
    </div>
    <button id="trigger-offcanvas" class="btn btn-light" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
    <div class="container-fluid">
        <div class="row">
            <!-- main layout -->
            <div class="col-12 border bg-light">
                <div class="container-fluid" id="map" style="height:100%; width:100%;">
                    <!-- map inisialisasi di sini -->
                </div>
            </div>
        </div>
    </div>
    <div class="collapse container bg-light shadow p-2 border rounded" id="ruteTo">
            <!-- informasi lokasi -->
    </div>
    <div class="title container">
        <h4 class="text-light" style="font-weight: 600;">Bandara Udara Supadio - PNK</h4>
        <h6 class="text-light" style="font-weight: 400;">Komplek Bandara Supadio</h5>
    </div>
    <script>
        var mapstyle2 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var mapstyle1 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '© Esri © OpenStreetMap Contributors',
            id: 'MapID',
            maxZoom: 20, 
            tileSize: 512, 
            zoomOffset: -1,
        });

        var map = L.map('map', {
            center: [-0.146751, 109.40486],
            zoom: 17,
            layers: [mapstyle1]
        });

        var basemaps = {
            "Citra Satelite": mapstyle1,
            "Peta Jalan": mapstyle2
        };

        var layerControl = L.control.layers(basemaps).addTo(map);

        <?php foreach($marker as $m): ?>
            var icons = L.divIcon({
                className: '',
                html: '<div class="custom-pin" style="background-color: <?php echo $m->warna_marker; ?>"><i class="bi bi-<?php echo $m->icons; ?>"></i></div>',
                iconSize: [30, 40],
                iconAnchor: [15, 40],
            });

            var marker = L.marker([<?php echo $m->latitude ?>, <?php echo $m->longitude ?>], {icon: icons}).addTo(map);

            marker.on('click', function () {
                var collapse1 = document.getElementById('ruteTo');
                collapse1.innerHTML = '<h4 class="p-2 text-center">Informasi Lokasi</h4><hr><p class="mt-4"><b><i class="bi bi-geo-alt-fill me-2 ms-2"></i></b><?php echo $m->nama_bangunan ?></p>';
                
                if (collapse1.classList.contains('show')) {
                    collapse1.classList.remove('show');
                } else {
                    collapse1.classList.add('show');
                }
            });
        <?php endforeach; ?>
        document.querySelector('[data-bs-target="#ruteTo"]').addEventListener('click', function () {
            var collapse2 = document.getElementById('ruteTo2');
            if (collapse2.classList.contains('show')) {
                collapse2.classList.remove('show');
            }
        });
    </script>

    <!-- PopUp Assist -->
    <script src="<?php echo base_url().'assets/script/Popup_latlang.js'; ?>"></script>
    <!-- Click Select Link -->
    <script src="<?php echo base_url().'assets/script/select_map.js' ?>"></script>

    <script src="<?php echo base_url().'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js'; ?>"></script>
</body>
</html>