<?php
$aksi_state = false;
$aksi_message = "";

function addPenduduk() {
    global $aksi_state, $aksi_message;

    // Insert data
    $query = new Query("INSERT INTO penduduk (nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, alamat_rt, alamat_rw, alamat_kel_desa, alamat_kecamatan, agama, status_perkawinan, pekerjaan, kewarganegaraan) VALUES (UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?), UPPER(?))");
    $query->execute([
        $_POST['nik'],
        $_POST['nama'],
        $_POST['tempat_lahir'],
        $_POST['tanggal_lahir'],
        $_POST['jenis_kelamin'],
        $_POST['alamat'],
        $_POST['alamat_rt'],
        $_POST['alamat_rw'],
        $_POST['alamat_kel_desa'],
        $_POST['alamat_kecamatan'],
        $_POST['agama'],
        $_POST['status_perkawinan'],
        $_POST['pekerjaan'],
        $_POST['kewarganegaraan']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }
    
    $id_penduduk = $query->getInsertedId();
    $id_user = $_SESSION['id_user'];

    // History
    $queryh = new Query("INSERT INTO penduduk_history (id_user, id_penduduk, keterangan) VALUES (?, ?, ?)");
    $queryh->execute([
        $id_user,
        $id_penduduk,
        "add penduduk"
    ]);

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function editPenduduk() {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE penduduk SET nik = UPPER(?), nama = UPPER(?), tempat_lahir = UPPER(?), tanggal_lahir = UPPER(?), jenis_kelamin = UPPER(?), alamat = UPPER(?), alamat_rt = UPPER(?), alamat_rw = UPPER(?), alamat_kel_desa = UPPER(?), alamat_kecamatan = UPPER(?), agama = UPPER(?), status_perkawinan = UPPER(?), pekerjaan = UPPER(?), kewarganegaraan = UPPER(?) WHERE id_penduduk = ?");
    $query->execute([
        $_POST['nik'],
        $_POST['nama'],
        $_POST['tempat_lahir'],
        $_POST['tanggal_lahir'],
        $_POST['jenis_kelamin'],
        $_POST['alamat'],
        $_POST['alamat_rt'],
        $_POST['alamat_rw'],
        $_POST['alamat_kel_desa'],
        $_POST['alamat_kecamatan'],
        $_POST['agama'],
        $_POST['status_perkawinan'],
        $_POST['pekerjaan'],
        $_POST['kewarganegaraan'],
        $_POST['id_penduduk']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }
    
    $id_penduduk = $_POST['id_penduduk'];
    $id_user = $_SESSION['id_user'];

    // History
    $queryh = new Query("INSERT INTO penduduk_history (id_user, id_penduduk, keterangan) VALUES (?, ?, ?)");
    $queryh->execute([
        $id_user,
        $id_penduduk,
        "edit penduduk"
    ]);

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function deletePenduduk() {
    global $aksi_state, $aksi_message;

    // Delete data
    $query = new Query("UPDATE penduduk SET status_deleted = 1 WHERE id_penduduk = ?");
    $query->execute([
        $_POST['id_penduduk']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }
    
    $id_penduduk = $_POST['id_penduduk'];
    $id_user = $_SESSION['id_user'];

    // History
    $queryh = new Query("INSERT INTO penduduk_history (id_user, id_penduduk, keterangan) VALUES (?, ?, ?)");
    $queryh->execute([
        $id_user,
        $id_penduduk,
        "delete penduduk"
    ]);

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}
?>