<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./component/table.php";
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/table-penduduk.php";
require_once "./backend/aksi-penduduk.php";

// Init
Sidebar::selection("table-penduduk");

// Aksi
if (isset($_POST['add-penduduk'])) {
    addPenduduk();
} elseif (isset($_POST['edit-penduduk'])) {
    editPenduduk();
} elseif (isset($_POST['delete-penduduk'])) {
    deletePenduduk();
}

if ($aksi_state) {
    header("Location: table-penduduk.php");
}

// Table
$pendudukList = TablePenduduk::loadTable();
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
        <?php Sidebar::render() ?>
    
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
                        <?php TablePenduduk::searchBox() ?>
                    </div>
                </form>

                <div class="table-responsive p-3">
                    <div class="w-50">
                        <?php if (!$aksi_state) :?>
                            <?php if ($aksi_message == "fail_query") : ?>
                                <p class="alert alert-danger">Query database gagal</p>
                            <?php elseif ($aksi_message == "fail_emptydata") : ?>
                                <p class="alert alert-danger">Input Data tidak boleh kosong</p>
                            <?php elseif ($aksi_message == "fail_duplicate") : ?>
                                <p class="alert alert-danger">Input Data tidak boleh sama</p>
                            <?php endif ?>
                        <?php else : ?>
                        <?php endif ?>
                    </div>
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nik</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Pekerjaan</th>
                                <th style="width: 8.5em;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendudukList as $count => $penduduk) :?>
                                <tr>
                                    <td><?= $penduduk['nama']?></td>
                                    <td><?= $penduduk['nik']?></td>
                                    <td><?= $penduduk['jenis_kelamin']?></td>
                                    <td><?= $penduduk['status_perkawinan']?></td>
                                    <td><?= $penduduk['pekerjaan']?></td>
                                    <td class="d-flex justify-content-around">
                                        <?php if ($_SESSION['role'] == "admin_desa") : ?>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-form-<?= $count ?>"><i class="ri-pencil-fill"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-form-<?= $count ?>"><i class="ri-delete-bin-2-fill"></i></button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-secondary" disabled><i class="ri-pencil-fill"></i></button>
                                            <button type="button" class="btn btn-secondary" disabled><i class="ri-delete-bin-2-fill"></i></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                
                <div>
                    <?php foreach ($pendudukList as $count => $penduduk) : ?>
                        <!-- Modal Edit Penduduk -->
                        <div class="modal fade" id="edit-form-<?= $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="POST" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Penduduk</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php elementFormPenduduk($penduduk); ?>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary" name="edit-penduduk">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus Penduduk -->
                        <div class="modal fade" id="delete-form-<?= $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="POST" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Data Penduduk</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php elementFormPenduduk($penduduk, "disabled"); ?>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger" name="delete-penduduk">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                
                <div class="d-flex justify-content-between p-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-form">Tambah Data</button>
                    <nav aria-label="Page navigation example" style="height: 38px">
                        <?php Table::pagination() ?>
                    </nav>
                </div>

                <div class="card-footer py-2">
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Tambah Penduduk -->
    <div class="modal fade" id="add-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data Penduduk</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php elementFormPenduduk(); ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="add-penduduk">Tambah</button>
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

<?php function elementFormPenduduk($penduduk = [], $inputAttribute = "") {?>
    <?php
    if (!$penduduk) {
        $penduduk = arrayAssocFill(["id_penduduk", "nik", "nama", "tempat_lahir", "tanggal_lahir", "jenis_kelamin", "alamat", "alamat_rt", "alamat_rw", "alamat_kel_desa", "alamat_kecamatan", "alamat_kabupaten", "agama", "status_perkawinan", "pekerjaan", "kewarganegaraan"], "");
        $penduduk['alamat_kel_desa'] = "SUKAHARJA";
        $penduduk['alamat_kecamatan'] = "TELUKJAMBE TIMUR";
        $penduduk['alamat_kabupaten'] = "KARAWANG";
    }
    ?>

    <div class="modal-body">
        <div>
            <div style="display: none">
                <input type="hidden" class="form-control text-uppercase" id="id_penduduk" name="id_penduduk" value="<?= $penduduk['id_penduduk'] ?>">
            </div>
            <div class="form-group">
                <label for="nik" class="col-form-label">NIK:</label>
                <input type="number" class="form-control text-uppercase" id="nik" name="nik" value="<?= $penduduk['nik'] ?>" <?= $inputAttribute ?>>
            </div>
            <div class="form-group">
                <label for="nama" class="col-form-label">Nama:</label>
                <input type="text" class="form-control text-uppercase" id="nama" name="nama" value="<?= $penduduk['nama'] ?>" <?= $inputAttribute ?>>
            </div>
            <div class="form-group">
                <label for="tempat_lahir" class="col-form-label">Tempat, Tanggal Lahir:</label>
                <div class="d-flex flex-row gap-2">
                    <input type="text" class="form-control text-uppercase w-50" id="tempat_lahir" name="tempat_lahir" value="<?= $penduduk['tempat_lahir'] ?>" <?= $inputAttribute ?>>
                    <input type="date" class="form-control text-uppercase" id="tanggal_lahir" name="tanggal_lahir" value="<?= $penduduk['tanggal_lahir'] ?>" <?= $inputAttribute ?>>
                </div>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control text-uppercase" <?= $inputAttribute ?>>
                    <option <?= atOption($penduduk['jenis_kelamin'], "LAKI-LAKI") ?>>LAKI-LAKI</option>
                    <option <?= atOption($penduduk['jenis_kelamin'], "PEREMPUAN") ?>>PEREMPUAN</option>
                </select>
            </div>
            <div class="my-1">
                <label for="alamat" class="col-form-label">Alamat Lengkap:</label>
                <div class="px-3 border">
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Alamat:</label>
                        <input type="text" class="form-control text-uppercase" id="alamat" name="alamat" value="<?= $penduduk['alamat'] ?>" <?= $inputAttribute ?>>
                    </div>
                    <div class="form-group">
                        <label for="alamat_rt" class="col-form-label">Rt/Rw:</label>
                        <div class="d-flex flex-row gap-2">
                            <input type="number" class="form-control text-uppercase w-50" id="alamat_rt" name="alamat_rt" value="<?= $penduduk['alamat_rt'] ?>" <?= $inputAttribute ?>>
                            <input type="number" class="form-control text-uppercase w-50" id="alamat_rw" name="alamat_rw" value="<?= $penduduk['alamat_rw'] ?>" <?= $inputAttribute ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat_kel-desa" class="col-form-label">Kelurahan/Desa:</label>
                        <input type="text" class="form-control text-uppercase" id="alamat_kel-desa" name="alamat_kel_desa" value="<?= $penduduk['alamat_kel_desa'] ?>" <?= $inputAttribute ?>>
                    </div>
                    <div class="form-group">
                        <label for="alamat_kecamatan" class="col-form-label">Kecamatan:</label>
                        <input type="text" class="form-control text-uppercase" id="alamat_kecamatan" name="alamat_kecamatan" value="<?= $penduduk['alamat_kecamatan'] ?>" <?= $inputAttribute ?>>
                    </div>
                    <div class="form-group">
                        <label for="alamat_kabupaten" class="col-form-label">Kabupaten:</label>
                        <input type="text" class="form-control text-uppercase" id="alamat_kabupaten" name="alamat_kabupaten" value="<?= $penduduk['alamat_kabupaten'] ?>" <?= $inputAttribute ?>>
                    </div>
                    <div class="p-2"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="agama" class="col-form-label">Agama:</label>
                <select id="agama" name="agama" class="form-control text-uppercase" <?= $inputAttribute ?>>
                    <option <?= atOption($penduduk['agama'], "ISLAM") ?>>ISLAM</option>
                    <option <?= atOption($penduduk['agama'], "KRISTEN") ?>>KRISTEN</option>
                    <option <?= atOption($penduduk['agama'], "HINDU") ?>>HINDU</option>
                    <option <?= atOption($penduduk['agama'], "BUDHA") ?>>BUDHA</option>
                    <option <?= atOption($penduduk['agama'], "KATOLIK") ?>>KATOLIK</option>
                    <option <?= atOption($penduduk['agama'], "KONGHUCU") ?>>KONGHUCU</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status_perkawinan" class="col-form-label">Status Perkawinan:</label>
                <select id="status_perkawinan" name="status_perkawinan" class="form-control text-uppercase" <?= $inputAttribute ?>>
                    <option <?= atOption($penduduk['status_perkawinan'], "BELUM KAWIN") ?>>BELUM KAWIN</option>
                    <option <?= atOption($penduduk['status_perkawinan'], "KAWIN") ?>>KAWIN</option>
                    <option <?= atOption($penduduk['status_perkawinan'], "CERAI HIDUP") ?>>CERAI HIDUP</option>
                    <option <?= atOption($penduduk['status_perkawinan'], "CERAI MATI") ?>>CERAI MATI</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pekerjaan" class="col-form-label">Pekerjaan:</label>
                <select id="pekerjaan" name="pekerjaan" class="form-control text-uppercase" <?= $inputAttribute ?>>
                    <option <?= atOption($penduduk['pekerjaan'], "BELUM/TIDAK BEKERJA") ?>>BELUM/TIDAK BEKERJA</option>
                    <option <?= atOption($penduduk['pekerjaan'], "PELAJAR/MAHASISWA") ?>>PELAJAR/MAHASISWA</option>
                    <option <?= atOption($penduduk['pekerjaan'], "KARYAWAN SWASTA") ?>>KARYAWAN SWASTA</option>
                    <!-- <option class="custom-option" value="lainnya">Lainnya...</option> -->
                </select>
            </div>
            <div class="form-group">
                <label for="kewarganegaraan" class="col-form-label">Kewarganegaraan:</label>
                <select id="kewarganegaraan" name="kewarganegaraan" class="form-control text-uppercase" <?= $inputAttribute ?>>
                    <option <?= atOption($penduduk['kewarganegaraan'], "WNI") ?>>WNI</option>
                    <option <?= atOption($penduduk['kewarganegaraan'], "WNA") ?>>WNA</option>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
