<?php
session_start();

function getPage() {
    $page = 0;
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    }

    return $page;
}

function loadPenduduk($page) {
    global $db_connect;

    // Page
    $min = $page * 6;
    $max = 6;

    // Read data
    $query = new Query("SELECT id, nama, nik, umur, pekerjaan FROM warga limit ?, ?");
    $query->execute([
        $min,
        $max
    ]);

    if(!$query->state) {
        echo "query: $query->message";
        die;
    }

    return $query->getData();
}

?>