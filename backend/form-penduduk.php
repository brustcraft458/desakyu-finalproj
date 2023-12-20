<?php
session_start();

function inputPenduduk() {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $umur = intval($_POST['umur']);
    $pekerjaan = $_POST['pekerjaan'];

    // Insert data
    $query = new Query("INSERT INTO penduduk (nama, nik, umur, pekerjaan) VALUES (?, ?, ?, ?)");
    $query->execute([
        $nama,
        $nik,
        $umur,
        $pekerjaan
    ]);
    
    $id_penduduk = $query->getInsertedId();
    $id_user = $_SESSION['id_user'];

    // History
    $queryh = new Query("INSERT INTO penduduk_history (id_user, id_penduduk, keterangan) VALUES (?, ?, ?)");
    $queryh->execute([
        $id_user,
        $id_penduduk,
        "add penduduk"
    ]);
    

    if (!$query->state) {
        echo "query: $query->message";
        die;
    }
}

?>