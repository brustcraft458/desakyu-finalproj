<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/table-penduduk.php";
require_once "./backend/aksi-penduduk.php";

// Aksi
if (isset($_POST['add-penduduk'])) {
    inputPenduduk();
} elseif (isset($_POST['edit-penduduk'])) {
    //
}

$page = getPage();
$search = getSearchBox();
$pendudukList = loadPenduduk($page['cur'], $search);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.min.css" integrity="sha512-9dM+qk2jOZSKUQwjFh8iOtYvIoz3HidudalPDswePq12rBzkbVAQYqb1lrASFwocSLSUJ5TqNQ6xgNuOFSfT6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

                <form action="" method="POST" class="navbar-search mt-3 px-3 w-25">
                    <div class="input-group">
                        <input type="text" name="data" class="form-control bg-light border-0 small" placeholder="Cari untuk...">
                        
                        <button class="btn btn-primary" type="submit" name="search">
                            <i class="ri-search-line"></i>
                        </button>
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
                                <th style="width: 17.5em;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendudukList as $count => $penduduk) :?>
                                <tr>
                                    <td><?= $penduduk['nama']?></td>
                                    <td><?= $penduduk['nik']?></td>
                                    <td style="display: flex; justify-content: space-around;">
                                        <button type="button" class="btn btn-primary">Lihat Detail</button>
                                        <button href="./edit-penduduk.php?id=<?= $penduduk['id_penduduk'] ?>" class="btn btn-warning edit">Edit</button>
                                        <button href="./backend/delete-penduduk.php?id=<?= $penduduk['id_penduduk'] ?>" class="btn btn-danger delete">Hapus</button>
                                    </td>
                                </tr>
                                
                                <!-- Modal Edit Penduduk -->
                                <div class="modal fade" id="edit-penduduk-<?= $count ?>" tabindex="-1" role="dialog" aria-labelledby="form-penduduk-label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between p-3">
                    <!-- <a href="./form-penduduk.php" class="btn btn-primary">Tambah Data</a> -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-form">Tambah Data</button>
                    <nav aria-label="Page navigation example" style="height: 38px">
                        <ul class="pagination">
                            <?php if ($page['cur'] > 0) :?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $page['cur'] - 1 ?>"><<</a></li>
                            <?php else : ?>
                                <li class="page-item"><a class="page-link disabled" href=""><<</a></li>
                            <?php endif ?>

                            <?php for ($i = $page['cur']; $i < $page['cur'] + 4 ; $i++) :?>
                                <?php if ($i < $page['max']) : ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i?></a></li>
                                <?php else :?>
                                    <li class="page-item disabled"><a class="page-link" href="#"><?= $i?></a></li>
                                <?php endif ?>
                            <?php endfor ?>

                            <?php if ($page['cur'] < $page['max'] - 1) :?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $page['cur'] + 1 ?>">>></a></li>
                            <?php else :?>
                                <li class="page-item"><a class="page-link disabled" href="#">>></a></li>
                            <?php endif ?>
                        </ul>
                    </nav>
                </div>

                <div class="card-footer py-2">
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Tambah Penduduk -->
    <div class="modal fade" id="add-form" tabindex="-1" role="dialog" aria-labelledby="form-penduduk" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-penduduk">Input Data Penduduk</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="nik" class="col-form-label">Nik:</label>
                            <input type="number" class="form-control" id="nik" name="nik">
                        </div>
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir" class="col-form-label">Tempat, Tanggal Lahir:</label>
                            <div class="d-flex flex-row gap-2">
                                <input type="text" class="form-control w-50" id="tempat_lahir" name="tempat_lahir">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-form-label">Alamat:</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="form-group">
                            <label for="alamat_rt" class="col-form-label">Alamat Rt/Rw:</label>
                            <div class="d-flex flex-row gap-2">
                                <input type="number" class="form-control w-50" id="alamat_rt" name="alamat_rt">
                                <input type="number" class="form-control w-50" id="alamat_rw" name="alamat_rw">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_kel-desa" class="col-form-label">Alamat Kelurahan/Desa:</label>
                            <input type="text" class="form-control" id="alamat_kel-desa" name="alamat_kel-desa">
                        </div>
                        <div class="form-group">
                            <label for="alamat_kecamatan" class="col-form-label">Alamat Kecamatan:</label>
                            <input type="text" class="form-control" id="alamat_kecamatan" name="alamat_kecamatan">
                        </div>
                        <div class="form-group">
                            <label for="agama" class="col-form-label">Agama:</label>
                            <select id="agama" name="agama" class="form-control">
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="hindu">Hindu</option>
                                <option value="budha">Budha</option>
                                <option value="katolik">Katolik</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_perkawinan" class="col-form-label">Status Perkawinan:</label>
                            <select id="status_perkawinan" name="status_perkawinan" class="form-control">
                                <option value="belum kawin">Belum Kawin</option>
                                <option value="kawin">Kawin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan" class="col-form-label">Pekerjaan:</label>
                            <select id="pekerjaan" name="pekerjaan" class="form-control">
                                <option value="pelajar">Pelajar</option>
                                <option value="karyawan">Karyawan</option>
                                <option class="custom-option" value="lainnya">Lainnya...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kewarganegaraan" class="col-form-label">Kewarganegaraan:</label>
                            <select id="kewarganegaraan" name="kewarganegaraan" class="form-control">
                                <option value="wni">WNI</option>
                                <option value="wna">WNA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add-penduduk">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="./main.js"></script>
</body>

</html>