<?php
session_start();

function inputPenduduk() {
    global $db_connect;

    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $umur = intval($_POST['umur']);
    $pekerjaan = $_POST['pekerjaan'];

    // Insert data
    $sql = "INSERT INTO warga (nama, nik, umur, pekerjaan)
            VALUES ('$nama', '$nik', $umur, '$pekerjaan')";
    
    // Execute the query
    $query = mysqli_query($db_connect, $sql);
    if (!$query) {
        echo "query gagal";
        die;
    }
}

?>