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
    $query = new Query("SELECT COUNT(*) AS count FROM warga");
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
    global $db_connect, $query_state, $query_message;

    // Page
    $min = $page * 6;
    $max = 6;

    // Read data
    if (!empty($search)) {
        // Search
        $query = new Query("SELECT id, nama, nik, umur, pekerjaan FROM warga WHERE concat(nama, nik, umur, pekerjaan) LIKE ? LIMIT ?, ?");

        $query->execute([
            "%$search%",
            $min,
            $max
        ]);
    } else {
        // Default
        $query = new Query("SELECT id, nama, nik, umur, pekerjaan FROM warga LIMIT ?, ?");

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