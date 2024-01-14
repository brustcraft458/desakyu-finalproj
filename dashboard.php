<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/statistic.php";
require_once "./backend/dashboard.php";

// Init
Sidebar::selection("dashboard");
StatisticDash::init();
$totalPenduduk = StatisticDash::getTotalPenduduk();
$totalSuratPending = StatisticDash::getTotalSuratPending();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.min.css" integrity="sha512-9dM+qk2jOZSKUQwjFh8iOtYvIoz3HidudalPDswePq12rBzkbVAQYqb1lrASFwocSLSUJ5TqNQ6xgNuOFSfT6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./style/sbadmin.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <main class="d-flex flex-row">
        <!-- Sidebar -->
        <?php Sidebar::render() ?>

        <!-- Dashboard -->
        <div class="container-fluid px-5 py-3">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!-- Jumlah -->
            <div class="d-flex flex-row gap-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <p class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Penduduk</p>
                                    <p class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalPenduduk ?></p>
                                </div>
                                <div class="col-auto">
                                    <i class="ri-group-fill ri-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <p class="text-xs font-weight-bold text-primary text-uppercase mb-1">Surat Pending</p>
                                    <p class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalSuratPending ?></p>
                                </div>
                                <div class="col-auto">
                                    <i class="ri-mail-open-fill ri-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <p class="text-xs font-weight-bold text-primary text-uppercase mb-1">Laporan Pending</p>
                                    <p class="h5 mb-0 font-weight-bold text-gray-800">0</p>
                                </div>
                                <div class="col-auto">
                                    <i class="ri-file-copy-2-fill ri-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="./main.js"></script>
</body>

</html>