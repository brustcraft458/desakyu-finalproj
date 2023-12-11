<?php
session_start();

function getPage() {
    $current = 0;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current = intval($_GET['page']);
    }
    
    // Count
    $query = new Query("SELECT COUNT(*) AS count FROM warga");
    $query->execute();

    if(!$query->state) {
        echo "query: $query->message";
        die;
    }

    // Limit
    $count = $query->getData()['count'];
    $limit = round($count / 6);

    // Max
    $maximum = $current + 4;
    if ($maximum > $limit) {
        $maximum = $limit;
    }

    // Session
    $_SESSION['page_penduduk'] = $current;

    return ['cur' => $current, 'max' => $maximum];
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