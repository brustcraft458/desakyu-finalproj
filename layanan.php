<?php
require './config/db.php';
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/layanan.php";

if (isset($_GET['fill-surat-keterangan-usaha'])) {
    $target = "surat-keterangan-usaha";

    $dataSurat = suratFill($target);
    elementSuratForm($target, $dataSurat);
    exit;
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
            <img src="./img/sukharja-orang.png">
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
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary">Ajukan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Surat -->
        <div class="modal fade" id="surat-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Surat</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>SURAT KETERANGAN TIDAK MAMPU</td>
                                    <td><button class="btn btn-primary">Buat</button></td>
                                </tr>
                                <tr>
                                    <td>SURAT KETERANGAN USAHA (DALAM)</td>
                                    <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#skud-form">Buat</button></td>
                                </tr>
                                <tr>
                                    <td>SURAT KETERANGAN USAHA (LUAR)</td>
                                    <td><button class="btn btn-primary">Buat</button></td>
                                </tr>
                                <tr>
                                    <td>SURAT PENGHASILAN ORANG TUA</td>
                                    <td><button class="btn btn-primary">Buat</button></td>
                                </tr>
                                <tr>
                                    <td>SURAT DOMISILI DALAM</td>
                                    <td><button class="btn btn-primary">Buat</button></td>
                                </tr>
                                <tr>
                                    <td>SURAT KETERANGAN BELUM MENIKAH</td>
                                    <td><button class="btn btn-primary">Buat</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="send-pesan">Kirim</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Surat Keterangan Usaha -->
        <div class="modal fade" id="skud-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Surat</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div style="display: none">
                                <input type="hidden" class="form-control text-uppercase" id="id_penduduk" name="id_penduduk">
                            </div>
                            <div class="form-group">
                                <label for="nik" class="col-form-label">NIK:</label>
                                <div class="d-flex flex-row align-items-center">
                                    <input type="number" class="form-control text-uppercase" id="input-surat-keterangan-usaha-nik" name="nik">
                                    <div class="mx-2"><i class="ri-check-double-line ri-xl text-primary"></i></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama" class="col-form-label">Nama:</label>
                                <div class="d-flex flex-row align-items-center">
                                    <input type="text" class="form-control text-uppercase" id="input-surat-keterangan-usaha-nama" name="nama">
                                    <div class="mx-2"><i class="ri-check-double-line ri-xl text-primary"></i></div>
                                </div>
                            </div>
                            <?php elementSuratFill("surat-keterangan-usaha"); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="send-pesan">Kirim</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Laporan -->
        <div class="modal fade" id="laporan-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Surat</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jenis Laporan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>LAPORAN PENDATANG</td>
                                    <td><button class="btn btn-primary">Buat</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="send-pesan">Kirim</button> -->
                    </div>
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

<?php function elementSuratFill($target) { ?>
    <div id="fill-<?= $target ?>">
        <?php elementSuratForm($target) ?>
    </div>

    <script>
        const url = './layanan.php'
        const target = "<?= $target ?>"
        const input = document.querySelector(`#input-${target}-nik`)
        const parrent = document.querySelector(`#fill-${target}`)

        input.addEventListener("input", debounce(async(event) => {
            let value = event.target.value
            let formData = new FormData()
            formData.append('nik', value)
            formData.append(`fill-${target}`, '')

            const param = new URLSearchParams(formData);

            let resp = await fetch(
                `${url}?${param}`, 
                {method: 'GET'}
            )


            // Send
            //let resp = await fetch(url, { method: 'GET', body: formData })
            
            // Get
            resp = await resp.text()
            console.log(resp)
            parrent.innerHTML = resp
        }, 500))
    </script>
<?php } ?>

<?php function elementSuratForm($target, $data = []) {?>
    <?php
    if (!$data) {
        $data = arrayAssocFill(["nama"], "");
    }
    ?>

    <?php if ($target == "surat-keterangan-usaha") :?>
        <div class="form-group">
            <label for="nama" class="col-form-label">Nama:</label>
            <input type="text" class="form-control text-uppercase" id="nama" name="nama" value="<?= $data['nama'] ?>">
        </div>
    <?php endif; ?>
<?php } ?>