<?php
require '../config/db.php';
require_once "./query.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deletePenduduk($id);
    header("Location: ../table-penduduk.php");
}

function deletePenduduk($id) {
    // Get data
    $query = new Query("DELETE FROM warga WHERE id = ?");
    $query->execute([
        $id
    ]);

    if (!$query->state) {
        echo "error: $query->message";
        die;
    }

    return;
}
?>