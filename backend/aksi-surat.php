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
    $state = [];
    $data = [];

    switch ($target) {
        case 'surat-keterangan-usaha-dalam':
            $state = ['nik' => false, 'nama' => false];

            // Check
            $querysr = new Query("SELECT COUNT(id_penduduk) AS count FROM penduduk WHERE status_deleted = 0 AND nik = ?");
            $querysr->execute([
                $_GET['nik'],
            ]);

            if (!$querysr->state) {
                break;
            }

            $count = $querysr->getData()['count'];
            if ($count > 0) {
                $state['nik'] = true;
            }

            // Data
            $query = new Query("SELECT id_penduduk, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, pekerjaan, alamat FROM penduduk WHERE status_deleted = 0 AND nik = ? AND nama = ?");
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

            if (!$query->state) {
                $aksi_state = false;
                $aksi_message = $query->message;
                return;
            }
        
        
            $id_data = $query->getInsertedId();
            $id_penduduk = $_POST['id_penduduk'];
        
            // Message Master
            $querym = new Query("INSERT INTO surat (id_penduduk, id_skud, jenis) VALUES (?, ?, UPPER(?))");
            $querym->execute([
                $id_penduduk,
                $id_data,
                str_replace('-', ' ' , $target)
            ]);
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