<?php
$aksi_state = false;
$aksi_message = "";

function sendSurat($target) {
    global $aksi_state, $aksi_message;

    // Insert data
    switch ($target) {
        case 'surat-keterangan-usaha-dalam':
            $query = new Query("INSERT INTO surat_skud (alamat, nama_usaha) VALUES (UPPER(?), UPPER(?))");
            $query->execute([
                $_POST['alamat'],
                $_POST['nama_usaha'],
            ]);
            break;
        
        default:
            exit;
    }

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }


    $id_data = $query->getInsertedId();
    $id_penduduk = $_POST['id_penduduk'];

    // Message Master
    $querym = new Query("INSERT INTO surat (id_penduduk, id_data, jenis) VALUES (?, ?, UPPER(?))");
    $querym->execute([
        $id_penduduk,
        $id_data,
        str_replace('-', ' ' , $target)
    ]);

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}
?>