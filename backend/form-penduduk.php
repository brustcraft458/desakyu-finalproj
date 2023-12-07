<?php
session_start();

function inputPenduduk() {
    global $db_connect;

    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $umur = intval($_POST['umur']);
    $pekerjaan = $_POST['pekerjaan'];

    // Insert data
    $query = new Query("INSERT INTO warga (nama, nik, umur, pekerjaan) VALUES (?, ?, ?, ?)");
    $query->execute([
        $nama,
        $nik,
        $umur,
        $pekerjaan
    ]);
    

    if (!$query->state) {
        echo "query: $query->message";
        die;
    }
}

?>