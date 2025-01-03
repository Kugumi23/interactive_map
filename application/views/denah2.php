<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denah Terminal</title>
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
            z-index: 1000; /* Supaya berada di atas peta */
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
                <form action="<?php echo base_url().'ViewController/MarkersByName'; ?>" method="post">
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
                    <option selected value="<?php echo base_url().'ViewController/terminalL1' ?>">Denah Terminal Bandara - Lt.1</option>
                    <option value="<?php echo base_url().'ViewController/terminalL2' ?>">Denah Terminal Bandara - Lt.2</option>
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
        </div>
    </div>
    <button id="trigger-offcanvas" class="btn btn-light" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-three-dots-vertical"></i></button>
    <div class="container-fluid">
        <div class="row" id="maprow">
            <div class="col-12 border bg-light">
                <div class="container-fluid ps-2 pe-2" id="map" style="height:100%; width:100%;">
                    <!-- Wadah map -->
                </div>
            </div>
        </div>
    </div>
    <div class="title container">
        <h4 style="font-weight: 600;" class="text-dark">Bandara Udara Supadio - PNK</h4>
        <h6 style="font-weight: 400;" class="text-dark">Terminal Bandara Lantai 1</h6>
    </div>
    <!-- Isi -->
    
    
    <!-- PopUp Assist -->
    <script src="<?php echo base_url().'assets/script/Popup_latlang.js'; ?>"></script>
    <!-- Click Select Map -->
    <script src="<?php echo base_url().'assets/script/select_map.js' ?>"></script>

    <script src="<?php echo base_url().'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js'; ?>"></script>
</body>
</html>