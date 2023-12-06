<?php
session_start();

function loadPenduduk() {
    global $db_connect;

    // Read data
    $data = Query::execute("SELECT nama, nik, umur, pekerjaan FROM warga");
    if (!$data) {
        echo "query gagal";
        die;
    }

    return $data;
}

?>