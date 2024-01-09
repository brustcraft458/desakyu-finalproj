<?php
class Laporan {
    static public function modal() {
        elementModalLaporan();
    }
    
    static public function send($target) {
        sendLaporan($target);
    }
}
?>

<!-- Layanan Laporan -->
<?php function elementModalLaporan() {?>
    <!-- Modal Laporan -->
    <div class="modal fade" id="laporan-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Laporan</h5>
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
                                <td>LAPORAN PENGKINIAN DATA</td>
                                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lpd-form">Buat</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Laporan Pengkinian Data -->
    <div class="modal fade" id="lpd-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="modal-content" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Laporan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="nik" class="col-form-label">NIK:</label>
                            <div class="d-flex flex-row align-items-center" id="fgroup-lpd-nik">
                                <input type="number" class="form-control text-uppercase" id="nik" name="nik">
                                <div class="check-status mx-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama Lengkap:</label>
                            <div class="d-flex flex-row align-items-center" id="fgroup-lpd-nama">
                                <input type="text" class="form-control text-uppercase" id="nama" name="nama">
                                <div class="check-status mx-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ktp_img" class="col-form-label">Lampiran KTP:</label><br>
                            <input type="file" class="form-control-file" id="ktp_img" name="ktp_img" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="send-laporan" value="laporan-pengkinian-data">Kirim</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>