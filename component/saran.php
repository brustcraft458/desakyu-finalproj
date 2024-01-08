<?php
class Saran {
    static public function modal() {
        elementModalSaran();
    }
    static public function fill($target) {
        $dsaran = saranFill($target);
        elementSaranForm($target, $dsaran['state'], $dsaran['data']);
    }
    
    static public function send($target) {
        sendSaran($target);
    }
}
?>

<!-- Layanan Saran -->
<?php function elementModalSaran() {?>
    <!-- Modal -->
    <div class="modal fade" id="saran-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Saran</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <?php elementSaran("saran"); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="send-saran" value="saran">Kirim</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>

<?php function elementSaran($target) {?>
    <div class="form-group">
        <label for="nik" class="col-form-label">NIK:</label>
        <div class="d-flex flex-row align-items-center" id="fgroup-saran-nik">
            <input type="number" class="form-control text-uppercase" id="nik" name="nik">
            <div class="check-status mx-2"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="nama" class="col-form-label">Nama Lengkap:</label>
        <div class="d-flex flex-row align-items-center" id="fgroup-saran-nama">
            <input type="text" class="form-control text-uppercase" id="nama" name="nama">
            <div class="check-status mx-2"></div>
        </div>
    </div>

    <?php elementSaranFill($target) ?>
<?php } ?>

<?php function elementSaranFill($target) { ?>
    <div id="fill-<?= $target ?>">
        <?php elementSaranForm($target) ?>
    </div>
    <script>
        formFill("<?= $target ?>", "fill-saran")
    </script>
<?php } ?>

<?php function elementSaranForm($target, $state = [], $data = []) {?>
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
        $data = arrayAssocFill(["id_penduduk", "saran"], "");
    }
    ?>

    <?php if ($target == "saran") :?>
        <div style="display: none;">
            <input type="hidden" class="form-control text-uppercase" id="id_penduduk" name="id_penduduk" value="<?= $data['id_penduduk']?>">
        </div>
        <div class="form-group">
            <label for="text" class="col-form-label">Rating:</label>
            <div class="rating">
                <input id="rating1" type="radio" name="rating" value="1">
                <label for="rating1">1</label>
                <input id="rating2" type="radio" name="rating" value="2">
                <label for="rating2">2</label>
                <input id="rating3" type="radio" name="rating" value="3">
                <label for="rating3">3</label>
                <input id="rating4" type="radio" name="rating" value="4">
                <label for="rating4">4</label>
                <input id="rating5" type="radio" name="rating" value="5">
                <label for="rating5">5</label>
            </div>
        </div>
        <div class="form-group">
            <label for="text" class="col-form-label">Saran:</label>
            <div class="d-flex flex-row align-items-center">
                <textarea id="text" class="form-control text-uppercase" name="text" rows="5" cols="40"></textarea><br>
            </div>
        </div>
    <?php endif; ?>
<?php } ?>