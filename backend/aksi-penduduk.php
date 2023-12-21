<?php

function inputPenduduk() {
    // Insert data
    $query = new Query("INSERT INTO penduduk (nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, alamat_rt, alamat_rw, alamat_kel_desa, alamat_kecamatan, agama, status_perkawinan, pekerjaan, kewarganegaraan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->execute([
        $_POST['nik'],
        $_POST['nama'],
        $_POST['tempat_lahir'],
        $_POST['tanggal_lahir'],
        $_POST['jenis_kelamin'],
        $_POST['alamat'],
        $_POST['alamat_rt'],
        $_POST['alamat_rw'],
        $_POST['alamat_kel-desa'],
        $_POST['alamat_kecamatan'],
        $_POST['agama'],
        $_POST['status_perkawinan'],
        $_POST['pekerjaan'],
        $_POST['kewarganegaraan']
    ], "lowercase");
    
    $id_penduduk = $query->getInsertedId();
    $id_user = $_SESSION['id_user'];

    // History
    $queryh = new Query("INSERT INTO penduduk_history (id_user, id_penduduk, keterangan) VALUES (?, ?, ?)");
    $queryh->execute([
        $id_user,
        $id_penduduk,
        "add penduduk"
    ]);
    

    if (!$query->state) {
        echo "query: $query->message";
        die;
    }
}

function updatePenduduk($id) {
}
?>