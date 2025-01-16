<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denah Terminal</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="<?php echo base_url().'vendor/twbs/bootstrap-icons/font/bootstrap-icons.css'?>">
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
        #maprow {
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
            width: 40px;
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
            z-index: 1001; /* Supaya berada di atas peta */
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="offcanvas offcanvas-start" id="sidebar">
        <div class="offcanvas-header d-flex">
            <h6 class="ms-2"><img src="<?php echo base_url().'assets/picture/injourney-logo.png' ?>" alt="injourney-logo" style="width: 45%; height: 45%;"></h6>
            <button class="btn ms-auto" type="button" data-bs-dismiss="offcanvas"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="container p-2">
                <form action="<?php echo base_url().'ViewController/MarkersByName1'; ?>" method="post">
                    <label for="search" class="label-form text-secondary">Cari lokasi</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Cari">
                        <button type="submit" name="submit" class="btn btn-primary ms-2"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="container ps-2 pe-2 mt-5">
                <label for="opsi" class="label-form text-secondary">Pilihan Denah</label>
                <select class="form-select text-secondary" name="opsi" id="opsi">
                    <option value="<?php echo base_url().'ViewController/index' ?>">Denah Komplek Bandara</option>
                    <option value="<?php echo base_url().'ViewController/terminalL1' ?>">Denah Terminal Bandara - Lt.1</option>
                    <option selected value="<?php echo base_url().'ViewController/terminalL2' ?>">Denah Terminal Bandara - Lt.2</option>
                    <option value="<?php echo base_url().'ViewController/terminalL3' ?>">Denah Terminal Bandara - Lt.3</option>
                </select>
            </div>
            <label for="legenda" class="text-secondary ps-2 mt-5">Legenda</label>
            <div class="row ps-2 pe-2 mt-4" name="legenda" id="legenda">
                <?php foreach($colors as $c): ?>
                    <div class="col-4 d-flex">
                        <div class="custom-pin" style="background-color: <?php echo $c->warna_marker ?>; width:25px; height:25px;"><i class="bi bi-circle-fill"></i></div>
                        <h4 class="ms-3 text-secondary"><?php echo $c->jumlah_tanda ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
            <label class="text-secondary mt-5" for="list">Daftar Lokasi</label>
            <div class="container ps-2 mt-2" id="list">
                <?php foreach($marker as $m): ?>
                    <div class="d-flex p-1">
                        <div class="custom-pin" style="background-color: <?php echo $m->warna_marker ?>; width:12px; height:12px;"></div><h6 class="ms-2"><?php echo $m->nama_bangunan ?></h6>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <button id="trigger-offcanvas" class="btn btn-light border border-dark border-1 rounded-1" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-three-dots-vertical"></i></button>
    <div class="container-fluid">
        <div class="row" id="maprow">
            <div class="col-12 border bg-light">
                <div class="container-fluid" id="map" style="height:100%; width:100%;">
                    <!-- Wadah map -->
                </div>
            </div>
        </div>
    </div>
    <div class="collapse container bg-light shadow p-2 border rounded" id="ruteTo">
        <!-- Isi detail lokasi -->
    </div>
    <div class="title container">
        <h4 style="font-weight: 600;" class="text-dark">Bandara Udara Supadio - PNK</h4>
        <h6 style="font-weight: 400;" class="text-dark">Terminal Bandara Lantai 2</h6>
    </div>
    <!-- Isi -->

    <script>
        const imageUrl = '<?php echo base_url().'assets/picture/terminal_lantai_2.jpg' ?>';
        
        const img = new Image();
        img.onload = function () {
            const width = img.width;
            const height = img.height;

            const bounds = [[0,0], [height, width]];

            const map = L.map('map', {
                crs: L.CRS.Simple,
            }).setView([height/2,width/2], 1);

            L.imageOverlay(imageUrl, bounds).addTo(map);

            map.fitBounds(bounds);

            let pics = <?php echo json_encode($pictures) ?>

            <?php foreach($marker as $m): ?>
                var icons = L.divIcon({
                    className: '',
                    html: '<div class="custom-pin" style="background-color: <?php echo $m->warna_marker; ?>"><i class="bi bi-<?php echo $m->icons; ?>"></i></div>',
                    iconSize: [40, 40],
                    iconAnchor: [15, 40],
                });

                var marker = L.marker([<?php echo $m->latitude ?>, <?php echo $m->longitude ?>], {icon: icons}).addTo(map);

                marker.on('click', function () {
                    var collapse = document.getElementById('ruteTo');

                    let match = pics.filter(p=>p.id_bangunan == <?php echo $m->id ?>);

                    if (match.length > 0) {
                        let cItem = '';
                        let activated = true;

                        match.forEach((item, index)=> {
                            let activeImg = activated ? 'active' : '' ;
                            activated = false;
                            
                            let imgSrc = 'data:image/jpeg;base64,'+item.gambar;
                        
                            cItem += `<div class="carousel-item ${activeImg}">
                                <img class="img-thumbnail mx-auto d-block" style="width:80%; height:80%" src="${imgSrc}">
                            </div>`;
                        });
                        
                        collapse.innerHTML = `
                            <div class="container d-flex">
                                <h4 class="pt-2 text-center">Informasi Lokasi</h4>
                                <button class="btn btn-sm ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#ruteTo" aria-expanded="true" aria-controls="ruteTo">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <hr>
                            <div class="carousel slide" id="image" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    ${cItem}
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#image" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#image" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>
                            <p class="mt-3"><i class="bi bi-geo-alt-fill me-2 ms-2"></i><?php echo $m->nama_bangunan ?></p>`;
                    } else {
                        collapse.innerHTML = `
                            <div class="container d-flex ">
                                <h4 class="pt-2">Informasi Lokasi</h4>
                                <button class="btn btn-sm ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#ruteTo" aria-expanded="true" aria-controls="ruteTo">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <hr>
                            <p class="mt-4"><b><i class="bi bi-geo-alt-fill me-2 ms-2"></i></b><?php echo $m->nama_bangunan ?></p>`;
                    }

                    // Kondisi untuk menampilkan gambar
                    let bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapse);
                    bsCollapse.show();
                    
                });
            <?php endforeach; ?>

            const popup = L.popup();

            function onMapClick(e) {
                const latlng = e.latlng;
                popup.setLatLng(latlng).setContent("Koordinat: " + latlng.toString()).openOn(map);
            } map.on('click', onMapClick);
        };
        img.src = imageUrl;
    </script>
    
    <!-- PopUp Assist -->
    <script src="<?php echo base_url().'assets/script/Popup_latlang.js'; ?>"></script>
    <!-- Click Select Map -->
    <script src="<?php echo base_url().'assets/script/select_map.js' ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>