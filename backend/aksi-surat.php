<?php
$aksi_state = false;
$aksi_message = "";
$fpdi = new \setasign\Fpdi\Fpdi();

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

    // Acc
    if ($status == "DISETUJUI") {
        // File
        $path_acc = File::moveUpload("surat_reupload", "document/surat/");

        // Query
        $query = new Query("UPDATE surat SET file_surat_final = ? WHERE id_surat = ?");
        $query->execute([
            $path_acc,
            $_POST['id_surat']
        ]);
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
    $kontak = $_POST['kontak'];

    // Convert Phone
    if ($pphone = isPhoneNumber($kontak)) {
        if ($pphone == "local") {
            $kontak = convertPhone62($kontak);
        }
    } else {
        $aksi_state = false;
        $aksi_message = "fail_phone";
        return;
    }

    
    // Insert data
    $query = new Query("INSERT INTO surat (id_penduduk, jenis, kontak) VALUES (?, UPPER(?), ?)");
    $query->execute([
        $id_penduduk,
        str_replace('-', ' ' , $target),
        $kontak
    ]);
    $id_surat = $query->getInsertedId();

    // Custom Value
    switch ($target) {
        case 'surat-keterangan-usaha-dalam':
            // Any
            break;

        case 'surat-keterangan-domisili':
            // Any

            break;
        
        case 'surat-keterangan-belum-menikah':
            // Read data
            $query = new Query("SELECT * FROM surat INNER JOIN surat_skbm ON surat.id_skbm = surat_skbm.id_skbm WHERE id_surat = ?");
            $query->execute([
                $id_surat
            ]);
            $surat = $query->getData();
            $id_skbm = $surat['id_skbm'];
            break;
        
        default:
            exit;
    }

    // File
    $filepath = savepdfSurat($target, $surat);

    // Master
    $querym = new Query("UPDATE surat SET file_surat = ? WHERE id_surat = ?");
    $querym->execute([
        $filepath,
        $id_surat
    ]);

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function savepdfSurat($target, $data) {
    global $fpdi;

    switch ($target) {
        case 'surat-keterangan-belum-menikah':
            $fpdi->setSourceFile('./template/surat-keterangan-belum-menikah.pdf');
            $fpdi->AddPage('P', array(225, 350));
            $tplIdx = $fpdi->importPage(1);
            $fpdi->useTemplate($tplIdx);

            $textWarga = [
                "Nama Lengkap" => [
                    [103, 81], $data['nama']
                ],
                "Tempat / Tanggal Lahir" => [
                    [103, 88],
                    $data['tempat_lahir'] . ", " . $data['tanggal_lahir']
                ],
                "Jenis Kelamin" => [
                    [103, 95.5],
                    $data['jenis_kelamin']
                ],
                "Kewarganegaraan" => [
                    [103, 100],
                    $data['kewarganegaraan']
                ],
                "Agama" => [
                    [103, 108],
                    $data['agama']
                ],
                "Pekerjaan" => [
                    [103, 115.5],
                    $data['pekerjaan']
                ],
                "Alamat" => [
                    [103, 122.8],
                    $data['alamat']
                ],
                "Nomor KTP" => [
                    [105.4, 137.3],
                    $data['nik']
                ],
                "Nomor KK" => [
                    [105.4, 144.7],
                    $data['nkk']
                ],
            
            ];
            break;
        
        default:
            # code...
            return null;
    }

    // Text
    foreach ($textWarga as $value) {
        $fpdi->SetFont('times', '', 12);
        $fpdi->SetXY($value[0][0], $value[0][1]);
        $fpdi->Write(0, $value[1]);
    }

    $filename = File::generateName();
    $filepath = "upload/surat/$filename.pdf";

    $fpdi->Output("./$filepath", "F");
    return $filepath;
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