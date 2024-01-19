<?php
$aksi_state = false;
$aksi_message = "";

function sendLaporan($target) {
    global $aksi_state, $aksi_message;

    // Insert data
    switch ($target) {
        case 'laporan-pengkinian-data':
            // File
            $path = File::moveUpload("ktp_img", "upload/ktp/");

            if (!$path) {
                $aksi_state = false;
                $aksi_message = "file_fail";
                var_dump($_POST);
                var_dump($aksi_message);
                exit;
            }

            // Tes download
            File::saveDownload($path);


            // Query
            $query = new Query("INSERT INTO laporan (nik, nama) VALUES (UPPER(?), UPPER(?))");
            $query->execute([
                $_POST['nik'],
                $_POST['nama']
            ]);

            if (!$query->state) {
                $aksi_state = false;
                $aksi_message = $query->message;
                return;
            }
            break;
        
        default:
            exit;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function deleteLaporan() {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE laporan SET status_deleted = 1 WHERE id_laporan = ?");
    $query->execute([
        $_POST['id_laporan']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

?>