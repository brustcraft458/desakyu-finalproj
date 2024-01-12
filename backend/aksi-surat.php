<?php
$aksi_state = false;
$aksi_message = "";

function accStatusSurat($status) {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE surat SET status_pengajuan = ? WHERE id_surat = ?");
    $query->execute([
        $status,
        $_POST['id_surat']
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

function suratFill($target) {
    $state = ['nik' => false, 'nama' => false];
    $data = [];

    // Check
    $querysr = new Query("SELECT COUNT(id_penduduk) AS count FROM penduduk WHERE status_deleted = 0 AND nik = ?");
    $querysr->execute([
        $_GET['nik'],
    ]);
    if (!$querysr->state) {
        return ['state' => $state, 'data' => $data];
    }
    $count = $querysr->getData()['count'];
    if ($count > 0) {
        $state['nik'] = true;
    }

    // Data
    $query = new Query("SELECT * FROM penduduk WHERE status_deleted = 0 AND nik = ? AND nama = ?");
    $query->execute([
        $_GET['nik'],
        $_GET['nama']
    ]);

    if ($query->state) {
        $state['nama'] = true;
    } else {
        return ['state' => $state, 'data' => $data];
    }

    $data = $query->getData();
    return ['state' => $state, 'data' => $data];
}

function sendSurat($target) {
    global $aksi_state, $aksi_message;
    $id_penduduk = $_POST['id_penduduk'];
    
    // Insert data
    $query = new Query("INSERT INTO surat (id_penduduk, jenis) VALUES (?, UPPER(?))");
    $query->execute([
        $id_penduduk,
        str_replace('-', ' ' , $target)
    ]);

    // Custom Value
    switch ($target) {
        case 'surat-keterangan-usaha-dalam':
            // Any
            
            break;

        case 'surat-keterangan-domisili':
            // Any

            break;
        
        case 'surat-keterangan-belum-menikah':
            // Any

            break;
        
        default:
            exit;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function printSurat() {
    
}

function deleteSurat() {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE surat SET status_deleted = 1 WHERE id_surat = ?");
    $query->execute([
        $_POST['id_surat']
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