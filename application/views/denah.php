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
    <style>
        .row {
            height: 100vh;
        }
        body {
            font-family: Arial, sans-serif;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark shadow">
        <div class="contaier-fluid ps-md-4 ps-3 pt-2">
            <h3 class="text-light"><i class="bi bi-map-fill"></i></h3>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <!-- main layout -->
            <div class="col-12 border bg-light">
                <div class="container-fluid ps-2 pe-2" id="map" style="height:100%; width:100%;">
                    <!-- map inisialisasi di sini -->
                </div>
            </div>
        </div>
    </div>
    <div class="custom-layout pe-2" id="custom-layout">
        <div class="d-flex flex-row mb-2">
            <form action="<?php echo base_url('ViewController/MarkersByName') ?>" method="post" class="d-flex">
                <input type="text" class="form-control shadow" name="nama_bangunan" placeholder="Cari Lokasi">
                <button type="submit" class="btn btn-md btn-primary ms-2 shadow"><i class="bi bi-search"></i></button>
            </form>
            <button type="button" class="btn btn-primary ms-2 shadow" data-bs-toggle="collapse" data-bs-target="#ruteTo"><i class="bi bi-sign-turn-slight-left-fill"></i></button>
        </div>  
        <div class="collapse container bg-light shadow" id="ruteTo">
            <h4>Testimoni lok!</h4>
        </div>
        <div class="collapse container bg-light shadow p-2 border rounded" id="ruteTo2">
            <!-- informasi lokasi -->
        </div>
    </div>

    <script>
        // var map = L.map('map').setView([-0.152567, 109.405606], 15);
        // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     minzoom: 15,
        //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        // }).addTo(map);
        
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
            center: [-0.152567, 109.405606],
            zoom: 15,
            layers: [mapstyle1]
        });

        var basemaps = {
            "Open Street": mapstyle1,
            "Satelite": mapstyle2
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
                var collapse2 = document.getElementById('ruteTo2');
                collapse2.innerHTML = '<h4 class="text-bg-primary p-2 text-center">Informasi Lokasi</h4><p class="mt-4"><b>Lokasi : </b><?php echo $m->nama_bangunan ?></p>';
                
                if (collapse1.classList.contains('show') || collapse2.classList.contains('show')) {
                    collapse1.classList.remove('show');
                    collapse2.classList.remove('show');
                } else {
                    collapse2.classList.add('show');
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

    <script src="<?php echo base_url().'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js'; ?>"></script>
</body>
</html>