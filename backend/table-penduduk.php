<?php
session_start();
$query_state = false;
$query_message = "";

function getPage() {
    $current = 0;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current = intval($_GET['page']);
    }
    
    // Count
    $query = new Query("SELECT COUNT(*) AS count FROM penduduk WHERE status_deleted = 0");
    $query->execute();

    if(!$query->state) {
        echo "query: $query->message";
        die;
    }

    // Max
    $count = $query->getData()['count'];
    $maximum = ceil($count / 6);

    // Session
    $_SESSION['page_penduduk'] = $current;

    return ['cur' => $current, 'max' => $maximum];
}

function getSearchBox() {
    $search = "";
    if (isset($_POST['search'])) {
        $search = $_POST['data'];
        $search = trim($search);
    }

    return $search;
}

function loadPenduduk($page, $search = "") {
    global $query_state, $query_message;

    // Page
    $min = $page * 6;
    $max = 6;

    // Read data
    if (!empty($search)) {
        // Search
        $query = new Query("SELECT id_penduduk, nama, nik FROM penduduk WHERE status_deleted = 0 AND concat(nama, nik) LIKE ? LIMIT ?, ?");

        $query->execute([
            "%$search%",
            $min,
            $max
        ]);
    } else {
        // Default
        $query = new Query("SELECT id_penduduk, nama, nik FROM penduduk WHERE status_deleted = 0 LIMIT ?, ?");

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