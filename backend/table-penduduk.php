<?php
session_start();

function loadPenduduk() {
    global $db_connect;

    // Read data
    $sql = "SELECT nama, nik, umur, pekerjaan FROM warga";
    
    // Execute the query
    $query = mysqli_query($db_connect, $sql);
    if (!$query) {
        echo "query gagal";
        die;
    }

    // Data
    $data = [];
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        array_push($data, $row);
    }

    return $data;
}

?>