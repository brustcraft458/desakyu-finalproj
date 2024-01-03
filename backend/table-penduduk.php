<?php
session_start();
$query_state = false;
$query_message = "";

function getPage($search = "") {
    $current = 1;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current = intval($_GET['page']);
    }
    
    // Count
    if (!empty($search)) {
        $query = new Query("SELECT COUNT(*) AS count FROM penduduk WHERE status_deleted = 0 AND concat(nama, nik, jenis_kelamin, status_perkawinan, pekerjaan) LIKE ?");
        $query->execute([
            "%$search%"
        ]);
    } else {
        $query = new Query("SELECT COUNT(*) AS count FROM penduduk WHERE status_deleted = 0");
        $query->execute();
    }

    if(!$query->state) {
        echo "query: $query->message";
        die;
    }

    // Max
    $count = $query->getData()['count'];
    $maximum = ceil($count / 5);

    // Session
    $_SESSION['page_penduduk'] = $current;

    return ['cur' => $current, 'max' => $maximum];
}

function getSearchBox() {
    $search = "";
    if (isset($_POST['search'])) {
        $search = $_POST['data'];
        $search = trim($search);

        $_SESSION['search_penduduk'] = $search;
    } elseif (isset($_SESSION['search_penduduk'])) {
        $search = $_SESSION['search_penduduk'];
    }

    return $search;
}

function loadPenduduk($page, $search = "") {
    global $query_state, $query_message;

    // Page
    $min = ($page - 1) * 5;
    $max = 5;

    // Read data
    if (!empty($search)) {
        // Search
        $query = new Query("SELECT * FROM penduduk WHERE status_deleted = 0 AND concat(nama, nik, jenis_kelamin, status_perkawinan, pekerjaan) LIKE ? LIMIT ?, ?");

        $query->execute([
            "%$search%",
            $min,
            $max
        ]);
    } else {
        // Default
        $query = new Query("SELECT * FROM penduduk WHERE status_deleted = 0 LIMIT ?, ?");

        $query->execute([
            $min,
            $max
        ]);
    }

    // End
    $query_state = $query->state;
    return $query->getData("multi");
}

?>