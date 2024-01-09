<?php
require './config/db.php';
require_once "./component/surat.php";
require_once "./component/laporan.php";
require_once "./component/saran.php";
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/file.php";
require_once "./backend/aksi-surat.php";
require_once "./backend/aksi-laporan.php";
require_once "./backend/aksi-saran.php";

// Init
$rootdir = __DIR__;

// Aksi Surat
if (isset($_GET['fill-surat'])) {
    Surat::fill($_GET['fill-surat']);
    exit;
} else if (isset($_POST['send-surat'])) {
    Surat::send($_POST['send-surat']);
} else if (isset($_GET['fill-saran'])) {
    Saran::fill($_GET['fill-saran']);
    exit;
} else if (isset($_POST['send-laporan'])) {
    Laporan::send($_POST['send-laporan']);
} else if (isset($_POST['send-saran'])) {
    Saran::send($_POST['send-saran']);
}

if ($aksi_state) {
    header("Location: layanan.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.min.css" integrity="sha512-9dM+qk2jOZSKUQwjFh8iOtYvIoz3HidudalPDswePq12rBzkbVAQYqb1lrASFwocSLSUJ5TqNQ6xgNuOFSfT6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./style/index.css" rel="stylesheet">
    <title>Desaku</title>
</head>
<body>
    <script src="./function.js"></script>
    
    <header>
        <div class="background-img mix-white">
            <img src="./img/sukharja-orang.jpg">
        </div>
        <nav class="navbar">
            <div class="logo small">
                <img src="./img/karawang-logo.png"></img>
            </div>
            <ul class="menu-nav" id="menu-navbar">
                <li>Tentang Desa</li>
                <li>Pembangunan</li>
                <li>Lembaga</li>
                <li>Produk Desa</li>
                <li><a href="./layanan.php">Layanan Desa</a></li>
                <li><a href="./login.php">Admin</a></li>
            </ul>
            <div class="toggle button small" id="toggle-navbar">
                <img src="./img/expand.png"></img>
            </div>
        </nav>
        <div class="navbar-fill"></div>
        <div class="p-3 mt-2 mx-auto text-center">
            <h1 class="display-4 fw-normal">Layanan Desa</h1>
            <p class="fs-5 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta dignissimos dolorem aperiam autem fuga eum ad ut, facere excepturi temporibus.</p>
        </div>
    </header>
    <main>
        <div class="row row-cols-1 row-cols-md-3 text-center mx-auto px-4 d-flex align-items-center" style="max-width: 63em;">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Surat</h4>
                    </div>
                    <div class="card-body">
                        <i class="ri-mail-send-line ri-7x"></i>
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary" data-bs-toggle="modal" data-bs-target="#surat-form">Ajukan</button>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Laporan</h4>
                    </div>
                    <div class="card-body">
                        <i class="ri-file-shield-2-line ri-7x"></i>
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary" data-bs-toggle="modal" data-bs-target="#laporan-form">Ajukan</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Saran</h4>
                    </div>
                    <div class="card-body">
                        <i class="ri-feedback-line ri-7x"></i>
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary" data-bs-toggle="modal" data-bs-target="#saran-form">Ajukan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Surat -->
        <?php Surat::modal() ?>

        <!-- Modal Laporan -->
        <?php Laporan::modal() ?>

        <!-- Modal Saran -->
        <?php Saran::modal() ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="./main.js"></script>
</body>
</html>