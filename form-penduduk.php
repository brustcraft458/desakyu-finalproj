<?php
require './config/db.php';
require_once "./component/chart.php";
require_once "./component/sidebar.php";
require_once "./backend/query.php";
require_once "./backend/form-penduduk.php";

if (isset($_POST['submit'])) {
    inputPenduduk();
    header("Location: table-penduduk.php");
}
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

    <main class="d-flex flex-row">
        <!-- Sidebar -->
        <?php Sidebar::selection("form-penduduk") ?>
    
        <!-- Dashboard -->
        <div class="container-fluid px-5 py-3">
    
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Kependudukan</h1>
            </div>
    
            <!-- Content Row -->
            <div class="card shadow mb-4" style="width: max-content">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Input Data Warga</h6>
                </div>
    
                <form action="" method="POST" class="card-body p-4">
                    <div class="d-flex flex-row gap-3">
                        <div>
                            <div class="mb-2">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama">
                            </div>
                            <div class="mb-2">
                                <label for="nik" class="form-label">Nik</label>
                                <input type="number" class="form-control" name="nik" id="nik">
                            </div>
                        </div>
    
                        <div>
                            <div class="mb-2">
                                <label for="umur" class="form-label">Umur</label>
                                <input type="number" class="form-control" name="umur" id="umur">
                            </div>

                            <div class="mb-2">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select id="pekerjaan" name="pekerjaan" class="form-control">
                                    <option value="tidak_bekerja">Tidak Bekerja</option>
                                    <option value="karyawan">Karyawan</option>
                                </select>
                            </div>
                        </div>
                    </div>
    
                    <div class="mt-3" style="align-self: flex-start;">
                        <button type="submit" class="btn btn-primary" name="submit" >Submit</button>
                    </div>
                </form>

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