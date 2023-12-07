<?php
session_start();

function loadPenduduk() {
    global $db_connect;

    // Read data
    $query = new Query("SELECT nama, nik, umur, pekerjaan FROM warga");
    $query->execute();

    if(!$query->state) {
        echo "query: $query->message";
        die;
    }

    return $query->getData();
}

?>