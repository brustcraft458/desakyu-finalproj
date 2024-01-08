<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./component/table.php";
require_once "./component/saran.php";
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/table-saran.php";
require_once "./backend/aksi-saran.php";

// Aksi Saran
if (isset($_POST['delete-saran'])) {
    deleteSaran();
}

if (isset($_GET['fill-saran'])) {
    Saran::fill($_GET['fill-saran']);
    exit;
} else if (isset($_POST['send-saran'])) {
    Saran::send($_POST['send-saran']);
}

if ($aksi_state) {
    header("Location: table-saran.php");
}

// Table
$saranList = TableSaran::loadTable();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.min.css" integrity="sha512-9dM+qk2jOZSKUQwjFh8iOtYvIoz3HidudalPDswePq12rBzkbVAQYqb1lrASFwocSLSUJ5TqNQ6xgNuOFSfT6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="./img/head-icon.png" type="image/x-icon">
    <title>Document</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./function.js"></script>

    <main class="d-flex flex-row">
        <!-- Sidebar -->
        <?php Sidebar::selection("table-saran") ?>
    
        <!-- Dashboard -->
        <div class="container-fluid px-5 py-3">
    
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Saran User</h1>
            </div>
    
            <!-- Content Row -->
            <div class="card shadow mb-4" style="max-height: 40rem;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Saran</h6>
                </div>

                <form action="" method="POST" class="navbar-search mt-3 px-3 w-25">
                    <div class="input-group">
                        <?php TableSaran::searchBox() ?>
                    </div>
                </form>

                <div class="table-responsive p-3">
                    <div class="w-50">
                        <?php if (!$aksi_state) :?>
                            <?php if ($aksi_message == "fail_query") : ?>
                                <p class="alert alert-danger">Query database gagal</p>
                            <?php elseif ($aksi_message == "fail_emptydata") : ?>
                                <p class="alert alert-danger">Input Data tidak boleh kosong</p>
                            <?php endif ?>
                        <?php else : ?>
                        <?php endif ?>
                    </div>
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nik</th>
                                <th>Rating</th>
                                <th style="min-width: 20em">Saran</th>
                                <th style="width: 4.5em;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($saranList as $count => $saran) :?>
                                <tr>
                                    <td><?= $saran['nama']?></td>
                                    <td><?= $saran['nik']?></td>
                                    <td><?= $saran['rating']?></td>
                                    <td><?= $saran['saran']?></td>
                                    <td class="d-flex justify-content-around">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-form-<?= $count ?>"><i class="ri-delete-bin-2-fill"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                
                <div>
                    <?php foreach ($saranList as $count => $saran) : ?>
                        <!-- Modal Delete Saran -->
                        <div class="modal fade" id="delete-form-<?= $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="POST" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Saran</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div style="display: none">
                                                <input type="hidden" class="form-control text-uppercase" id="id_saran" name="id_saran" value="<?= $saran['id_saran'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger" name="delete-saran">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                
                <div class="d-flex justify-content-between p-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saran-form">Tambah Saran</button>
                    <nav aria-label="Page navigation example" style="height: 38px">
                        <?php Table::pagination() ?>
                    </nav>
                </div>

                <div class="card-footer py-2">
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Saran -->
    <?php Saran::modal() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="./main.js"></script>
</body>

</html>