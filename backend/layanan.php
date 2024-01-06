<?php
function suratFill($target) {
    switch ($target) {
        case 'surat-keterangan-usaha-dalam':
            $query = new Query("SELECT id_penduduk, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, pekerjaan, alamat FROM penduduk WHERE status_deleted = 0 AND nik = ? AND nama = ?");
            break;
        
        default:
            exit;
    }

    $query->execute([
        $_GET['nik'],
        $_GET['nama']
    ]);

    if (!$query->state) {
        return [];
    }
    
    return $query->getData();
}
?>