<?php
$aksi_state = false;
$aksi_message = "";

function accStatusSurat($status) {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE surat SET status_pengajuan = ? WHERE id_penduduk = ?");
    $query->execute([
        $status,
        $_POST['id_penduduk']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function printSurat() {}

function deleteSurat() {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE surat SET status_deleted = 1 WHERE id_penduduk = ?");
    $query->execute([
        $_POST['id_penduduk']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

?>