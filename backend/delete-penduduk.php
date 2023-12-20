<?php
require '../config/db.php';
require_once "./query.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deletePenduduk($id);
    header("Location: ../table-penduduk.php");
}

function deletePenduduk($id) {
    // Delete data
    $query = new Query("UPDATE penduduk SET status_deleted = 1 WHERE id_penduduk = ?");
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