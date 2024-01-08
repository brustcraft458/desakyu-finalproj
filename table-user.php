<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./component/table.php";
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/table-user.php";
require_once "./backend/aksi-user.php";

// Init
Sidebar::selection("table-user");

// Aksi
if (isset($_POST['add-user'])) {
    addUser();
} elseif (isset($_POST['edit-user'])) {
    editUser();
} elseif (isset($_POST['delete-user'])) {
    deleteUser();
}

if ($aksi_state) {
    header("Location: table-user.php");
}

// Table
$userList = TableUser::loadTable();
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
                <h1 class="h3 mb-0 text-gray-800">Kelola User</h1>
            </div>
    
            <!-- Content Row -->
            <div class="card shadow mb-4" style="max-height: 40rem;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Warga</h6>
                </div>

                <form action="" method="POST" class="navbar-search mt-3 px-3 w-25">
                    <div class="input-group">
                        <?php TableUser::searchBox() ?>
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
                                <th>Username</th>
                                <th>Role</th>
                                <th style="width: 8.5em;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userList as $count => $user) :?>
                                <tr>
                                    <td><?= $user['username']?></td>
                                    <td><?= $user['role']?></td>
                                    <td class="d-flex justify-content-around">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-form-<?= $count ?>"><i class="ri-pencil-fill"></i></button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-form-<?= $count ?>"><i class="ri-delete-bin-2-fill"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                
                <div>
                    <?php foreach ($userList as $count => $user) : ?>
                        <!-- Modal Edit User -->
                        <div class="modal fade" id="edit-form-<?= $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="POST" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data User</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php elementFormUser($user); ?>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary" name="edit-user">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus User -->
                        <div class="modal fade" id="delete-form-<?= $count ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="" method="POST" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Data User</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php elementFormUser($user, "disabled"); ?>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger" name="delete-user">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                
                <div class="d-flex justify-content-between p-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-form">Tambah User</button>
                    <nav aria-label="Page navigation example" style="height: 38px">
                        <?php Table::pagination() ?>
                    </nav>
                </div>

                <div class="card-footer py-2">
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="add-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php elementFormUser(); ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="add-user">Tambah</button>
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

<?php function elementFormUser($user = [], $inputAttribute = "") {?>
    <?php
    if (!$user) {
        $user = arrayAssocFill(["id_user", "username", "password", "role"], "");
    }
    ?>

    <div class="modal-body">
        <div>
            <div style="display: none">
                <input type="hidden" class="form-control text-uppercase" id="id_user" name="id_user" value="<?= $user['id_user'] ?>">
            </div>
            <div class="form-group">
                <label for="username" class="col-form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" <?= $inputAttribute ?>>
            </div>
            <div class="form-group">
                <label for="password" class="col-form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?= $user['password'] ?>" <?= $inputAttribute ?>>
            </div>
            <div class="form-group">
                <label for="role" class="col-form-label">role:</label>
                <select id="role" name="role" class="form-control" <?= $inputAttribute ?>>
                    <option <?= atOption($user['role'], "warga") ?>>warga</option>
                    <option <?= atOption($user['role'], "admin_rt") ?>>admin rt</option>
                    <option <?= atOption($user['role'], "admin_desa") ?>>admin desa</option>
                    <option <?= atOption($user['role'], "admin_super") ?>>admin super</option>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
