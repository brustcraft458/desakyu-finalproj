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
                            <!-- <tr>
                                <td>SURAT KETERANGAN TIDAK MAMPU</td>
                                <td><button class="btn btn-primary">Buat</button></td>
                            </tr> -->
                            <!-- <tr>
                                <td>SURAT KETERANGAN USAHA</td>
                                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#skud-form">Buat</button></td>
                            </tr> -->
                            <!-- <tr>
                                <td>SURAT PENGHASILAN ORANG TUA</td>
                                <td><button class="btn btn-primary">Buat</button></td>
                            </tr> -->
                            <!-- <tr>
                                <td>SURAT KETERANGAN DOMISILI</td>
                                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#skd-form">Buat</button></td>
                            </tr> -->
                            <tr>
                                <td>SURAT KETERANGAN BELUM MENIKAH</td>
                                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#skbm-form">Buat</button></td>
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

    <!-- Modal Surat Domisili -->
    <div class="modal fade" id="skd-form" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <?php elementSurat("surat-keterangan-domisili"); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="send-surat" value="surat-keterangan-domisili">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Surat Keterangan Belum Menikah -->
    <div class="modal fade" id="skbm-form" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <?php elementSurat("surat-keterangan-belum-menikah"); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="send-surat" value="surat-keterangan-belum-menikah">Kirim</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>

<?php function elementSurat($target) {?>
    <div class="form-group">
        <label for="nik" class="col-form-label">NIK:</label>
        <div class="d-flex flex-row align-items-center" id="fgroup-<?= $target ?>-nik">
            <input type="number" class="form-control text-uppercase" id="nik" name="nik">
            <div class="check-status mx-2"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="nama" class="col-form-label">Nama Lengkap:</label>
        <div class="d-flex flex-row align-items-center" id="fgroup-<?= $target ?>-nama">
            <input type="text" class="form-control text-uppercase" id="nama" name="nama">
            <div class="check-status mx-2"></div>
        </div>
    </div>

    <?php elementSuratFill($target) ?>

    <div class="form-group">
        <label for="kontak" class="col-form-label">Nomor HP</label>
        <input type="text" class="form-control text-uppercase phone-number" id="kontak" name="kontak">
    </div>
<?php } ?>

<?php function elementSuratFill($target) { ?>
    <div id="fill-<?= $target ?>">
        <?php elementSuratForm($target) ?>
    </div>
    <script>
        formFill("<?= $target ?>", "fill-surat")
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
        $data = arrayAssocFill(["id_penduduk", "nik", "nkk", "nama", "tempat_lahir", "tanggal_lahir", "jenis_kelamin", "alamat", "alamat_rt", "alamat_rw", "alamat_kel_desa", "alamat_kecamatan", "alamat_kabupaten", "agama", "status_perkawinan", "pekerjaan", "kewarganegaraan"], "");
    }
    ?>

    <?php if ($target == "surat-keterangan-usaha-dalam") :?>
        <div>
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
        </div>
    <?php elseif ($target == "surat-keterangan-domisili") :?>
        <div>
            <div style="display: none;">
                <input type="hidden" class="form-control text-uppercase" id="id_penduduk" name="id_penduduk" value="<?= $data['id_penduduk']?>">
            </div>
            <div class="form-group">
                <label for="nkk" class="col-form-label">Nomor KK:</label>
                <input type="number" class="form-control text-uppercase" id="nkk" name="nkk" value="<?= $data['nkk'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="tempat_lahir" class="col-form-label">Tempat, Tanggal Lahir:</label>
                <div class="d-flex flex-row gap-2">
                    <input type="text" class="form-control text-uppercase w-50" id="tempat_lahir" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" disabled>
                    <input type="date" class="form-control text-uppercase" id="tanggal_lahir" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
                <input type="text" class="form-control text-uppercase w-50" id="jenis_kelamin" name="jenis_kelamin" value="<?= $data['jenis_kelamin'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="kewarganegaraan" class="col-form-label">Kewarganegaraan:</label>
                <input type="text" class="form-control text-uppercase w-50" id="kewarganegaraan" name="kewarganegaraan" value="<?= $data['kewarganegaraan'] ?>" disabled>
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
                <input type="text" class="form-control text-uppercase" id="alamat" name="alamat" value="<?= $data['alamat'] ?>" disabled>
            </div>
        </div>
    <?php elseif ($target == "surat-keterangan-belum-menikah") :?>
        <div>
            <div style="display: none;">
                <input type="hidden" class="form-control text-uppercase" id="id_penduduk" name="id_penduduk" value="<?= $data['id_penduduk']?>">
            </div>
            <div class="form-group">
                <label for="nkk" class="col-form-label">Nomor KK:</label>
                <input type="number" class="form-control text-uppercase" id="nkk" name="nkk" value="<?= $data['nkk'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="tempat_lahir" class="col-form-label">Tempat, Tanggal Lahir:</label>
                <div class="d-flex flex-row gap-2">
                    <input type="text" class="form-control text-uppercase w-50" id="tempat_lahir" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" disabled>
                    <input type="date" class="form-control text-uppercase" id="tanggal_lahir" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
                <input type="text" class="form-control text-uppercase w-50" id="jenis_kelamin" name="jenis_kelamin" value="<?= $data['jenis_kelamin'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="kewarganegaraan" class="col-form-label">Kewarganegaraan:</label>
                <input type="text" class="form-control text-uppercase w-50" id="kewarganegaraan" name="kewarganegaraan" value="<?= $data['kewarganegaraan'] ?>" disabled>
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
                <input type="text" class="form-control text-uppercase" id="alamat" name="alamat" value="<?= $data['alamat'] ?>" disabled>
            </div>
        </div>
    <?php endif; ?>
<?php } ?>