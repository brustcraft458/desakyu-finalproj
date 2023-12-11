<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./backend/query.php";
require_once "./backend/table-penduduk.php";

$page = getPage();
$pendudukList = loadPenduduk($page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <main class="d-flex flex-row">
        <!-- Sidebar -->
        <?php Sidebar::selection("table-penduduk") ?>
    
        <!-- Dashboard -->
        <div class="container-fluid px-5 py-3">
    
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Kependudukan</h1>
            </div>
    
            <!-- Content Row -->
            <div class="card shadow mb-4" style="max-height: 40rem;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Warga</h6>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nik</th>
                                <th>Umur</th>
                                <th>Pekerjaan</th>
                                <th style="width: 10.5em;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendudukList as $penduduk) :?>
                                <tr>
                                    <td><?= $penduduk['nama']?></td>
                                    <td><?= $penduduk['nik']?></td>
                                    <td><?= $penduduk['umur']?></td>
                                    <td><?= $penduduk['pekerjaan']?></td>
                                    <td style="display: flex; justify-content: space-around;">
                                        <button href="./edit-penduduk.php?id=<?= $penduduk['id'] ?>" class="btn btn-warning edit">Edit</button>
                                        <button href="./backend/delete-penduduk.php?id=<?= $penduduk['id'] ?>" class="btn btn-danger delete">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between p-3">
                    <a href="./form-penduduk.php" class="btn btn-primary">Tambah Data</a>
                    <nav aria-label="Page navigation example" style="height: 38px">
                        <ul class="pagination">
                          <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                          <?php for ($i= $page; $i < $page + 3 ; $i++) :?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i?></a></li>
                          <?php endfor ?>
                          <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="card-footer py-2">
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="./main.js"></script>
</body>

</html>