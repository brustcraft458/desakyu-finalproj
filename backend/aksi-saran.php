<?php
$aksi_state = false;
$aksi_message = "";

function saranFill($target) {
    $state = [];
    $data = [];

    $state = ['nik' => false, 'nama' => false];

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

    switch ($target) {
        case 'saran':
            // Data
            $query = new Query("SELECT id_penduduk FROM penduduk WHERE status_deleted = 0 AND nik = ? AND nama = ?");
            $query->execute([
                $_GET['nik'],
                $_GET['nama']
            ]);
        
            if ($query->state) {
                $state['nama'] = true;
            } else {
                break;
            }

            $data = $query->getData();
            break;
        
        default:
            exit;
    }

    return ['state' => $state, 'data' => $data];
}

function sendSaran($target) {
    global $aksi_state, $aksi_message;

    // Insert data
    switch ($target) {
        case 'saran':
            $query = new Query("INSERT INTO saran (id_penduduk, rating, saran) VALUES (UPPER(?), UPPER(?), UPPER(?))");
            $query->execute([
                $_POST['id_penduduk'],
                $_POST['rating'],
                $_POST['text']
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

function deleteSaran() {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE saran SET status_deleted = 1 WHERE id_saran = ?");
    $query->execute([
        $_POST['id_saran']
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