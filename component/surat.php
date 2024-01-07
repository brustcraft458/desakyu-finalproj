<?php
class Surat {
    static public function modal() {
        elementModalSurat();
    }
    static public function fill($target) {
        $dsurat = suratFill($target);
        elementSuratForm($target, $dsurat['state'], $dsurat['data']);
    }
    
    static public function send($target) {
        sendSurat($target);
    }
}
?>

<!-- Layanan Surat -->
<?php function elementModalSurat() {?>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Surat Keterangan Usaha Dalam -->
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
                        <?php elementSurat("surat-keterangan-usaha-dalam"); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="send-surat" value="surat-keterangan-usaha-dalam">Kirim</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>

<?php function elementSurat($target) {?>
    <div class="form-group">
        <label for="nik" class="col-form-label">NIK:</label>
        <div class="d-flex flex-row align-items-center" id="fgroup-surat-keterangan-usaha-dalam-nik">
            <input type="number" class="form-control text-uppercase" id="nik" name="nik">
            <div class="check-status mx-2"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="nama" class="col-form-label">Nama Lengkap:</label>
        <div class="d-flex flex-row align-items-center" id="fgroup-surat-keterangan-usaha-dalam-nama">
            <input type="text" class="form-control text-uppercase" id="nama" name="nama">
            <div class="check-status mx-2"></div>
        </div>
    </div>

    <?php elementSuratFill($target) ?>
<?php } ?>

<?php function elementSuratFill($target) { ?>
    <div id="fill-<?= $target ?>">
        <?php elementSuratForm($target) ?>
    </div>

    <script>
        const url = window.location.href
        const target = "<?= $target ?>"

        const elmntNik = document.querySelector(`#fgroup-${target}-nik`)
        const elmntNama = document.querySelector(`#fgroup-${target}-nama`)
        const inputNik = elmntNik.querySelector("input")
        const inputNama = elmntNama.querySelector("input")
        const statusNik = elmntNik.querySelector(".check-status")
        const statusNama = elmntNama.querySelector(".check-status")
        const parrent = document.querySelector(`#fill-${target}`)
        
        const fillForm = async() => {
            let nik = inputNik.value
            let nama = inputNama.value
            let formData = new FormData()
            formData.append('nik', nik)
            formData.append('nama', nama)
            formData.append(`fill-surat`, target)

            const param = new URLSearchParams(formData);

            let resp = await fetch(
                `${url}?${param}`, 
                {method: 'GET'}
            )
            
            // Get
            resp = await resp.text()

            if (resp.indexOf("<!-- check-status-nik-true -->") != -1) {
                statusNik.innerHTML = "<i class='ri-check-line ri-xl text-primary'></i>"
            } else {
                statusNik.innerHTML = "<i class='ri-close-line ri-xl text-secondary'></i>"
            }
            if (resp.indexOf("<!-- check-status-nama-true -->") != -1) {
                statusNama.innerHTML = "<i class='ri-check-line ri-xl text-primary'></i>"
            } else {
                statusNama.innerHTML = "<i class='ri-close-line ri-xl text-secondary'></i>"
            }
            parrent.innerHTML = resp
        }

        inputNik.addEventListener("input", debounce(fillForm, 500))
        inputNama.addEventListener("input", debounce(fillForm, 500))
    </script>
<?php } ?>

<?php function elementSuratForm($target, $state = [], $data = []) {?>
    <?php
    if (!$state) {
        $state = arrayAssocFill(["nik", "nama"], false);
    }

    if ($state['nik']) {
        echo("<!-- check-status-nik-true -->");
    }
    if ($state['nama']) {
        echo("<!-- check-status-nama-true -->");
    }
    ?>

    <?php
    if (!$data) {
        $data = arrayAssocFill(["id_penduduk", "jenis_kelamin", "tempat_lahir", "tanggal_lahir", "agama", "pekerjaan", "alamat"], "");
    }
    ?>

    <?php if ($target == "surat-keterangan-usaha-dalam") :?>
        <div style="display: none;">
            <input type="hidden" class="form-control text-uppercase" id="id_penduduk" name="id_penduduk" value="<?= $data['id_penduduk']?>">
        </div>
        <div class="form-group">
            <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
            <input type="text" class="form-control text-uppercase w-50" id="jenis_kelamin" name="jenis_kelamin" value="<?= $data['jenis_kelamin'] ?>" disabled>
        </div>
        <div class="form-group">
            <label for="tempat_lahir" class="col-form-label">Tempat, Tanggal Lahir:</label>
            <div class="d-flex flex-row gap-2">
                <input type="text" class="form-control text-uppercase w-50" id="tempat_lahir" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" disabled>
                <input type="date" class="form-control text-uppercase" id="tanggal_lahir" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="agama" class="col-form-label">Agama:</label>
            <input type="text" class="form-control text-uppercase" id="agama" name="agama" value="<?= $data['agama'] ?>" disabled>
        </div>
        <div class="form-group">
            <label for="pekerjaan" class="col-form-label">Pekerjaan:</label>
            <input type="text" class="form-control text-uppercase" id="pekerjaan" name="pekerjaan" value="<?= $data['pekerjaan'] ?>" disabled>
        </div>
        <div class="form-group">
            <label for="alamat" class="col-form-label">Alamat:</label>
            <input type="text" class="form-control text-uppercase" id="alamat" name="alamat" value="<?= $data['alamat'] ?>">
        </div>
        <div class="form-group">
            <label for="nama_usaha" class="col-form-label">Nama Usaha:</label>
            <input type="text" class="form-control text-uppercase" id="nama_usaha" name="nama_usaha" value="">
        </div>
    <?php endif; ?>
<?php } ?>