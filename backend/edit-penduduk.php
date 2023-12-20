<?php
session_start();

function getPenduduk($id) {
    // Get data
    $query = new Query("SELECT nama, nik, umur, pekerjaan FROM penduduk WHERE id_penduduk = ?");
    $query->execute([
        $id
    ]);

    if (!$query->state) {
        echo "error: $query->message";
        die;
    }

    return $query->getData();
}

function updatePenduduk($id) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $umur = intval($_POST['umur']);
    $pekerjaan = $_POST['pekerjaan'];

    // Update data
    $query = new Query("UPDATE penduduk SET nama = ? , nik = ? , umur = ?, pekerjaan = ? WHERE id_penduduk = ?");
    $query->execute([
        $nama,
        $nik,
        $umur,
        $pekerjaan,
        $id
    ]);

    if (!$query->state) {
        echo "input data gagal";
        die;
    }

    return;
}
?>